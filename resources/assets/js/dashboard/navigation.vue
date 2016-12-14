<template>
    <div>
    <div class="navbar-fixed z-depth-2">
        <nav>
            <div class="nav-wrapper">
                <a href="#" data-activates="nav-mobile"
                   class="button-collapse btn-flat pink-text"><i
                        class="material-icons">menu</i></a>
                <a href="javascript:void(0);" class="brand-logo pink-text">Dashboard <label for="">by Forehalo</label></a>
                <ul class="right hide-on-med-and-down">
                    <li><router-link to="/dashboard/settings" class="waves-effect waves-light tooltipped" data-delay="50" data-tooltip="settings"><i class="material-icons">settings</i></a></router-link></li>
                    <li><a href="/dashboard/logout" class="waves-effect waves-light tooltipped" data-position="bottom" data-delay="50" data-tooltip="logout"><i class="material-icons">arrow_forward</i></a></li>
                </ul>
                <ul class="side-nav" id="nav-mobile" style="width: 240px">
                    <li class="bold">
                        <router-link to="/dashboard" class="waves-effect">Dashboard<i class="material-icons left">dashboard</i></router-link>
                    </li>
                    <li class="no-padding ">
                        <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                            <li class="bold">
                                <a class="collapsible-header waves-effect">Posts <i class="material-icons left">create</i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li>
                                            <router-link to="/dashboard/posts" class="waves-effect">All</router-link>
                                        </li>
                                        <li>
                                            <router-link to="/dashboard/posts/create" class="waves-effect">New</router-link>
                                        </li>
                                        <li>
                                            <router-link to="/dashboard/posts/file" class="waves-effect">From Files</router-link>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="bold">
                        <router-link to="/dashboard/comments" class="waves-effect">
                            Comments<i class="material-icons left">comment</i>
                        </router-link>
                    </li>
                    <li class="bold">
                        <router-link to="/dashboard/settings" class="waves-effect">
                            Settings<i class="material-icons left">settings</i>
                        </router-link>
                    </li>
                </ul>
            </div>
        </nav>
    </div>


    <router-link v-if="$route.fullPath != '/dashboard/posts/create'" to="/dashboard/posts/create" class="fixed-action-btn btn-floating btn-large waves-effect waves-light blue tooltipped" data-position="left" data-delay="50" data-tooltip="Create">
        <i class="material-icons">mode_edit</i>
    </router-link>
    </div>
</template>

<script>
    export default {
        mounted() {
            let rect = document.body.getBoundingClientRect();
            $(".button-collapse").sideNav();
            if(rect.right >= 992) {
                $(".button-collapse").sideNav('show');
            }
        }
    }
</script>

