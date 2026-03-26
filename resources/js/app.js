import { createApp } from "vue";
import router from "./router";

const app = createApp({});

// Use Pinia
const pinia = createPinia();
app.use(pinia);

// Use Router
app.use(router);

app.mount("#app");
