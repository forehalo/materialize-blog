import VueRouter from 'vue-router';
// Components
import Posts from './components/posts.vue';
import Category from './components/category.vue';
import Tag from './components/tag.vue';
import Date from './components/date.vue';

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
    if (['default', 'categories', 'tags', 'date'].includes(to.name)) {
        Laravel.currentViewType = to.name;
    }
});

export default router;

