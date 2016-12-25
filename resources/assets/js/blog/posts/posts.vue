<template>
    <div class="row">
        <div class="col s12">
            <transition-group name="articles" :css="false" @beforeEnter="beforeArticleEnter" @enter="articleEnter" class="collection posts"
                tag="div">
                <div class="collection-item post-item" v-for="(post, index) in posts" :key="index" :data-delay="index">
                    <h5 class="title">
                        <router-link :to="'/posts/' + post.slug">{{ post.title }}</router-link>
                    </h5>
                    <div class="label article-info">
                        published at {{ post.created_at.substr(0, 10) }}
                        <i class="material-icons">visibility</i>{{ post.view_count }}
                        <i class="material-icons">comment</i>{{ post.comment_count }}
                        <a href="javascript:void(0)" class="favorite-btn" @click="like(post)" :class="post.like ? 'blue-text' : ''">
                            <i class="material-icons">{{ post.like ? 'favorite' : 'favorite_border'}}</i>
                            <span>{{ post.favorite_count }}</span>
                        </a>
                    </div>
                    <p class="summary">{{ post.summary }}</p>
                    <div class="row no-margin">
                        <div class="col s12 m12 l12 no-padding">
                            <div class="chip" v-for="tag in post.tags">
                                <router-link :to="'/tags/' + tag.name">{{ tag.name }}</router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- No more posts -->
                <div class="collection-item" v-if="noMore" :key="0">
                    <p>{{ $trans('no_more_post') }}</p>
                </div>
            </transition-group>
            <!-- loader -->
            <div class="loader-wrapper center">
                <circular-loader v-show="loading"></circular-loader>
            </div>
        </div>
    </div>
</template>
<script>
    import CircularLoader from '../../components/circular-loader.vue';
    export default {

        components: {
            CircularLoader
        },

    	data() {
    		return {
                page: 0,
    			posts: [],
                scrollFire: null,
                hasMore: true,
                loading: false,
                velCount: 0
    		}
    	},

        computed: {
            noMore() {
                return !this.hasMore && this.velCount == this.posts.length;
            }
        },

        created() {
            this.loadMorePosts();
            this.scrollFire = { selector: 'footer', offset: -100, callback: this.loadMorePosts, done: true};
            Materialize.scrollFire([this.scrollFire]);
        },

    	mounted() {
            store.setTitle(this.$trans('index'));
    	},

        beforeRouteLeave(to, from, next) {
            this.scrollFire.done = true;
            next();
        },

        methods: {
            loadMorePosts() {
                if(this.hasMore && !this.loading) {
                    this.loading = true;
                    this.$http.get(`/api/posts?page=${this.page + 1}`).then((response) => {
                        let body = response.body;
                        this.posts = this.posts.concat(body.data);
                        this.page = body.current_page;
                        this.hasMore = body.next_page_url != null;
                        this.$nextTick(() => {
                            this.scrollFire.done = !this.hasMore;
                            this.loading = false;
                        });
                    }, (response) => {
                        Materialize.toast(this.$trans('get_posts_fail'), 4000);
                        this.loading = false;                        
                    });
                }
            }, 
            beforeArticleEnter (el) {
                el.style.opacity = 0;
            },
            articleEnter (el, done) {
                var delay = (el.dataset.delay - this.velCount) * 150;
                setTimeout(() => {
                    $.Velocity(el,{ opacity: 1 },{ complete: () => {
                        if(!this.noMore) {
                            this.velCount++;
                        }
                        done.call(this);
                    }});
                }, delay)
            },
            like(post) {
                if(!post.like) {
                    this.$http.post(`/api/posts/${post.id}/likes`)
                        .then(response => {
                            Materialize.toast(this.$trans('like_post_success'), 4000);
                            post.favorite_count++;
                            post.like = true;
                        }, response => {
                            Materialize.toast(response.body.message, 4000);
                        });
                }
            }
        }
    }
</script>
