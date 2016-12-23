<template>
    <div class="navbar-fixed">
        <nav :class="'nav-' + Laravel.currentViewType">
            <div class="container">
                <div class="nav-wrapper">
                    <!-- Toggle side menu -->
                    <a href="#" data-activates="nav-mobile" class="button-collapse waves-effect btn-flat btn-floating"><i
                            class="material-icons">menu</i></a>
                    <router-link to="/" class="brand-logo">{{ Laravel.config.logo }}</router-link>
                    <topbar :categories="categories"></topbar>
                    <sidebar :categories="categories"></sidebar>
                </div>
            </div>
            <form id="topbar-search-form" style="display: none;">
                <div class="input-field">
                    <input id="search" type="search" required>
                    <label for="search"><i class="material-icons">search</i></label>
                    <i class="material-icons">close</i>
                </div>
            </form>
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
                Laravel
            }
        },

        computed: {
            categories() {
                return store.getCategories();
            }
        },

        mounted() {
            this.$http.get('/api/categories')
                .then((response) => {
                    store.setCategories(response.body);
                }, (response) => {
                    Materialize.toast(this.$trans('get_categories_fail'), 4000);
                });
        }
    }
</script>
