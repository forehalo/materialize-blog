import VueRouter from 'vue-router';
// Components
import Index from './index.vue';
import Posts from './posts.vue';
// 404
import NotFound from '../components/404.vue';

const routes = [
    {
        name: 'index',
        path: '/dashboard',
        component: Index
    },
    {
        name: '404',
        path: '/dashboard/404',
        component: NotFound
    },
    {
        name: 'posts',
        path: '/dashboard/posts',
        component: Posts
    }
];

var router = new VueRouter({
    routes,
    mode: 'history'
});

export default router;

