<template>
  <div class="input-group flatpickr" :id="instanceId">
    <input 
      type="text" 
      autocomplete="off" 
      class="form-control" 
      :value="modelValue" 
      @input="$emit('update:modelValue', $event.target.value)"
      :placeholder="placeholder" 
      data-input 
    />
    <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
  </div>
</template>

<script setup>
import { ref, onMounted, watch, nextTick } from 'vue';
import { calc } from '@/common/utilities/flatPickerFunc';

const props = defineProps({
  modelValue: String,
  placeholder: {
    type: String,
    default: 'Select Date'
  },
  mode: {
    type: String,
    default: 'single' // single, range, multiple
  },
  enableTime: {
    type: Boolean,
    default: false
  },
  showCustomButtons: {
    type: Boolean,
    default: false
  },
  dateFormat: {
    type: String,
    default: 'Y-m-d'
  }
});

const emit = defineEmits(['update:modelValue', 'update:start_date']);

const instanceId = ref(`flatpickr-${Math.random().toString(36).substr(2, 9)}`);
const fpInstance = ref(null);

const initFlatPicker = () => {
  if (fpInstance.value) {
    fpInstance.value.destroy();
  }

  fpInstance.value = flatpickr(`#${instanceId.value}`, {
    mode: props.mode,
    wrap: true,
    dateFormat: props.dateFormat,
    enableTime: props.enableTime,
    allowInput: true,
    defaultDate: props.modelValue,
    onReady: (selectedDates, dateStr, instance) => {
      if (props.showCustomButtons) {
        calc.customBtn(instance);
      }
    },
    onClose: (selectedDates, dateStr) => {
      emit('update:modelValue', dateStr);
      // Compatibility with old usage
      emit('update:start_date', dateStr);
    },
    onChange: (selectedDates, dateStr) => {
      emit('update:modelValue', dateStr);
    }
  });
};

onMounted(() => {
  initFlatPicker();
  nextTick(() => {
    if (window.feather) window.feather.replace();
  });
});

watch(() => props.modelValue, (newVal) => {
  if (fpInstance.value) {
    const currentVal = fpInstance.value.input.value;
    if (newVal !== currentVal) {
      fpInstance.value.setDate(newVal || '', false);
    }
  }
});
</script>
