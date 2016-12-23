<template>
    <ul id="topbar" class="hide-on-med-and-down nav-items right">
        <li>
            <router-link to="/" class="waves-effect waves-block">
                <i class="material-icons left">list</i>{{ $trans('posts') }}
            </router-link>
        </li>
        <li><a href="#" class="waves-effect waves-block dropdown-button" data-activates="cate_drop_top">{{ $trans('categories') }}<i
                class="material-icons left">class</i><i
                class="material-icons right">arrow_drop_down</i></a>
            <ul id="cate_drop_top" class="dropdown-content">
                <li v-for="category in categories">
                    <router-link :to="'/categories/' + category.name">
                        {{ category.name }}
                    </router-link>
                </li>
            </ul>
        </li>
        <li><a href="#" class="waves-effect waves-block dropdown-button" data-activates="archive_drop">{{ $trans('archives') }}<i
                class="material-icons left">label_outline</i><i class="material-icons right">arrow_drop_down</i></a>
            <ul id="archive_drop" class="dropdown-content">
                <li><a href="#" class="black-text disabled">{{ $trans('group_by') }}</a></li>
                <li class="divider"></li>
                <li>
                    <router-link to="/categories" class="green-text waves-effect waves-teal">{{ $trans('categories') }}</router-link>
                </li>
                <li>
                    <router-link to="/tags" class="pink-text waves-effect waves-teal">{{ $trans('tags') }}</router-link>
                </li>
                <li>
                    <router-link to="/dates" class="orange-text waves-effect waves-teal">{{ $trans('dates') }}</router-link>
                </li>
            </ul>
        </li>
        <li>
            <router-link to="/pages/about" class="waves-effect waves-block">
                {{ $trans('about') }}
                <i class="material-icons left">perm_identity</i>
            </router-link>
    </ul>
</template>

<script>
    export default {
        props: {
            categories: {
                type: Array,
                reqired: true
            }
        },
        data() {
            return {
                Laravel
            }
        },
        mounted() {
            //
        },

        methods: {}
    }
</script>
