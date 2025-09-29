import Login from '../pages/Login.vue';
import Register from '../pages/Register.vue';
import AllUsers from '../pages/AllUsers.vue';
import Main from '../pages/Main.vue';
import CheckUser from '../pages/CheckUser.vue';
import ResetPassword from '../pages/ResetPasswordEmail.vue';
//import NewPassword from '../pages/NewPassword.vue';

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