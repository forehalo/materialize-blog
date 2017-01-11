<template>
    <div class="container">
        <h4>{{ $trans('posts') }}</h4>
        <div class="divider"></div>
        <div class="card-panel">
            <div class="loader-wrapper center" v-if="!currentPagePosts">
                <circular-loader></circular-loader>
            </div>
            <table class="bordered striped responsive-table" v-else>
                <thead>
                <tr>
                    <th>{{ $trans('title') }}</th>
                    <th>{{ $trans('date') }}</th>
                    <th>{{ $trans('publish') }}</th>
                    <th>{{ $trans('operation') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(post, index) in currentPagePosts">
                    <td><a target="view-window" :href="'/posts/' + post.slug">{{ post.title }}</a></td>
                    <td>{{ post.created_at.substr(0, 10) }}</td>
                    <td>
                        <circular-loader size="tiny" v-if="processItem == post.id"></circular-loader>
                        <template v-else>
                            <input type="checkbox" :id="'publish-' + post.id" name="publish" class="filled-in"
                                   v-model="post.published" @change="togglePublish(post)"/>
                            <label :for="'publish-' + post.id"></label>
                        </template>
                    </td>
                    <td>
                        <router-link :to="'/dashboard/posts/' + post.id + '/edit'" class="btn btn-success">{{ $trans('edit') }}
                        </router-link>
                    </td>
                    <td>
                        <a :href="'/dashboard/posts/' + post.id + '/export'" class="btn btn-warning">{{ $trans('export') }}</a>
                    </td>
                    <td>
                        <a href="javascript:;" @click="wantDestroy(post, index)" class="btn btn-danger">{{ $trans('destroy') }}</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <pagination :total="totalPage" :current='currentPage' @jump="selectPage"></pagination>
        <div id="destroy-post-modal" class="modal bottom-sheet">
            <div class="modal-content">
                <h4>{{ $trans('warning') }}</h4>
                <p>{{ $trans('warning_info') }}</p>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="left modal-action waves-effect waves-red btn-flat" @click="destroyPost">{{ $trans('confirm') }}</a>
                <a href="javascript:;" class="left modal-action modal-close waves-effect waves-green btn-flat">{{ $trans('cancel') }}</a>
            </div>
        </div>
    </div>
</template>
<script>
    import CircularLoader from '../../components/circular-loader.vue';
    import Pagination from '../../components/pagination.vue';
    export default {
        components: {
            Pagination,
            CircularLoader
        },
        data() {
            return {
                posts: {},
                currentPage: 1,
                totalPage: 0,
                processItem: 0,
                willDestroyed: null
            }
        },
        computed: {
            currentPagePosts() {
                return this.posts[this.currentPage];
            }
        },
        mounted() {
            this.fetchPosts(this.currentPage);
            $('#destroy-post-modal').modal();
            store.loading = false;
        },
        methods: {
            fetchPosts(page) {
                this.$http.get(`/api/dashboard/posts?page=${page}`)
                        .then(response => {
                            let body = response.body;
                            this.$set(this.posts, page, body.data);
                            this.totalPage = body.last_page;
                        }, response => {
                            Materialize.toast(this.$trans('get_posts_fail'), 4000);
                        });
            },
            wantDestroy(post, index) {
                this.willDestroyed = {post, index};
                this.$nextTick(() => {
                    $('#destroy-post-modal').modal('open');
                });
            },
            destroyPost() {
                store.loading = true;
                $('#destroy-post-modal').modal('close');
                this.$http.delete(`/api/dashboard/posts/${this.willDestroyed.post.id}`)
                        .then(response => {
                            this.posts[this.currentPage].splice(this.willDestroyed.index, 1);
                            store.loading = false;
                            Materialize.toast(this.$trans('delete_post_success'), 4000);
                        }, response => {
                            store.loading = false;
                            Materialize.toast(response.body.message, 4000);
                        });
            },
            selectPage(to) {
                this.currentPage = to;
                if (typeof this.currentPagePosts == 'undefined') {
                    this.fetchPosts(to);
                }
            },
            togglePublish(post) {
                this.processItem = post.id;
                this.$http.put(`/api/dashboard/posts/${post.id}/publish`)
                        .then(response => {
                            this.processItem = 0;
                            Materialize.toast(this.$trans('toggle_post_publish_success'), 4000);
                        }, response => {
                            post.published = !post.published;
                            this.processItem = 0;
                            Materialize.toast(response.body.message, 4000);
                        });
            }
        }
    }
</script>
