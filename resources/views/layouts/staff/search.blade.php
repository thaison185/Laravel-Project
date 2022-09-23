<!-- Morphing Search  -->
<div id="morphsearch" class="morphsearch">
    <form class="morphsearch-form" action="{{route('staff.search')}}" method="post">
        @csrf
        <div class="form-group m-0">
            <input value="" type="search"  name="search" placeholder="Search..." class="form-control morphsearch-input" />
            <button class="morphsearch-submit" type="submit">Search</button>
        </div>
    </form>
    <div class="morphsearch-content d-none" style="overflow: scroll;height: 75vh">
        <div class="dummy-column" id="search-lecturer">
        </div>
        <div class="dummy-column" id="search-student">
        </div>
        <div class="dummy-column" id="search-staff">
        </div>
    </div>
    <span class="morphsearch-close"></span>
</div>
