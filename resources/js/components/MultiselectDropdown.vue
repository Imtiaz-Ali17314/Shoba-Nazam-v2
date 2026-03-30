<template>
  <multiselect
    v-model="internalValue"
    :options="options"
    :searchable="true"
    :close-on-select="true"
    :show-labels="false"
    :placeholder="placeholder"
    :track-by="trackBy"
    :label="labelKey"
    class="multiselect-custom w-full"
  >
    <!-- Option -->
    <template #option="{ option }">
      {{ formatOption(option) }}
    </template>

    <!-- Selected -->
    <template #singleLabel="{ option }">
      {{ formatOption(option) }}
    </template>
  </multiselect>
</template>

<script>
import { computed } from "vue";
import Multiselect from "vue-multiselect";

export default {
  name: "MultiselectDropdown",
  components: {
    Multiselect,
  },
  props: {
    modelValue: Object,
    options: {
      type: Array,
      required: true,
    },
    placeholder: {
      type: String,
      default: "Select option",
    },

    labelKey: {
      type: String,
      default: "name",
    },
    trackBy: {
      type: String,
      default: "id",
    },

    customLabel: Function,
  },

  emits: ["update:modelValue"],

  setup(props, { emit }) {
    const internalValue = computed({
      get: () => props.modelValue,
      set: (val) => emit("update:modelValue", val),
    });

    const formatOption = (option) => {
      if (props.customLabel) {
        return props.customLabel(option);
      }
      return option[props.labelKey];
    };

    return {
      internalValue,
      formatOption,
    };
  },
};
</script>

<style scoped>
:deep(.multiselect__tags) {
  width: 100%;
  height: 35px;
  background: #f9fafb;
  border: 1px solid #e5e7eb;
  border-radius: 0.5rem;
  font-size: 0.9rem;
}

:deep(.multiselect--active .multiselect__tags) {
  box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.5);
}

:deep(.multiselect__option--highlight) {
  background-color: #eef2ff;
  color: #4338ca;
}

:deep(.multiselect__single) {
  background: #f9fafb;
  font-size: 0.9rem;
}

:deep(.multiselect__input) {
  background: #f9fafb;
  font-size: 0.9rem;
}

:deep(.multiselect__option) {
  position: relative;
  transition: background-color 0.2s ease, color 0.2s ease, padding-left 0.2s ease;
}

</style>