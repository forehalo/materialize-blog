import VueRouter from 'vue-router';
// Components

// 404
import NotFound from '../components/404.vue';

const routes = [
    {
        name: 'index',
        path: '/dashboard'
    },
    {
        name: '404',
        path: '/dashboard/404',
        component: NotFound
    }
];

var router = new VueRouter({
    routes,
    mode: 'history'
});

router.beforeEach((to, from, next) => {
    $('button-collapse').sideNav('hide');
    if (to.matched.length) {
        next();
    } else {
        next({ name: '404' });
    }
});

router.afterEach((to, from) => {

});

export default router;

