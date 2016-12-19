import VueRouter from 'vue-router';
// Components
import Index from './index.vue';
import Posts from './posts/posts.vue';
import Post from './posts/post.vue';
import Comments from './comments.vue';
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
    },
    {
        name: 'create-post',
        path: '/dashboard/posts/create',
        component: Post
    },
    {
        name: 'edit-post',
        path: '/dashboard/posts/:id/edit',
        component: Post
    },
    {
        name: 'comments',
        path: '/dashboard/comments',
        component: Comments
    }
];

var router = new VueRouter({
    routes,
    mode: 'history'
});

export default router;

