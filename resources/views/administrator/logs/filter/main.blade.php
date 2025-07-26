<div class="row m-3" id="filter_section" style="display: none;">
    <div class="col-md-12">
        <form id="filter_form">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="row">
                        @include('administrator.logs.filter.user')

                        @include('administrator.logs.filter.module')
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="d-flex justify-content-end gap-1">
                        <button type="reset" id="reset-btn" class="btn btn-danger text-white">Reset</button>
                        <button id="filter_submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--end::Card toolbar-->
</div>
