<template>
    <div>
        <ul id="topbar" class="hide-on-med-and-down nav-items right">
            <li>
                <router-link to="/" class="waves-effect waves-block">
                    <i class="material-icons left">list</i>Posts
                </router-link>
            </li>
            <li><a href="#" class="waves-effect waves-block dropdown-button" data-activates="cate_drop_top">Categories<i
                    class="material-icons left">class</i><i
                    class="material-icons right">arrow_drop_down</i></a>
                <ul id="cate_drop_top" class="dropdown-content">
                    <li v-for="category in categories">
                        <router-link :to="'/categories/' + category.id">
                            {{ category.name }}
                        </router-link>
                    </li>
                </ul>
            </li>
            <li><a href="#" class="waves-effect waves-block dropdown-button" data-activates="archive_drop">Archives<i
                    class="material-icons left">label_outline</i><i class="material-icons right">arrow_drop_down</i></a>
                <ul id="archive_drop" class="dropdown-content">
                    <li><a href="#" class="black-text disabled">Group By</a></li>
                    <li class="divider"></li>
                    <li>
                        <router-link to="categories">Categories</router-link>
                    </li>
                    <li>
                        <router-link to="tags">Tags</router-link>
                    </li>
                    <li>
                        <router-link to="date">Date</router-link>
                    </li>
                </ul>
            </li>
            <li>
                <router-link to="about" class="waves-effect waves-block">
                    About
                    <i class="material-icons left">perm_identity</i>
                </router-link>
        </ul>
        <!-- <form id="topbar-search-form">
            <div class="input-field">
                <input id="search" type="search" required>
                <label for="search"><i class="material-icons">search</i></label>
                <i class="material-icons">close</i>
            </div>
        </form> -->
    </div>
</template>

<script>
    export default {
        props: {
            categories: {
                type: Array,
                reqired: true
            }
        },
        mounted() {
            //
        },

        methods: {

        }
    }
</script>
