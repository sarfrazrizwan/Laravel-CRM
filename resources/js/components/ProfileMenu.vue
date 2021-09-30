<template>
    <q-btn-dropdown flat unelevated icon="person">
        <div class="row no-wrap q-pa-md">
            <div class="column">
                <q-list dense>
                    <!-- <q-item clickable v-ripple>
                        <q-item-section avatar>
                            <q-avatar>
                                <img :src="userImage" />
                            </q-avatar>
                        </q-item-section>
                        <q-item-section>
                            <q-item-label>{{ user.name }}</q-item-label>
                            <q-item-label caption>{{
                                user.level_name
                            }}</q-item-label>
                        </q-item-section>
                    </q-item>
                    <q-separator spaced inset /> -->

                    <q-item clickable v-close-popup v-ripple @click="logout">
                        <q-item-section>
                            Logout
                        </q-item-section>
                        <q-item-section side>
                            <q-icon name="power_settings_new" color="red" />
                        </q-item-section>
                    </q-item>
                </q-list>
            </div>
        </div>
    </q-btn-dropdown>
</template>
<script>
export default {
    name: "ProfileMenu",
    components: {},
    data() {
        return {
            isTermModalOpen: false
        };
    },
    computed: {},
    methods: {
        logout() {
            this.isLoading = true;
            const instance = axios.create({
                baseURL: window.baseUrl
            });
            instance
                .post("logout")
                .then(response => {
                    window.location = window.baseUrl;
                })
                .catch(error => {});
        }
    },
    mounted() {}
};
</script>
<style>
.q-btn__content img {
    border-radius: 50%;
}
</style>
