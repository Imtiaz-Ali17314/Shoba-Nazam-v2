<template>
    <button v-if="!loading" type="button" :class="[ text ? 'btn h-px-40' : 'btn p-0 h-px-39', color,  'pd-y-px-8', 'text-end' , 'd-inline-flex text-nowrap']">
        <span  class="d-flex gap-2 align-items-center">
        <span   v-if="materialIcon && is_icon" :class="['icon-color',text ? 'px-0' : 'px-2']" class="material-icons material-symbols-outlined">{{ materialIcon }}</span>
         <i v-if="!materialIcon && is_icon" class="pd-x-px-8"   :class="['icon-color',icon ? icon : text ? ' fa-solid fa-square-plus px-0 font-24' : 'fa-solid fa-plus font-24']"></i>
            {{ text }}
        </span>
    </button>
    <button v-else type="button" class="btn btn-outline-primary h-px-39 text-center" >
        <LoaderComponent :loaderText="loaderText"/>
    </button>
    </template>
    <script>
        import LoaderComponent from '@/common/components/LoaderComponent.vue';
    export default {
        
        name: 'BgBtn',
        components:{
            LoaderComponent,
        },
        props: {
            text: {
                type: String,
                default: ''
            },
            icon: {
                type: String,
                default: ''
            },
            color: {
                type: String,
                default: 'btn-primary' // Example class
            },
            materialIcon: {
                type: String,
                default: ''
            },
            iconColor: {
                type: String,
                default: 'text-primary'
            },
            loading:{
                type:Boolean,
                default: false
            },
            loaderText:{
               type: String,
                default: 'Loading ...'
            },
            is_icon:{
                type:Boolean,
                default: true
            }
        },


    };
    </script>


    <style lang="scss" scoped>

    /* Add styling if needed */
    </style>
