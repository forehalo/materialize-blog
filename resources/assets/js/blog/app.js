
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
import Navigation from './navigations/navigation.vue';
import router from './router';


window.store = {
	categories: [],

	getCategories() {
		return this.categories;
	},

	setCategories(newValue) {
		this.categories = newValue;
	}

}

const header = new Vue({
	el: 'header',
	router,
	components: {
		Navigation
	},
	data: {
		store
	}
});

const app = new Vue({
	el: 'main',
	router,
	data: {
		transitionName: 'slide-left',
		leaveClass: 'fadeOutLeft',
		store
	},
	watch: {
		'$route'(to, from) {
			let toDepth = to.path.split('/').length;
			let fromDepth = from.path.split('/').length;
			if (toDepth < fromDepth) {
				this.transitionName = 'slide-right';
				this.leaveClass = 'fadeOutRight';
			} else {
				this.transitionName = 'slide-left';
				this.leaveClass = 'fadeOutLeft';
			}
		}
	}
});
