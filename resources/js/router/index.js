import { createRouter, createWebHistory } from "vue-router";

// Components import karo
// Ye aapke resources/js/Components folder ke hisaab se paths change ho sakte hain
import MainLayout from "../Layouts/MainLayout.vue";
import SetupPage from "../Components/SetupPage.vue";
import LoginPage from "../Components/LoginPage.vue";
import DashboardPage from "../Components/DashboardPage.vue";
import StudentsPage from "../Components/StudentsPage.vue";
import DisciplinePage from "../Components/DisciplinePage.vue";
import UsersPage from "../Components/UsersPage.vue";
import SettingsPage from "../Components/SettingsPage.vue";

// Routes define karo
const routes = [
    {
        path: "/",
        component: MainLayout,
        children: [
            { path: "/dashboard", component: DashboardPage },
            { path: "/students", component: StudentsPage },
            { path: "/discipline", component: DisciplinePage },
            { path: "/users", component: UsersPage },
            { path: "/settings", component: SettingsPage },
        ],
    },
    { path: "/setup", component: SetupPage },
    { path: "/login", component: LoginPage },
];

// Router create karo
const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
