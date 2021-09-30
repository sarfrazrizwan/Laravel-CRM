<template>
    <div id="app">
        <router-view />
    </div>
</template>

<script>
export default {
    name: "App",
    props: {
        isLogin: {
            default: false
        }
    },
    methods: {},
    mounted() {}
};
</script>

<style>
.header {
    background: linear-gradient(145deg, #1976d2 11%, #0f477e 75%) !important;
}
.bgGreen {
    background: #c8e6c9;
}
.q-toolbar__title {
    font-size: 16px;
}
</style>
