<div class="image-upload-wrapper">
    <input type="file" 
           name="{{ $name }}" 
           class="form-control image-upload-input @error($name) is-invalid @enderror" 
           accept="image/*"
           {{ $attributes }}>
    
    <div class="image-preview-container mt-3">
        @if(isset($current) && $current)
            <div class="position-relative d-inline-block">
                <img src="{{ asset($path . '/' . $current) }}" 
                     class="img-thumbnail" 
                     style="max-width: 200px; max-height: 200px; object-fit: cover;">
                <button type="button" 
                        class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-image-btn" 
                        style="margin: 5px;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif
    </div>
    
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    
    @if(isset($hint))
        <small class="text-muted d-block mt-2">{{ $hint }}</small>
    @endif
</div>
