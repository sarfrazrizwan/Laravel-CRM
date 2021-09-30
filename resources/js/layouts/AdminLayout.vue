<template>
    <q-layout view="hHh LpR fFf">
        <q-header elevated class="bg-indigo-6 header">
            <q-toolbar>
                <q-btn
                    flat
                    round
                    dense
                    @click="isDrawerVisible = !isDrawerVisible"
                    icon="menu"
                ></q-btn>
                <q-btn
                    style="text-transform: none"
                    stretch
                    flat
                    @click="redirectToHome"
                >
                    <q-toolbar-title class="mainHeader">App</q-toolbar-title>
                </q-btn>
                <q-space />
                <profile-menu />
            </q-toolbar>
        </q-header>
        <q-drawer :behavior="behavior" v-model="isDrawerVisible" side="left">
            <drawer-menu v-on:closeDrawer="closeDrawer" />
        </q-drawer>
        <q-page-container class="full-width" dark>
            <div class="" style="padding: 10px; width: 100%">
                <router-view />
                <q-ajax-bar />
            </div>
        </q-page-container>
    </q-layout>
</template>

<script>
import ProfileMenu from "./../components/ProfileMenu";
import DrawerMenu from "./../components/admin/DrawerMenu";
export default {
    name: "AdminLayout",
    components: {
        ProfileMenu,
        DrawerMenu
    },
    data() {
        return {
            isDrawerVisible: true,
            partyId: 1,
            behavior: "desktop"
        };
    },
    computed: {
        str: function() {
            return this.$root.str;
        }
    },
    methods: {
        redirectToHome: function() {
            this.$router.push("/").catch(err => {});
        },
        closeDrawer: function() {
            this.isDrawerVisible = false;
        }
    },
    beforeMount() {},
    mounted() {}
};
</script>

<style>
/*.card-bordered
{
  border: 1px solid rgba(0,0,0,0.1);
}*/
.tox-notifications-container {
    display: none;
}

.highcharts-credits {
    display: none;
}

.wrap {
    word-break: break-word !important;
    word-wrap: break-word !important;
    white-space: normal !important;
}

.full-width {
    width: 100%;
}

.fullscreen-dialog > .fixed-full {
    background-color: white;
}

.mainHeader {
    display: none;
}
.q-toolbar__title {
    font-size: 16px;
}
@media screen and (min-width: 760px) {
    .q-footer {
        display: none;
    }
    .mainHeader {
        display: block;
    }
}
</style>
