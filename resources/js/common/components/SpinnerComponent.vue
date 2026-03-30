<template>
  <div
    :class="['spinner-border', `text-${variant}`, sizeClass]"
    role="status"
    :style="customStyle"
  >
    <span class="visually-hidden">{{ loadingText }}</span>
  </div>
</template>

<script setup>
import { computed } from 'vue';

// Props
const props = defineProps({
  variant: {
    type: String,
    default: 'primary',
    validator: (value) => [
      'primary',
      'secondary',
      'success',
      'danger',
      'warning',
      'info',
      'light',
      'dark'
    ].includes(value)
  },
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['sm', 'md', 'lg'].includes(value)
  },
  loadingText: {
    type: String,
    default: 'Loading...'
  },
  customSize: {
    type: String,
    default: null
  }
});

// Computed
const sizeClass = computed(() => {
  if (props.size === 'sm') return 'spinner-border-sm';
  return '';
});

const customStyle = computed(() => {
  if (props.customSize) {
    return {
      width: props.customSize,
      height: props.customSize
    };
  }
  return {};
});
</script>

<style scoped>
/* Optional: Add custom sizes if needed */
.spinner-border-lg {
  width: 3rem;
  height: 3rem;
  border-width: 0.3em;
}
</style>
