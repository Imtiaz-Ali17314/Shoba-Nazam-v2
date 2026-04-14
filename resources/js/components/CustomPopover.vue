<template>
  <div class="custom-popover" ref="popoverEl">
    <span class="custom-popover-arrow" ref="arrowEl"></span>
    
    <div v-if="title" class="px-4 py-3 border-b border-gray-100 bg-gray-50/80 rounded-t-xl">
      <h6 class="font-bold text-gray-900 truncate">{{ title }}</h6>
    </div>

    <div class="px-4 py-3 custom-scroll max-h-[300px] overflow-y-auto">
      <slot>
        <div v-if="content" class="text-sm text-gray-600 prose prose-sm leading-relaxed" v-html="content"></div>
      </slot>
    </div>
  </div>
</template>

<script setup>
import { onMounted, onBeforeUnmount, ref } from 'vue';
import { createPopper } from '@popperjs/core';

const props = defineProps({
  title: {
    type: String,
    default: ''
  },
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
    
    // Add group class to parent element dynamically if not present for hover triggers
    if (!referenceEl.classList.contains('group')) {
        referenceEl.classList.add('group');
        referenceEl.classList.add('relative');
    }

    popperInstance = createPopper(referenceEl, popoverEl.value, {
      placement: 'top',
      modifiers: [
        { name: 'offset', options: { offset: [0, 10] } },
        { name: 'arrow', options: { element: arrowEl.value } },
        { name: 'preventOverflow', options: { padding: 10 } },
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
.custom-popover {
  position: absolute;
  z-index: 50;
  width: max-content;
  max-width: 380px;
  background: white;
  border-radius: 0.75rem;
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
  border: 1px solid rgba(0,0,0,0.05);
  visibility: hidden;
  opacity: 0;
  transition: opacity 0.2s ease, visibility 0.2s ease;
  pointer-events: none;
}

/* Show when parent is hovered */
:global(.group:hover .custom-popover) {
  visibility: visible;
  opacity: 1;
  pointer-events: auto;
}

.custom-popover-arrow,
.custom-popover-arrow::before {
  position: absolute;
  width: 12px;
  height: 12px;
  background: white;
  z-index: -1;
}

.custom-popover-arrow {
  visibility: hidden;
}

.custom-popover-arrow::before {
  visibility: visible;
  content: '';
  transform: rotate(45deg);
  border: 1px solid rgba(0,0,0,0.05);
}

.custom-popover[data-popper-placement^='top'] > .custom-popover-arrow { bottom: -6px; }
.custom-popover[data-popper-placement^='top'] > .custom-popover-arrow::before { border-top: none; border-left: none; box-shadow: 2px 2px 2px rgba(0,0,0,0.02); }

.custom-popover[data-popper-placement^='bottom'] > .custom-popover-arrow { top: -6px; }
.custom-popover[data-popper-placement^='bottom'] > .custom-popover-arrow::before { border-bottom: none; border-right: none; box-shadow: -2px -2px 2px rgba(0,0,0,0.02); }

.custom-popover[data-popper-placement^='left'] > .custom-popover-arrow { right: -6px; }
.custom-popover[data-popper-placement^='left'] > .custom-popover-arrow::before { border-bottom: none; border-left: none; box-shadow: 2px -2px 2px rgba(0,0,0,0.02); }

.custom-popover[data-popper-placement^='right'] > .custom-popover-arrow { left: -6px; }
.custom-popover[data-popper-placement^='right'] > .custom-popover-arrow::before { border-top: none; border-right: none; box-shadow: -2px 2px 2px rgba(0,0,0,0.02); }

.custom-scroll::-webkit-scrollbar { width: 5px; }
.custom-scroll::-webkit-scrollbar-track { background: transparent; }
.custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
.custom-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
