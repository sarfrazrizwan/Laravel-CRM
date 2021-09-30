const ifAuthenticated = (to, from, next) => {
    // console.log('auth check', store.state.auth.isLogin);

    if (window.isLogin) {
        if (["/login", "/register", "/forgot-password"].includes(to.path)) {
            next(from.path);
            return;
        }
        next();
        return;
    }
    next("/login");
};
const authCheck = (to, from, next) => {
    if (window.isLogin) {
        next(from.path);
        return;
    }
    next();
};

const home = [
    {
        path: "/login",
        name: "login",
        beforeEnter: authCheck,
        component: () => import("./../layouts/AuthLayout.vue"),
        children: [
            { path: "/", component: () => import("./../views/auth/Login.vue") }
        ]
    }
];

export default home;
