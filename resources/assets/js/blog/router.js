import VueRouter from 'vue-router';
// Components
import Posts from './posts/posts.vue';
import Post from './posts/post.vue';
import Category from './archives/category.vue';
import Tag from './archives/tag.vue';
import Date from './archives/date.vue';

// 404
import NotFound from '../components/404.vue';

const routes = [
    {
        name: 'default',
        path: '/',
        component: Posts
    },
    {
        name: 'categories',
        path: '/categories/:name?',
        component: Category
    },
    {
        name: 'tags',
        path: '/tags/:name?',
        component: Tag
    },
    {
        name: 'dates',
        path: '/dates',
        component: Date
    },
    {
        path: '/posts/:slug?',
        component: Post
    },
    {
        name: '404',
        path: '/404',
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
    Laravel.currentViewType =
        ['default', 'categories', 'tags', 'dates'].includes(to.name) ?
            to.name :
            'default';
});

export default router;

