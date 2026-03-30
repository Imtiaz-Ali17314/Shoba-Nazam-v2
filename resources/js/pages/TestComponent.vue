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

    <!-- BgBtn Component Section -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
      <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">4. BgBtn Component</h2>
      <div class="flex flex-wrap items-center gap-4">
        <BgBtn text="Primary Button" />
        
        <BgBtn 
          text="Success Button" 
          color="bg-emerald-500 hover:bg-emerald-600 text-white shadow-emerald-500/30 focus:ring-emerald-500" 
        />
        
        <BgBtn 
          text="Loading State" 
          :loading="true" 
          loaderText="Saving..." 
        />
        
        <BgBtn text="Icon Button">
          <template #icon>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
          </template>
        </BgBtn>
      </div>
    </div>

    <!-- OutlineBtn Component Section -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
      <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">5. OutlineBtn Component</h2>
      <div class="flex flex-wrap items-center gap-4">
        <OutlineBtn text="Primary Outline" />
        
        <OutlineBtn 
          text="Danger Outline" 
          color="border-red-500 text-red-500 hover:bg-red-50 hover:border-red-600 hover:text-red-600 focus:ring-red-500" 
        />
        
        <OutlineBtn 
          text="Loading State" 
          :loading="true" 
          loaderText="Processing..." 
        />
        
        <OutlineBtn text="Icon Outline">
          <template #icon>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
          </template>
        </OutlineBtn>
      </div>
    </div>

    <!-- LoaderComponent Section -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
      <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">6. LoaderComponent</h2>
      <div class="space-y-6">
        <div>
          <h3 class="text-sm font-semibold text-gray-500 mb-2">Block Loader:</h3>
          <div class="bg-gray-50 border border-gray-200 rounded-lg h-32 flex items-center justify-center">
            <LoaderComponent :show="true" loaderText="Please wait..." />
          </div>
        </div>
        
        <div>
          <h3 class="text-sm font-semibold text-gray-500 mb-2">Overlay Loader (covering container):</h3>
          <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-6 relative overflow-hidden">
            <p class="text-indigo-900 mb-4">This content is behind the loading overlay.</p>
            <LoaderComponent :show="true" :overlay="true" loaderText="Processing Data" />
          </div>
        </div>
      </div>
    </div>

    <!-- InfoBar Component Section -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
      <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">7. InfoBar Component</h2>
      <div class="space-y-4">
        <InfoBar 
          color="info" 
          context="اسسٹم کو اپڈیٹ کیا جا رہا ہے۔ براہ کرم کچھ دیر بعد کوشش کریں۔" 
        />
        
        <InfoBar 
          color="success" 
          context="<strong>کامیابی!</strong> ریکارڈ کامیابی سے محفوظ کر لیا گیا ہے۔" 
        />
        
        <InfoBar 
          color="danger" 
          context="ڈیٹا بیس سے رابطہ منقطع ہو گیا ہے۔" 
        />
        
        <InfoBar color="warning">
          یہ ایک <strong>کسٹم سلاٹ</strong> کا استعمال کر رہا ہے تاکہ زیادہ کنٹرول مل سکے۔
        </InfoBar>
      </div>
    </div>

    <!-- NoData & NotFound Section -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
      <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">8. NoData & NotFound Components</h2>
      
      <div class="space-y-12">
        <!-- NoData -->
        <div>
          <h3 class="text-lg font-semibold text-gray-600 mb-4 tracking-tight">NoData Empty State:</h3>
          <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
            <NoData />
          </div>
        </div>

        <!-- NotFound -->
        <div>
          <h3 class="text-lg font-semibold text-gray-600 mb-4 tracking-tight">NotFound 404 View:</h3>
          <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4 relative overflow-hidden">
            <!-- Render NotFound without scaling so it looks like a real page -->
            <NotFound />
          </div>
        </div>
      </div>
    </div>

    <!-- ReusableModal Section -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
      <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">9. ReusableModal Component</h2>
      
      <BgBtn text="Open Modal (Medium)" @click="$refs.myModal.openModal()" />
      <BgBtn text="Open Modal (Small)" color="bg-emerald-600 hover:bg-emerald-700 text-white shadow-emerald-600/30 ms-3" @click="$refs.smallModal.openModal()" />
      
      <ReusableModal 
        ref="myModal" 
        modalId="demo-modal" 
        title="Sample Modal Title"
        confirmText="Confirm Action"
        @confirm="handleModalConfirm"
      >
        <template #body>
           <p class="text-gray-600 leading-relaxed">This is a fully accessible, animated, and customizable modal component built with Tailwind CSS. It supports multiple sizes, click-outside-to-close, and custom slots for all sections!</p>
        </template>
      </ReusableModal>

      <ReusableModal 
        ref="smallModal" 
        modalId="small-modal" 
        modalSize="sm"
        title="Warning"
        confirmText="Delete"
        cancelText="Go Back"
      >
        <template #body>
           <p class="text-red-500 font-medium">Are you sure you want to delete this record? This action cannot be undone.</p>
        </template>
      </ReusableModal>

    </div>

    <!-- MultiselectWithInfiniteScroll Section -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
      <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">10. MultiselectWithInfiniteScroll Component</h2>
      
      <div class="max-w-md">
        <label class="block text-sm font-semibold text-gray-700 mb-2">Search Students (Paginated API Demo)</label>
        <MultiselectWithInfiniteScroll 
          ref="infiniteScrollSelect"
          v-model="selectedStudent" 
          label="sname"
          placeholder="طالب علم تلاش کریں..."
          :internalSearch="false"
        />
        <div class="mt-3 text-sm text-gray-500">
          Selected: <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ selectedStudent ? selectedStudent.sname : 'None' }}</span>
        </div>
      </div>
    </div>

    <!-- Popovers Section -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
      <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">11. Custom & Raw Popovers</h2>
      
      <div class="flex flex-wrap gap-8 items-center mt-8 mb-4">
        
        <!-- CustomPopover Trigger -->
        <span class="inline-flex items-center text-indigo-600 font-medium cursor-help border-b border-dashed border-indigo-400">
          Hover for Custom Popover
          <CustomPopover 
            title="معلومات (Information)"
            content="<p>This is a fully styled popover that renders HTML content safely. It has a beautiful rounded interface, subtle shadow depth, and automatic arrow positioning.</p>"
          />
        </span>

        <!-- RawPopover Trigger -->
        <span class="inline-flex items-center text-gray-700 font-medium cursor-help bg-gray-100 px-3 py-1.5 rounded-lg">
          Hover for Tooltip (Raw Popover)
          <RawPopover 
            content="I am a simple dark-themed tooltip."
          />
        </span>

      </div>
    </div>

  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import Loader from '../components/Loader.vue';
