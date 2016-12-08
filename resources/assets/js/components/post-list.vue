<template>
    <div>{{ title }}</div>
</template>
<script>
    export default {
        props: {
            title: {
                type: String,
                required: true
            },
            color: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                posts: []
            }
        },
        mounted() {

        }
    }
</script>