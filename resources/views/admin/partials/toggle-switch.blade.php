@php $toggleId = 'toggle_' . $id . '_' . $field; @endphp
<div class="form-check form-switch">
    <input class="form-check-input toggle-status"
           type="checkbox"
           role="switch"
           id="{{ $toggleId }}"
           data-url="{{ $url }}"
           {{ $value ? 'checked' : '' }}>
</div>
