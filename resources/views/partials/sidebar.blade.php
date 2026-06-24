<!-- ─── FILTERS SIDEBAR ──────────────────────────────────── -->
<aside class="filters-sidebar" id="filtersSidebar">
    <div class="filters-header">
        <h2 class="filters-title">Filters</h2>
        <a href="{{ route('category.index') }}" class="filters-clear">Clear All</a>
    </div>

    <!-- Filter: Category -->
    <div class="filter-group">
        <button class="filter-group__toggle" type="button" aria-expanded="true">
            Category
            <svg viewBox="0 0 16 16" fill="none"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        </button>
        <div class="filter-group__body">
            @foreach($categories ?? [] as $cat)
                <label class="filter-checkbox">
                    <input type="checkbox" name="category[]" value="{{ $cat->slug }}"
                        {{ in_array($cat->slug, (array) request('category')) ? 'checked' : '' }}>
                    {{ $cat->name }}
                    <span class="filter-count">({{ $cat->products_count ?? 0 }})</span>
                </label>
            @endforeach
            {{-- Static fallback for frontend integration --}}
            @if(empty($categories))
                <label class="filter-checkbox"><input type="checkbox" {{ request('sub') == 'foundation' ? 'checked' : '' }}> Foundation &amp; Concealer <span class="filter-count">(48)</span></label>
                <label class="filter-checkbox"><input type="checkbox" {{ request('sub') == 'lip' ? 'checked' : '' }}> Lip Color <span class="filter-count">(63)</span></label>
                <label class="filter-checkbox"><input type="checkbox" {{ request('sub') == 'eye' ? 'checked' : '' }}> Eye Makeup <span class="filter-count">(41)</span></label>
                <label class="filter-checkbox"><input type="checkbox"> Blush &amp; Bronzer <span class="filter-count">(29)</span></label>
                <label class="filter-checkbox"><input type="checkbox"> Setting &amp; Primer <span class="filter-count">(22)</span></label>
                <label class="filter-checkbox"><input type="checkbox"> Highlighter <span class="filter-count">(17)</span></label>
            @endif
        </div>
    </div>

    <!-- Filter: Brand -->
    <div class="filter-group">
        <button class="filter-group__toggle" type="button" aria-expanded="true">
            Brand
            <svg viewBox="0 0 16 16" fill="none"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        </button>
        <div class="filter-group__body">
            @foreach($brands ?? [] as $brand)
                <label class="filter-checkbox">
                    <input type="checkbox" name="brand[]" value="{{ $brand->slug }}"
                        {{ in_array($brand->slug, (array) request('brand')) ? 'checked' : '' }}>
                    {{ $brand->name }}
                    <span class="filter-count">({{ $brand->products_count ?? 0 }})</span>
                </label>
            @endforeach
            {{-- Static fallback --}}
            @if(empty($brands))
                <label class="filter-checkbox"><input type="checkbox"> Huda Beauty <span class="filter-count">(24)</span></label>
                <label class="filter-checkbox"><input type="checkbox"> Maybelline <span class="filter-count">(38)</span></label>
                <label class="filter-checkbox"><input type="checkbox"> L'Oréal Paris <span class="filter-count">(31)</span></label>
                <label class="filter-checkbox"><input type="checkbox"> Essence <span class="filter-count">(19)</span></label>
                <label class="filter-checkbox"><input type="checkbox"> Rivaj UK <span class="filter-count">(15)</span></label>
                <label class="filter-checkbox"><input type="checkbox"> Golden Rose <span class="filter-count">(12)</span></label>
            @endif
        </div>
    </div>

    <!-- Filter: Price Range -->
    <div class="filter-group">
        <button class="filter-group__toggle" type="button" aria-expanded="true">
            Price Range
            <svg viewBox="0 0 16 16" fill="none"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        </button>
        <div class="filter-group__body">
            <label class="filter-checkbox"><input type="checkbox" name="price[]" value="0-999"> Under PKR 1,000</label>
            <label class="filter-checkbox"><input type="checkbox" name="price[]" value="1000-2999"> PKR 1,000 – 2,999</label>
            <label class="filter-checkbox"><input type="checkbox" name="price[]" value="3000-5999"> PKR 3,000 – 5,999</label>
            <label class="filter-checkbox"><input type="checkbox" name="price[]" value="6000-9999"> PKR 6,000 – 9,999</label>
            <label class="filter-checkbox"><input type="checkbox" name="price[]" value="10000+"> PKR 10,000+</label>
        </div>
    </div>

    <!-- Filter: Rating -->
    <div class="filter-group">
        <button class="filter-group__toggle" type="button" aria-expanded="true">
            Rating
            <svg viewBox="0 0 16 16" fill="none"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        </button>
        <div class="filter-group__body">
            <label class="filter-checkbox"><input type="checkbox" name="rating[]" value="4"> 4★ &amp; above</label>
            <label class="filter-checkbox"><input type="checkbox" name="rating[]" value="3"> 3★ &amp; above</label>
        </div>
    </div>

    <!-- Filter: Availability -->
    <div class="filter-group">
        <button class="filter-group__toggle" type="button" aria-expanded="false">
            Availability
            <svg viewBox="0 0 16 16" fill="none"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        </button>
        <div class="filter-group__body">
            <label class="filter-checkbox"><input type="checkbox" name="availability[]" value="in_stock"> In Stock</label>
            <label class="filter-checkbox"><input type="checkbox" name="availability[]" value="on_sale"> On Sale</label>
        </div>
    </div>
</aside>
