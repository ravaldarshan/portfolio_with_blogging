<!-- Modal Detail User -->
<div class="modal fade" tabindex="-1" role="dialog" id="detailUser" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailUserLabel">Detail User</h5>
                <button type="button" class="close" id="buttonCloseModuleModal" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detailUserBody">
                
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('#detailUser').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');

            var modalBody = $('#detailUserBody');
            modalBody.html('<div id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin"></i> Loading...' +
                '</div>');
            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: '{{ route('admin.users.getDetail', ':id') }}'.replace(':id', id),
                method: 'GET',
                success: function(response) {
                    var data = response.data;

                    // Assuming data.user_group is an object, you can check if it exists before rendering it.
                    var userGroupHtml = data.user_group ? data.user_group.name : '';

                    // Fungsi untuk mengubah angka bulan menjadi nama bulan
                    function formatBulan(angkaBulan) {
                        const namaBulan = [
                            "Januari", "Februari", "Maret", "April",
                            "Mei", "Juni", "Juli", "Agustus",
                            "September", "Oktober", "November", "Desember"
                        ];
                        return namaBulan[angkaBulan - 1] || "";
                    }

                    // Ubah format date
                    var rawDate = data.profile.date_of_birth ? data.profile.date_of_birth : '';
                    var date = new Date(rawDate).getDate();
                    var bulan = new Date(rawDate).getMonth() +
                    1; // Tambahkan 1 karena bulan dimulai dari 0
                    var tahun = new Date(rawDate).getFullYear();

                    var formattedDate = date + " " + formatBulan(bulan) + " " + tahun;

                    // Tampilkan data dengan format bulan yang baru
                    modalBody.html(
                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Tempat, Date of Birth</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.profile.place_of_birth + ', ' + formattedDate +
                        '</div>' +
                        '</div>' +
                        '</div>'
                    );

                    modalBody.html(
                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">ID</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.id + '</div>' +
                        '</div>' +
                        '</div>' +

                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Nama</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.name + '</div>' +
                        '</div>' +
                        '</div>' +

                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Email</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.email + '</div>' +
                        '</div>' +
                        '</div>' +

                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">User Group</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + userGroupHtml + '</div>' +
                        '</div>' +
                        '</div>' +

                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Status</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + (data.status === '1' ? 'Active' : 'Not Active') +
                        '</div>' +
                        '</div>' +
                        '</div>' +

                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Nama Lengkap</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.profile.full_name + '</div>' +
                        '</div>' +
                        '</div>' +

                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">No Telephone</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.profile.phone_number + '</div>' +
                        '</div>' +
                        '</div>' +

                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Pendidikan Terakhir</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.profile.last_education + '</div>' +
                        '</div>' +
                        '</div>' +

                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Tempat, Date of Birth</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.profile.place_of_birth + ', ' + formattedDate +
                        '</div>' +
                        '</div>' +
                        '</div>' +

                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Address</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.profile.address + '</div>' +
                        '</div>' +
                        '</div>'
                    );


                    loadingSpinner.hide(); // Sembunyikan elemen animasi setelah data dimuat
                }
            });
        });
    </script>
@endpush
