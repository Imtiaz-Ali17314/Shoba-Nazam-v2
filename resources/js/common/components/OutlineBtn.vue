<template>
    <button type="button" :class="[ text ? 'btn h-px-40' : 'btn p-0 h-px-37', color, 'pd-y-px-8', 'text-end',  'd-inline-flex text-nowrap' ]">
      <span class="d-flex gap-2 align-items-center d-inline-flex text-nowrap">
        <span  v-if="materialIcon" :class="['icon-color',text ? 'px-0' : 'px-2']" class="material-icons material-symbols-outlined">{{ materialIcon }}</span>
        <i v-else  class="pd-x-px-8" :class="['icon-color',icon ? icon : text ? ' fa-solid fa-square-plus px-0 font-24' : 'fa-solid fa-plus font-24']"></i>
        {{ text }}
      </span>
    </button>
  </template>

  <script>
  export default {
    name: 'OutlineBtn',
    props: {
      text: {
        type: String,
        default: ''
      },
      icon: {
        type: String,
        default: ''
      },
      materialIcon: {
        type: String,
        default: ''
      },
      color: {
        type: String,
        default: 'btn-outline-primary'
      },
      iconColor: {
        type: String,
        default: 'text-primary'
      },
    }
  };
  </script>

<style lang="scss" scoped>
.icon-color {
  color: v-bind('iconColor'); 
  transition: color 0.2s ease;
}
button:hover .icon-color {
  color: white !important;
}
</style>
