const ifAuthenticated = (to, from, next) => {
    if (window.isLogin) {
        next(from.path);
        return;
    }
    next("/login");
};

const admin = [
    {
        path: "",
        component: () => import("./../layouts/AdminLayout.vue"),
        beforeEnter: ifAuthenticated,
        children: [
            {
                path: "/",
                component: () => import("./../views/admin/Dashboard.vue")
            }
        ]
    }
];

export default admin;
