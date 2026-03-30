<template>
  <div 
    v-if="show"
    :class="[
      'flex flex-col items-center justify-center', 
      overlay ? 'absolute inset-0 bg-white/70 backdrop-blur-[2px] z-50 rounded-inherit' : 'p-4'
    ]"
  >
    <div class="flex flex-col sm:flex-row items-center gap-3">
      <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
      </svg>
      <strong v-if="loaderText" class="text-indigo-700 font-bold text-lg tracking-wide">{{ loaderText }}</strong>
    </div>
  </div>
</template>

<script setup>
defineProps({
  show: {
    type: Boolean,
    default: true
  },
  loaderText: {
    type: String,
    default: 'لوڈ ہو رہا ہے...' // Default Urdu "Loading..."
  },
  overlay: {
    type: Boolean,
    default: false
  }
});
</script>

<style scoped>
.rounded-inherit {
  border-radius: inherit;
}
</style>
