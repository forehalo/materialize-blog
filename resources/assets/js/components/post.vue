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
                                <ul>
                                    <li>作者：<span class="blue-text">Forehalo</span></li>
                                    <li>本文地址：<span class="blue-text">{{ url }}</span></li>
                                    <li>保留权利，转载请注明出处。</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="divider"></div>
                            <h5>Make a comment</h5>
                            <form class="col s12" id="comment-form" @submit.prevent="submitComment">
                                <input type="hidden" name="parent_id" value="0">
                                <div class="input-field col s12 l4">
                                    <input type="text" name="name" id="name" class="validate">
                                    <label for="name"><i class="material-icons">person</i>Name</label>
                                </div>

                                <div class="input-field col s12 l4">
                                    <input type="text" name="email" id="email" class="validate">
                                    <label for="email"><i class="material-icons">email</i>Email(invisible)</label>
                                </div>

                                <div class="input-field col s12 l4">
                                    <input type="text" name="website" id="website" class="validate">
                                    <label for="website"><i class="material-icons">web</i>Website(http://...)</label>
                                </div>
                                <div class="input-field col s12">
                                    <textarea id="origin" class="materialize-textarea" name="origin" cols="50" rows="10"></textarea>
                                    <label for="origin"><i class="material-icons">comment</i>content (markdown)</label>
                                </div>
                                <div class="input-field captcha-field col s12">
                                    <div class="captcha-input">
                                        <input class="captcha validate" id="captcha" name="captcha" type="text">
                                        <label for="captcha"><i class="material-icons">security</i>captcha</label>
                                    </div>
                                    <img src="/captcha" id="captcha-img" @click="refreshCaptcha">
                                </div>
                            </form>
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
                post: null,
                url: location.href
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
                        this.$router.replace({ name: '404'});
                    });
            },
            refreshCaptcha(event) {
                let newSrc = '/captcha?' + Math.random();
                if(typeof event != "undefined") {
                    event.srcElement.src = newSrc;
                } else {
                    $('img#captcha-img').attr('src', newSrc); 
                }
            },
            submitComment(event) {
                // TODO
                this.refreshCaptcha();
            }
        },
        updated() {
            Prism.highlightAll();
        }
    }
</script>