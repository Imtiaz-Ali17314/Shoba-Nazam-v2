<template>
  <div class="flex flex-col items-center justify-center p-8 bg-gray-50/50 rounded-2xl border border-dashed border-gray-200">
    <div class="text-gray-300 mb-4">
      <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
      </svg>
    </div>
    <h3 class="text-lg font-bold text-gray-800 mb-1 tracking-tight">{{ title }}</h3>
    <p class="text-sm text-gray-500 text-center max-w-sm font-medium">{{ message }}</p>
    <div v-if="$slots.action" class="mt-6">
      <slot name="action"></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: "NoData",
  props: {
    title: {
      type: String,
      default: "کوئی ریکارڈ نہیں ملا" // "No record found"
    },
    message: {
      type: String,
      default: "دکھانے کے لیے کوئی ڈیٹا دستیاب نہیں ہے۔" // "No data available to show."
    },
  },
};
</script>
