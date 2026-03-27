<template>
  <div dir="rtl" class="flex h-screen bg-gray-50 font-sans overflow-hidden text-gray-800">
    <!-- Sidebar -->
    <aside class="w-72 bg-white border-l border-gray-100 shadow-xl shadow-gray-200/40 z-20 flex flex-col transition-all duration-300">
      <!-- Logo Area -->
      <div class="h-20 flex items-center px-8 border-b border-gray-100 bg-gradient-to-l from-indigo-50/50 to-transparent">
        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/30 text-white me-3">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
        </div>
        <h1 class="text-2xl font-black text-gray-900 tracking-tight">شوبا نظام</h1>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
        <router-link to="/dashboard" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition-all group font-medium" active-class="bg-indigo-50 text-indigo-700 shadow-inner group">
          <svg class="w-5 h-5 me-3 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
          ڈیش بورڈ
        </router-link>
        
        <router-link to="/students" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition-all group font-medium" active-class="bg-indigo-50 text-indigo-700 shadow-inner group">
          <svg class="w-5 h-5 me-3 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
          طلباء
        </router-link>
        
        <router-link to="/discipline-records" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition-all group font-medium" active-class="bg-indigo-50 text-indigo-700 shadow-inner group">
          <svg class="w-5 h-5 me-3 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
          ڈسپلن
        </router-link>
        
        <router-link to="/users" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition-all group font-medium" active-class="bg-indigo-50 text-indigo-700 shadow-inner group">
          <svg class="w-5 h-5 me-3 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
          صارفین
        </router-link>
        
        <router-link to="/settings" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition-all group font-medium" active-class="bg-indigo-50 text-indigo-700 shadow-inner group">
          <svg class="w-5 h-5 me-3 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
          سیٹنگز
        </router-link>
      </nav>
    </aside>

    <!-- Main ContentWrapper -->
    <div class="flex-1 flex flex-col relative bg-gray-50/50">
      <!-- Top header -->
      <header class="h-20 bg-white/80 backdrop-blur-md px-8 flex items-center justify-between z-10 sticky top-0">
        <div class="flex items-center">
          <h2 class="text-xl font-bold tracking-tight text-gray-800">{{ $route.name || 'صفحہ' }}</h2>
        </div>
        
        <div class="flex items-center space-x-4 space-x-reverse">
          <button class="flex items-center p-2 text-gray-500 hover:bg-gray-100 rounded-full transition-colors relative">
            <span class="absolute top-1 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
          </button>
          
          <button @click="logout" class="group flex items-center px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-xl transition-all">
            <svg class="w-5 h-5 ml-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            لاگ آؤٹ
          </button>
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1 overflow-auto p-8 z-0">
        <router-view v-slot="{ Component }">
          <transition name="fade" mode="out-in">
            <component :is="Component" />
          </transition>
        </router-view>
      </main>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import axios from '../axios'
import { useAuthStore } from '../stores/authStore'

const router = useRouter()
const auth = useAuthStore()

const logout = async () => {
  try {
    await axios.post('/logout')
  } catch (e) {
    // If it fails (transient error), we still clear local session
  }
  auth.logout()
  router.push('/login')
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease, transform 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(10px);
}
</style>