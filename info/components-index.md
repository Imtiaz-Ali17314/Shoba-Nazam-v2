# Tracklo Reusable Components Index

This document outlines all the reusable Vue components available in the `/home/pc/Coding_Lab/work/tracklo/tracklo-local/resources/js/common/components` directory.

## Core UI Components
- **`BgBtn.vue`**: Button with a background color styling.
- **`OutlineBtn.vue`**: Button with an outline styling.
- **`BreadCrumb.vue`**: Navigation breadcrumbs component.
- **`ColorPicker.vue`**: Component for picking colors.
- **`Flatpickr.vue`**: Wrapper for the Flatpickr date/time selection library.
- **`InfoBar.vue`**: Informational banner or alert bar.
- **`LoaderComponent.vue`**: Full-page or block loading state indicator.
- **`SpinnerComponent.vue`**: Small loading spinner component.
- **`NoData.vue`**: Placeholder component displayed when no data is available (empty state).
- **`NotFound.vue`**: 404/Not Found generic display component.
- **`ReusableModal.vue`**: A standard, flexible modal/dialog component.

## Forms & Inputs
- **`MultiselectWithInfiniteScroll.vue`**: Complex multiselect component with infinite scrolling capabilities (likely for large datasets).
- **`select2Component.vue`**: Integration component for Select2-style dropdowns.
- **`Recaptcha.vue`**: Integration for Google reCAPTCHA.

## Overlays & Popovers
- **`CustomPopover.vue`**: Styled popover component for contextual information.
- **`RawPopover.vue`**: Basic popover positioning without built-in heavy styling.

## Image Handling
- **`imagePicker.vue`**: Component for selecting/uploading images.
- **`ImageCropper.vue`**: Component for cropping images before upload.
- **`imagePreviewBtn.vue`**: Button that triggers an image preview.
- **`ImagePreviewModal.vue`**: Modal specifically designed to display a larger image preview.
- **`ImagePreviewModalWithInfo.vue`**: Extended image preview modal that includes side/bottom information panels.

## Domain-Specific & Complex Components
- **`HtmlContentRenderer/HtmlContentRenderer.vue`**: Safely renders stored HTML content.
  - *`HtmlContentRenderer/component/SimpleImagePreview.vue`*: Used internally by the renderer for image tags.
- **`Select_company/SelectCompany.vue`**: Component to choose or switch an active company context.
  - *`Select_company/SelectCompanyModal.vue`*: Modal variant/container for company selection.
- **`textEditor/TextEditor.vue`**: Rich text editor component.
  - *`textEditor/helpers/editorHelper.js`*: Helper logic for the text editor.
  - *`textEditor/helpers/modalFocusHelper.js`*: Logic for handling focus conflicts when the editor is within a modal.
  - *`textEditor/mixins/EditorMixin.js`*: Reusable mixin logic for editor variations.
