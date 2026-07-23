import './bootstrap';
import Swal from 'sweetalert2';

window.Swal = Swal;

// ─── Toast Notification ─────────────────────────────────────────────────────
window.Toast = {
    success(msg) { this._fire(msg, 'success'); },
    error(msg)   { this._fire(msg, 'error'); },
    warning(msg) { this._fire(msg, 'warning'); },
    info(msg)    { this._fire(msg, 'info'); },
    _fire(msg, icon) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon,
            title: msg,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    }
};

document.addEventListener('DOMContentLoaded', () => {

    // ─── Auto flash session messages as toasts ───────────────────────────────
    document.querySelectorAll('.alert-success[data-toast]').forEach(el => Toast.success(el.dataset.msg || el.textContent.trim()));
    document.querySelectorAll('.alert-danger[data-toast]').forEach(el => Toast.error(el.dataset.msg || el.textContent.trim()));

    // ─── DataTables: manual init per view (not automatic) ─────────────────────
    // Note: Each view will initialize its own DataTable with specific columns
    // This prevents reinitialize errors and gives more control

    // ─── Delete confirmation (SweetAlert) ─────────────────────────────────────
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            Swal.fire({
                title  : 'Delete this record?',
                text   : "This action cannot be undone.",
                icon   : 'warning',
                showCancelButton    : true,
                confirmButtonColor  : '#dc3545',
                cancelButtonColor   : '#6c757d',
                confirmButtonText   : '<i class="fas fa-trash me-1"></i> Yes, delete!',
                cancelButtonText    : 'Cancel',
            }).then(r => { if (r.isConfirmed) form.submit(); });
        });
    });

    // ─── Bulk Delete ──────────────────────────────────────────────────────────
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    if (bulkDeleteBtn) {
        bulkDeleteBtn.addEventListener('click', function () {
            const checked = [...document.querySelectorAll('.item-checkbox:checked')];
            if (!checked.length) { Toast.warning('Please select at least one item.'); return; }
            const ids = checked.map(c => c.value);
            Swal.fire({
                title  : `Delete ${ids.length} item(s)?`,
                icon   : 'warning',
                showCancelButton   : true,
                confirmButtonColor : '#dc3545',
                confirmButtonText  : 'Yes, delete all!',
            }).then(r => {
                if (r.isConfirmed) {
                    const f = document.createElement('form');
                    f.method = 'POST'; f.action = this.dataset.url;
                    f.innerHTML = `<input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
                                   <input type="hidden" name="ids" value='${JSON.stringify(ids)}'>`;
                    document.body.appendChild(f); f.submit();
                }
            });
        });
    }

    // ─── Select All ───────────────────────────────────────────────────────────
    const selectAll = document.getElementById('select-all');
    if (selectAll) {
        selectAll.addEventListener('change', function () {
            document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = this.checked);
        });
    }

    // ─── Image Upload – live preview + remove ─────────────────────────────────
    document.querySelectorAll('.image-upload-wrapper').forEach(wrapper => {
        const input   = wrapper.querySelector('.image-upload-input');
        const preview = wrapper.querySelector('.image-preview-container');
        if (!input || !preview) return;

        input.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                preview.innerHTML = `
                    <div class="position-relative d-inline-block mt-2">
                        <img src="${e.target.result}" class="img-thumbnail rounded" style="max-width:200px;max-height:180px;object-fit:cover;">
                        <button type="button" class="btn btn-danger btn-sm remove-image-btn position-absolute"
                            style="top:-8px;right:-8px;width:24px;height:24px;padding:0;line-height:1;">
                            <i class="fas fa-times" style="font-size:10px;"></i>
                        </button>
                    </div>`;
            };
            reader.readAsDataURL(file);
        });

        preview.addEventListener('click', function (e) {
            if (e.target.closest('.remove-image-btn')) {
                input.value = '';
                // keep existing-image hidden if present
                const existingWrap = preview.querySelector('.position-relative');
                if (existingWrap) existingWrap.remove();
            }
        });
    });

    // ─── Toggle Status (AJAX) ─────────────────────────────────────────────────
    document.querySelectorAll('.toggle-status').forEach(toggle => {
        toggle.addEventListener('change', async function () {
            const url    = this.dataset.url;
            const status = this.checked ? 1 : 0;
            const el     = this;
            try {
                const res  = await fetch(url, {
                    method  : 'POST',
                    headers : {
                        'Content-Type' : 'application/json',
                        'X-CSRF-TOKEN' : document.querySelector('meta[name=csrf-token]').content,
                        'Accept'       : 'application/json',
                    },
                    body: JSON.stringify({ status })
                });
                const data = await res.json();
                if (data.success) Toast.success(data.message || 'Status updated.');
                else { el.checked = !el.checked; Toast.error(data.message || 'Failed to update.'); }
            } catch {
                el.checked = !el.checked; Toast.error('Network error.');
            }
        });
    });

    // ─── TinyMCE (FREE CDN - No API Key Required) ─────────────────────────────
    const richEditors = document.querySelectorAll('.rich-editor');
    if (richEditors.length) {
        loadTinyMCE();
    }

    function loadTinyMCE() {
        if (window.tinymce) { initTinyMCE(); return; }
        const s = document.createElement('script');
        // FREE TinyMCE CDN - jsdelivr (no API key needed)
        s.src  = 'https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js';
        s.onload = initTinyMCE;
        document.head.appendChild(s);
    }

    function initTinyMCE() {
        if (!window.tinymce) return;
        tinymce.init({
            selector  : '.rich-editor',
            height    : 450,
            menubar   : 'file edit view insert format tools table help',
            promotion : false,
            branding  : false,
            plugins   : [
                'advlist','autolink','lists','link','image','charmap','preview','anchor',
                'searchreplace','visualblocks','code','fullscreen','insertdatetime',
                'media','table','wordcount','emoticons','codesample','directionality',
                'visualchars','nonbreaking','pagebreak','quickbars','help'
            ],
            toolbar   : [
                'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough',
                'forecolor backcolor | alignleft aligncenter alignright alignjustify',
                'bullist numlist outdent indent | removeformat | link image media table',
                'code fullscreen preview | charmap emoticons codesample | help'
            ].join(' | '),
            content_style : 'body{font-family:Inter,Arial,sans-serif;font-size:14px;line-height:1.6}',
            image_advtab  : true,
            automatic_uploads: false,
            paste_as_text : false,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            setup(editor) {
                editor.on('change', () => editor.save());
            }
        });
    }

    // ─── SortableJS for drag-and-drop lists ───────────────────────────────────
    document.querySelectorAll('[data-sortable]').forEach(el => {
        if (typeof Sortable === 'undefined') return;
        Sortable.create(el, {
            animation : 150,
            handle    : '.drag-handle',
            onEnd     : async () => {
                const url   = el.dataset.sortUrl;
                if (!url) return;
                const items = [...el.children].map((c, i) => ({ id: c.dataset.id, sort_order: i + 1 }));
                try {
                    const res  = await fetch(url, {
                        method  : 'POST',
                        headers : {
                            'Content-Type' : 'application/json',
                            'X-CSRF-TOKEN' : document.querySelector('meta[name=csrf-token]').content,
                        },
                        body: JSON.stringify({ items })
                    });
                    const data = await res.json();
                    if (data.success) Toast.success('Order saved.');
                    else Toast.error(data.message || 'Failed to save order.');
                } catch { Toast.error('Network error.'); }
            }
        });
    });

    // ─── Auto-dismiss alerts after 5 s ────────────────────────────────────────
    setTimeout(() => {
        document.querySelectorAll('.alert:not(.alert-permanent)').forEach(a => {
            a.style.transition = 'opacity .5s';
            a.style.opacity    = '0';
            setTimeout(() => a.remove(), 500);
        });
    }, 5000);

});
