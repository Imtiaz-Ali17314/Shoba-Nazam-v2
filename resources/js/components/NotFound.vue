<template>
  <div class="min-h-[60vh] flex flex-col items-center justify-center px-4">
    <div class="text-center">
      <h1 class="text-9xl font-black text-gray-200 drop-shadow-sm">404</h1>
      <h2 class="text-2xl font-bold text-gray-900 mt-4 tracking-tight">صفحہ نہیں ملا (Page Not Found)</h2>
      <p class="text-gray-500 mt-3 mb-8 max-w-md mx-auto font-medium">
        معذرت، جس صفحے کی آپ تلاش کر رہے ہیں وہ موجود نہیں ہے یا ہٹا دیا گیا ہے۔
      </p>
      <router-link 
        to="/dashboard" 
        class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-600/30 active:scale-95"
      >
        <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        ڈیش بورڈ پر واپس جائیں
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: "NotFound"
};
</script>
