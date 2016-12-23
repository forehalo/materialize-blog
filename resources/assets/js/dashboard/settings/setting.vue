<template>
    <div class="container">
        <h4>{{ $trans('settings') }}</h4>
        <div class="divider"></div>
        <div class="row">
            <div class="col s12 l6">
                <ul class="tabs tabs-fixed-width" id="setting-tabs">
                    <li class="tab">
                        <a href="#link">{{ $trans('link') }}</a>
                    </li>
                    <li class="tab">
                        <a href="#auth">{{ $trans('auth') }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <link-setting></link-setting>
            <auth-setting></auth-setting>
        </div>
    </div>
</template>
<script>
    import LinkSetting from './link.vue';
    import AuthSetting from './auth.vue';

    export default {
        components: {
            LinkSetting, AuthSetting
        },
        mounted() {
            $('#setting-tabs').tabs();
            store.loading = false;
        }
    }
</script>