import Spinner from '../components/Spinner.vue';
import MultiselectDropdown from '../components/MultiselectDropdown.vue';
import BgBtn from '../components/BgBtn.vue';
import OutlineBtn from '../components/OutlineBtn.vue';
import LoaderComponent from '../components/LoaderComponent.vue';
import InfoBar from '../components/InfoBar.vue';
import NoData from '../components/NoData.vue';
import NotFound from '../components/NotFound.vue';
import ReusableModal from '../components/ReusableModal.vue';
import MultiselectWithInfiniteScroll from '../components/MultiselectWithInfiniteScroll.vue';
import CustomPopover from '../components/CustomPopover.vue';
import RawPopover from '../components/RawPopover.vue';

export default {
  name: 'TestComponent',
  components: {
    Loader,
    Spinner,
    MultiselectDropdown,
    BgBtn,
    OutlineBtn,
    LoaderComponent,
    InfoBar,
    NoData,
    NotFound,
    ReusableModal,
    MultiselectWithInfiniteScroll,
    CustomPopover,
    RawPopover
  },
  setup() {
    const selectedItem = ref(null);
    const selectedStudent = ref(null);
    const infiniteScrollSelect = ref(null);
    const dummyOptions = ref([
      { id: 1, name: 'Option A' },
      { id: 2, name: 'Option B' },
      { id: 3, name: 'Option C' },
    ]);

    const handleModalConfirm = () => {
      alert("Modal Confirmed!");
    };

    onMounted(() => {
      // Trigger the initial data fetch for the infinite scroll component targeting students endpoint
      if (infiniteScrollSelect.value) {
        infiniteScrollSelect.value.getData('/students');
      }
    });

    return {
      selectedItem,
      selectedStudent,
      infiniteScrollSelect,
      dummyOptions,
      handleModalConfirm
    }
  }
}
</script>
