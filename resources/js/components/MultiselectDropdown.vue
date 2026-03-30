<template>
 <multiselect v-model="internalValue" :options="enhancedOptions" :searchable="true" :internal-search="true"
    :close-on-select="true" :show-labels="false" :placeholder="placeholder" :track-by="trackBy" label="__search"
    class="multiselect-custom w-full">
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
      default: () => [],
    },
    placeholder: String,

    labelKey: {
      type: String,
      default: "name",
    },

    trackBy: {
      type: String,
      default: "id",
    },

    customLabel: Function,

    searchFields: {
      type: Array,
      default: () => [],
    },
  },

  emits: ["update:modelValue"],

  setup(props, { emit }) {
    // v-model binding
    const internalValue = computed({
      get: () => props.modelValue,
      set: (val) => emit("update:modelValue", val),
    });

    // custom label formatter
    const formatOption = (option) => {
      if (!option) return "";
      if (props.customLabel) return props.customLabel(option);
      return option[props.labelKey];
    };

    // 🔥 Multi-field searchable options
    const enhancedOptions = computed(() => {
      if (!props.searchFields.length) return props.options;

      return props.options.map((option) => {
        const searchText = props.searchFields
          .map((field) => option[field] || "")
          .join(" ")
          .toLowerCase();

        return {
          ...option,
          __search: searchText,
        };
      });
    });

    return {
      internalValue,
      formatOption,
      enhancedOptions,
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

:deep(.multiselect__single),
:deep(.multiselect__input) {
  background: #f9fafb;
  font-size: 0.9rem;
}

:deep(.multiselect__option) {
  transition: all 0.2s ease;
}
</style>