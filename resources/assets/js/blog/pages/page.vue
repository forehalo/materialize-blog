<template>
    <div class="row">
        <div class="col s12">
            <h5 class="center"><strong>{{ $trans(name) }}</strong></h5>
            <div class="loader-wrapper center" v-if="loading">
                <circular-loader></circular-loader>
            </div>
            <div class="card z-depth-3 article" v-else>
                <div class="card-content">
                    <div class="article-content markdown-body" v-html="content" v-once></div>
                </div>
            </div>
            <links v-if="name == 'about'"></links>
        </div>
    </div>
</template>
<script>
    import Links from './links.vue';
    import CircularLoader from '../../components/circular-loader.vue'
    export default {
        components: {
            Links, CircularLoader
        },
        data() {
            return {
                loading: true,
                content: ''
            }
        },
        computed: {
            name() {
                return this.$route.params.name;
            }
        },
        created() {
            this.fetchContent();
            store.setTitle(this.name);
        },
        methods: {
            fetchContent() {
                this.$http.get(`/api/pages/${this.name}`)
                        .then(response => {
                            this.loading = false;
                            this.content = response.body.content;
                        }, response => {
                            this.$router.replace({name: '404'});
                        });
            }
        }
    }
</script>
