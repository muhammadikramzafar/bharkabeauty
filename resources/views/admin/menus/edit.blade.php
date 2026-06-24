@extends('layouts.admin')
@section('title', 'Edit Menu: ' . $menu->name)
@section('page_title', 'Edit Menu: ' . $menu->name)

@section('content')
<div class="menu-builder-layout">

    {{-- LEFT: Add Items --}}
    <div class="menu-builder-sidebar">

        {{-- Menu Settings --}}
        <div class="admin-card">
            <div class="admin-card-header"><h3 class="admin-card-title">Menu Settings</h3></div>
            <form method="POST" action="{{ route('admin.menus.update', $menu) }}" class="admin-form">
                @csrf @method('PUT')
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name', $menu->name) }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Location</label>
                    <select name="location" class="form-control">
                        @foreach(['header','footer','mobile'] as $loc)
                            <option value="{{ $loc }}" {{ $menu->location == $loc ? 'selected' : '' }}>{{ ucfirst($loc) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-checkbox-label">
                        <input type="checkbox" name="is_active" value="1" {{ $menu->is_active ? 'checked' : '' }}> Active
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Save</button>
            </form>
        </div>

        {{-- Add Custom Link --}}
        <div class="admin-card">
            <div class="admin-card-header"><h3 class="admin-card-title">Add Link</h3></div>
            <form method="POST" action="{{ route('admin.menu-items.store') }}" class="admin-form">
                @csrf
                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                <div class="form-group">
                    <label>Label</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Home" required>
                </div>
                <div class="form-group">
                    <label>URL</label>
                    <input type="text" name="url" class="form-control" placeholder="https:// or /path">
                </div>
                <div class="form-group">
                    <label>Parent</label>
                    <select name="parent_id" class="form-control">
                        <option value="">— Top Level —</option>
                        @foreach($menu->items as $item)
                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Open In</label>
                    <select name="target" class="form-control">
                        <option value="_self">Same Tab</option>
                        <option value="_blank">New Tab</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Add to Menu</button>
            </form>
        </div>

        {{-- Add CMS Page --}}
        @if($pages->count())
        <div class="admin-card">
            <div class="admin-card-header"><h3 class="admin-card-title">Add Page</h3></div>
            <form method="POST" action="{{ route('admin.menu-items.store') }}" class="admin-form">
                @csrf
                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                <div class="form-group">
                    <label>Select Page</label>
                    <select name="cms_page_id" class="form-control" required>
                        <option value="">— Select Page —</option>
                        @foreach($pages as $page)
                            <option value="{{ $page->id }}">{{ $page->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Label (optional)</label>
                    <input type="text" name="title" class="form-control" placeholder="Leave blank to use page title">
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Add Page</button>
            </form>
        </div>
        @endif
    </div>

    {{-- RIGHT: Menu Tree --}}
    <div class="menu-builder-main">
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">Menu Structure</h3>
                <small class="text-muted">Drag to reorder · Nest items to create sub-menus</small>
            </div>

            <div id="menu-sortable" class="menu-sortable-list">
                @forelse($menu->items as $item)
                    @include('admin.menus._item', ['item' => $item, 'depth' => 0])
                @empty
                    <div class="menu-empty">No items yet. Add items from the left panel.</div>
                @endforelse
            </div>

            @if($menu->allItems->count())
            <div class="menu-save-order-wrap">
                <button id="save-order-btn" class="btn btn-primary">Save Order</button>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.3/Sortable.min.js"></script>
<script>
function initSortable(el) {
    new Sortable(el, {
        group: 'menu-items',
        animation: 150,
        handle: '.menu-item-handle',
        ghostClass: 'menu-item-ghost',
        onEnd: function() {}
    });
}
document.querySelectorAll('.menu-sortable-list, .menu-children-list').forEach(initSortable);

document.getElementById('save-order-btn')?.addEventListener('click', function() {
    const items = [];
    function collect(list, parentId) {
        list.querySelectorAll(':scope > .menu-sortable-item').forEach((el, idx) => {
            items.push({ id: el.dataset.id, parent_id: parentId });
            const children = el.querySelector('.menu-children-list');
            if (children) collect(children, el.dataset.id);
        });
    }
    collect(document.getElementById('menu-sortable'), null);

    fetch('{{ route('admin.menu-items.reorder') }}', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        body: JSON.stringify({ items })
    }).then(r => r.json()).then(d => {
        if (d.success) alert('Order saved!');
    });
});
</script>
@endpush
