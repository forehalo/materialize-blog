<template>
    <div id="link" class="col s12 l8">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Friend links</span>
                <label>click to edit</label>
                <a href="javascript:;" class="btn btn-floating btn-warning waves-effect right" @click="openCreateModal">
                    <i class="material-icons">add</i>
                </a>
                <div class="loader-wrapper center" v-if="loading">
                    <circular-loader></circular-loader>
                </div>
                <template v-else>
                    <p class="flow-text" v-if="!links.length">
                        You must have some friends, right? Click the plus button to add your first friend!
                    </p>

                    <div class="collection" v-else>
                        <a href="javascript:;" class="collection-item" v-for="(link, index) in links" @click="openEditModal(link, index)">
                            <div>
                                <span class="title">{{ link.name }}</span>
                                <p>{{ link.link }}</p>
                            </div>
                        </a>
                    </div>
                </template>

            </div>
            <div class="modal" id="new-link-modal">
                <div class="modal-content">
                    <h4 class="capitalize">{{ modalType }}</h4>
                    <form @submit.prevent="updateOrCreate">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">face</i>
                            <input type="text" name="name" id="name" class="validate" v-model="form.name">
                            <label for="name">Name</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">web</i>
                            <input type="text" name="website" id="website" class="validate" v-model="form.link">
                            <label for="website">Website</label>
                        </div>
                        <button type="submit" class="btn waves-effect btn-success">{{ modalType }}</button>
                        <a href="javascript:;" class="btn btn-danger waves-effect" v-show="modalType === 'update'" @click="wantDestroy">Destroy</a>
                    </form>
                </div>
            </div>
            <div class="modal bottom-sheet" id="destroy-modal">
                <div class="modal-content">
                    <h4>Warning</h4>
                    <p>Really want to destroy this link? You can't recover it after done!</p>
                </div>
                <div class="modal-footer">
                    <a href="javascript:;" class="left modal-action waves-effect waves-red btn-flat"
                       @click="destroy">Confirm</a>
                    <a href="javascript:;"
                       class="left modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
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
                links: [],
                modal: null,
                modalType: 'create',
                editIndex: -1,
                form: {
                    name: '',
                    link: ''
                },
                willDestroyed: null
            }
        },
        mounted() {
            this.fetchLinks();
            this.modal = $('#new-link-modal').modal({
                ready: () => {
                    Materialize.updateTextFields();
                }
            });
            $('#destroy-modal').modal();
        },
        methods: {
            fetchLinks() {
                this.$http.get('/api/dashboard/settings/links')
                        .then(response => {
                            this.links = response.body;
                            this.$nextTick(() => {
                                this.loading = false;
                            });
                        }, response => {
                            this.lading = false;
                        });
            },
            openCreateModal() {
                this.modalType = 'create';
                this.form = {name: '', link: ''};
                this.modal.modal('open');
            },
            openEditModal(link, index) {
                this.modalType = 'update';
                this.form = link;
                this.editIndex = index;
                this.modal.modal('open');
            },
            updateOrCreate() {
                if (this.modalType === 'update') {
                    this.updateLink();
                } else if(this.modalType === 'create') {
                    this.createLink();
                }
            },
            createLink() {
                this.modal.modal('close');
                store.loading = true;
                this.$http.post('/api/dashboard/settings/links', this.form)
                        .then(response => {
                            store.loading = false;
                            this.links.push(response.body);
                        }, response => {
                            store.loading = false;
                        });
            },
            updateLink() {
                this.modal.modal('close');
                store.loading = true;
                this.$http.put(`/api/dashboard/settings/links/${this.form.id}`, this.form)
                        .then(response => {
                            store.loading = false;
                            this.links[this.editIndex] = this.form;
                        }, response => {
                            store.loading = false;
                        });
            },
            wantDestroy() {
                this.modal.modal('close');
                this.willDestroyed = {link: this.form, index: this.editIndex};
                $('#destroy-modal').modal('open');
            },
            destroy() {
                store.loading = true;
                $('#destroy-modal').modal('close');
                this.$http.delete(`/api/dashboard/settings/links/${this.willDestroyed.link.id}`)
                        .then(response => {
                            this.links.splice(this.willDestroyed.index, 1);
                            store.loading = false;
                            Materialize.toast('Delete friend link successfully.', 4000);
                        }, response => {
                            store.loading = false;
                            Materialize.toast('Delete friend link failed.', 4000);
                        });
            }
        }
    }
</script>
