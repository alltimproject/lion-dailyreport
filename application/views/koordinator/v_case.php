<div class="page-title" id="top">
    <div class="title_left">
        <h3>Daftar Case</h3>
    </div>
</div>

<div class="clearfix"></div>

<div class="x_panel">
    <div class="x_content">
        <table class="table jambo_table table-responsive" id="table-case">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID Case</th>
                    <th>Kode Booking</th>
                    <th>Klasifikasi</th>
                    <th>Tanggal</th>
                    <th>PIC</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody id="data-case"></tbody>
        </table>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-case">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
                <h4 class="modal-title" id="myModalLabel">Detail Case</h4>
            </div>
            <form class="form-case">
                <div class="modal-body">
                    <h5><b>Report</b></h5>
                    <table class="table">
                        <tr>
                            <td style="width: 20%">ID Report</td>
                            <td style="width: 5%">:</td>
                            <td style="width: 75%" class="id_report"></td>
                        </tr>
                        <tr>
                            <td>Kode Booking</td>
                            <td>:</td>
                            <td class="kd_booking"></td>
                        </tr>
                        <tr>
                            <td>Klasifikasi</td>
                            <td>:</td>
                            <td class="klasifikasi"></td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td>:</td>
                            <td class="keterangan"></td>
                        </tr>
                    </table>

                    <h5><b>Call Center</b></h5>
                    <table class="table">
                        <tr>
                            <td style="width: 20%">NIP</td>
                            <td style="width: 5%">:</td>
                            <td style="width: 75%" class="nip"></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td class="nama"></td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td class="jabatan"></td>
                        </tr>
                    </table>

                    <h5><b>Kronologis</b></h5>
                    <div class="kronologis"></div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id_case" id="id_case">
                    <input type="hidden" name="id_report" id="id_report">
                    <button type="submit" id="acc" class="btn btn-success">Acc</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {


        function load_data() {
            $.ajax({
                url: '<?= base_url().'asmen/show_case' ?>',
                type: 'POST',
                dataType: 'JSON',
                success: function(data) {
                    var html = '';
                    var no = 0;

                    $.each(data.case, function(k, v) {
                        no++;
                        html += `<tr id="pilih" data-coba_kronologis="${v.kronologis}">`;
                        html += `<td>${no}</td>`;
                        html += `<td>${v.id_case}</td>`;
                        html += `<td>${v.kd_booking}</td>`;
                        html += `<td>${v.klasifikasi}</td>`;
                        html += `<td>${v.datetime_report}</td>`;
                        html += `<td>${v.nama}</td>`;
                        html += `<td>${v.keterangan}</td>`;

                        if (v.status_case == 'Acc') {
                            html += `<td>Accepted <i class="fa fa-check"></i></td>`;
                        } else {
                            html += `<td>Waiting Acc <i class="fa fa-clock-o"></i></td>`;
                        }

                        html += `<td><button class="btn btn-sm btn-info" id="lihat-case" data-id_case="${v.id_case}" data-status_case="${v.status_case}" data-kronologis="${v.kronologis}" data-id_report="${v.id_report}" data-kd_booking="${v.kd_booking}" data-tanggal="${v.datetime_report}" data-klasifikasi="${v.klasifikasi}" data-keterangan="${v.keterangan}" data-nip="${v.nip}" data-nama="${v.nama}" data-jabatan="${v.jabatan}">Lihat</button></td>`;
                        html += '</tr>';
                    });

                    $('#data-case').html(html);
                }
            });
        }

        load_data();

        $('#table-case').on('click', '#lihat-case', function() {
            var id_case = $(this).attr('data-id_case');
            var kronologis = $(this).attr('data-kronologis');
            var id_report = $(this).attr('data-id_report');
            var kd_booking = $(this).attr('data-kd_booking');
            var klasifikasi = $(this).attr('data-klasifikasi');
            var keterangan = $(this).attr('data-keterangan');
            var nip = $(this).attr('data-nip');
            var nama = $(this).attr('data-nama');
            var jabatan = $(this).attr('data-jabatan');
            var tanggal = $(this).attr('data-tanggal');
            var status_case = $(this).attr('data-status_case');

            $('.id_report').text(id_report);
            $('.kd_booking').text(kd_booking);
            $('.klasifikasi').text(klasifikasi);
            $('.keterangan').text(keterangan);
            $('.nip').text(nip);
            $('.nama').text(nama);
            $('.jabatan').text(jabatan);
            $('#id_case').val(id_case);
            $('#id_report').val(id_report);
            $('.kronologis').text(kronologis);

            if (status_case == 'Acc') {
                $('#acc').hide();
            } else {
                $('#acc').show();
            }

            $('#modal-case').modal('show');
        });

        $('.form-case').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '<?= base_url().'koordinator/validasi_case' ?>',
                type: 'POST',
                data: $(this).serialize(),
                success: function(data) {
                    if (data == 'berhasil') {
                        toastr.success('Berhasil memvalidasi case', 'Success');
                    } else {
                        toastr.error('Tidak berhasil memvalidasi case', 'Error');
                    }
                    load_data();
                    $('.form-case')[0].reset();
                    $('#modal-case').modal('hide');
                },
                error: function() {
                    toastr.error('Halaman tidak dapat diakses', 'Error');
                }
            });
        });

    });
</script>
