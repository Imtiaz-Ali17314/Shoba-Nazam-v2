<template>
  <div class="p-8 space-y-8 bg-gray-50 min-h-screen">
    <div>
      <h1 class="text-3xl font-extrabold text-gray-900 mb-6">Test Component / Playground</h1>
      <p class="text-gray-500 mb-8">This is a testing ground for reusable components in the system, similar to the test component in Tracklo.</p>
    </div>

    <!-- Loader Component Section -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
      <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">1. Loader Component</h2>
      <div class="relative h-32 bg-gray-50 rounded-lg flex items-center justify-center border border-gray-200">
        <Loader :show="true" />
      </div>
    </div>

    <!-- Spinner Component Section -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
      <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">2. Spinner Component</h2>
      <div class="flex items-center space-x-4">
        <Spinner class="w-8 h-8 text-indigo-600" />
        <span class="text-gray-600 font-medium">Loading data...</span>
      </div>
    </div>

    <!-- MultiselectDropdown Component Section -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
      <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">3. Multiselect Dropdown Component</h2>
      <div class="max-w-md">
        <label class="block text-sm font-semibold text-gray-700 mb-2">Select Item</label>
        <MultiselectDropdown 
          v-model="selectedItem" 
          :options="dummyOptions" 
          placeholder="Search and select..."
          labelKey="name" 
          trackBy="id" 
          :searchFields="['name']" 
        />
        <div class="mt-3 text-sm text-gray-500">
          Selected: <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ selectedItem ? selectedItem.name : 'None' }}</span>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import { ref } from 'vue';
import Loader from '../components/Loader.vue';
import Spinner from '../components/Spinner.vue';
import MultiselectDropdown from '../components/MultiselectDropdown.vue';

export default {
  name: 'TestComponent',
  components: {
    Loader,
    Spinner,
    MultiselectDropdown
  },
  setup() {
    const selectedItem = ref(null);
    const dummyOptions = ref([
      { id: 1, name: 'Option A' },
      { id: 2, name: 'Option B' },
      { id: 3, name: 'Option C' },
    ]);

    return {
      selectedItem,
      dummyOptions
    }
  }
}
</script>
