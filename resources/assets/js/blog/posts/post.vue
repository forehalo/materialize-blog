<template>
    <div class="row">
        <div class="col s12">
            <div class="loader-wrapper center" v-if="loading">
                <circular-loader></circular-loader>
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
                            <a href="javascript:void(0)" class="favorite-btn" @click="likeArticle"
                               :class="like ? 'blue-text' : ''">
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
                                    <h5>{{ $trans('category') }} :</h5>
                                    <div class="chip">
                                        <router-link :to="'/categories/' + post.category.name">{{ post.category.name
                                            }}
                                        </router-link>
                                    </div>
                                </div>
                                <div class="col s12 l6">
                                    <h5>{{ $trans('tags') }} :</h5>
                                    <div class="chip" v-for="tag in post.tags">
                                        <router-link :to="'/tags/' + tag.name">{{ tag.name }}</router-link>
                                    </div>
                                </div>
                                <div class="col s12 post-right">
                                    <ul>
                                        <li>{{ $trans('author') }}：<span
                                                class="blue-text">{{ Laravel.config.author }}</span></li>
                                        <li>{{ $trans('post_url') }}：<span class="blue-text">{{ url }}</span></li>
                                        <li>{{ $trans('declaration') }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="divider"></div>
                                <h5>{{ $trans('add_comment') }}</h5>
                                <form class="col s12 form" id="comment-form">
                                    <input type="hidden" name="parent_id" v-model="form.parent_id">
                                    <div class="input-field col s12 l4">
                                        <input type="text" name="name" id="name" class="validate" v-model="form.name"
                                               :class="errors.name ? 'invalid' : ''">
                                        <label for="name" :data-error="errors.name"><i class="material-icons">person</i>{{
                                            $trans('name') }}</label>
                                    </div>

                                    <div class="input-field col s12 l4">
                                        <input type="email" name="email" id="email" class="validate"
                                               v-model="form.email" :class="errors.email ? 'invalid' : ''">
                                        <label for="email" :data-error="errors.email"><i
                                                class="material-icons">email</i>{{ $trans('email') }}</label>
                                    </div>
                                    <div class="input-field col s12 l4">
                                        <input type="text" name="website" id="website" class="validate"
                                               v-model="form.blog" :class="errors.blog ? 'invalid' : ''">
                                        <label for="website" :data-error="errors.blog"><i class="material-icons">web</i>{{
                                            $trans('website') }}</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <textarea id="origin" class="materialize-textarea" name="origin" cols="50"
                                                  rows="10" v-model="form.origin"
                                                  :placeholder="$trans('markdown_syntax')"
                                                  :class="errors.origin ? 'invalid' : ''"></textarea>
                                        <label for="origin" class="active">
                                            <i class="material-icons">comment</i>{{ $trans('comment') }}
                                        </label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <a href="javascript:;" class="btn waves-effect wave-light green"
                                           @click="previewComment">
                                            {{ $trans('preview') }} <i class="material-icons right">visibility</i>
                                        </a>
                                        <a class="btn waves-effect wave-light blue" :class="submittingComment ? 'disabled' : ''" @click="submitComment">
                                            {{ $trans('submit') }} <i class="material-icons right">send</i>
                                        </a>
                                        <circular-loader size="tiny" class="align-bottom" v-show="submittingComment"></circular-loader>
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
                <div class="loader-wrapper center vertical-padding-20" v-if="loadingComments">
                    <circular-loader size="small"></circular-loader>
                </div>
                <div class="card-content comment-list" id="comments" v-else>
                    <h5 v-if="!hasComment">{{ $trans('no_comment') }}</h5>
                    <div v-for="comment in comments" :id="'comment-' + comment.id" class="comment" v-else>
                        <a :href="comment.blog" class="comment-title"><i class="material-icons">person</i>{{
                            comment.name }}</a>
                        <span>|&nbsp;{{ comment.created_at }}&nbsp;:&nbsp;</span>
                        <a href="javascript:;" @click="reply(comment.id)" class="reply-btn tooltipped"
                           data-position="right" data-delay="50" :data-tooltip="$trans('reply')">
                            <i class="material-icons" style="top: 6px;">reply</i>
                        </a>
                        <div class="row content">
                            <p class="reply" v-if="comment.parent != null">
                                {{ $trans('reply') }}&nbsp;<a href="javascript:;"
                                                              @click="goToComment(comment.parent_id)">@{{
                                comment.parent.name }}</a>&nbsp;:
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
                Laravel,
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
                },
                submittingComment: false,
                // form errors
                errors: {},

                scrollFire: null
            };
        },

        computed: {
            hasComment() {
                return this.comments.length != 0;
            }
        },
        created() {
            this.scrollFire = {selector: 'footer', offset: 0, callback: this.fetchComments};
            this.getPost(this.$route.params.slug);
        },
        beforeRouteLeave(to, from, next) {
            this.scrollFire.done = true;
            next();
        },
        methods: {
            getPost(slug) {
                this.$http.get(`/api/posts/${slug}`)
                        .then((response) => {
                            this.post = response.body;
                            this.loading = false;
                            this.$nextTick(() => {
                                store.setTitle(this.post.title);
                                Prism.highlightAll();
                                $('.markdown-body img').materialbox();
                                $('#comment-preview-modal').modal();
                                // lazy load comments when scrolled to bottom.
                                Materialize.scrollFire([this.scrollFire]);
                            });
                        }, (response) => {
                            this.$router.replace({name: '404'});
                        });
            },
            submitComment() {
                this.submittingComment = true;
                this.$http.post(`/api/posts/${this.post.id}/comments`, this.form)
                        .then((response) => {
                            this.comments.unshift(response.body);
                            Materialize.toast(this.$trans('comment_success'), 4000);
                            this.form = {parent_id: 0};
                            this.$nextTick(() => {
                                this.submittingComment = false;
                                this.errors = {};
                                Prism.highlightAll();
                                $('.tooltipped').tooltip();
                                
                                // Scroll to submitted comment.
                                this.goToComment(response.body.id);                                
                            });
                        }, (response) => {
                            Materialize.toast(response.body.message, 4000);
                            this.submittingComment = false;
                            this.errors = response.body.errors;
                        });
            },
            fetchComments() {
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
                $(comment).css({"background-color": '#dcdcdc'});
                setTimeout(() => {
                    $(comment).css({"background-color": '#FFF'});
                }, 2000);
                $('html, body').animate({scrollTop: scrollY + rect.top - 100}, 300);

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
                                Materialize.toast(this.$trans('like_post_success'), 4000);
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
