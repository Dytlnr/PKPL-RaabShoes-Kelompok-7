window.installOrderDraft = async ({ form, key, hasOldInput, refresh }) => {
    const notice = document.getElementById('order-draft-status');
    const photo = form.querySelector('[name="item_photo"]');
    const fields = [...form.querySelectorAll('input, select, textarea')].filter(el =>
        el.name && !['_token', 'item_photo'].includes(el.name) && !['submit', 'button', 'hidden'].includes(el.type));
    let storageKey;
    try {
        let tab = sessionStorage.getItem('raab-order-tab');
        if (!tab) { tab = crypto.randomUUID(); sessionStorage.setItem('raab-order-tab', tab); }
        storageKey = `raab-order-draft:${tab}:${key}`;
        // Only discard drafts from this tab after the server advances the successful-order revision.
        Object.keys(sessionStorage).filter(k => k.startsWith(`raab-order-draft:${tab}:`) && k !== storageKey)
            .forEach(k => sessionStorage.removeItem(k));
    } catch {
        notice.textContent = 'Penyimpanan browser tidak tersedia. Draf tidak dapat disimpan otomatis.';
        return;
    }
    let db;
    const database = new Promise(resolve => {
        try {
            const request = indexedDB.open('raab-order-photo-drafts', 1);
            request.onupgradeneeded = () => request.result.createObjectStore('photos');
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => resolve(null);
            request.onblocked = () => resolve(null);
        } catch { resolve(null); }
    });
    const saveText = () => {
        try {
            sessionStorage.setItem(storageKey, JSON.stringify(Object.fromEntries(fields.map(el => [el.name, el.value]))));
            notice.textContent = 'Draf tersimpan di tab ini. Isian akan kembali jika halaman ter-refresh.';
        } catch { notice.textContent = 'Draf gagal disimpan. Penyimpanan browser mungkin penuh.'; }
    };
    const savePhoto = async () => {
        db = await database;
        if (!db) { notice.textContent = 'Isian disimpan, tetapi foto perlu dipilih ulang setelah refresh.'; return; }
        const tx = db.transaction('photos', 'readwrite');
        if (photo.files[0]) tx.objectStore('photos').put(photo.files[0], storageKey);
        else tx.objectStore('photos').delete(storageKey);
        tx.onerror = () => { notice.textContent = 'Foto belum tersimpan sebagai draf. Pilih ulang foto jika halaman ter-refresh.'; };
    };
    try {
        const saved = JSON.parse(sessionStorage.getItem(storageKey) || 'null');
        if (saved && !hasOldInput) fields.forEach(el => {
            if (Object.hasOwn(saved, el.name)) el.value = saved[el.name];
        });
        if (saved) notice.textContent = 'Draf sebelumnya dipulihkan. Silakan lanjutkan pengisian.';
        refresh();
    } catch { notice.textContent = 'Draf sebelumnya tidak dapat dibaca. Silakan isi kembali.'; }
    form.addEventListener('input', saveText);
    form.addEventListener('change', saveText);
    photo.addEventListener('change', savePhoto);
    form.addEventListener('submit', saveText);
    window.addEventListener('pagehide', saveText);
    db = await database;
    if (db) {
        const tx = db.transaction('photos', 'readwrite');
        const store = tx.objectStore('photos');
        const cursor = store.openCursor();
        cursor.onsuccess = () => {
            const item = cursor.result;
            if (!item) return;
            const prefix = storageKey.slice(0, storageKey.lastIndexOf(':') + 1);
            if (String(item.key).startsWith(prefix) && item.key !== storageKey) item.delete();
            item.continue();
        };
        const request = store.get(storageKey);
        request.onsuccess = () => {
            if (!request.result || photo.files.length) return;
            try {
                const transfer = new DataTransfer();
                transfer.items.add(request.result);
                photo.files = transfer.files;
                photo.dispatchEvent(new Event('change', { bubbles: true }));
            } catch { notice.textContent = 'Isian dipulihkan. Silakan pilih ulang foto barang.'; }
        };
    }
};
