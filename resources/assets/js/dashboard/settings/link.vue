<template>
    <div id="link" class="col s12 l8">
        <div class="card">
            <div class="card-content">
                <span class="card-title">{{ $trans('friend_links') }}</span>
                <label>{{ $trans('click_to_edit') }}</label>
                <a href="javascript:;" class="btn btn-floating btn-warning waves-effect right" @click="openCreateModal">
                    <i class="material-icons">add</i>
                </a>
                <div class="loader-wrapper center" v-if="loading">
                    <circular-loader></circular-loader>
                </div>
                <template v-else>
                    <p class="flow-text" v-if="!links.length">{{ $trans('no_friend') }}</p>

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
                    <h4 class="capitalize">{{ $trans(modalType + '_link') }}</h4>
                    <form class="form" @submit.prevent="updateOrCreate">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">face</i>
                            <input type="text" name="name" id="name" class="validate" v-model="form.name" :class="errors.name ? 'invalid' : ''">
                            <label for="name" :data-error="errors.name">{{ $trans('name') }}</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">web</i>
                            <input type="text" name="website" id="website" class="validate" v-model="form.link" :class="errors.link ? 'invalid' : ''">
                            <label for="website" :data-error="errors.link">{{ $trans('website') }}</label>
                        </div>
                        <button type="submit" class="btn waves-effect btn-success">{{ $trans(modalType + '_link') }}</button>
                        <a href="javascript:;" class="btn btn-danger waves-effect" v-show="modalType === 'update'" @click="wantDestroy">{{ $trans('destroy') }}</a>
                    </form>
                </div>
            </div>
            <div class="modal bottom-sheet" id="destroy-modal">
                <div class="modal-content">
                    <h4>{{ $trans('warning') }}</h4>
                    <p>{{ $trans('warning_info') }}</p>
                </div>
                <div class="modal-footer">
                    <a href="javascript:;" class="left modal-action waves-effect waves-red btn-flat"
                        @click="destroy">{{ $trans('confirm') }}</a>
                    <a href="javascript:;"
                       class="left modal-action modal-close waves-effect waves-green btn-flat">{{ $trans('cancel') }}</a>
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
                errors: {},
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
                this.$http.get('/api/links')
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
                this.errors = {};
                if (this.modalType === 'update') {
                    this.updateLink();
                } else if(this.modalType === 'create') {
                    this.createLink();
                }
            },
            createLink() {
                store.loading = true;
                this.$http.post('/api/dashboard/settings/links', this.form)
                        .then(response => {
                            this.links.push(response.body);
                            this.$nextTick(() => {
                                Materialize.toast(this.$trans('add_link_success'), 4000);
                            });
                            store.loading = false;
                            this.modal.modal('close');
                        }, response => {
                            this.errors = response.body.errors;
                            Materialize.toast(response.body.message, 4000);
                            store.loading = false;
                        });
            },
            updateLink() {
                store.loading = true;
                this.$http.put(`/api/dashboard/settings/links/${this.form.id}`, this.form)
                        .then(response => {
                            this.links[this.editIndex] = this.form;
                            Materialize.toast(this.$trans('update_link_success'), 4000);
                            store.loading = false;
                            this.modal.modal('close');
                        }, response => {
                            this.errors = response.body.errors;                            
                            Materialize.toast(response.body.message, 4000);
                            store.loading = false;
                        });
            },
            wantDestroy() {
                this.modal.modal('close');
                this.willDestroyed = {link: this.form, index: this.editIndex};
                this.$nextTick(() => {
                    $('#destroy-modal').modal('open');
                });
            },
            destroy() {
                store.loading = true;
                $('#destroy-modal').modal('close');
                this.$http.delete(`/api/dashboard/settings/links/${this.willDestroyed.link.id}`)
                        .then(response => {
                            this.links.splice(this.willDestroyed.index, 1);
                            store.loading = false;
                            Materialize.toast(this.$trans('delete_link_success'), 4000);
                        }, response => {
                            store.loading = false;
                            Materialize.toast(response.body.message, 4000);
                        });
            }
        }
    }
</script>
