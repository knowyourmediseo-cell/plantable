<div class="btn-group">
    <a href="{{ $editRoute }}" class="btn btn-sm btn-primary">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ $deleteRoute }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger delete-btn">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>
