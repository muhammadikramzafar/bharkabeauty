<div class="menu-sortable-item {{ $depth > 0 ? 'menu-item-child' : '' }}" data-id="{{ $item->id }}">
    <div class="menu-item-row">
        <span class="menu-item-handle" title="Drag to reorder">⠿</span>
        <div class="menu-item-info">
            <span class="menu-item-title">{{ $item->title }}</span>
            <span class="menu-item-url">{{ $item->url ?? ($item->page?->slug ? '/'.$item->page->slug : '—') }}</span>
        </div>
        <div class="menu-item-actions">
            <form method="POST" action="{{ route('admin.menu-items.destroy', $item) }}" onsubmit="return confirm('Remove this item?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-table-action btn-table-danger">Remove</button>
            </form>
        </div>
    </div>

    @if($item->children->count())
        <div class="menu-children-list">
            @foreach($item->children as $child)
                @include('admin.menus._item', ['item' => $child, 'depth' => $depth + 1])
            @endforeach
        </div>
    @else
        <div class="menu-children-list"></div>
    @endif
</div>
