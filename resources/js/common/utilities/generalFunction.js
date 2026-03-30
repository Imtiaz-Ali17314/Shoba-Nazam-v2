const cdnUrl = '';
const browserApps = new Set([
    "Google Chrome",
    "Google Chrome Canary",
    "Google Chrome Beta",
    "Google Chrome Dev",
    "Microsoft Edge",
    "Microsoft Edge Beta",
    "Microsoft Edge Dev",
    "Microsoft Edge Canary",
    "Mozilla Firefox",
    "Firefox",
    "Firefox Nightly",
    "Firefox Developer Edition",
    "Safari",
    "Opera",
    "Opera GX",
    "Opera Mini",
    "Opera Touch",
    "Brave",
    "Vivaldi",
    "Samsung Internet",
    "UC Browser",
    "Chromium",
    "Yandex Browser",
]);
let tooltipTriggerList;
const funcGen = {
    getFlatText(detail, num = 0) {
        if (!detail) {
            return "";
        }
        let textOnly = detail.replace(/<\/?[^>]+(>|$)/g, "");
        textOnly = textOnly.replace(/&[^;\s]+;/g, "");
        textOnly = textOnly.trim();
        if (num > 0) {
            return textOnly.length <= num
                ? textOnly
                : textOnly.slice(0, num);
        }
        return textOnly;
    },
    applyCDN(content) {
        if (content?.includes('src="/')) {
            content = content.replace(/<img\s+[^>]*src=["'](\/[^"']*)["'][^>]*>/g, (match, srcPath) => {
            if (srcPath.startsWith(cdnUrl)) {
                return match
            }
            const newPath = `${cdnUrl}${srcPath}`
            return match.replace(srcPath, newPath)
            })
            content = content.replace(
            /<(video|source)\s+[^>]*src=['"]?(\/[^'">\s]+)['"]?[^>]*>/gi,
            (match, tag, srcPath) => {
                if (srcPath.startsWith(cdnUrl)) return match
                return match.replace(srcPath, `${cdnUrl}${srcPath}`)
            }
            )
        }
        return content
    },

    toastMixin() {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger me-2",
            },
            buttonsStyling: false,
        });

        swalWithBootstrapButtons
            .fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonClass: "me-2",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true,
            })
            .then((result) => {
                if (result.value) {
                    swalWithBootstrapButtons.fire(
                        "Deleted!",
                        "Your file has been deleted.",
                        "success"
                    );
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        "Cancelled",
                        "Your imaginary file is safe :)",
                        "error"
                    );
                }
            });
    },
    tostMin(msg) {
        toast.fire({
            icon: "success",
            timer: 3000,
            title: msg,
        });
    },
    tostErr(err) {
        toast.fire({
            icon: "error",
            timer: 3000,
            title: err,
        });
    },

    hideTooltips() {
        if (tooltipTriggerList) {
            tooltipTriggerList.forEach((tooltip) => {
                const tooltipInstance = bootstrap.Tooltip.getInstance(tooltip);
                if (tooltipInstance) {
                    tooltipInstance.hide();
                }
            });
        }
    },

    is_company() {
        return false;
    },
 getLocalStorageSize() {
        let totalSize = 0;

        // Loop through all the keys in localStorage
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            const value = localStorage.getItem(key);

            // Add the size of the key and value to the total
            totalSize += key.length + value.length;
        }

        // Return the total size in bytes
        return (totalSize/ 1024).toFixed(2) + " KB";
    },
    getReadableTextColor(bgColor) {
        if (!bgColor) return "#000";
        const hex = bgColor.replace("#", "");
        const r = parseInt(hex.substring(0, 2), 16);
        const g = parseInt(hex.substring(2, 4), 16);
        const b = parseInt(hex.substring(4, 6), 16);
        const brightness = (r * 299 + g * 587 + b * 114) / 1000;
        return brightness > 125 ? "#000" : "#fff";
    },

    handleBackendError(error) {
        if (error.response && error.response.status === 422) {
            const backendErrors = error.response.data.errors;
            const firstError = Object.values(backendErrors)[0][0];
            this.tostErr(firstError);
            return backendErrors;
        } else if (error.response && error.response.status === 413) {
            const errorMsg = "File too large for server. Please upload a smaller image.";
            this.tostErr(errorMsg);
            return { error: errorMsg };
        } else if (error.response && error.response.data.error) {
            this.tostErr(error.response.data.error);
            return { error: error.response.data.error };
        }
        return null;
    },
};
export { funcGen };


export function    tooltipInit() {
    tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            delay: { show: 600, hide: 100 },
        });
    });
};


export const getImage = (row) => {
    if (row.logo_path) {
        return `${cdnUrl}/${row.logo_path}`;
    }
    const isBrowser = browserApps.has(row.app);
    return isBrowser ? "/icons/web-placeholder.png" : "/icons/app-placeholder.png";
}
export const getTitle = (row) => {
    if(row.mapped_title){
        return row.mapped_title;
    }
    if(row.title){
        return row.title;
    }
  return  row.screenshot ? row.screenshot.split('/').pop() : "";
}


export const calculateProgress = (activity) => {
        let workOnTime = 0;
        activity.details.forEach((row) => {
            if (row.clicks > 0 || row.keyPresses > 0) {
                workOnTime += 1;
            }
        });
        const progress = (workOnTime / activity.interval_time) * 100;
        return progress > 100 ? 100 : progress.toFixed(0);
    }


    export function addCdnUrlToImagePaths(content) {
    if (content?.includes('src="/')) {
        content = content.replace(
            /<img\s+[^>]*src=["'](\/[^"']*)["'][^>]*>/g,
            (match, srcPath) => {
                if (srcPath.startsWith(cdnUrl)) {
                    return match;
                }
                const newPath = `${cdnUrl}${srcPath}`;
                return match.replace(srcPath, newPath);
            }
        );
    }
   return content;
}

export function openTabFromHash() {
    const hash = window.location.hash;

    if (hash) {
        const targetTab = document.querySelector(`a[data-bs-target="${hash}"]`);

        if (targetTab) {
            // If it's a nested tab (inside another parent tab), open the parent first
            const parentTabPane = targetTab.closest('.tab-pane');
            if (parentTabPane && parentTabPane.id) {
                const parentTabTrigger = document.querySelector(
                    `a[data-bs-target="#${parentTabPane.id}"]`
                );
                if (parentTabTrigger) {
                    const parentTab = new bootstrap.Tab(parentTabTrigger);
                    parentTab.show();
                }
            }

            // Then open the target (nested) tab
            const nestedTab = new bootstrap.Tab(targetTab);
            nestedTab.show();
        }
    }
};
export function openThisTab() {
    document.addEventListener("click", (e) => {
        const tab = e.target.closest('[data-bs-toggle="tab"]');
        if (!tab) return;

        const target = tab.getAttribute("data-bs-target");
        if (target) {
            history.replaceState(null, "", target);
        }
    });
};

export function enableScroll() {
    try {
        document.body.style.overflow = '';
        document.documentElement.style.overflow = '';
        document.body.style.position = '';
        document.documentElement.style.touchAction = '';
        // remove common classes added by modals/editors/plugins
        document.body.classList.remove('modal-open', 'overflow-hidden', 'tox-dialog__disable-scroll');
        // clear any touchmove lock if set as handler
        try { document.ontouchmove = null; } catch (e) { }
    } catch (e) {
        console.warn('enableScroll error', e);
    }
};
