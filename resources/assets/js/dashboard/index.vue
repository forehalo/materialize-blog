<template>
    <div class="container">
        <h4>{{ $trans('items') }}</h4>
        <div class="divider"></div>
        <div class="row white-text dashboard">
            <div class="col s12 m6 l4">
                <div class="card-panel blue">
                    <div class="card-content">
                        <i class="material-icons medium">create</i>
                        <div class="right">
                            <div class="number">{{ statistics.post_count }}</div>
                            <div>{{ $trans('total_posts') }}</div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <router-link to="/dashboard/posts">
                        <div class="card-action">
                            <div class="left">{{ $trans('view') }}</div>
                            <i class="material-icons right">arrow forward</i>
                        </div>
                    </router-link>
                </div>
            </div>
            <div class="col s12 m6 l4">
                <div class="card-panel teal">
                    <div class="card-content">
                        <i class="material-icons medium">comment</i>
                        <div class="right">
                            <div class="number">{{ statistics.unread_comment_count }}</div>
                            <div>{{ $trans('new_comments') }}</div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <router-link to="/dashboard/comments">
                        <div class="card-action">
                            <div class="left">{{ $trans('view') }}</div>
                            <i class="material-icons right">arrow forward</i>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                statistics: {}
            }
        },
        mounted() {
            this.getStatistics();
        },
        methods: {
            getStatistics() {
                this.$http.get('/api/dashboard/statistics')
                    .then(response => {
                        this.statistics = response.body;
                        this.$nextTick(() => {
                            store.loading = false;                            
                        });
                    }, response => {
                        Materialize.toast(this.$trans('load_items_fail'), 4000);
                    });
            }
        }
    }
</script>
