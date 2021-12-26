<template>
	<v-container>
		<CommonWithLeftColumnTemplate
		    :device="getDeviceType"
		>
			<template slot="container">
				<div>試合中のゲームルーム</div>
				<v-row no-gutters class="mt-3" :class="{'mr-3': getDeviceType === 'pc'}">
					<v-col cols="12">
						<v-card tile>
							<v-row no-gutters class="pa-4">
								<v-col cols="3">
									<v-row no-gutters>
										<v-col cols="12">
											<v-icon>mdi-account</v-icon><span class="pl-2">人数</span>
										</v-col>
										<v-col cols="12" class="pl-2">8 人</v-col>
									</v-row>
								</v-col>
								<v-col cols="5">
									マップ
									<div>
										アラビア
									</div>
								</v-col>
								<v-col cols="4">
									<v-icon>mdi-timer-outline</v-icon><span class="pl-2">経過時間</span>
									<Timer l-datetime="2021-12-25 20:16:00" :r-datetime="now" />
								</v-col>
							</v-row>
							<v-row no-gutters class="py-3">
								<v-col class="text-center" cols="12" sm="12" md="6" lg="6" xl="6">
									チーム1
									<v-divider class="ma-3" />
									<v-list>
										<v-list-item>
											<v-list-item-avatar>
												<v-img src="https://placehold.jp/150x150.png"></v-img>
											</v-list-item-avatar>
											<v-list-item-content>a</v-list-item-content>
										</v-list-item>
										<v-list-item>a</v-list-item>
										<v-list-item>a</v-list-item>
										<v-list-item>a</v-list-item>
									</v-list>
								</v-col>
								<v-col class="text-center" cols="12" sm="12" md="6" lg="6" xl="6">
									チーム2
									<v-divider class="ma-3" />
									<v-list>
										<v-list-item>a</v-list-item>
										<v-list-item>a</v-list-item>
										<v-list-item>a</v-list-item>
										<v-list-item>a</v-list-item>
									</v-list>
								</v-col>
							</v-row>
							<v-row no-gutters>
								<v-col cols="12"><Label tag>AoE2DE</Label></v-col>
							</v-row>
						</v-card>
					</v-col>
				</v-row>

			</template>
			<template slot="left">
				<calendar :events="events"/>
				<v-row no-gutters class="pa-0 ma-0">
					<v-col cols="12">
						<div class="py-3">お知らせ</div>
						<v-list class="pa-0 ma-0">
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
						</v-list>
					</v-col>
					<v-col cols="12">
						<Button label="続きを見る" depressed block />
					</v-col>
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
import { mapGetters } from 'vuex'
export default {
	name: 'Home',
	components: {
		CommonWithLeftColumnTemplate,
		Calendar,
		Label,
		Button,
		Timer,
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
	data() {
		return {
			nowDatetime: this.$dayjs(),
			// TODO: カレンダーのデータを作る events
            events: [
                {
					name: 'あいうえお',
					color: "cyan",
                    start: '2021-12-02',
                },
                {
					name: 'aaa',
					color: "cyan",
                    start: '2021-12-02',
                },
                {
					name: 'aaa',
					color: "cyan",
                    start: '2021-12-10',
                },
                {
					name: 'aaa',
					color: "cyan",
                    start: '2021-12-10',
                },
                {
					name: 'aaa',
					color: "cyan",
                    start: '2021-12-05',
                },
                {
					name: 'aaa',
					color: "cyan",
                    start: '2021-12-05',
                },
                {
					name: 'aaa',
					color: "cyan",
                    start: '2021-12-05',
                },
                {
					name: 'aaa',
					color: "cyan",
                    start: '2022-01-01',
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
