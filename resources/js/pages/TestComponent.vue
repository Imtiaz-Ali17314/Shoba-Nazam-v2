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

    <!-- Migrated Components Section -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
      <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">4. Migrated Core UI Components</h2>
      
      <div class="space-y-6">
        <!-- Buttons -->
        <div>
          <h3 class="font-medium text-gray-700 mb-2">Buttons</h3>
          <div class="flex space-x-4 space-x-reverse">
            <BgBtn label="Background Button" class="bg-indigo-600 text-white" />
            <OutlineBtn label="Outline Button" class="border-indigo-600 text-indigo-600" />
          </div>
        </div>

        <!-- ColorPicker -->
        <div>
          <h3 class="font-medium text-gray-700 mb-2">Color Picker</h3>
          <ColorPicker v-model="selectedColor" label="Choose Theme Color" />
          <p class="text-xs text-gray-500 mt-1">Selected: {{ selectedColor }}</p>
        </div>

        <!-- Flatpickr -->
        <div class="max-w-md">
          <h3 class="font-medium text-gray-700 mb-2">Date Picker (Flatpickr)</h3>
          <Flatpickr v-model="selectedDate" placeholder="Select a date..." />
          <p class="text-xs text-gray-500 mt-1">Selected: {{ selectedDate }}</p>
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

import BgBtn from '../common/components/BgBtn.vue';
import OutlineBtn from '../common/components/OutlineBtn.vue';
import ColorPicker from '../common/components/ColorPicker.vue';
import Flatpickr from '../common/components/Flatpickr.vue';

export default {
  name: 'TestComponent',
  components: {
    Loader,
    Spinner,
    MultiselectDropdown,
    BgBtn,
    OutlineBtn,
    ColorPicker,
    Flatpickr
  },
  setup() {
    const selectedItem = ref(null);
    const dummyOptions = ref([
      { id: 1, name: 'Option A' },
      { id: 2, name: 'Option B' },
      { id: 3, name: 'Option C' },
    ]);

    const selectedColor = ref('#4F46E5');
    const selectedDate = ref('');

    return {
      selectedItem,
      dummyOptions,
      selectedColor,
      selectedDate
    }
  }
}
</script>
