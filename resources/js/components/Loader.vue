<template>
  <div v-if="show" class="flex flex-col items-center py-8">
    <!-- Spinner -->
    <svg class="animate-spin h-12 w-12 text-indigo-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
    </svg>
    <div class="text-gray-500 font-medium text-sm">لوڈ ہو رہا ہے...</div>
  </div>
</template>

<script>
export default {
  props: {
    show: { type: Boolean, default: false }
  }
}
</script>

<style scoped>
/* optional small styling tweaks for table loader */
</style>