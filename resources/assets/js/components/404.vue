<template>
    <div id="404modal" class="modal">
        <div class="container center-align">
            <div class="modal-content">
                <img src="/images/logo-trans.png" class="responsive-img" width="400">
                <h4> 404 </h4>
                <p>{{ $trans('404') }}</p>
            </div>
            <div class="modal-footer">
                <a class="modal-action modal-close waves-effect waves-green btn-flat" @click="goBack">{{ $trans('back') }}</a>
                <router-link to="/" class=" modal-action modal-close waves-effect waves-green btn-flat">{{ $trans('home') }}</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            let modal = $('#404modal');
            modal.modal({dismissible: false});
            modal.modal('open');
        },
        methods: {
            goBack () {
                this.$router.go(-1);
            }
        }
    }
</script>
