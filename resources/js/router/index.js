import { createRouter, createWebHistory } from "vue-router";

// Components import karo
// Ye aapke resources/js/Components folder ke hisaab se paths change ho sakte hain
import MainLayout from "../Layouts/MainLayout.vue";
import Setup from "../pages/Setup.vue";
import Login from "../pages/Login.vue";
import Dashboard from "../pages/Dashboard.vue";
import Students from "../pages/Students.vue";
import StudentForm from "../pages/StudentForm.vue";
import DisciplineForm from "../pages/DisciplineForm.vue";
import DisciplineRecords from "../pages/DisciplineRecords.vue";
import Users from "../pages/Users.vue";
import Settings from "../pages/Settings.vue";

// Routes define karo
const routes = [
    {
        path: "/",
        component: MainLayout,
        children: [
            { path: "/dashboard", component: Dashboard },
            { path: "/students", component: Students },
            { path: "/student-form", component: StudentForm },
            { path: "/discipline-form", component: DisciplineForm },
            { path: "/discipline-records", component: DisciplineRecords },
            { path: "/users", component: Users },
            { path: "/settings", component: Settings },
        ],
    },
    { path: "/setup", component: Setup },
    { path: "/login", component: Login },
];

// Router create karo
const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
