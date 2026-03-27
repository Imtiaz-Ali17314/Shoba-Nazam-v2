<template>
  <div dir="rtl" class="flex h-screen bg-gray-100 font-sans">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md">
      <div class="p-4 text-xl font-bold border-b">شوبا نظام</div>
      <nav class="mt-4">
        <ul>
          <li class="p-2 hover:bg-gray-200">
            <router-link to="/dashboard">ڈیش بورڈ</router-link>
          </li>
          <li class="p-2 hover:bg-gray-200">
            <router-link to="/students">طلباء</router-link>
          </li>
          <li class="p-2 hover:bg-gray-200">
           <router-link to="/discipline-records">ڈسپلن</router-link>
          </li>
          <li class="p-2 hover:bg-gray-200">
            <router-link to="/users">صارفین</router-link>
          </li>
          <li class="p-2 hover:bg-gray-200">
            <router-link to="/settings">سیٹنگز</router-link>
          </li>
        </ul>
      </nav>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col">
      <!-- Header -->
      <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-lg font-semibold">صفحة</h1>
        <div>
          <button class="px-4 py-2 bg-red-500 text-white rounded">لاگ آؤٹ</button>
        </div>
      </header>

      <!-- Page content -->
      <main class="flex-1 p-6 overflow-auto">
        <router-view></router-view>
      </main>

      <!-- Footer -->
      <footer class="bg-white text-center p-4 shadow-inner">
        © 2026 شوبا نظام
      </footer>
    </div>
  </div>
</template>

<script setup>
// JS logic agar zarurat ho to yahan
</script>

<style scoped>
/* Optional: additional RTL or layout styling */
</style>