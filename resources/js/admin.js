/**
 * Admin shell behaviour. Vanilla JS, event delegation, safe to run twice.
 * The login page does not use the `.admin-app` scope, so form-submit loading
 * never touches the bespoke login button.
 */
const initAdminShell = () => {
    if (window.__adminShellInitialized) {
        return;
    }
    window.__adminShellInitialized = true;

    const drawer = document.querySelector('[data-drawer]');
    const overlay = document.querySelector('[data-drawer-overlay]');
    const toggle = document.querySelector('[data-drawer-toggle]');

    const setDrawer = (open) => {
        if (!drawer) {
            return;
        }

        drawer.classList.toggle('-translate-x-full', !open);
        drawer.classList.toggle('translate-x-0', open);

        if (overlay) {
            overlay.classList.toggle('hidden', !open);
        }

        if (toggle) {
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        }

        document.body.classList.toggle('overflow-hidden', open);
    };

    const activateTab = (group, tab) => {
        const tabs = Array.from(group.querySelectorAll('[data-tab]'));
        const panels = Array.from(group.querySelectorAll('[data-tab-panel]'));

        tabs.forEach((item) => {
            const isActive = item === tab;
            item.setAttribute('aria-selected', isActive ? 'true' : 'false');
            item.tabIndex = isActive ? 0 : -1;
        });

        panels.forEach((panel) => {
            panel.hidden = panel.dataset.tabPanel !== tab.dataset.tab;
        });
    };

    document.addEventListener('click', (event) => {
        if (event.target.closest('[data-drawer-toggle]')) {
            setDrawer(true);
            drawer?.querySelector('a, button')?.focus();
            return;
        }

        if (event.target.closest('[data-drawer-close]') || event.target === overlay) {
            setDrawer(false);
            toggle?.focus();
            return;
        }

        const drawerLink = event.target.closest('[data-drawer] a[href]');
        if (drawerLink && window.innerWidth < 1024) {
            setDrawer(false);
        }

        const dismiss = event.target.closest('[data-dismiss]');
        if (dismiss) {
            dismiss.closest('[data-alert]')?.remove();
            return;
        }

        const tab = event.target.closest('[data-tab]');
        if (tab) {
            const group = tab.closest('[data-tabs]');
            if (group) {
                event.preventDefault();
                activateTab(group, tab);
                tab.focus();
            }
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setDrawer(false);
        }

        const tablist = event.target.closest('[role="tablist"]');
        if (!tablist) {
            return;
        }

        const keys = ['ArrowLeft', 'ArrowRight', 'Home', 'End'];
        if (!keys.includes(event.key)) {
            return;
        }

        const tabs = Array.from(tablist.querySelectorAll('[data-tab]')).filter((tab) => !tab.disabled);
        const current = tabs.indexOf(document.activeElement);
        if (current === -1 || tabs.length === 0) {
            return;
        }

        event.preventDefault();

        let next = current;
        if (event.key === 'ArrowRight') {
            next = (current + 1) % tabs.length;
        } else if (event.key === 'ArrowLeft') {
            next = (current - 1 + tabs.length) % tabs.length;
        } else if (event.key === 'Home') {
            next = 0;
        } else if (event.key === 'End') {
            next = tabs.length - 1;
        }

        const group = tablist.closest('[data-tabs]');
        if (group) {
            activateTab(group, tabs[next]);
        }
        tabs[next].focus();
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            setDrawer(false);
        }
    });

    // Auto-dismiss success flashes after five seconds.
    document.querySelectorAll('[data-alert-autohide]').forEach((alert) => {
        window.setTimeout(() => {
            alert.classList.add('opacity-0');
            window.setTimeout(() => alert.remove(), 200);
        }, 5000);
    });

    // Submit feedback: never prevent the actual submit.
    document.addEventListener('submit', (event) => {
        if (event.defaultPrevented) {
            return;
        }

        const form = event.target;
        if (!(form instanceof HTMLFormElement) || !form.closest('.admin-app')) {
            return;
        }

        const submitter = event.submitter || form.querySelector('button[type="submit"], input[type="submit"]');
        if (!submitter) {
            return;
        }

        submitter.setAttribute('data-loading', '');
        submitter.setAttribute('aria-busy', 'true');

        window.setTimeout(() => {
            if (submitter.tagName === 'BUTTON') {
                submitter.disabled = true;
            }
        }, 0);
    });

    // Re-enable buttons restored from the bfcache.
    window.addEventListener('pageshow', (event) => {
        if (!event.persisted) {
            return;
        }

        document.querySelectorAll('[data-loading]').forEach((element) => {
            element.removeAttribute('data-loading');
            element.removeAttribute('aria-busy');
            if (element.tagName === 'BUTTON') {
                element.disabled = false;
            }
        });
    });

    // Live image preview for file inputs.
    document.querySelectorAll('input[data-file-preview]').forEach((input) => {
        input.addEventListener('change', () => {
            const target = document.querySelector(input.dataset.filePreview);
            const nameTarget = input.dataset.fileName ? document.querySelector(input.dataset.fileName) : null;
            const file = input.files && input.files[0];

            if (nameTarget) {
                nameTarget.textContent = file ? file.name : '';
            }

            if (!target || !file || !file.type.startsWith('image/')) {
                return;
            }

            const reader = new FileReader();
            reader.onload = (readerEvent) => {
                if (target.tagName === 'IMG') {
                    target.src = readerEvent.target.result;
                } else {
                    target.style.backgroundImage = `url(${readerEvent.target.result})`;
                }
            };
            reader.readAsDataURL(file);
        });
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAdminShell);
} else {
    initAdminShell();
}
