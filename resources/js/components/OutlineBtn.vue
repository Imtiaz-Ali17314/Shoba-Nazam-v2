<template>
  <button 
    v-if="!loading" 
    type="button" 
    :class="[
      'inline-flex items-center justify-center font-semibold transition-all rounded-xl border bg-transparent active:scale-95 focus:outline-none focus:ring-2 focus:ring-offset-2',
      text ? 'px-5 py-2.5' : 'p-2.5',
      color
    ]"
    @click="$emit('click', $event)"
  >
    <div class="flex items-center gap-2">
      <span v-if="is_icon" class="flex-shrink-0 flex items-center">
        <slot name="icon">
          <i v-if="icon" :class="icon"></i>
        </slot>
      </span>
      <span v-if="text">{{ text }}</span>
    </div>
  </button>
  
  <button 
    v-else 
    type="button" 
    disabled
    :class="[
      'inline-flex items-center justify-center font-semibold transition-colors rounded-xl border bg-transparent opacity-75 cursor-not-allowed',
      text ? 'px-5 py-2.5' : 'p-2.5',
      color
    ]"
  >
    <Spinner :class="['w-5 h-5 text-current', loaderText ? 'me-2' : '']" />
    <span v-if="loaderText">{{ loaderText }}</span>
  </button>
</template>

<script setup>
import Spinner from './Spinner.vue';

const props = defineProps({
  text: {
    type: String,
    default: ''
  },
  icon: {
    type: String,
    default: ''
  },
  color: {
    type: String,
    default: 'border-indigo-600 text-indigo-600 hover:bg-indigo-50 hover:border-indigo-700 hover:text-indigo-700 focus:ring-indigo-500' 
  },
  loading: {
    type: Boolean,
    default: false
  },
  loaderText: {
    type: String,
    default: 'لوڈ ہو رہا ہے...' // Default Urdu "Loading..."
  },
  is_icon: {
    type: Boolean,
    default: true
  }
});

defineEmits(['click']);
</script>
