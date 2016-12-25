<template>
    <div class="row">
        <div class="col s12" id="date">
            <h5 class="center"><strong>{{ $trans('dates') }}</strong></h5>
            <div class="divider"></div>
            <div class="row date-group">
                <div class="col s12" v-for="date in dates">
                    <h4 class="date-year">{{ date.year }}</h4>
                    <div class="row">
                        <a href="javascript:;" class="col l3 m4 s4 date-month" v-for="month in date.months" @click="switchDate(date.year + '-' + month)">
                            <blockquote>
                                <p class="num">{{ month }}</p>
                                <p class="en">{{ intToMonth(month) }}</p>
                            </blockquote>
                        </a>
                    </div>
                    <div class="col s12 post-list" v-show="date.year + '-' + month == currentDate" v-for="month in date.months">
                        <post-list :origins="groupedPosts[date.year + '-' + month]" :title="intToMonth(month)" color="pink"></post-list>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PostList from './post-list.vue';
    export default {
        components: {
            PostList
        },
        data() {
            return {
                dates: [],
                groupedPosts: {},
                currentDate: null
            }
        },

        created() {
            this.fetchDates();
        },

        mounted() {
            store.setTitle(this.$trans('dates'));
        },

        methods: {
            fetchDates() {
                this.$http.get('/api/dates')
                        .then(response => {
                            this.dates = response.body;
                        }, response => {
                            Materialize.toast(response.body.message, 4000);
                        });
            },
            fetchPostsByDate(date) {
                this.$http.get(`/api/dates/${date}/posts`)
                        .then(response => {
                            this.$set(this.groupedPosts, date, response.body)
                        }, response => {
                            Materialize.toast(response.body.message, 4000);
                        });
            },
            intToMonth(i) {
                let monthArr = {
                    1: "January",
                    2: "February",
                    3: "March",
                    4: "April",
                    5: "May",
                    6: "June",
                    7: "July",
                    8: "August",
                    9: "September",
                    10: "October",
                    11: "November",
                    12: "December"
                };

                return monthArr[i];
            },
            switchDate(date) {
                this.currentDate = date;
                this.fetchPostsByDate(date);
            }
        }
    }
</script>
