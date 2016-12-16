<template>
    <div class="row">
        <div class="col s12">
            <div class="loader-wrapper center" v-if="loading">
                <circular-loader size="small"></circular-loader>
            </div>
            <transition name="article" enter-active-class="animated fadeInUp">
                <div class="card z-depth-3 article" v-if="!loading">
                    <div class="card-content">
                        <!--title-->
                        <h4 class="title">{{ post.title }}</h4>
                        <!--info-->
                        <div class="label article-info">
                            published at {{ post.created_at.substr(0, 10) }}
                            <i class="material-icons">visibility</i>{{ post.view_count }}
                            <i class="material-icons">comment</i>{{ post.comment_count }}
                            <a href="javascript:void(0)" class="favorite-btn" @click="likeArticle" :class="like ? 'blue-text' : ''">
                                <i class="material-icons">{{ like ? 'favorite' : 'favorite_border' }}</i>
                                <span>{{ post.favorite_count }}</span>
                            </a>
                        </div>
                        <!--content-->
                        <div class="article-content markdown-body" v-html="post.body" v-once></div>
                        <!--actions-->
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
                                    <input type="hidden" name="parent_id" v-model="form.parent_id">
                                    <div class="input-field col s12 l4">
                                        <input type="text" name="name" id="name" class="validate" v-model="form.name" :class="errors.name ? 'invalid' : ''">
                                        <label for="name" :data-error="errors.name"><i class="material-icons">person</i>Name</label>
                                    </div>

                                    <div class="input-field col s12 l4">
                                        <input type="email" name="email" id="email" class="validate" v-model="form.email" :class="errors.email ? 'invalid' : ''">
                                        <label for="email" :data-error="errors.email"><i class="material-icons">email</i>Email(invisible)</label>
                                    </div>
                                    <div class="input-field col s12 l4">
                                        <input type="text" name="website" id="website" class="validate" v-model="form.blog" :class="errors.blog ? 'invalid' : ''">
                                        <label for="website" :data-error="errors.blog"><i class="material-icons">web</i>Website(http://...)</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <textarea id="origin" class="materialize-textarea" name="origin" cols="50" rows="10" v-model="form.origin" placeholder="markdown here"
                                            :class="errors.origin ? 'invalid' : ''"></textarea>
                                        <label for="origin" class="active">
                                            <i class="material-icons">comment</i>content
                                        </label>
                                    </div>
                                    <div class="input-field captcha-field col s12">
                                        <div class="captcha-input">
                                            <input class="captcha validate" id="captcha" name="captcha" type="text" v-model="form.captcha" :class="errors.captcha ? 'invalid' : ''">
                                            <label for="captcha" :data-error="errors.captcha"><i class="material-icons">security</i>captcha</label>
                                        </div>
                                        <img src="/captcha" id="captcha-img" @click="refreshCaptcha">
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <a href="javascript:;" class="btn waves-effect wave-light green" @click="previewComment">
                                            preview <i class="material-icons right">visibility</i>
                                        </a>
                                        <button class="btn waves-effect wave-light blue" type="submit">
                                            submit <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                    <div id="comment-preview-modal" class="modal">
                                        <div class="modal-content">
                                            <div class="markdown-body" v-html="commentPreview"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </transition>

            <!--comments-->
            <div class="card z-depth-3" v-show="post">
                <div class="loader-wrapper center" v-if="loadingComments">
                    <circular-loader size="small"></circular-loader>
                </div>
                <div class="card-content comment-list" id="comments" v-else>
                    <h5 v-if="!hasComment">No Comment</h5>
                    <div v-for="comment in comments" :id="'comment-' + comment.id" class="comment" v-else>
                        <a :href="comment.blog" class="comment-title"><i class="material-icons">person</i>{{ comment.name }}</a>
                        <span>|&nbsp;{{ comment.created_at }}&nbsp;:&nbsp;</span>
                        <a href="javascript:;" @click="reply(comment.id)" class="reply-btn tooltipped" data-position="right" data-delay="50" data-tooltip="reply">
                            <i class="material-icons" style="top: 6px;">reply</i>
                        </a>
                        <div class="row content">
                            <p class="reply" v-if="comment.parent != null">
                                reply&nbsp;<a href="javascript:;" @click="goToComment(comment.parent_id)">@{{ comment.parent.name }}</a>&nbsp;:
                            </p>
                            <div class="markdown-body" v-html="comment.content"></div>
                        </div>
                    </div>
                </div>
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
                loading: true,
                post: null,
                url: location.href,
                comments: [],
                loadingComments: false,
                like: false,
                commentPreview: '',


                // v-model bindings
                form: {
                    parent_id: 0,
                    name: '',
                    email: '',
                    blog: '',
                    origin: '',
                    captcha: ''
                },

                // form errors
                errors: {}
            };
        },

        computed: {
            hasComment() {
                return this.comments.length != 0;
            }
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
                        this.$nextTick(() => {
                            Prism.highlightAll();
                            $('.markdown-body img').materialbox();
                            $('#comment-preview-modal').modal();
                            // lazy load comments when scrolled to bottom.
                            Materialize.scrollFire([{
                                selector: 'footer',
                                offset: 0,
                                callback: this.fetchComments
                            }]);
                        });
                    }, (response) => {
                        this.$router.replace({ name: '404' });
                    });
            },
            refreshCaptcha(event) {
                let newSrc = '/captcha?' + Math.random();
                if (typeof event != "undefined") {
                    event.srcElement.src = newSrc;
                } else {
                    $('img#captcha-img').attr('src', newSrc);
                }
            },
            submitComment(event) {
                this.$http.post(`/api/posts/${this.post.id}/comments`, this.form)
                    .then((response) => {
                        this.comments.unshift(response.body);
                        // Materialize.toast('Comment successfully!', 4000);                        
                        $('#comment-form input, textarea').val('');
                        $('#comment-form label').removeClass('class');
                        this.goToComment(response.body.id);
                        this.$nextTick(() => {
                            Prism.highlightAll();
                            $('.tooltipped').tooltip();
                        });
                    }, (response) => {
                        Materialize.toast(response.body.message, 4000);
                        this.errors = response.body.errors;
                    });
                this.errors = {};
                this.refreshCaptcha();
            },
            fetchComments() {
                if (!this.post) {
                    return;
                }
                this.loadingComments = true;
                this.$http.get(`/api/posts/${this.post.id}/comments`)
                    .then((response) => {
                        this.comments = response.body;
                        this.loadingComments = false;
                        this.$nextTick(() => {
                            Prism.highlightAll();
                            $('.tooltipped').tooltip();
                        });
                    });
            },
            goToComment(commentID) {
                // scroll to parent comment
                let comment = document.getElementById('comment-' + commentID);
                let rect = comment.getBoundingClientRect();
                $(comment).css({ "background-color": '#dcdcdc' });
                setTimeout(() => {
                    $(comment).css({ "background-color": '#FFF' });
                }, 2000);
                $('html, body').animate({ scrollTop: scrollY + rect.top - 100 }, 300);

            },
            reply(commentID) {
                this.form.parent_id = commentID;
                $('html, body').animate({
                    scrollTop: scrollY + document.getElementById('comment-form').getBoundingClientRect().top - 100
                }, 300);
            },
            likeArticle() {
                if (!this.like) {
                    this.$http.post(`/api/posts/${this.post.id}/likes`)
                        .then(response => {
                            Materialize.toast(response.body.message, 4000);
                            this.post.favorite_count++;
                            this.like = true;
                        }, response => {
                            Materialize.toast(response.body.message, 4000);
                        });
                }
            },
            previewComment() {
                this.commentPreview = marked(this.form.origin);
                $('#comment-preview-modal').modal('open');
            }
        }
    }
</script>