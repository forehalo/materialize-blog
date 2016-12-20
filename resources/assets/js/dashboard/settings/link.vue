<template>
    <div id="link" class="col s12 l8">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Friend links</span>
                <label>click to edit</label>
                <a href="javascript:;" class="btn btn-floating btn-warning waves-effect right" @click="openModal">
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
                        <a href="javascript:;" class="collection-item" v-for="link in links" >
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
                    <h4>New friend link</h4>
                    <form @submit.prevent="addNewLink">
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
                        <button type="submit" class="btn waves-effect btn-success">Save</button>
                    </form>
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
                modal: null,
                loading: true,
                links: [],
                form: {
                    name: '',
                    link: ''
                }
            }
        },
        mounted() {
            this.fetchLinks();
            this.modal = $('#new-link-modal').modal();
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
            openModal() {
                this.modal.modal('open');
            },
            addNewLink() {
                store.loading = true;
                this.$http.post('/api/dashboard/settings/links', this.form)
                        .then(response => {
                            this.modal.modal('close');
                            store.loading = false;
                            this.links.push(response.body);
                        }, response => {
                            store.loading = false;
                        });
            }
        }
    }
</script>
