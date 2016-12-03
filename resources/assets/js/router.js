import VueRouter from 'vue-router';
// Components
import Posts from './components/posts.vue';
import Category from './components/category.vue';
import Tag from './components/tag.vue';
import Date from './components/date.vue';
import Post from './components/post.vue';

// 404
import NotFound from './components/404.vue';

const routes = [
    {
        name: 'default',
        path: '/',
        component: Posts
    },
    {
        name: 'categories',
        path: '/categories/:id?',
        component: Category
    },
    {
        name: 'tags',
        path: '/tags/:id?',
        component: Tag
    },
    {
        name: 'date',
        path: '/date',
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
    next();
});

router.afterEach((to, from) => {
    Laravel.currentViewType =
        ['default', 'categories', 'tags', 'date'].includes(to.name) ?
            to.name :
            'default';
});

export default router;

