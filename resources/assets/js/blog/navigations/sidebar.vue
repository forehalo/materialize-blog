<template>
	<ul id="nav-mobile" class="side-nav" :class="'nav-' + Laravel.currentViewType">
		<li class="bold">
			<router-link to="/" class="waves-effect waves-teal white-text">
				Posts
				<i class="material-icons left">list</i>
			</router-link>
			<li class="no-padding">
				<ul class="collapsible collapsible-accordion" data-collapsible="accordion">
					<li class="bold">
						<a class="collapsible-header waves-effect waves-teal white-text">Categories<i
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
						<a class="collapsible-header waves-effect waves-teal white-text">Archives<i
	                            class="material-icons left">label_outline</i><i
	                            class="material-icons right">arrow_drop_down</i></a>
						<div class="collapsible-body">
							<ul>
								<li><a class="black-text disabled">Group By</a></li>
								<li>
									<router-link to="/categories" class="green-text waves-effect waves-teal">Categories</router-link>
									<router-link to="/tags" class="pink-text waves-effect waves-teal">Tags</router-link>
									<router-link to="/dates" class="orange-text waves-effect waves-teal">Dates</router-link>
								</li>
							</ul>
						</div>
					</li>
				</ul>
			</li>
			<li class="bold">
				<router-link to="/about" class="waves-effect waves-teal white-text">
					About <i class="material-icons left">perm_identity</i>
				</router-link>
				<li class="search-item">
					<form action="/search">
						<div class="input-field">
							<input name="key" id="search-mobile" type="search" required>
							<label for="search-mobile"><i class="material-icons">search</i></label>
							<i class="material-icons">close</i>
						</div>
					</form>
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
