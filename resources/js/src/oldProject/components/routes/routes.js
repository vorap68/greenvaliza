

const routes = [
    {
        path: '/',
        component: Main,
    },

    {
        path: '/login',
        component: Login,
        meta: { requiresAuth: false },
    },

    {
        path: '/register-user',
        component: Register,
        meta: { requiresAuth: false },
    },

    {
        path: '/all-users',
        component: AllUsers,
        meta: { requiresAuth: true },
    },


    {
        path: '/check-user',
        component: CheckUser,
        meta: { requiresAuth: false }
    },

    {
        path: '/reset-password',
        component: ResetPassword,
        meta: { requiresAuth: false }
    },



]

export default routes;