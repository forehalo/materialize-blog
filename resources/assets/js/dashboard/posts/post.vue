<template>
    <div class="container">
        <h4 class="capitalize">{{ type }}</h4>
        <div class="divider"></div>
        <div class="card-panel">
            <form class="col s12">
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" class="validate" name="title" id="title" v-model="form.title" />
                        <label for="title">Title</label>
                    </div>
                    <div class="input-field col s12">
                        <input type="text" class="validate" placeholder="slug" name="slug" id="slug" v-model="form.slug" />
                        <label for="title">link: http://example.com/posts/{{ form.slug }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea name="summary" id="summary" class="materialize-textarea" v-model="form.summary"></textarea>
                        <label for="summary">Summary</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea name="origin" id="origin" class="materialize-textarea" placeholder="markdown syntax" v-model="form.origin"></textarea>
                        <label for="origin">Content</label>
                    </div>
                    <div id="preview-modal" class="modal">
                        <div class="modal-content markdown-body" v-html="contentPreview"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 l3">
                        <input type="text" class="validate" name="category" id="category" v-model="form.category" />
                        <label for="category">Category</label>
                    </div>
                    <div class="input-field col s12 l9">
                        <div class="chips">
                            <input type="text" class="validate" name="tags" id="tags" />
                        </div>
                        <label for="tags">Tags(Enter to input)</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <a href="javascript:;" class="btn waves-effect green" @click="preview">preview <i class="material-icons right">visibility</i></a>
                        <a href="javascript:;" class="btn waves-effect btn-success" @click="submit">submit <i class="material-icons right">send</i></a>
                        <input type="checkbox" id="publish" name="publish" class="filled-in" v-model="form.published" />
                        <label for="publish">Publish</label>
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
                        });
                } else {
                    store.loading = false;
                    $('.chips').material_chip();
                    Materialize.updateTextFields();
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
                        Materialize.toast('Create new post successfully.', 4000);
                    }, response => {
                        Materialize.toast('Create new post failed.', 4000);
                    });
            },
            update() {
                this.$http.put(`/api/dashboard/posts/${this.$route.params.id}`, this.form)
                    .then(response => {
                        this.$router.push('/dashboard/posts');
                        Materialize.toast('Update post successfully.', 4000);
                    }, response => {
                        Materialize.toast('Update post failed.', 4000);
                    });
            }
        }
    }
</script>
