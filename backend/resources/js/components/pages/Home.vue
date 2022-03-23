<template>
	<v-container>
		<CommonWithLeftColumnTemplate
		    :device="getDeviceType"
		>
			<template slot="container">
				<div>試合中のゲームルーム</div>
				<v-row no-gutters class="mt-3" :class="{'mr-3': getDeviceType === 'pc'}">
					<Loading v-if="isLoading" :size="32" />
					<v-col cols="12" v-else-if="warMatchingHistories.length > 0 && !isLoading">
						<v-card tile v-for="warHistory in warMatchingHistories" :key="warHistory.gameRecordId">
							<v-row no-gutters class="pa-4">
								<v-col cols="3">
									<v-row no-gutters>
										<v-col cols="12">
											<v-icon>mdi-account</v-icon><span class="pl-2">人数</span>
										</v-col>
										<v-col cols="12" class="pl-2">{{warHistory.playerCount}} 人</v-col>
									</v-row>
								</v-col>
								<v-col cols="5">
									マップ
									<div>
										{{warHistory.gameMap.name}}
									</div>
								</v-col>
								<v-col cols="4">
									<v-icon>mdi-timer-outline</v-icon><span class="pl-2">経過時間</span>
									<Timer :l-datetime="warHistory.startedAt" :r-datetime="now" />
								</v-col>
							</v-row>
							<v-row no-gutters class="py-3">
								<v-col class="text-center" cols="12" sm="12" md="6" lg="6" xl="6">
									チーム1
									<v-divider class="ma-3" />
									<v-list v-for="playerMemory in warHistory.playerMemories.team1" :key="playerMemory.playerMemoryId">
										<v-list-item>
											<v-list-item-avatar>
												<v-img :src="playerMemory.avatorImage"></v-img>
											</v-list-item-avatar>
											<v-list-item-content class="text-left">
												<Link :path="`/player/${playerMemory.userId}`">{{playerMemory.playerName}}({{playerMemory.rank}})</Link>
											</v-list-item-content>
										</v-list-item>
									</v-list>
								</v-col>
								<v-col class="text-center" cols="12" sm="12" md="6" lg="6" xl="6">
									チーム2
									<v-divider class="ma-3" />
									<v-list v-for="playerMemory in warHistory.playerMemories.team2" :key="playerMemory.playerMemoryId">
										<v-list-item>
											<v-list-item-avatar>
												<v-img :src="playerMemory.avatorImage"></v-img>
											</v-list-item-avatar>
											<v-list-item-content class="text-left">
												<Link :path="`/player/${playerMemory.userId}`">{{playerMemory.playerName}}({{playerMemory.rank}})</Link>
											</v-list-item-content>
										</v-list-item>
									</v-list>
								</v-col>
							</v-row>
							<v-row no-gutters>
								<v-col cols="12"><Label tag>{{warHistory.gamePackage.name}}</Label></v-col>
							</v-row>
						</v-card>
					</v-col>
					<v-col cols="12" v-else>
						<div class="pa-1">現在、部屋はありません。</div>
					</v-col>
				</v-row>

			</template>
			<template slot="left">
				<Calendar :events="events"/>
				<v-row no-gutters class="pa-0 ma-0">
					<v-col cols="12">
						<div class="py-3">お知らせ</div>
						<div class="pa-1">-</div>
						<!--v-list class="pa-0 ma-0">
							<template v-for="information in informations">
							<v-list-item class="pa-0 ma-0" :to="information.link" :key="information.id">
								<Label
									:color="information.category.color"
								>{{information.category.label}}</Label>
								<v-list-item-content>
									<v-list-item-title>{{information.subject}}</v-list-item-title>
									<v-list-item-subtitle>{{information.published_at}}</v-list-item-subtitle>
								</v-list-item-content>
							</v-list-item>
							<v-divider :key="`information-divider-${information.id}`" />
							</template>
						</v-list-->
					</v-col>
					<!--v-col cols="12">
						<Button label="続きを見る" depressed block />
					</v-col-->
				</v-row>
			</template>
		</CommonWithLeftColumnTemplate>
	</v-container>
</template>

<script>
import CommonWithLeftColumnTemplate from '@templates/CommonWithLeftColumnTemplate'
import Calendar from '@molecules/Calendar'
import Label from '@atoms/Label'
import Button from '@atoms/Button'
import Timer from '@atoms/Timer'
import Loading from '@atoms/Loading'
import Link from '@atoms/Link'
import { mapGetters, mapActions } from 'vuex'
import { gameStatus } from '@/config/game'
export default {
	name: 'Home',
	components: {
		CommonWithLeftColumnTemplate,
		Calendar,
		Label,
		Button,
		Timer,
		Loading,
		Link,
	},
	computed: {
		...mapGetters('breakpointStore', ['getDeviceType']),
		now() {
			setInterval(function() {
				this.nowDatetime = this.$dayjs()
			}.bind(this), 1000)
			return this.nowDatetime.format('YYYY-MM-DD HH:mm:ss')
		}
	},
	methods: {
    	...mapActions('warStore', ['fetchAllWarHistoryList']),
		fetchWarMatchingHistories() {
			this.isLoading = true
			new Promise((resolve) => {
				resolve(this.fetchAllWarHistoryList({
					status: gameStatus.matching,
					page: 1, // マッチング中のゲームは１ページ（10件）で収まる件数のため、ページ1を明示的に指定
				}))
			})
			.then(res => {
				this.warMatchingHistories = this.spliTeamtWarHistories(res)
			})
			.finally(() => {
				this.isLoading = false
			})
		},
		spliTeamtWarHistories(warHistories) {
			let splitedTeamWarHistories = []

			warHistories.forEach( (warHistory) => {
				let splitedTeamPlayerMemories = {
					team1: [],
					team2: [],
				}

				_.forEach(warHistory.playerMemories, (m, i) => {
					_.forEach(m, playerMemory => {
						if (i == 1) {
							splitedTeamPlayerMemories.team1.push(playerMemory)
						} else {
							splitedTeamPlayerMemories.team2.push(playerMemory)
						}
					})
				})
				warHistory.playerMemories = splitedTeamPlayerMemories
				splitedTeamWarHistories.push(warHistory)
			})
			return splitedTeamWarHistories
		}
	},
	mounted() {
		this.fetchWarMatchingHistories()
	},
	data() {
		return {
			warMatchingHistories: [],
			nowDatetime: this.$dayjs(),
			isLoading: false,
			// TODO: カレンダーのデータを作る events
            events: [
                {
					name: 'あいうえお',
					color: "cyan",
                    start: '2021-12-31',
                },
            ],
			// TODO: ダミーデータを削除し、DBからデータを参照するように修正する
			informations: [
				{
					id: 3,
					link: '/test',
					subject: 'サイトのお知らせ',
					published_at: '2021-12-23 00:00:00',
					category: {
						label: 'お知らせ',
						color: 'info',
					}
				},
				{
					id: 2,
					link: '/test',
					subject: 'サイトのお知らせ',
					published_at: '2021-12-23 00:00:00',
					category: {
						label: 'お知らせ',
						color: 'info',
					}
				},
				{
					id: 1,
					link: '/test',
					subject: '2021年末大会',
					published_at: '2021-12-23 00:00:00',
					category: {
						label: 'イベント',
						color: 'warning',
					}
				}
			]
		}
	}
}
</script>
