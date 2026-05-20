export const bs = (() => {
    const modal = (id) => {
        const element = document.getElementById(id);

        if (!element) {
            console.warn(`Modal "${id}" tidak ditemukan`);
            return null;
        }

        return window.bootstrap.Modal.getOrCreateInstance(element);
    };

    const tab = (id) => {
        const element = document.getElementById(id);

        if (!element) {
            console.warn(`Tab "${id}" tidak ditemukan`);
            return null;
        }

        return window.bootstrap.Tab.getOrCreateInstance(element);
    };

    return {
        tab,
        modal,
    };
})();
