<div class="sidebar">

    <form action="{{ url('/products') }}{{ request()->has('page') ? '?page=' . request('page') : ''}}" method="GET" id="frmProductsSideBar">
    <div class="widget-card bg-white">
        <div class="widget-title ">{{ __('Filters') }}</div>
        <div class="widget-body ">
            @php
                $CategoryListForFilter = CategoryListForFilter();
                $ColorListForFilter = ColorList();
                $PatternList = PatternList();
            @endphp

            <div class="mb-3">
                <label class="form-label">By Fabric:</label>
                <select  name="fabric" class="form-select form-select-sm" onchange=" $('#frmProductsSideBar').submit()">
                    <option value="" >Select Fabric</option>
                    @foreach ($CategoryListForFilter as $row)
                        <option {{ request()->has('fabric') && request('fabric') ==  $row->name?  'selected' : ''}} value="{{ $row->name }}">{{ $row->name }} ({{ $row->TotalProduct }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">By Pattern:</label>
                <select  name="pattern" class="form-select form-select-sm" onchange=" $('#frmProductsSideBar').submit()">
                    <option value="" >Select Pattern</option>
                    @foreach ($PatternList as $row)
                        <option {{ request()->has('pattern') && request('pattern') ==   $row->item_slug?  'selected' : ''}} value="{{  $row->item_slug }}">{{ htmlspecialchars_decode($row->name) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">By Color:</label>
                <select  name="color" class="form-select form-select-sm" onchange=" $('#frmProductsSideBar').submit()">
                    <option value="" >Select Color</option>
                    @foreach ($ColorListForFilter as $row)
                        <option {{ request()->has('color') && request('color') ==  $row->item_slug?  'selected' : ''}} value="{{ $row->item_slug }}">{{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <a href="{{url('products')}}" class="float-end">Clear Filters</a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</form>

</div>
