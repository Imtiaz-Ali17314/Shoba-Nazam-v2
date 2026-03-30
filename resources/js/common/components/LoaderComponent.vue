<template>
<!-- Loader section -->
<div class="text-center">
    <div class="d-flex align-items-center gap-1 ">
        <div class="spinner-border spinner-border-sm text-primary" role="status">
        </div>
        <strong v-if="loaderText" class="text-primary">{{ loaderText }}</strong>
    </div>
</div>
</template>

<script>
export default {
    props: {
        loaderText: {
            type: String,
            default: 'Loading ...'
        },
    }

}
</script>

<style lang="scss" scoped>
/* HTML: <div class="loader"></div> */
.loader {
    width: fit-content;
    font-family: sans-serif;
    font-size: 20px;
    padding-bottom: 8px;
    background: linear-gradient(currentColor 0 0) 0 100%/0% 3px no-repeat;
    animation: l2 2s linear infinite;
}

.loader:before {
    content: "Loading..."
}

@keyframes l2 {
    to {
        background-size: 100% 3px
    }
}

.checke-box {
    transform: scale(1.5);
}
</style>
