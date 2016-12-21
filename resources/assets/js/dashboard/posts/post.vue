<template>
    <div class="container">
        <h4 class="capitalize">{{ type }}</h4>
        <div class="divider"></div>
        <div class="card-panel">
            <form class="col s12">
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" class="validate" name="title" id="title" v-model="form.title" />
                        <label for="title" class="active">{{ $trans('title') }}</label>
                    </div>
                    <div class="input-field col s12">
                        <input type="text" class="validate" placeholder="slug" name="slug" id="slug" v-model="form.slug" />
                        <label for="title" class="active">{{ $trans('slug') }}: http://example.com/posts/{{ form.slug }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea name="summary" id="summary" class="materialize-textarea" v-model="form.summary"></textarea>
                        <label for="summary" class="active">{{ $trans('summary') }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea name="origin" id="origin" class="materialize-textarea" :placeholder="$trans('markdown_syntax')" v-model="form.origin"></textarea>
                        <label for="origin" class="active">{{ $trans('content') }}</label>
                    </div>
                    <div id="preview-modal" class="modal">
                        <div class="modal-content markdown-body" v-html="contentPreview"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 l3">
                        <input type="text" class="validate" name="category" id="category" v-model="form.category" />
                        <label for="category" class="active">{{ $trans('category') }}</label>
                    </div>
                    <div class="input-field col s12 l9">
                        <div class="chips">
                            <input type="text" class="validate" name="tags" id="tags" />
                        </div>
                        <label for="tags" class="active">{{ $trans('tags') }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <a href="javascript:;" class="btn waves-effect green" @click="preview">{{ $trans('preview') }} <i class="material-icons right">visibility</i></a>
                        <a href="javascript:;" class="btn waves-effect btn-success" @click="submit">{{ $trans('submit') }} <i class="material-icons right">send</i></a>
                        <input type="checkbox" id="publish" name="publish" class="filled-in" v-model="form.published" />
                        <label for="publish">{{ $trans('publish') }}</label>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    export default {

        data() {
            return {
                type: 'create',
                form: {
                    title: '',
                    slug: '',
                    summary: '',
                    origin: '',
                    category: '',
                    tags: [],
                    published: false
                },
                contentPreview: '',
            }
        },

        mounted() {
            this.preloadIfEdit();
            $('#preview-modal').modal();
        },
        methods: {
            submit() {
                if (this.type === 'create') {
                    this.create();
                } else if (this.type === 'edit') {
                    this.update();
                }
            },
            preview() {
                this.contentPreview = marked(this.form.origin);
                $('#preview-modal').modal('open');
            },
            preloadIfEdit() {
                if (this.$route.name == 'edit-post') {
                    this.type = "edit";
                    this.$http.get(`/api/dashboard/posts/${this.$route.params.id}`)
                        .then(response => {
                            this.form = response.body;
                            this.$nextTick(() => {
                                $('.chips').material_chip({
                                    data: this.form.tags.map(tag => { return { tag } })
                                });
                                $('textarea').trigger('autoresize');
                                Materialize.updateTextFields();
                            });
                            store.loading = false;
                        }, response => {
                            store.loading = false;
                            Materialize.toast(response.body.message, 4000);
                        });
                } else {
                    store.loading = false;
                    $('.chips').material_chip({data: [{tag: 'tag'}]});
                }
                $('.chips').on('chip.add', this.addTag).on('chip.delete', this.deleteTag);
            },
            addTag(e, tag) {
                this.form.tags.push(tag.tag);
            },
            deleteTag(e, tag) {
                let index = this.form.tags.findIndex((name) => {
                    return name === tag.tag;
                });
                this.form.tags.splice(index, 1);
            },
            create() {
                this.$http.post('/api/dashboard/posts', this.form)
                    .then(response => {
                        this.$router.push('/dashboard/posts');
                        Materialize.toast(this.$trans('create_post_success'), 4000);
                    }, response => {
                        Materialize.toast(response.body.message, 4000);
                    });
            },
            update() {
                this.$http.put(`/api/dashboard/posts/${this.$route.params.id}`, this.form)
                    .then(response => {
                        this.$router.push('/dashboard/posts');
                        Materialize.toast(this.$trans('update_post_success'), 4000);
                    }, response => {
                        Materialize.toast(response.body.message, 4000);
                    });
            }
        }
    }
</script>
