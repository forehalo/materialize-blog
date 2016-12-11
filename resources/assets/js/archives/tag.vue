<template>
    <div class="row">
        <div class="col s12" id="tags">
            <h5 class="center"><strong>Tags</strong></h5>
            <div class="divider"></div>
            <div class="input-field right">
                <select id="tag-order">
                    <option value="" disabled selected>Select Order</option>
                    <option value="hot">Hot</option>
                    <option value="created_at">Date</option>
                </select>
            </div>
            <div class="row">
                <transition-group name="tags" tag="div" class="col s12">
                    <a href="javascript:;" class="chip tag-chip pink accent-1" v-for="tag in sortedTags" :key="tag.id" @click="switchTag(tag.name)">{{ tag.name }}</a>
                </transition-group>
            </div>
            <div class="row">
                <div class="col s12 post-list">
                    <div v-for="tag in tags" :id="tag.name" style="display: none;" :key="tag.id">
                        <post-list :origins="orderedPosts[tag.name]" :title="tag.name" color="pink"></post-list>
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
                orderedPosts: {}
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
        mounted() {
            $('select').material_select();
            $('#tag-order').on('change', () => {
                this.orderTags();
            });
            this.fetchTags();
        },

        methods: {
            fetchTags() {
                this.$http.get('/api/tags')
                        .then(response => {
                            this.tags = response.body;
                        }, response => {

                        })
            },
            orderTags() {
                this.sortBy = $('option:selected').val();
            },
            switchTag(tag) {
                this.currentTag = tag;
                if(typeof this.orderedPosts[tag] == 'undefined') {
                    this.$http.get(`/api/tags/${tag}/posts`)
                            .then(response => {
                                // Set new reactive property.
                                this.$set(this.orderedPosts, tag, response.body);
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