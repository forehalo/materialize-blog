'<template>
    <div class="navbar-fixed">
        <nav>
            <div class="container">
                <div class="nav-wrapper">
                    <!-- Toggle side menu -->
                    <a href="#" data-activates="nav-mobile"
                       class="button-collapse waves-effect btn-flat btn-floating"><i
                            class="material-icons">menu</i></a>
                    <router-link to="/" class="brand-logo">{{ Laravel.config.logo }}</router-link>
                    <topbar :categories="categories"></topbar>
                    <sidebar :categories="categories"></sidebar>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
    import Sidebar from './sidebar.vue';
    import Topbar from './topbar.vue';

    export default {
        components: {
            Sidebar, Topbar
        },

        data() {
            return {
                Laravel,
                categories: []
            }
        },

        mounted() {
            this.$http.get('/api/categories')
                .then((response) => {
                    // console.log(response);
                    this.categories = response.body;
                }, (response) => {
                    // error callback
                });
        }
    }
</script>
