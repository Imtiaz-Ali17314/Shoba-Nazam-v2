<template>
<nav aria-label="breadcrumb pd-y-px-0">
    <ol class="breadcrumb text-muted">
        <li class="breadcrumb-item active" aria-current="page">
            <router-link class="text-muted text-lowercase" :to="$route.path.includes('/app-admin/') ? '/app-admin/dashboard' : '/dashboard'">
                dashboard
            </router-link>
        </li>
        <li class="breadcrumb-item active text-lowercase" aria-current="page" v-for="(item, index) in paths" :key="index">
            <router-link  :to="`${item.path}`" :class=" getActiveClass(item.path)">
                <span class="w-30ch">{{ item.name ? item.name.replace('null', '').trim() : '' }}</span>
            </router-link>
        </li>
    </ol>
</nav>
</template>

<script>
export default {
    props: {
        paths: {
            type: Array,
            required: true
        }
    },
    methods: {
        getActiveClass(path) {
            return this.$route.path === path ? " " : "text-muted";
        },
    }
}
</script>

<style lang="scss" scoped>

</style>
