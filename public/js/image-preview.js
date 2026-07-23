// Comprehensive Image Preview with Remove functionality
document.addEventListener('DOMContentLoaded', function() {
    // Image Upload Preview
    document.querySelectorAll('.image-upload-input').forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            
            const wrapper = this.closest('.image-upload-wrapper');
            if (!wrapper) return;
            
            let previewContainer = wrapper.querySelector('.image-preview-container');
            if (!previewContainer) {
                previewContainer = document.createElement('div');
                previewContainer.className = 'image-preview-container mt-3';
                wrapper.appendChild(previewContainer);
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewContainer.innerHTML = `
                    <div class="position-relative d-inline-block">
                        <img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-image-btn" style="margin: 5px;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        });
    });
    
    // Remove Image Preview
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-image-btn')) {
            e.preventDefault();
            const btn = e.target.closest('.remove-image-btn');
            const wrapper = btn.closest('.image-upload-wrapper');
            if (wrapper) {
                const input = wrapper.querySelector('.image-upload-input');
                const preview = wrapper.querySelector('.image-preview-container');
                if (input) input.value = '';
                if (preview) preview.innerHTML = '';
            }
        }
    });
});
