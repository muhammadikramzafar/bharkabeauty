<!-- ─── FILTERS SIDEBAR ──────────────────────────────────── -->
@php
    $filterAction = route('category.index', ['cat' => request()->route('cat')]);
    $activePrices = (array) request('price', []);
    $activeAvail  = (array) request('availability', []);
    $activeBrands = (array) request('brand', []);
    $activeCats   = (array) request('category', []);
@endphp

<aside class="filters-sidebar" id="filtersSidebar">
    <div class="filters-header">
        <h2 class="filters-title">Filters</h2>
        <a href="{{ $filterAction }}" class="filters-clear">Clear All</a>
    </div>

    <form id="filter-form" method="GET" action="{{ $filterAction }}">

        <!-- Preserve sort if set -->
        @if(request('sort') && request('sort') !== 'featured')
            <input type="hidden" name="sort" value="{{ request('sort') }}">
        @endif

        <!-- Filter: Category -->
        @if(!empty($categories) && count($categories))
        <div class="filter-group">
            <button class="filter-group__toggle" type="button" aria-expanded="true">
                Category
                <svg viewBox="0 0 16 16" fill="none"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            </button>
            <div class="filter-group__body">
                @foreach($categories as $cat)
                    <label class="filter-checkbox">
                        <input type="checkbox" name="category[]" value="{{ $cat->slug }}"
                            {{ in_array($cat->slug, $activeCats) ? 'checked' : '' }}>
                        {{ $cat->name }}
                        <span class="filter-count">({{ $cat->products_count ?? 0 }})</span>
                    </label>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Filter: Brand -->
        @if(!empty($brands) && count($brands))
        <div class="filter-group">
            <button class="filter-group__toggle" type="button" aria-expanded="true">
                Brand
                <svg viewBox="0 0 16 16" fill="none"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            </button>
            <div class="filter-group__body">
                @foreach($brands as $brand)
                    <label class="filter-checkbox">
                        <input type="checkbox" name="brand[]" value="{{ $brand->slug }}"
                            {{ in_array($brand->slug, $activeBrands) ? 'checked' : '' }}>
                        {{ $brand->name }}
                        <span class="filter-count">({{ $brand->products_count ?? 0 }})</span>
                    </label>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Filter: Price Range -->
        <div class="filter-group">
            <button class="filter-group__toggle" type="button" aria-expanded="true">
                Price Range
                <svg viewBox="0 0 16 16" fill="none"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            </button>
            <div class="filter-group__body">
                <label class="filter-checkbox"><input type="checkbox" name="price[]" value="0-999"     {{ in_array('0-999',     $activePrices) ? 'checked' : '' }}> Under PKR 1,000</label>
                <label class="filter-checkbox"><input type="checkbox" name="price[]" value="1000-2999" {{ in_array('1000-2999', $activePrices) ? 'checked' : '' }}> PKR 1,000 – 2,999</label>
                <label class="filter-checkbox"><input type="checkbox" name="price[]" value="3000-5999" {{ in_array('3000-5999', $activePrices) ? 'checked' : '' }}> PKR 3,000 – 5,999</label>
                <label class="filter-checkbox"><input type="checkbox" name="price[]" value="6000-9999" {{ in_array('6000-9999', $activePrices) ? 'checked' : '' }}> PKR 6,000 – 9,999</label>
                <label class="filter-checkbox"><input type="checkbox" name="price[]" value="10000+"    {{ in_array('10000+',    $activePrices) ? 'checked' : '' }}> PKR 10,000+</label>
            </div>
        </div>

        <!-- Filter: Availability -->
        <div class="filter-group">
            <button class="filter-group__toggle" type="button" aria-expanded="true">
                Availability
                <svg viewBox="0 0 16 16" fill="none"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            </button>
            <div class="filter-group__body">
                <label class="filter-checkbox"><input type="checkbox" name="availability[]" value="in_stock" {{ in_array('in_stock', $activeAvail) ? 'checked' : '' }}> In Stock</label>
                <label class="filter-checkbox"><input type="checkbox" name="availability[]" value="on_sale"  {{ in_array('on_sale',  $activeAvail) ? 'checked' : '' }}> On Sale</label>
            </div>
        </div>

        <div style="padding-top:1.25rem;margin-top:.25rem;border-top:1px solid var(--color-border);">
            <button type="submit" class="btn btn-primary btn-full">Apply Filters</button>
        </div>

    </form>
</aside>

<script>
// Auto-submit filter form on any checkbox change (instant filtering)
(function () {
    var form = document.getElementById('filter-form');
    if (!form) return;
    form.querySelectorAll('input[type="checkbox"]').forEach(function (cb) {
        cb.addEventListener('change', function () { form.submit(); });
    });
})();
</script>
