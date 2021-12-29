<template>
<v-row no-gutters class="pa-0 ma-0">
    <v-col>
        <v-row no-gutters no-wrap class="cyan">
            <v-col cols="3" class="text-center">
                <v-btn
                    fab
                    text
                    small
                    color="white"
                    @click="prev"
                >
                    <v-icon>
                        mdi-chevron-left
                    </v-icon>
                </v-btn>
            </v-col>
            <v-col cols="6" class="pa-2 text-center white--text">
                <template v-if="$refs.calendar">
                    {{ $refs.calendar.title }}
                </template>
                <template v-else>
                    {{ defaultSetDate }}
                </template>
            </v-col>
            <v-col cols="3" class="text-center">
                <v-btn
                    fab
                    text
                    small
                    color="white"
                    @click="next"
                >
                    <v-icon>
                        mdi-chevron-right
                    </v-icon>
                </v-btn>
            </v-col>
        </v-row>
        <v-sheet height="340" color="transparent">
            <v-calendar
                ref="calendar"
                color="cyan"
                type="month"
                locale="ja-jp"
                event-overlap-mode="column"
                v-model="focus"
                :events="events"
                :month-format="monthFormat"
                :day-format="dayFormat"
                event-more-text="他{0} 件"
                @click:day="viewDay"
                @click:more="viewMore"
                height="500"
            >
            </v-calendar>
        </v-sheet>
    </v-col>
</v-row>
</template>

<script>
export default {
	name: 'Calendar',
    props: {
        events: { type: Array },
    },
	data() {
		return {
            focus: null,
            defaultSetDate: this.$dayjs().format('M月 YYYY')
        }
    },
    mounted () {
      this.$refs.calendar.checkChange()
    },
    methods: {
        prev () {
            this.$refs.calendar.prev()
        },
        next () {
            this.$refs.calendar.next()
        },
        viewDay(date) {
            console.log(date)
        },
        viewMore(date) {
            console.log("A")
            console.log(date)
        },
        dayFormat(date) {
            return this.$dayjs(date.date).format('D')
        },
        monthFormat(date) {
            return `${this.$dayjs(date.date).format('M')} /`
        }
    }
}
</script>
