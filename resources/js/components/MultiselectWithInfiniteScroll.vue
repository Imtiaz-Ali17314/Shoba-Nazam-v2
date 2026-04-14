<template>
  <div class="relative w-full">
    <multiselect 
      v-model="internalSelectedItem" 
      :options="multiselectData" 
      :loading="isLoading" 
      :disabled="disabled && multiselectData.length <= 0" 
      :label="label" 
      :track-by="'id'" 
      :show-labels="false" 
      :placeholder="placeholder" 
      :internal-search="internalSearch" 
      ref="multiselectRef" 
      @open="attachScrollListener" 
      @search-change="asyncFind"
      class="multiselect-custom"
    >
      <template #noResult>کوئی نتیجہ نہیں ملا (No Result Found)</template>
      <template #noOptions>فہرست خالی ہے (List is empty)</template>
    </multiselect>
  </div>
</template>

<script setup>
import { ref, watch, nextTick } from 'vue';
import Multiselect from 'vue-multiselect';
import axios from '../axios';

const props = defineProps({
  modelValue: {
    type: [Object, String, Number, Array],
    default: null
  },
  label: {
    type: String,
    default: 'name', // typically 'name' in Shoba-Nazam instead of 'title'
  },
  placeholder: {
    type: String,
    default: 'منتخب کریں...', // select
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  internalSearch: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(['update:modelValue', 'selectedItem']);

const page = ref(1);
const isFirstBottom = ref(true);
const hasMore = ref(true);
const isLoading = ref(false);
const multiselectData = ref([]);
const search_query = ref("");
const internalSelectedItem = ref(props.modelValue);
const multiselectUrl = ref('');
const multiselectRef = ref(null);

watch(() => props.modelValue, (newVal) => {
  internalSelectedItem.value = newVal;
}, { deep: true });

watch(internalSelectedItem, (newVal) => {
  emit('update:modelValue', newVal);
  emit('selectedItem', newVal);
});

const attachScrollListener = () => {
  setTimeout(() => {
    const dropdownMenu = multiselectRef.value?.$el.querySelector('.multiselect__content-wrapper');
    if (!dropdownMenu) return;
    dropdownMenu.removeEventListener("scroll", onScroll);
    dropdownMenu.addEventListener("scroll", onScroll, {
      once: false,
    });
    isFirstBottom.value = false;
  }, isFirstBottom.value ? 0 : 300);
};

const onScroll = (e) => {
  if (isLoading.value || !hasMore.value) return;
  const el = e.target;
  if (el.scrollTop + el.clientHeight >= el.scrollHeight - 50) {
    getData();
  }
};

const asyncFind = (query) => {
  search_query.value = query;
  if (!query) {
    multiselectData.value = [];
    getData();
    return;
  }
  
  if (props.internalSearch) {
    const hasMatch = multiselectData.value.some(item => 
      String(item[props.label] || '').toLowerCase().includes(query.toLowerCase())
    );
    if (hasMatch) return;
  }

  multiselectData.value = [];
  isLoading.value = true;
  page.value = 1;
  hasMore.value = true;
  debouncedGetData();
};

let timeoutId = null;
const debouncedGetData = () => {
  clearTimeout(timeoutId);
  timeoutId = setTimeout(() => {
    getData();
  }, 400); // 400ms debounce for search
};

const getData = async (url = null, preSelected = null) => {
  if (url) {
    clearData();
    multiselectUrl.value = url;
  }

  if (!multiselectUrl.value || !hasMore.value) return;

  isLoading.value = true;

  try {
    const response = await axios.get(multiselectUrl.value, {
      params: {
        page: page.value,
        search: search_query.value, // mapping search_query to search for generic Shoba api
      }
    });

    // Handle Laravel standard pagination { data: [...], current_page: 1, last_page: x } OR simple array
    const responseData = response.data.data ? response.data.data : response.data;
    
    if (responseData && responseData.length > 0) {
      if (search_query.value && page.value === 1) {
        multiselectData.value = [...responseData];
      } else {
        multiselectData.value.push(...responseData);
      }
      
      // Update hasMore based on Laravel pagination if available
      if (response.data.current_page && response.data.last_page) {
        hasMore.value = response.data.current_page < response.data.last_page;
        page.value = response.data.current_page + 1;
      } else {
        // Fallback for custom structure
        page.value++; 
      }
    } else {
      hasMore.value = false;
    }
  } catch (error) {
    console.error("Multiselect Data Fetch Error:", error);
  } finally {
    isLoading.value = false;
  }

  if (preSelected !== null) {
    await nextTick();
    internalSelectedItem.value = preSelected;
  }
};

const clearData = () => {
  page.value = 1;
  hasMore.value = true;
  isLoading.value = false;
  multiselectData.value = [];
  search_query.value = "";
  internalSelectedItem.value = null;
};

defineExpose({
  getData,
  clearData,
});
</script>

<style scoped>
:deep(.multiselect__tags) {
  width: 100%;
  min-height: 44px;
  background: #f9fafb;
  border: 1px solid #e5e7eb;
  border-radius: 0.75rem;
  font-size: 0.95rem;
  padding: 10px 40px 0 16px;
}

:deep(.multiselect--active .multiselect__tags) {
  box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
  border-color: #6366f1;
}

:deep(.multiselect__option--highlight) {
  background-color: #eef2ff;
  color: #4338ca;
}

:deep(.multiselect__single),
:deep(.multiselect__input) {
  background: transparent;
  font-size: 0.95rem;
  margin-bottom: 0px;
}

:deep(.multiselect__spinner) {
  background: transparent;
}
:deep(.multiselect__spinner:before),
:deep(.multiselect__spinner:after) {
  border-top-color: #6366f1;
}
</style>
