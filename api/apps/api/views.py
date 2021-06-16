from rest_framework.views import APIView
from rest_framework.response import Response

from .utils.auth import Authentication, JWTAuthentication
from rest_framework.permissions import IsAuthenticated
import json

import collections
import copy
import itertools
import math
import sys
import trueskill
from apps.settings import MU,SIGMA

# Create your views here.
class Auth(APIView):
    authentication_classes = [Authentication, ]

    def post(self, request, *args, **kwargs):
        return Response({"token": request.user})

# スキルのデフォルト値の取得
# 新規プレイヤー登録時等、初期レートを取得
class DefaultSkill(APIView):
    authentication_classes = [JWTAuthentication, ]
    permission_classes = [IsAuthenticated, ]

    def get(self, request, *args, **kwargs):
        env = create_trueskill()
        rating = env.create_rating()
        result = {
            'mu': rating.mu,
            'sigma': rating.sigma,
            'rating_exposure' : env.expose(rating)
        }
        return Response(result)

# 試合データからスキルを計算
# 試合に参加したチームのリストと勝敗結果を渡すと計算後のスキルを返す
# 試合品質も付与しています。
class CalcSkill(APIView):
    authentication_classes = [JWTAuthentication, ]
    permission_classes = [IsAuthenticated, ]

    def post(self, request, *args, **kwargs):
        datas = json.loads(request.body)

        result = copy.deepcopy(datas)
        env = create_trueskill()

        winning_team = datas['winning_team']
        ranks = None
        if winning_team == 1:
          ranks = [1, 2]
        elif winning_team == 2:
          ranks = [2, 1]
        else:
          #引き分け時はAPI呼び出しされない想定だが、一応考慮
          ranks = [0, 0]

        teams_rate = []
        for t in datas['teams']:
            team_rate = []
            for p in t:
                rating = env.create_rating(mu=p['mu'], sigma=p['sigma'])
                team_rate.append(rating)
            teams_rate.append(team_rate)

        #trueskill計算
        new_teams_rate = env.rate(teams_rate, ranks=ranks)
        #品質を計算
        quality = env.quality(teams_rate)

        #勝率を計算
        lt1 = teams_rate[0]
        lt2 = teams_rate[1]
        wp = win_probability(tuple(lt1), tuple(lt2), env=env)

        #計算結果を反映
        for ntsr,t in zip(new_teams_rate, result['teams']):
            for ntr,p in zip(ntsr, t):
                p['mu'] = ntr.mu
                p['sigma'] = ntr.sigma
                p['rating_exposure'] =  env.expose(ntr)

        result['quality'] = quality
        result['win_probability'] = wp

        return Response(result)

# チーム分けパターンを取得
# 参加プレイヤーの一覧を渡すとチーム分けパターンを返す。
# チーム分けパターンのリストは、試合品質が高い順にソート
# 参考情報としてチーム１とチーム２の合計muも付加
class TeamDivisionPattern(APIView):
    authentication_classes = [JWTAuthentication, ]
    permission_classes = [IsAuthenticated, ]

    def post(self, request, *args, **kwargs):
        datas = json.loads(request.body)

        players = datas['players']
        env = create_trueskill()
        #trueskillのリストを作成
        ratings = [env.create_rating(mu=p['mu'], sigma=p['sigma']) for p in players]

        indexList = range(len(players))

        #奇数メンバーの場合のチーム分けの考慮なし
        c = itertools.combinations(indexList, math.ceil(len(indexList)/2))

        patternList = []
        for ptn in c:
            #第１プレイヤーをピックした組み合わせのみ残す
            if ptn[0] == 0:
                index_team1 = list(ptn)
                index_team2 = []
                for index in indexList:
                    if index not in index_team1:
                        index_team2.append(index)

                team1_rate = [ratings[i] for i in index_team1]
                team2_rate = [ratings[i] for i in index_team2]

                quality = env.quality([team1_rate,team2_rate])

                pattern = {}
                pattern['quality'] = quality
                pattern['team1'] = [players[i] for i in index_team1]
                pattern['team2'] = [players[i] for i in index_team2]
                pattern['sum_mu1'] = sum([players[i]['mu'] for i in index_team1])
                pattern['sum_mu2'] = sum([players[i]['mu'] for i in index_team2])
                patternList.append(pattern)

        #品質順（降順）にソート
        patternList_sorted = sorted(patternList, key=lambda x:x['quality'],reverse=True)

        return Response(patternList_sorted)

