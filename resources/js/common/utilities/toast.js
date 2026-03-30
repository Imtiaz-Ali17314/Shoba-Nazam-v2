export function toastSuccess(message) {
    toast.fire({
        icon: "success",
        timer: 3000,
        title: message || "Data updated successfully",
    });
}
export function toastError(message, timer = 3000) {
    toast.fire({
        icon: "error",
        timer: timer,
        title: message || "Something went wrong \n Try Later",
    });
}
export function toastWarning(message, timer = 3000) {
    toast.fire({
        icon: "warning",
        timer: timer,
        title: message || "Warning",
    });
}
export function swalInfo({
    title = "",
    text = "",
    html = "",
    icon = "info",
    confirmText = "OK",
}) {
    return Swal.fire({
        title,
        text,
        html,
        icon,
        confirmButtonText: confirmText,
    });
}

export function swalConfirm({
    title = "Are you sure?",
    text = "",
    html = "",
    icon = "warning",
    confirmText = "Yes, proceed!",
    cancelText = "Cancel",
    denyText = "Don't save",
    confirmColor = "#3085d6",
    cancelColor = "#d33",
    denyColor = "#aaa",
    showDenyButton = false,
}) {
    return Swal.fire({
        title,
        text,
        html,
        icon,
        showCancelButton: true,
        showDenyButton,
        confirmButtonColor: confirmColor,
        cancelButtonColor: cancelColor,
        denyButtonColor: denyColor,
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
        denyButtonText: denyText,
    });
}

export function swalConfirmWithTextValidation({
    title = "Are you sure?",
    text = "",
    html = "",
    icon = "warning",
    confirmText = "Yes, proceed!",
    cancelText = "Cancel",
    confirmColor = "#3085d6",
    cancelColor = "#d33",
    denyText = null,

    // OPTIONAL — only used when validation input exists
    requiredText = "Confirm",
    inputId = "projectTitleInput", // default for your existing components
}) {
    return Swal.fire({
        title,
        text,
        html,
        icon,
        showCancelButton: true,
        showDenyButton: !!denyText,
        denyButtonText: denyText,
        denyButtonColor: "#ffc107",
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
        confirmButtonColor: confirmColor,
        cancelButtonColor: cancelColor,

        preConfirm: () => {
            const input = document.getElementById(inputId);

            // If no input exists → do NOT block confirmation (backward compatibility)
            if (!input) return true;

            const value = input.value.trim();

            if (value.toLowerCase() !== requiredText.toLowerCase()) {
                Swal.showValidationMessage(
                    `You must type "${requiredText}" exactly to proceed.`
                );
                return false;
            }

            return true;
        },

        customClass: {
            denyButton: "my-deny-button",
        },
    });
}



export function swalConfirmWithInputValidation({
    title = "Are you sure?",
    text = "",
    html = "",
    confirmText = "Yes, proceed!",
    cancelText = "Cancel",
    validationText = "confirm",
    inputPlaceholder = `Type '${validationText}' to confirm`,
    confirmColor = "#3085d6",
    cancelColor = "#d33",
    denyText = null,
}) {
    return Swal.fire({
        title,
        text,
        html,
        input: "text",
        inputPlaceholder,
        inputAttributes: {
            autocapitalize: "off",
        },
        showCancelButton: true,
        buttonsStyling: true,
        confirmButtonColor: confirmColor,
        cancelButtonColor: cancelColor,
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
        showDenyButton: denyText && true,
        denyButtonText: denyText,
        denyButtonColor: "#ffc107",
        preConfirm: (inputValue) => {
            if (!inputValue || inputValue.trim().length < 2) {
                Swal.showValidationMessage("Please enter a valid Input.");
                return false;
            }
            return inputValue.trim();
        },
        customClass: {
            denyButton: "my-deny-button",
        },
    });
}

export async function swalConfirmWithSkip(message) {
    const today = new Date().toISOString().split("T")[0];
    const skipDate = localStorage.getItem("skip_delete_confirm");

    if (skipDate === today) return true;

    const result = await Swal.fire({
        title: "Confirmation",
        html: `
            Are you sure <br/>
            you want to delete 
            <b>${message}</b>?
            <br/><br/>
            <label style="font-size:14px;">
                <input 
                    type="checkbox" 
                    id="skipToday" 
                    style="transform: scale(1.5); margin-right:6px;"
                />
                Don't show for today
            </label>
        `,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Delete it!",
    });

    if (!result.isConfirmed) return false;

    if (document.getElementById("skipToday")?.checked) {
        localStorage.setItem("skip_delete_confirm", today);
    }

    return true;
}

