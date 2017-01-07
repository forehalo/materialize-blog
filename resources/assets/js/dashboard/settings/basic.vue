<template>
    <div id="basic" class="col s12 l8">
        <div class="card">
            <div class="card-content">
                <span class="card-title">{{ $trans('basic') }}</span>
                <div class="row">
                    <form @submit.prevent="update">
                        <div class="input-field col s12">
                            <input type="text" name="author" id="author" class="validate" v-model="form.author" :class="errors.author ? 'invalid' : ''">
                            <label for="author" :data-error="errors.author">{{ $trans('author') }}</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="email" name="email" id="email" class="validate" v-model="form.email" :class="errors.email ? 'invalid' : ''">
                            <label for="email" :data-error="errors.email">{{ $trans('email') }}</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="text" name="desc" id="desc" class="validate" v-model="form.desc" :class="errors.desc ? 'invalid' : ''">
                            <label for="desc" :data-error="errors.desc">{{ $trans('desc') }}</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="text" name="keywords" id="keywords" class="validate" v-model="form.keywords" :class="errors.keywords ? 'invalid' : ''">
                            <label for="keywords" :data-error="errors.keywords">{{ $trans('keywords') }}</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="text" name="logo" id="logo" class="validate" v-model="form.logo" :class="errors.logo ? 'invalid' : ''">
                            <label for="logo" :data-error="errors.logo">{{ $trans('logo') }}</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="text" name="post_per_page" id="post_per_page" class="validate" v-model="form.post_per_page" :class="errors.post_per_page ? 'invalid' : ''">
                            <label for="post_per_page" :data-error="errors.post_per_page">{{ $trans('post_per_page') }}</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="text" name="dashboard_post_per_page" id="dashboard_post_per_page" class="validate" v-model="form.dashboard_post_per_page" :class="errors.dashboard_post_per_page ? 'invalid' : ''">
                            <label for="dashboard_post_per_page" :data-error="errors.dashboard_post_per_page">{{ $trans('dashboard_post_per_page') }}</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="text" name="dashboard_comment_per_page" id="dashboard_comment_per_page" class="validate" v-model="form.dashboard_comment_per_page" :class="errors.dashboard_comment_per_page ? 'invalid' : ''">
                            <label for="dashboard_comment_per_page" :data-error="errors.dashboard_comment_per_page">{{ $trans('dashboard_comment_per_page') }}</label>
                        </div>
                        <div class="input-field col s12">
                            <button class="btn btn-success waves-effect">{{ $trans('submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        
        data() {
            return {
                form: Laravel.config,
                errors: {}
            }
        },

        methods: {
            update() {
                this.$http.put('/api/dashboard/settings/basic', this.form)
                    .then(response => {
                        Materialize.toast(this.$trans('update_settings_success'), 4000);
                    }, response => {
                        this.errors = response.body.errors;
                        Materialize.toast(response.body.message, 4000);
                    });
            }
        }
    }
</script>
