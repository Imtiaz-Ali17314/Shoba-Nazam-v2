<template>
    <div class="modal fade" :id="modalId" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" :class="modalSize">
            <div class="modal-content">
                <div class="modal-header" v-if="!hideHeader">
                    <h5 class="modal-title" id="modalLabel">
                        <slot name="title">{{ title }}</slot>
                    </h5>
                    <button type="button" @click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>

                <div class="modal-body">
                    <slot name="body"></slot>
                </div>

                <div class="modal-footer" v-if="!hideFooter">
                    <slot name="footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-primary" @click="onConfirm">
                            {{ confirmText }}
                        </button>
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

const props = defineProps({
    modalId: {
        type: String,
        required: true
    },
    title: {
        type: String,
        default: 'Modal Title'
    },
    confirmText: {
        type: String,
        default: 'Save'
    },
    modalSize: {
        type: String,
        default: '', // '', 'modal-sm', 'modal-lg', 'modal-xl'
        validator: (value) => ['', 'modal-sm', 'modal-lg', 'modal-xl'].includes(value)
    },
    hideHeader: {
        type: Boolean,
        default: false
    },
    hideFooter: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['close', 'confirm']);

const openModal = () => {
    $(`#${props.modalId}`).modal('show');
};

const closeModal = () => {
    $(`#${props.modalId}`).modal('hide');
    emit('close');
};

const onConfirm = () => {
    emit('confirm');
};

// Expose methods to parent component
defineExpose({
    openModal,
    closeModal
});
</script>

<style scoped>
.modal {
    --bs-modal-zindex: 1055;
}
</style>
