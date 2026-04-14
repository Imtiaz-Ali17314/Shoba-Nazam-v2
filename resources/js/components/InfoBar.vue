<template>
  <div :class="[
    'flex items-start gap-3 p-4 rounded-xl border font-medium text-sm leading-relaxed', 
    colorClass
  ]" role="alert">
    
    <div class="flex-shrink-0 mt-0.5">
      <slot name="icon">
        <i v-if="icon" :class="[icon, 'text-xl']"></i>
        <svg v-else class="w-6 h-6 opacity-80" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
        </svg>
      </slot>
    </div>
    
    <div class="flex-1 w-full overflow-hidden self-center">
      <slot>
        <div v-if="context" v-html="context" class="prose prose-sm max-w-none"></div>
      </slot>
    </div>

  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  context: {
    type: String,
    default: ''
  },
  color: {
    type: String,
    default: 'warning' // 'info', 'success', 'danger', 'warning', 'indigo'
  },
  icon: {
    type: String,
    default: ''
  }
});

const colorClass = computed(() => {
  const map = {
    warning: 'bg-amber-50 text-amber-800 border-amber-200',
    info: 'bg-blue-50 text-blue-800 border-blue-200',
    success: 'bg-emerald-50 text-emerald-800 border-emerald-200',
    danger: 'bg-red-50 text-red-800 border-red-200',
    indigo: 'bg-indigo-50 text-indigo-800 border-indigo-200'
  };
  
  return map[props.color] || map.warning;
});
</script>
