<template>
    <!--<q-scroll-area color="secondary" slot="left" style="width: 100%; height: 100vh;">-->
    <div style="border-right: 1px solid lightgray; height:100%">
        <q-list no-border link inset-separator>
            <q-item clickable v-ripple>
                <q-item-section avatar>
                    <q-icon name="people" />
                </q-item-section>
                <q-item-section>
                    <q-item-label>
                        Users
                    </q-item-label>
                    <q-item-label caption>
                        Users
                    </q-item-label>
                </q-item-section>
            </q-item>
        </q-list>
    </div>
    <!--</q-scroll-area>-->
</template>

<script>
export default {
    name: "drawer-menu",
    props: {},
    data: () => ({}),
    methods: {},
    mounted() {}
};
</script>

<style>
.greetings {
    color: #288fe7;
}
</style>
