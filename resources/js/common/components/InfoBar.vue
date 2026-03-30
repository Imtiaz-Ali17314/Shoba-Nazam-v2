<template>
    <div :class="['alert d-flex ai-center gap-2 pd-y-px-10', `alert-${color}`]" role="alert">
        <i :class="['mdi font-22', icon]"></i>
        <span v-html="context"></span>
    </div>
</template>

<script setup>
defineProps({
    context: {
        type: String,
        required: true
    },
    color: {
        type: String,
        default: 'warning'
    },
    icon: {
        type: String,
        default: 'mdi-information-outline'
    }
});
</script>

<style scoped>
.ai-center {
    align-items: center;
}
</style>
