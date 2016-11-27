<template>
    <div class="row">
        <div class="col s12">
            <div class="card z-depth-3 article">
                <div class="loader-wrapper center" v-if="loading">
                    <circular-loader size="small"></circular-loader>
                </div>
                <div class="card-content" v-else>
                    <h4 class="title">{{ post.title }}</h4>
                    <div class="label article-info">
                        published at {{ post.created_at.substr(0, 10) }}
                        <i class="material-icons">visibility</i>{{ post.view_count }}
                        <i class="material-icons">comment</i>{{ post.comment_count }}
                        <a href="javascript:void(0)" class="favorite-btn">
                            <i class="material-icons">favorite_border</i>
                            <span>{{ post.favorite_count }}</span>
                        </a>
                    </div>
                    <div class="article-content markdown-body" v-html="post.body"></div>
                    <div class="card-action">
                        <div class="row">
                            <div class="col s12 l6">
                                <h5>category :</h5>
                                <div class="chip">
                                    <router-link :to="'/categories/' + post.category.id">{{ post.category.name }}</router-link>
                                </div>
                            </div>
                            <div class="col s12 l6">
                                <h5>tags :</h5>
                                <div class="chip" v-for="tag in post.tags">
                                    <router-link :to="'/tags/' + tag.id">{{ tag.name }}</router-link>
                                </div>
                            </div>
                            <div class="col s12 post-right">
                            </div>
                        </div>
                    </div>
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
                loading: true,
                post: null
            };
        },
        mounted() {
            this.getPost(this.$route.params.slug);
        },

        methods: {
            getPost(slug) {
                this.$http.get(`/api/posts/${slug}`)
                    .then((response) => {
                        this.post = response.body;
                        this.loading = false;
                    }, (response) => {

                    });
            }
        },
        updated() {
            Prism.highlightAll();
        }
    }
</script>