<template>
    <ul class="collection with-header z-depth-2">
        <li class="collection-header lighten-5" :class="color">
            <h5>{{ title }}</h5>
        </li>
        <li class="collection-item" v-if="loading">
            <div class="loader-wrapper center">
                <circular-loader></circular-loader>
            </div>
        </li>
        <router-link v-for="post in posts" :to="'/posts/' + post.slug" class="collection-item" :class="color + '-text'">
            <div class="row valign-wrapper">
                <div class="col s11 m11 l11 truncate">{{ post.title }}</div>
                <div class="col s1 m1 l1 valign-wrapper"><i class="material-icons">send</i></div>
            </div>
        </router-link>
    </ul>
</template>
<script>
    import CircularLoader from '../../components/circular-loader.vue';
    export default {
        props: {
            origins:{
                required: true
            },
            title: {
                type: String,
                required: true
            },
            color: {
                type: String,
                required: true
            }
        },
        components: {
            CircularLoader
        },
        data() {
            return {
                loading:true
            }
        },
        computed: {
            posts() {
                return this.origins || [];
            }
        },
        watch: {
            posts() {
                this.loading = false;
            }
        }
    }
</script>
