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
						チーム1
					</th>
					<th class="text-center w40">
						チーム2
					</th>
				</tr>
			</thead>
			<tbody>
				<tr class="tr py-2" v-for="d in data" :key="d.gameId">
					<td class="text-center">
						<div>{{d.gameStartDate}}</div>
						<div>{{d.gameStartTime}}</div>
						<div>
							<Label>{{d.gamePackageName}}</Label>
						</div>
					</td>
					<td>
						<template v-for="player in d.team1">
						<v-row no-gutters class="py-2" :key="`table-team1-${player.id}`">
							<v-col cols="2" class="text-center"><Avator /></v-col>
							<v-col cols="5" class="py-2">{{player.name}}</v-col>
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
									:color="status(d.winningTeam, 1) ? 'primary' : 'error'"
									v-if="d.winningTeam"
								>
									{{ status(d.winningTeam, 1) ? 'WIN' : 'LOSE' }}
								</Label>
							</v-col>
							<v-col cols="2" class="py-2">{{sum(d.team1, 'rank')}}</v-col>
							<v-col cols="2" class="py-2">{{sum(d.team1, 'rate')}}</v-col>
						</v-row>
					</td>
					<td>
						<template v-for="player in d.team2">
						<v-row no-gutters class="py-2" :key="`table-team1-${player.id}`">
							<v-col cols="2" class="text-center"><Avator /></v-col>
							<v-col cols="5" class="py-2">{{player.name}}</v-col>
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
									:color="status(d.winningTeam, 2) ? 'primary' : 'error' "
									v-if="d.winningTeam"
								>
									{{ status(d.winningTeam, 2) ? 'WIN' : 'LOSE' }}
								</Label>
							</v-col>
							<v-col cols="2" class="py-2">{{sum(d.team2, 'rank')}}</v-col>
							<v-col cols="2" class="py-2">{{sum(d.team2, 'rate')}}</v-col>
						</v-row>
					</td>
				</tr>
			</tbody>
		</template>
		</v-simple-table>
		<Pagination />
	</div>
</template>

<style scoped>
thead > tr {
  background: #eee;
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

<script>
import Avator from '@/components/atoms/Avator'
import Label from '@/components/atoms/Label'
import Pagination from '@/components/atoms/Pagination'
export default {
	name: 'GameRecordFullTable',
	components: {
		Avator,
		Label,
		Pagination
	},
	data() {
		return {
			data: [
				{
					gameId: 1,
					gameStartDate: "2020-01-01",
					gameStartTime: "00:00",
					gamePackageName: "AoE2DE",
					winningTeam: null,
					team1: [
						{id: 1, avator: null, name: "AAA", rank: 27, afterRank: null, rate: 2500, afterRate: null},
						{id: 2, avator: null, name: "BBB", rank: 25, afterRank: null, rate: 2333, afterRate: null},
						{id: 3, avator: null, name: "CCCCCCCCCC", rank: 25, afterRank: null, rate: 2110, afterRate: null},
						{id: 4, avator: null, name: "DDD", rank: 22, afterRank: null, rate: 2000, afterRate: null},
					],
					team2: [
						{id: 1, avator: null, name: "AAA", rank: 27, afterRank: null, rate: 2500, afterRate: null},
						{id: 2, avator: null, name: "BBB", rank: 25, afterRank: null, rate: 2333, afterRate: null},
						{id: 3, avator: null, name: "CCCCCCCCCC", rank: 25, afterRank: null, rate: 2110, afterRate: null},
						{id: 4, avator: null, name: "DDD", rank: 22, afterRank: null, rate: 2000, afterRate: null},
					],
				},
				{
					gameId: 2,
					gameStartDate: "2020-01-01",
					gameStartTime: "00:00",
					gamePackageName: "AoE2DE",
					winningTeam: 1,
					team1: [
						{id: 1, avator: null, name: "AAA", rank: 27, afterRank: -1, rate: 2500, afterRate: 30},
						{id: 2, avator: null, name: "BBB", rank: 25, afterRank: -2, rate: 2333, afterRate: 35},
						{id: 3, avator: null, name: "CCCCCCCCCC", rank: 25, afterRank: 0, rate: 2110, afterRate: 5},
						{id: 4, avator: null, name: "DDD", rank: 22, afterRank: -1, rate: 2000, afterRate: 10},
					],
					team2: [
						{id: 1, avator: null, name: "AAA", rank: 27, afterRank: +1, rate: 2500, afterRate: 30},
						{id: 2, avator: null, name: "BBB", rank: 25, afterRank: +2, rate: 2333, afterRate: 35},
						{id: 3, avator: null, name: "CCCCCCCCCC", rank: 25, afterRank: 0, rate: 2110, afterRate: 5},
						{id: 4, avator: null, name: "DDD", rank: 22, afterRank: +1, rate: 2000, afterRate: 10},
					],
				},
			]
		}
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
		}
	}
}
</script>
