<template>
    <div class="row">
        <div class="col s12">
            <div class="card post-card" v-for="post in posts">
                <div class="card-content">
                    <span class="card-title">{{ post.title }}</span>
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
                    <div class="row article-card no-margin">
                        <div class="col s12 m12 l12 no-padding">
                            <div class="chip" v-for="tag in post.tags">{{ tag.name }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {

    	data() {
    		return {
                page: 0,
    			posts: [],
                hasMore: true,
    		}
    	},

    	mounted() {
            this.loadMorePosts();
    	},

        methods: {
            loadMorePosts() {
                if(this.hasMore) {
                    this.$http.get('api/posts', {page: this.page + 1}).then((response) => {
                        this.posts = this.posts.concat(response.body.data);
                        this.page = response.body.current_page;
                        this.hasMore = response.next_page_url != null;
                    }, (response) => {
                        // TODO
                    });
                }
            }
        }
    }
</script>