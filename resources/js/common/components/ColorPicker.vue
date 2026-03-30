<template>
    <div class="color-picker-container">
        <label v-if="label" class="form-label d-flex align-items-center gap-2">
            {{ label }}:
            <span 
                v-if="modelValue" 
                class="py-1 px-2 rounded border shadow-sm" 
                :style="{ backgroundColor: modelValue, color: funcGen.getReadableTextColor(modelValue) }"
            >
                {{ modelValue }}
            </span>
        </label>
        
        <div class="color-boxes d-flex gap-1 flex-wrap mb-2">
            <div 
                v-for="color in validColors" 
                :key="color" 
                class="color-box rounded shadow-sm"
                :class="{ 'active': modelValue === color }"
                :style="{ backgroundColor: color }"
                @click="selectColor(color)"
            ></div>
        </div>
        
        <div class="d-flex align-items-center gap-2 mt-2" v-if="showCustom">
            <label class="form-label mb-0 small text-muted">Custom Color:</label>
            <input 
                :value="modelValue" 
                @input="onCustomInput" 
                type="color" 
                class="form-control form-control-color border-0 p-0" 
                style="width: 32px; height: 32px;" 
                title="System Color Picker"
            >
        </div>
    </div>
</template>

<script setup>
import { funcGen } from '@/common/utilities/generalFunction';

const props = defineProps({
    modelValue: String,
    label: {
        type: String,
        default: 'Color'
    },
    showCustom: {
        type: Boolean,
        default: true
    }
});

const emit = defineEmits(['update:modelValue']);

const validColors = [
    '#FFEB3B', '#FFF176', '#EEE600', '#FBBC06', '#FBC02D', '#FF9800', '#FF4500', '#E65100', '#ED9121', '#FFC48C', '#FFA07A', '#FFB3C1', '#E91E63', '#C21E56', '#880E4F', '#CC338B', '#DDA0DD', '#CE93D8', '#BA55D3', '#9400D3', '#4A148C', '#330066', '#2196F3', '#90CAF9', '#4169E1', '#0D47A1', '#6699CC', '#7FFFD4', '#32CD32', '#4CAF50', '#1B5E20', '#009966', '#A7ECAF', '#8FBC8F', '#808080', '#808087', '#36454F', '#CD5B45', '#DC143C',
];

const selectColor = (color) => {
    emit('update:modelValue', color);
};

const onCustomInput = (event) => {
    emit('update:modelValue', event.target.value);
};
</script>

<script>
export default {
    name: 'ColorPicker'
}
</script>

<style scoped>
.color-box {
    width: 32px;
    height: 32px;
    cursor: pointer;
    transition: transform 0.1s, border 0.1s;
    border: 2px solid transparent;
}

.color-box:hover {
    transform: scale(1.1);
}

.color-box.active {
    border-color: #000;
    transform: scale(1.05);
}
</style>
