
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */
import Navigation from './navigation.vue';
import CircularLoader from '../components/circular-loader.vue'
import router from './router';

window.store = {
    loading: false
};

router.beforeEach((to, from, next) => {
    $('button-collapse').sideNav('hide');
    store.loading = true;
    if (to.matched.length) {
        next();
    } else {
        next({ name: '404' });
    }
});

router.afterEach((to, from) => {

});
const header = new Vue({
    el: 'header',
    router,
    components: {
        Navigation
    }
});

const app = new Vue({
    el: 'main',
    router,
    components: {
        CircularLoader
    },
    data: {
        store,
        showActionButton: true
    },
    watch: {
        '$route.name'(val) {
            this.showActionButton = val != 'edit-post' && val != 'create-post';
        }
    }
});
