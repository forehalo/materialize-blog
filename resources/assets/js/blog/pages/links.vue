<template>
    <div class="card" v-show="links.length">
        <div class="card-content">
            <div class="card-title">{{ $trans('friend_links') }}</div>
            <a class="btn btn-flat waves-effect" target="_blank" v-for="link in links" :href="link.link" >{{ link.name }}</a>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                links: []
            }
        },
        mounted() {
            this.fetchLinks();
        },
        methods: {
            fetchLinks() {
                this.$http.get('/api/links')
                        .then(response => {
                            this.links = response.body;
                        });
            }
        }
    }
</script>
