<template>
  <div class="d-flex jc-center ai-center">
    <div class="no-data-content">
      <h2 class="text-muted font-18">{{ message }}</h2>
    </div>
  </div>
</template>

<script>
export default {
  name: "NoData",
  props: {
    message: {
      type: String,
      default: "No Data Available to show",
    },
  },
};
</script>
