<template>
    <q-page class="row justify-center items-center">
        <div class="col-md-5 col-10">
            <div class="">
                <q-card class="shadow-24 card" round>
                    <q-card-section class="bg-orange">
                        <h4 class="text-h5 text-white q-my-md text-center">
                            Login
                        </h4>
                    </q-card-section>
                    <q-card-section class="q-mb-md">
                        <q-form class="q-px-sm q-pt-xl">
                            <q-input
                                square
                                dense
                                v-model="user.email"
                                :error="hasEmailError"
                                :error-message="emailError"
                                type="email"
                                label="Email"
                            >
                                <template v-slot:prepend>
                                    <q-icon name="email" />
                                </template>
                            </q-input>
                            <q-input
                                square
                                dense
                                v-model="user.password"
                                :error="hasPasswordError"
                                :error-message="passwordError"
                                type="password"
                                label="Password"
                            >
                                <template v-slot:prepend>
                                    <q-icon name="lock" />
                                </template>
                            </q-input>
                        </q-form>
                    </q-card-section>
                    <div class="pointer  forget-link text-grey-6"></div>
                    <q-card-actions class="q-px-lg action justify-center">
                        <q-btn
                            unelevated
                            :loading="loading"
                            @click="login()"
                            size="lg"
                            color="purple-4"
                            class="text-white text-center"
                            label="Login"
                            icon-right="east"
                        >
                            <template v-slot:append>
                                <q-spinner-hourglass class="on-left" />
                                Loading...
                            </template>
                        </q-btn>
                    </q-card-actions>
                    <q-card-section class="text-center q-pa-sm ">
                    </q-card-section>
                </q-card>
            </div>
        </div>
    </q-page>
</template>

<script>
export default {
    name: "login",
    data: () => ({
        user: {
            email: "",
            password: ""
        },

        loading: false,
        error: false,
        errorMessage: []
    }),
    computed: {
        hasEmailError: function() {
            return (
                this.error &&
                this.errorMessage["email"] !== undefined &&
                this.errorMessage["email"] !== null
            );
        },

        emailError: function() {
            var error = this.hasEmailError
                ? this.errorMessage["email"].join("&lt;br&gt;")
                : "";
            if (error !== "") {
                error = error.replace("email", "email");
            }
            return error;
        },
        hasPasswordError: function() {
            return (
                this.error &&
                this.errorMessage["password"] !== undefined &&
                this.errorMessage["password"] !== null
            );
        },

        passwordError: function() {
            var error = this.hasPasswordError
                ? this.errorMessage["password"].join("&lt;br&gt;")
                : "";
            if (error !== "") {
                error = error.replace("password", "password");
            }
            return error;
        }
    },
    methods: {
        login: function() {
            this.isLoading = true;
            const instance = axios.create({
                baseURL: window.baseUrl
            });
            instance
                .post("login", this.user)
                .then(response => {
                    this.error = false;
                    this.errorMessage = [];
                    window.location = window.baseUrl;
                })
                .catch(error => {
                    this.isLoading = false;
                    this.error = true;
                    this.errorMessage = error.response.data.errors;
                });
        },

        cleardata() {
            this.name = null;
            this.email = null;
            this.password = null;
        }
    },
    mounted() {}
};
</script>

<style scoped>
.text-faded {
    color: #777 !important;
}
.or-seperator {
    margin: 40px 0 10px;
    text-align: center;
    border-top: 1px solid #ccc;
}

.centered {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
