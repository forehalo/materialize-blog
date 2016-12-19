<template>
    <ul class="pagination" v-show="total != 0">
        <li :class="disablePrev">
            <a href="javascript:;" @click="prev"><i class="material-icons">chevron_left</i></a>
        </li>
        <li class="waves-effect" :class="page == current ? 'active' : ''" v-for="page in pages">
            <a href="javascript:;" @click="jumpTo(page)">{{ page }}</a>
        </li>
        <li :class="disableNext">
            <a href="javascript:;" @click="next"><i class="material-icons">chevron_right</i></a>
        </li>
    </ul>
</template>
<script>
    export default {
        props: {
            total: {
                type: Number,
                required: true
            },
            current: {
                type: Number,
                required: true
            }
        },
        computed: {
            pages() {
                let pages = [], frontDots = false, backDots = false, page = 1;

                while (page <= this.total) {
                    if (page == 1 ||
                        page >= this.current - 2 &&
                        page <= this.current + 2 ||
                        page == this.total) {
                        pages.push(page++);
                        continue;
                    }
                    if (page < this.current - 2 && !frontDots) {
                        pages.push("...");
                        frontDots = true;
                    }
                    if (page > this.current + 2 && !backDots) {
                        pages.push("...");
                        backDots = true;
                    }
                    page++;
                }
                return pages;
            },
            disablePrev() {
                return this.current == 1 ? 'disabled' : 'waves-effect';
            },
            disableNext() {
                return this.total == this.current ? 'disabled' : 'waves-effect';
            }
        },
        methods: {
            jumpTo(page) {
                if (Number.isInteger(page)) {
                    this.$emit('jump', Number(page));
                }
            },
            prev() {
                if (this.current != 1) {
                    this.jumpTo(this.current - 1);
                }
            },
            next() {
                if (this.current != this.total) {
                    this.jumpTo(this.current + 1);
                }
            }
        }
    }
</script>
