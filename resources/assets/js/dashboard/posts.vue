<template>
    <div class="container">
        <h4>Posts</h4>
        <div class="divider"></div>
        <div class="card-panel">
            <div class="loader-wrapper center" v-if="!currentPagePosts">
                <circular-loader></circular-loader>
            </div>
            <table class="bordered striped responsive-table" v-else>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Publish</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(post, index) in currentPagePosts">
                        <td>{{ post.title }}</td>
                        <td>{{ post.created_at.substr(0, 10) }}</td>
                        <td>
                            <input type="checkbox" :id="'publish-' + post.id" name="publish" class="filled-in" v-model="post.published" />
                            <label :for="'publish-' + post.id"></label>
                        </td>
                        <td>
                            <a target="view-window" :href="'/posts/' + post.slug" class="btn btn-success">See</a>
                        </td>
                        <td>
                            <router-link :to="'/dashboard/posts/' + post.id + '/edit'" class="btn btn-warning">Edit</router-link>
                        </td>
                        <td>
                            <a href="javascript:;" @onclick="destroyPost(post.id, index)" class="btn btn-danger">Destroy</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <pagination :total="totalPage" :current='currentPage' @jump="selectPage"></pagination>
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
                posts: {},
                currentPage: 1,
                perPage: 8,
                totalPage: 0,
            }
        },
        computed: {
            currentPagePosts() {
                return this.posts[this.currentPage];
            }
        },
        mounted() {
            this.fetchPosts(this.currentPage);
            store.loading = false;
        },
        methods: {
            fetchPosts(page) {
                this.$http.get(`/api/dashboard/posts?page=${page}`)
                    .then(response => {
                        let body = response.body;
                        this.$set(this.posts, page, body.data);
                        this.totalPage = Math.ceil(parseInt(body.total / this.perPage));
                    }, response => {

                    });
            },
            destroyPost(id, index) {
                this.$http.delete(`/api/posts/${id}`)
                    .then(response => {
                        this.posts.splice(index, 1);
                    }, response => {

                    });
            },
            selectPage(to) {
                this.currentPage = to;
                if (typeof this.currentPagePosts == 'undefined') {
                    this.fetchPosts(to);
                }
            }
        }
    }
</script>