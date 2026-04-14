<template>
  <div class="raw-popover" ref="popoverEl">
    <span class="raw-popover-arrow" ref="arrowEl"></span>
    <div class="popover-content">
      <slot>
         <div v-if="content" v-html="content"></div>
      </slot>
    </div>
  </div>
</template>

<script setup>
import { onMounted, onBeforeUnmount, ref } from 'vue';
import { createPopper } from '@popperjs/core';

const props = defineProps({
  content: {
    type: String,
    default: ''
  }
});

const popoverEl = ref(null);
const arrowEl = ref(null);
let popperInstance = null;

onMounted(() => {
  if (popoverEl.value && popoverEl.value.parentElement) {
    const referenceEl = popoverEl.value.parentElement;
    
    // Auto-attach group trigger
    if (!referenceEl.classList.contains('group')) {
        referenceEl.classList.add('group');
        referenceEl.classList.add('relative');
    }

    popperInstance = createPopper(referenceEl, popoverEl.value, {
      placement: 'top',
      modifiers: [
        { name: 'offset', options: { offset: [0, 8] } },
        { name: 'arrow', options: { element: arrowEl.value } },
        { name: 'preventOverflow', options: { padding: 8 } },
      ],
    });
  }
});

onBeforeUnmount(() => {
  if (popperInstance) {
    popperInstance.destroy();
    popperInstance = null;
  }
});
</script>

<style scoped>
.raw-popover {
  position: absolute;
  z-index: 50;
  width: max-content;
  max-width: 250px;
  background: #1f2937; /* Default dark mode tooltip style */
  color: #f9fafb;
  border-radius: 6px;
  padding: 6px 10px;
  font-size: 0.8rem;
  font-weight: 500;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
  visibility: hidden;
  opacity: 0;
  transition: opacity 0.15s ease, visibility 0.15s ease;
  pointer-events: none;
}

:global(.group:hover .raw-popover) {
  visibility: visible;
  opacity: 1;
}

.raw-popover-arrow,
.raw-popover-arrow::before {
  position: absolute;
  width: 8px;
  height: 8px;
  background: #1f2937;
  z-index: -1;
}

.raw-popover-arrow { visibility: hidden; }
.raw-popover-arrow::before {
  visibility: visible;
  content: '';
  transform: rotate(45deg);
}

.raw-popover[data-popper-placement^='top'] > .raw-popover-arrow { bottom: -3px; }
.raw-popover[data-popper-placement^='bottom'] > .raw-popover-arrow { top: -3px; }
.raw-popover[data-popper-placement^='left'] > .raw-popover-arrow { right: -3px; }
.raw-popover[data-popper-placement^='right'] > .raw-popover-arrow { left: -3px; }
</style>
