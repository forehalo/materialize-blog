<template>
    <div class="row">
        <div class="col s12" id="tags">
            <h5 class="center"><strong>{{ $trans('tags') }}</strong></h5>
            <div class="divider"></div>
            <div class="input-field right">
                <select id="tag-order">
                    <option value="" disabled selected>{{ $trans('tags_order') }}</option>
                    <option value="hot">{{ $trans('hot') }}</option>
                    <option value="created_at">{{ $trans('date') }}</option>
                </select>
            </div>
            <div class="row">
                <transition-group name="tags" tag="div" class="col s12">
                    <a href="javascript:;" class="chip tag-chip" v-for="tag in sortedTags" :key="tag.id" @click="switchTag(tag.name)">{{ tag.name }}</a>
                </transition-group>
            </div>
            <div class="row">
                <div class="col s12 post-list">
                    <div v-for="tag in tags" :id="tag.name" style="display: none;" :key="tag.id">
                        <post-list :origins="groupedPosts[tag.name]" :title="tag.name" color="pink"></post-list>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PostList from './post-list.vue';
    export default {
        components: {
            PostList
        },
        data() {
            return {
                currentTag: null,
                tags: [],
                sortBy: 'hot',
                groupedPosts: {}
            }
        },

        computed: {
            sortedTags() {
                return this.tags.sort((a, b) => {
                    if (a[this.sortBy] > b[this.sortBy]) {
                        return -1;
                    } else {
                        return 1;
                    }
                });
            }
        },
        created() {
            this.fetchTags();
        },
        mounted() {
            $('select').material_select();
            $('#tag-order').on('change', () => {
                this.orderTags();
            });
            store.setTitle(this.$trans('tags'));
        },

        methods: {
            fetchTags() {
                this.$http.get('/api/tags')
                        .then(response => {
                            this.tags = response.body;
                            this.$nextTick(() => {
                                if (this.$route.params.name != null) {
                                    this.switchTag(this.$route.params.name);
                                }
                            });
                        }, response => {

                        })
            },
            orderTags() {
                this.sortBy = $('option:selected').val();
            },
            switchTag(tag) {
                this.currentTag = tag;
                if(typeof this.groupedPosts[tag] == 'undefined') {
                    this.$http.get(`/api/tags/${tag}/posts`)
                            .then(response => {
                                // Set new reactive property.
                                this.$set(this.groupedPosts, tag, response.body);
                            }, response => {

                            });
                }
                $(`.post-list > :not(#${tag})`).css('display', 'none');
                $(`#${tag}`).css('display', 'block');
            }

        },
        watch: {
            currentTag(value) {
                this.$router.push(`/tags/${value}`);
            }
        }
    }
</script>
