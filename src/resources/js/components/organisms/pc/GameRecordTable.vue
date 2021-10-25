<template>
	<div>
		<v-simple-table dense>
		<template v-slot:default>
			<thead>
				<tr>
					<th class="text-center w20">
						日付
					</th>
					<th class="text-center w40">
						<v-row no-gutters class="py-1">
							<v-col>チーム1</v-col>
						</v-row>
						<v-row no-gutters class="py-1">
							<v-col cols="2"></v-col>
							<v-col cols="5" class="py-1 text-left">プレイヤー</v-col>
							<v-col cols="2" class="py-1 text-left">ランク</v-col>
							<v-col cols="3" class="py-1 text-left">レート</v-col>
						</v-row>
					</th>
					<th class="text-center w40">
						<v-row no-gutters class="py-1">
							<v-col>チーム2</v-col>
						</v-row>
						<v-row no-gutters class="py-1">
							<v-col cols="2"></v-col>
							<v-col cols="5" class="py-1 text-left">プレイヤー</v-col>
							<v-col cols="2" class="py-1 text-left">ランク</v-col>
							<v-col cols="3" class="py-1 text-left">レート</v-col>
						</v-row>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr class="tr py-2" v-for="gameRecord in gameRecordList" :key="gameRecord.gameId">
					<td class="text-center">
						<div>{{gameRecord.gameStartDate}}</div>
						<div>{{gameRecord.gameStartTime}}</div>
						<div>
							<Label :color="'success'">{{gameRecord.gamePackage.name}}</Label>
						</div>
					</td>
					<td>
						<template v-for="player in gameRecord.playerMemories[1]">
						<v-row no-gutters class="py-2" :key="`table-team1-${player.playerId}`">
							<v-col cols="2" class="text-center"><Avator :src="player.avatorImage"/></v-col>
							<v-col cols="5" class="py-2">{{player.playerName}}</v-col>
							<v-col cols="2" class="py-2">
								{{player.rank}}
								<span v-if="player.afterRank !== null">({{ addSign(player.afterRank) }})</span>
							</v-col>
							<v-col cols="3" class="py-2">
								{{player.rate}}
								<span v-if="player.afterRate !== null">({{ addSign(player.afterRate) }})</span>
							</v-col>
						</v-row>
						</template>
						<v-divider />
						<v-row no-gutters class="py-2">
							<v-col cols="7">
								<Label
									:color="status(gameRecord.winningTeam, 1) ? 'primary' : 'error'"
									v-if="gameRecord.winningTeam"
								>
									{{ status(gameRecord.winningTeam, 1) ? 'WIN' : 'LOSE' }}
								</Label>
							</v-col>
							<v-col cols="2" class="py-2">{{sum(gameRecord.playerMemories[1], 'rank')}}</v-col>
							<v-col cols="2" class="py-2">{{sum(gameRecord.playerMemories[1], 'rate')}}</v-col>
						</v-row>
					</td>
					<td>
						<template v-for="player in gameRecord.playerMemories[2]">
						<v-row no-gutters class="py-2" :key="`table-team1-${player.playerId}`">
							<v-col cols="2" class="text-center"><Avator :src="player.avatorImage"/></v-col>
							<v-col cols="5" class="py-2">{{player.playerName}}</v-col>
							<v-col cols="2" class="py-2">
								{{player.rank}}
								<span v-if="player.afterRank !== null">({{ addSign(player.afterRank) }})</span>
							</v-col>
							<v-col cols="3" class="py-2">
								{{player.rate}}
								<span v-if="player.afterRate !== null">({{ addSign(player.afterRate) }})</span>
							</v-col>
						</v-row>
						</template>
						<v-divider />
						<v-row no-gutters class="py-2">
							<v-col cols="7">
								<Label
									:color="status(gameRecord.winningTeam, 2) ? 'primary' : 'error' "
									v-if="gameRecord.winningTeam"
								>
									{{ status(gameRecord.winningTeam, 2) ? 'WIN' : 'LOSE' }}
								</Label>
							</v-col>
							<v-col cols="2" class="py-2">{{sum(gameRecord.playerMemories[2], 'rank')}}</v-col>
							<v-col cols="2" class="py-2">{{sum(gameRecord.playerMemories[2], 'rate')}}</v-col>
						</v-row>
					</td>
				</tr>
			</tbody>
		</template>
		</v-simple-table>
		<Pagination
			:current="currentPage"
			:length="gameRecordTotalPage"
			@change="(page) => $emit('pageChange', page)"
		/>
	</div>
</template>

<script>
import Avator from '@atoms/Avator'
import Label from '@atoms/Label'
import Pagination from '@atoms/Pagination'
export default {
	name: 'GameRecordTable',
	components: {
		Avator,
		Label,
		Pagination
	},
	props: {
		gameRecordList: Array,
		currentPage: Number,
		gameRecordTotalPage: Number,
	},
	methods: {
		sum(d, key) {
			if (!d || !key) {
				return 0
			}

			return d.reduce(function(s, v) {
				return s + v[key]
			}, 0)
		},
		status(winning, team) {
			return winning == team
		},
		addSign(num) {
			if (num === null) return ''
			if (num > 0) {
				return `+${ Math.abs(num) }`
			} else if (num < 0) {
				return `-${ Math.abs(num) }`
			}
			return '0';
		},

	}
}
</script>

<style scoped>
	thead > tr {
		background: #cccddd;
	}

	thead > tr > th {
		height: 45px !important;
	}

	.w20 {
		width: 20%;
	}

	.w40 {
		width: 40%;
	}

	.tr:hover {
		background: transparent !important;
	}

	.v-data-table td {
		margin-bottom: 10px;
	}
</style>