# データコンバート
# 試合履歴を渡すと、試合履歴（スキル情報付き）、プレイヤーの最終スキルを返す
# ※「warzoneに登録あり＆試合実績なし」のプレイヤーはスキル計算できません。
class DataConversion(APIView):
    authentication_classes = [JWTAuthentication, ]
    permission_classes = [IsAuthenticated, ]

    def post(self, request, *args, **kwargs):
        datas = json.loads(request.body)

        # #試合履歴
        match_history = datas

        players = {}
        match_history_with_trueskill = []

        env = create_trueskill()

        for match in match_history:
            convert_match(players,env,match,match_history_with_trueskill)

        #プレイヤーをID順にソート
        players = collections.OrderedDict(
            sorted(players.items(), key=lambda x: x[0])
        )


        resutl_players = {}
        for id in players:
            player = players[id]
            newP = {}
            newP['id'] = player['id']
            newP['mu'] = player['rating'].mu
            newP['sigma'] = player['rating'].sigma
            newP['rating_exposure'] = env.expose(player['rating'])
            resutl_players[newP['id']] = newP


        result = {}
        result['players'] = resutl_players
        result['match_history_with_trueskill'] = match_history_with_trueskill

        return Response(result)





def create_trueskill():

    mu = MU
    sigma = SIGMA

    beta = sigma / 2.
    tau = sigma / 100.
    # draw_probability = 0.1
    draw_probability = 0 #warzoneではほぼ引き分けは無いに等しいのでデフォルト値から変更
    backend = None

    env = trueskill.TrueSkill(
        mu=mu, sigma=sigma, beta=beta, tau=tau,
        draw_probability=draw_probability, backend=backend)

    return env


def win_probability(team1, team2, env=None):
    env = env if env else trueskill.global_env()
    delta_mu = sum(r.mu for r in team1) - sum(r.mu for r in team2)
    sum_sigma = sum(r.sigma ** 2 for r in itertools.chain(team1, team2))
    size = len(team1) + len(team2)
    denom = math.sqrt(size * (env.beta * env.beta) + sum_sigma)
    return env.cdf(delta_mu / denom)

def create_match_with_trueskill(match,participant,env,isAfter):
    mtc = {}
    mtc['id'] = match['id']
    mtc['started_at'] = match['started_at']
    if isAfter :
      mtc['isAfter'] = '1:試合後'
    else :
      mtc['isAfter'] = '0:試合前'
    mtc['win_team'] = match['win_team']

    for key in participant:
      p = participant[key]
      if p is not None :
        mtc[key +'_id'] = p['id']
        mtc[key +'_mu'] = p['rating'].mu
        mtc[key +'_sigma'] = p['rating'].sigma
        mtc[key +'_rating_exposure'] = env.expose(p['rating'])
      else :
        mtc[key +'_id'] = None
        mtc[key +'_mu'] = None
        mtc[key +'_sigma'] = None
        mtc[key +'_rating_exposure'] = None


    return mtc

def get_or_create_player(players,id,env):

    if id < 0:
      # print('idがマイナス　id：'+str(id))
      return None

    if(id in players):
      return players[id]
    else:
      player={}
      player['id'] = id
      player['rating'] = env.create_rating()
      players[id]=player
      return players[id]

def convert_match(players,env,match,match_history_with_trueskill):

    #該当試合の参加プレイヤー
    participant={}
    for i in range(2):
      for j in range(4):
        key = 't'+ str(i+1) + 'm' + str(j+1)
        participant[key] = get_or_create_player(players,match[key +'_id'],env)


    #trueskill用のチームを作成
    t1 = {}
    t2 = {}

    for key in participant:
      p = participant[key]
      if p is not None :
        if 't1' in key :
          t1[key]=p['rating']
        else :
          t2[key]=p['rating']


    #trueskill版の試合データ(試合前)
    match_trueskill = create_match_with_trueskill(match,participant,env,False)

    match_history_with_trueskill.append(match_trueskill)

    win_team = match['win_team']
    if win_team==1:
      ranks = (1,2,)
    elif win_team==2:
      ranks = (2,1,)
    else :
      ranks = (0,0,)

    # trueskillを計算
    newt1,newt2, = env.rate((t1,t2,), ranks=ranks)

    for key in participant:
      p = participant[key]
      if p is not None :
        if 't1' in key :
          p['rating'] = newt1[key]
        else :
          p['rating'] = newt2[key]

    #trueskill版の試合データ(試合後)
    match_trueskill = create_match_with_trueskill(match,participant,env,True)

    match_history_with_trueskill.append(match_trueskill)
