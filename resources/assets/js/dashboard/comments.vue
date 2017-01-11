<template>
    <div class="container">
        <h4>{{ $trans('comments') }}</h4>
        <div class="divider"></div>
        <div class="card-panel">
            <div class="loader-wrapper center" v-if="!currentPageComments">
                <circular-loader></circular-loader>
            </div>
            <table class="bordered striped" v-else>
                <thead>
                <tr>
                    <th>{{ $trans('name') }}</th>
                    <th>{{ $trans('time') }}</th>
                    <th>{{ $trans('post') }}</th>
                    <th>{{ $trans('valid') }}</th>
                    <th>{{ $trans('seen') }}</th>
                    <th>{{ $trans('operation') }}</th>
                </tr>
                </thead>
                <tbody>
                <template v-for="(comment, index) in currentPageComments">
                    <tr>
                        <td>{{ comment.name }}</td>
                        <td>{{ comment.created_at }}</td>
                        <td>{{ comment.post.title }}</td>
                        <td>
                            <circular-loader size="tiny" v-if="processValidItem == comment.id"></circular-loader>
                            <template v-else>
                                <input type="checkbox" :id="'valid-' + comment.id" name="valid" class="filled-in"
                                       v-model="comment.valid" @change="toggleValid(comment)"/>
                                <label :for="'valid-' + comment.id"></label>
                            </template>
                        </td>
                        <td>
                            <circular-loader size="tiny" v-if="processSeenItem == comment.id"></circular-loader>
                            <template v-else>
                                <input type="checkbox" :id="'seen-' + comment.id" name="seen" class="filled-in"
                                       v-model="comment.seen" @change="toggleSeen(comment)"/>
                                <label :for="'seen-' + comment.id"></label>
                            </template>
                        </td>
                        <td>
                            <a href="javascript:;" @click="wantDestroy(comment, index)" class="btn btn-danger">{{ $trans('destroy') }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" class="markdown-body" v-html="comment.content"></td>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>
        <pagination :total="totalPage" :current='currentPage' @jump="selectPage"></pagination>
        <div id="destroy-comment-modal" class="modal bottom-sheet">
            <div class="modal-content">
                <h4>{{ $trans('warning') }}</h4>
                <p>{{ $trans('warning_info') }}</p>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="left modal-action waves-effect waves-red btn-flat"
                   @click="destroyComment">{{ $trans('confirm') }}</a>
                <a href="javascript:;"
                    class="left modal-action modal-close waves-effect waves-green btn-flat">{{ $trans('cancel') }}</a>
            </div>
        </div>
    </div>
</template>
<script>
    import CircularLoader from '../components/circular-loader.vue';
    import Pagination from '../components/pagination.vue';
    export default {
        components: {
            Pagination,
            CircularLoader
        },
        data() {
            return {
                comments: {},
                currentPage: 1,
                totalPage: 0,
                processValidItem: 0,
                processSeenItem: 0,
                willDestroyed: null
            }
        },
        computed: {
            currentPageComments() {
                return this.comments[this.currentPage];
            }
        },
        mounted() {
            this.fetchComments(this.currentPage);
            $('#destroy-comment-modal').modal();
            store.loading = false;
        },
        methods: {
            fetchComments(page) {
                this.$http.get(`/api/dashboard/comments?page=${page}`)
                        .then(response => {
                            let body = response.body;
                            this.$set(this.comments, page, body.data);
                            this.totalPage = body.last_page;
                        }, response => {
                            Materialize.toast(this.$trans('get_comment_fail'), 4000);
                        });
            },
            toggleValid(comment) {
                this.processValidItem = comment.id;
                this.$http.put(`/api/dashboard/comments/${comment.id}/valid`)
                        .then(response => {
                            this.processValidItem = 0;
                            Materialize.toast(this.$trans('toggle_comment_valid_success'), 4000);
                        }, response => {
                            comment.valid = !comment.valid;
                            this.processValidItem = 0;
                            Materialize.toast(response.body.message, 4000);
                        })
            },
            toggleSeen(comment) {
                this.processSeenItem = comment.id;
                this.$http.put(`/api/dashboard/comments/${comment.id}/seen`)
                        .then(response => {
                            this.processSeenItem = 0;
                            Materialize.toast(this.$trans('toggle_comment_seen_success'), 4000);
                        }, response => {
                            comment.seen = !comment.seen;
                            this.processSeenItem = 0;
                            Materialize.toast(response.body.message, 4000);
                        })
            },
            selectPage(to) {
                this.currentPage = to;
                if (typeof this.currentPageComments == 'undefined') {
                    this.fetchComments(to);
                }
            },
            wantDestroy(comment, index) {
                this.willDestroyed = {comment, index};
                this.$nextTick(() => {
                    $('#destroy-comment-modal').modal('open');
                });
            },
            destroyComment() {
                store.loading = true;
                $('#destroy-comment-modal').modal('close');
                this.$http.delete(`/api/dashboard/comments/${this.willDestroyed.comment.id}`)
                        .then(response => {
                            this.comments[this.currentPage].splice(this.willDestroyed.index, 1);
                            store.loading = false;
                            Materialize.toast(this.$trans('delete_comment_success'), 4000);
                            
                        }, response => {
                            store.loading = false;
                            Materialize.toast(response.body.message, 4000);
                        });
            }
        }
    }
</script>
