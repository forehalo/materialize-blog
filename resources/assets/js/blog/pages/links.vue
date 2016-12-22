<template>
    <div class="card-action" v-show="this.links.length">
        <a class="btn btn-flat waves-effect truncate" target="_blank" v-for="link in links" :href="link.link" >{{ link.name }}</a>
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
