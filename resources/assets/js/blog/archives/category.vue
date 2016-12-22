<template>
    <div class="row">
        <div class="col s12" id="categories" v-if="categories.length">
            <h5 class="center"><strong>{{ $trans('categories') }}</strong></h5>
            <div class="divider"></div>
            <div class="row">
                <div class="col s12">
                    <ul class="tabs tabs-fixed-width z-depth-1" id="category-tabs">
                        <li class="tab" v-for="category in categories">
                            <a @click.prevent="selectTab(category.name)" :href="'#' + category.name" class="green-text">{{ category.name }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col s12 post-list">
                    <div v-for="category in categories" :id="category.name">
                        <post-list :origins="groupedPosts[category.name]" :title="category.name" color="green"></post-list>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PostList from './post-list.vue';

    export default {
        components: {
            PostList
        },
        data() {
            return {
                // current active tab
                currentTab: null,
                // default active tab if no pre-selected
                defaultTab: null,
                firstUpdated: true,
                groupedPosts: {}
            }
        },

        computed: {
            categories() {
                return store.getCategories();
            },
            // Tab to be active throw uri param
            uriTab() {
                return this.$route.params.name;
            }
            
        },

        mounted() {
            this.mountDefaultTab();
            // Init tabs after navigated to category page.
            this.mountTabs();
            store.setTitle(this.$trans('categories'));
        },

        methods: {
            mountDefaultTab() {
                if (this.categories.length) {
                    this.defaultTab = this.categories[0].name;
                }
            },
            mountTabs() {
                if(this.categories.length) {
                    let found = this.categories.find((category) => {
                        return category.name == this.uriTab;
                    });
                    if (found) {
                        this.initTabs().changeActiveTab(this.currentTab || this.uriTab || this.defaultTab || '');
                    } else {
                        this.initTabs().changeActiveTab(this.currentTab || this.defaultTab || '');
                    }
                }
            },
            initTabs() {
                $('#category-tabs').tabs();
                return this;
            },
            changeActiveTab(tabID) {
                $('#category-tabs').tabs('select_tab', tabID);

                if(typeof this.groupedPosts[tabID] == 'undefined') {
                    this.$http.get(`/api/categories/${tabID}/posts`)
                    .then(response => {
                        // Set new reactive property.
                        this.$set(this.groupedPosts, tabID, response.body);
                    }, response => {

                    });
                }
                return this;
            },
            selectTab(tabID) {
                this.$router.push(`/categories/${tabID}`);
            }
        },
        watch: {
            categories() {
                this.mountDefaultTab();
                this.initTabs();
            },
            currentTab(value) {
                this.changeActiveTab(value);
            },
            '$route.params.name'(value) {
                this.currentTab = value || this.defaultTab;
            },
            
        },
        updated() {
            if(this.firstUpdated) {
                // Init tabs after direct access category page.
                this.mountTabs();
                this.firstUpdated = false;
            }
        }
    }
</script>
