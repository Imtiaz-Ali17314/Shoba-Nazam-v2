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
      <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3">4. Migrated Core UI Components</h2>
      
      <div class="space-y-8">
        <!-- Buttons -->
        <div class="border-b border-gray-200 pb-6">
          <h3 class="font-bold text-gray-700 mb-4 underline decoration-indigo-200 underline-offset-4">Buttons</h3>
          <div class="flex flex-wrap gap-4">
            <BgBtn label="Background Button" class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow" />
            <OutlineBtn label="Outline Button" class="border-2 border-indigo-600 text-indigo-600 px-4 py-2 rounded-lg" />
          </div>
        </div>

        <!-- ColorPicker -->
        <div class="border-b border-gray-200 pb-6">
          <h3 class="font-bold text-gray-700 mb-4 underline decoration-indigo-200 underline-offset-4">Color Picker</h3>
          <ColorPicker v-model="selectedColor" label="Choose Theme Color" />
          <p class="text-xs text-gray-500 mt-2">Selected: <span class="font-mono bg-gray-100 px-1 rounded">{{ selectedColor }}</span></p>
        </div>

        <!-- Flatpickr -->
        <div class="pb-2">
          <h3 class="font-bold text-gray-700 mb-4 underline decoration-indigo-200 underline-offset-4">Date Picker (Flatpickr)</h3>
          <div class="max-w-md">
            <Flatpickr v-model="selectedDate" placeholder="Select a date..." class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2" />
            <p class="text-xs text-gray-500 mt-2">Selected: <span class="font-mono bg-gray-100 px-1 rounded">{{ selectedDate || 'None' }}</span></p>
          </div>
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
