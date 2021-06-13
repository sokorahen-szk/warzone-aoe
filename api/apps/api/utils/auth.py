import time
import jwt
from apps.settings import SECRET_KEY
from rest_framework.authentication import BaseAuthentication, get_authorization_header
from rest_framework import exceptions

from api.models import UserInfo

class Authentication(BaseAuthentication):

    def authenticate(self, request):

        username = request._request.POST.get("username")
        password = request._request.POST.get("password")
        user_obj = UserInfo.objects.filter(username=username).first()
        if not user_obj:
            raise exceptions.AuthenticationFailed('認証失敗')
        elif user_obj.password != password:
            raise exceptions.AuthenticationFailed('パスワード不一致')
        token = generate_jwt(user_obj)
        return (token, None)

    def authenticate_header(self, request):
        pass

class JWTAuthentication(BaseAuthentication):
    keyword = 'JWT'
    model = None

    def authenticate(self, request):
        auth = get_authorization_header(request).split()

        if not auth or auth[0].lower() != self.keyword.lower().encode():
            return None

        if len(auth) == 1:
            raise exceptions.AuthenticationFailed("Authorization 無効")
        elif len(auth) > 2:
            raise exceptions.AuthenticationFailed("Authorization 無効 スペースはない")

        try:
            jwt_token = auth[1].decode('utf-8')
            jwt_info = jwt.decode(jwt_token, SECRET_KEY, algorithms="HS256")
            userid = jwt_info.get("userid")
            try:
                user = UserInfo.objects.get(pk=userid)
                user.is_authenticated = True
                return (user, jwt_token)
            except:
                raise exceptions.AuthenticationFailed("ユーザー存在しません")
        except jwt.ExpiredSignatureError:
            raise exceptions.AuthenticationFailed("tokenはタイムアウトしました")

    def authenticate_header(self, request):
        pass

def generate_jwt(user):
    timestamp = int(time.time()) + 60 * 60 * 24
    return jwt.encode(
        {
            "userid": user.pk,
            "username": user.username,
            "info": user.info,
            "exp": timestamp
        },
        SECRET_KEY,
        algorithm="HS256"
    )