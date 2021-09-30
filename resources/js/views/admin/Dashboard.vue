<template>
    <div class="container">
        <q-page class="row justify-center items-center">
            <div class="col-md-5 col-10">
                <div class="">
                    <h4 class="text-h4 q-my-md text-center text-primary">
                        {{ appName }}
                    </h4>
                    <h4 class="text-h6 q-my-md text-center">
                        Dashboard
                    </h4>
                    <h5 class="text-h6 q-my-md text-center">
                        {{ appVersion }}
                    </h5>
                </div>
            </div>
        </q-page>
    </div>
</template>

<script>
export default {
    name: "Dashboard",
    data() {
        return {
            appName: window.appName,
            appVersion: window.version
        };
    },
    methods: {},
    mounted() {}
};
</script>
