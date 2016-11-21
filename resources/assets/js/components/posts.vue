<template>
    <div class="row">
        <div class="col s12">
            <div class="collection z-depth-1 posts">
                <div class="collection-item post-item" v-for="post in posts">
                    <h5 class="title">
                        <router-link to="#">{{ post.title }}</router-link>
                    </h5>
                    <div class="label">
                        published at {{ post.created_at.substr(0, 10) }}
                        <i class="material-icons">visibility</i>{{ post.view_count }}
                        <i class="material-icons">comment</i>{{ post.comment_count }}
                        <a href="javascript:void(0)" class="favorite-btn">
                            <i class="material-icons">favorite_border</i>
                            <span>{{ post.favorite_count }}</span>
                        </a>
                    </div>
                    <p class="summary">{{ post.summary }}</p>
                    <div class="row no-margin">
                        <div class="col s12 m12 l12 no-padding">
                            <div class="chip" v-for="tag in post.tags">{{ tag.name }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--<ul class="collection">
                
            </ul>
            <div class="card post-card" v-for="post in posts">
                <div class="card-content">
                    
                </div>
            </div>-->

            <!-- loader -->
            <div class="loader-wrapper center">
                <circular-loader v-show="loading"></circular-loader>
            </div>
            <!-- No more posts -->
            <div class="card" v-if="!hasMore">
                <div class="card-content">
                    <div class="card-title">No More Posts</div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import CircularLoader from './circular-loader.vue';
    export default {

        components: {
            CircularLoader
        },

    	data() {
    		return {
                page: 0,
    			posts: [],
                hasMore: true,
                loading: false,
    		}
    	},

    	mounted() {
            this.loadMorePosts();
    	},

        methods: {
            loadMorePosts() {
                if(this.hasMore && !this.loading) {
                    this.loading = true;
                    this.$http.get(`api/posts?page=${this.page + 1}`).then((response) => {
                        let body = response.body;
                        this.posts = this.posts.concat(body.data);
                        this.page = body.current_page;
                        this.hasMore = body.next_page_url != null;
                        Materialize.scrollFire([{
                            selector: 'footer', 
                            offset: -100,
                            callback: this.loadMorePosts
                        }]);
                        this.loading = false;                      
                    }, (response) => {
                        // TODO
                        this.loading = false;                        
                    });
                }
            }
        }
    }
</script>