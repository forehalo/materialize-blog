<template>
	<ul id="nav-mobile" class="side-nav" :class="'nav-' + Laravel.currentViewType">
		<li class="bold">
			<router-link to="/" class="waves-effect waves-teal white-text">
				{{ $trans('posts') }}
				<i class="material-icons left">list</i>
			</router-link>
			<li class="no-padding">
				<ul class="collapsible collapsible-accordion" data-collapsible="accordion">
					<li class="bold">
						<a class="collapsible-header waves-effect waves-teal white-text">{{ $trans('categories') }}<i
	                            class="material-icons left">class</i><i
	                            class="material-icons right">arrow_drop_down</i>
	                	</a>
						<div class="collapsible-body">
							<ul>
								<li v-for="category in categories">
									<router-link :to="'/categories/' + category.name" class="green-text">
										{{ category.name }}
									</router-link>
								</li>
							</ul>
						</div>
					</li>
					<li class="bold">
						<a class="collapsible-header waves-effect waves-teal white-text">{{ $trans('archives') }}<i
	                            class="material-icons left">label_outline</i><i
	                            class="material-icons right">arrow_drop_down</i></a>
						<div class="collapsible-body">
							<ul>
								<li><a class="black-text disabled">{{ $trans('group_by') }}</a></li>
								<li>
									<router-link to="/categories" class="green-text waves-effect waves-teal">{{ $trans('categories') }}</router-link>
									<router-link to="/tags" class="pink-text waves-effect waves-teal">{{ $trans('tags') }}</router-link>
									<router-link to="/dates" class="orange-text waves-effect waves-teal">{{ $trans('dates') }}</router-link>
								</li>
							</ul>
						</div>
					</li>
				</ul>
			</li>
			<li class="bold">
				<router-link to="/pages/about" class="waves-effect waves-teal white-text">
					{{ $trans('about') }} <i class="material-icons left">perm_identity</i>
				</router-link>
			</li>
	</ul>
</template>

<script>
    export default {
    	props: {
    		categories: {
    			type: Array,
    			required: true
    		}
    	},

    	data() {
    		return {
    			Laravel
    		}
    	},

        mounted() {
            $(".button-collapse").sideNav();
        },

        methods: {

        }
    }
</script>
