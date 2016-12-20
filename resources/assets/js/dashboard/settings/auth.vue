<template>
    <div id="auth" class="col s12 l8">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Auth</span>
                <div class="loader-wrapper center" v-if="loading">
                    <circular-loader></circular-loader>
                </div>
                <div class="row" v-else>
                    <form @submit.prevent="submit">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">person</i>
                            <input type="text" name="name" id="name" class="validate" v-model="auth.name">
                            <label for="name">Username</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">email</i>
                            <input type="text" name="email" id="email" class="validate" v-model="auth.email">
                            <label for="email">E-mail</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">lock</i>
                            <input type="password" name="password" id="password" class="validate" v-model="auth.password">
                            <label for="password">Password</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">lock</i>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="validate" v-model="auth.password_confirmation">
                            <label for="password_confirmation">Password again</label>
                        </div>
                        <button class="btn btn-success waves-effect">Submit</button>
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
                auth: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                }
            }
        },
        mounted() {
            this.fetchAuth();
        },
        methods: {
            fetchAuth() {
                this.$http.get('/api/dashboard/settings/auth')
                        .then(response => {
                            this.auth.name = response.body.name;
                            this.auth.email = response.body.email;
                            this.$nextTick(() => {
                                Materialize.updateTextFields();
                            });
                        }, response => {

                        });
            },
            submit() {
                let form = {};
                if (this.auth.password.length) {
                    form = this.auth;
                } else {
                    form = {name: this.auth.name, email: this.auth.email};
                }
                this.$http.put('/api/dashboard/settings/auth', form)
                        .then(response => {
                            this.auth.password = '';
                            this.auth.password_confirmation = '';
                            Materialize.toast('Change profile information successfully', 4000);
                        }, response => {

                        });
            }
        }
    }
</script>
