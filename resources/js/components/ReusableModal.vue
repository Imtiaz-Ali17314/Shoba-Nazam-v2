<template>
  <Teleport to="body">
    <transition name="modal">
      <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" @click.self="closeModal">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="closeModal"></div>

        <!-- Modal Panel -->
        <div 
          :class="[
            'relative bg-white rounded-2xl shadow-2xl flex flex-col w-full max-h-[90vh] overflow-hidden transform transition-all',
            sizeClass
          ]"
          role="dialog"
          aria-modal="true"
          :aria-labelledby="modalId + '-title'"
        >
          <!-- Header -->
          <div v-if="!hideHeader" class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
            <h3 :id="modalId + '-title'" class="text-xl font-extrabold tracking-tight text-gray-900">
              <slot name="title">{{ title }}</slot>
            </h3>
            <button @click="closeModal" class="text-gray-400 hover:text-red-500 hover:bg-red-50 p-2 rounded-xl transition-colors">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <!-- Body -->
          <div class="px-6 py-5 overflow-y-auto flex-1">
            <slot name="body"></slot>
          </div>

          <!-- Footer -->
          <div v-if="!hideFooter" class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex items-center justify-end gap-3 rounded-b-2xl">
            <slot name="footer">
              <button 
                type="button" 
                @click="closeModal" 
                class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:text-gray-900 font-bold rounded-xl transition-colors shadow-sm"
              >
                {{ cancelText }}
              </button>
              <button 
                type="button" 
                @click="onConfirm" 
                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-indigo-600/30"
              >
                {{ confirmText }}
              </button>
            </slot>
          </div>
        </div>
      </div>
    </transition>
  </Teleport>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  modalId: { type: String, required: true },
  title: { type: String, default: 'Modal Title' },
  confirmText: { type: String, default: 'محفوظ کریں' }, // Save
  cancelText: { type: String, default: 'منسوخ کریں' }, // Cancel
  modalSize: { 
    type: String, 
    default: 'md', 
    validator: (v) => ['sm', 'md', 'lg', 'xl', 'full'].includes(v)
  },
  hideHeader: { type: Boolean, default: false },
  hideFooter: { type: Boolean, default: false }
});

const emit = defineEmits(['close', 'confirm']);
const isOpen = ref(false);

const sizeClass = computed(() => {
  const map = {
    'sm': 'max-w-md',
    'md': 'max-w-lg',
    'lg': 'max-w-2xl',
    'xl': 'max-w-4xl',
    'full': 'max-w-[95vw] h-[95vh]'
  };
  return map[props.modalSize] || map['md'];
});

const openModal = () => { isOpen.value = true; };
const closeModal = () => { 
  isOpen.value = false; 
  emit('close'); 
};
const onConfirm = () => { emit('confirm'); };

defineExpose({ openModal, closeModal });
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: all 0.2s ease-out;
}
.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
.modal-enter-from .max-w-lg,
.modal-leave-to .max-w-lg {
  transform: scale(0.95) translateY(10px);
}
</style>
