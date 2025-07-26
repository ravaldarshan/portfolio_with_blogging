<div class="row mb-3" id="filter_section" style="display: none;">
    <div class="col-md-12">
        <form id="filter_form">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6 pt-3">
                            <div class="form-group fv-row">
                                <label class="required form-label">Status</label>
                                <select class="form-control" data-hide-search="true" id="filterstatus">
                                    <option value="">Semua</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="d-flex justify-content-end gap-1 mx-3">
                        <button type="reset" id="reset-btn" class="btn btn-danger text-white">Reset</button>
                        <button id="filter_submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--end::Card toolbar-->
</div>
