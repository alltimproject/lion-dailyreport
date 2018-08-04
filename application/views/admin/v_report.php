<div class="page-title" id="top">
    <div class="title_left">
        <h3>Data Report
            <button type="button" id="refresh-data" class="btn btn-success btn-md"><i class="fa fa-refresh"></i> Refresh</button>
        </h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <form class="form-inline form-cari" target="_blank" method="post" action="<?= base_url().'admin/export_report' ?>">
                <div class="input-group">
                    <div class="container">
                        <input type="text" class="form-control" name="tgl_from" placeholder="From : yyyy-mm-dd" / id='tgl_from'>
                    </div>
                </div>
                <div class="input-group">
                    <div class="container">
                        <input type="text" class="form-control" name="tgl_to" placeholder="To : yyyy-mm-dd" / id='tgl_to'>
                    </div>
                </div>
                <div class="input-group">
                    <span class="input-group-btn">
            <button type="button" class="btn btn-info" id="cari-report">Cari <i class="fa fa-search"></i></button>
            <button type="submit" name="pdf" class="btn btn-primary" id="pdf">PDF <i class="fa fa-file-pdf-o"></i></button>
            <button type="submit" name="excel" class="btn btn-success" id="excel">Excel <i class="fa fa-file-excel-o"></i></button>
          </span>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<div class="x_panel">
  <div class="table-responsive">
    <table class="table jambo_table" id="coba">
        <thead>
            <tr>
                <th>#</th>
                <th>ID Report</th>
                <th>Kode Booking</th>
                <th>Tanggal/Waktu</th>
                <th>Klasifikasi</th>
                <th>Keterangan</th>
                <th>PIC</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="data-report"></tbody>
    </table>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-case">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
                <h4 class="modal-title" id="myModalLabel">Add Case</h4>
            </div>
            <form class="form-case">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <th>ID Report</th>
                                    <td class="id_report"></td>
                                </tr>
                                <tr>
                                    <th>Kode Booking</th>
                                    <td class="kd_booking"></td>
                                </tr>
                                <tr>
                                    <th>Tanggal/Waktu</th>
                                    <td class="tanggal"></td>
                                </tr>
                                <tr>
                                    <th>Klasifikasi</th>
                                    <td class="klasifikasi"></td>
                                </tr>
                                <tr>
                                    <th>PIC</th>
                                    <td class="pic"></td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td class="keterangan"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Kronologi</label>
                                <input type="hidden" name="id_report" id="id_report">
                                <textarea name="kronologi" id="kronologi" class="form-control" style="height: 200px;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" id="submit" class="btn btn-info">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        function load_data(tgl_from, tgl_to) {
            $.ajax({
                url: '<?= base_url().'admin/show_report' ?>',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    tgl_from: tgl_from,
                    tgl_to: tgl_to
                },
                success: function(data) {
                    var html = '';
                    var no = 0;

                    $.each(data.report, function(k, v) {
                        no++;
                        html += '<tr>';
                        html += `<td>${no}</td>`;
                        html += `<td>${v.id_report}</td>`;
                        html += `<td>${v.kd_booking}</td>`;
                        html += `<td>${v.datetime_report}</td>`;
                        html += `<td>${v.klasifikasi}</td>`;
                        html += `<td>${v.keterangan}</td>`;
                        html += `<td>${v.nama}</td>`;
                        if (v.status == 'Valid') {
                            html += `<td>Valid <i class="fa fa-check"></i></td>`;
                        } else {

                            if (v.status_case == null) {
                                html += `<td>`;
                                html += `<button type="button" class="btn btn-success btn-sm" id="validasi" data-id_report="${v.id_report}">Validasi</button>`;
                                html += `<button type="button" class="btn btn-warning btn-sm" id="add_case" data-id_report="${v.id_report}" data-kd_booking="${v.kd_booking}" data-tanggal="${v.datetime_report}" data-klasifikasi="${v.klasifikasi}" data-keterangan="${v.keterangan}" data-pic="${v.nama}">Add Case</button>`;
                                html += `</td>`;
                            } else if (v.status_case == 'Proses') {
                                html += `<td>Waiting Acc <i class="fa fa-clock-o"></i></td>`;
                            }

                        }

                        html += '</tr>';
                    });

                    $('#data-report').html(html);
                }
            });
        }

        load_data();

        $('#refresh-data').on('click', function() {
            load_data();
        });

        $('#tgl_from').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $('#tgl_to').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $("#tgl_from").on("dp.change", function(e) {
            $('#tgl_to').data("DateTimePicker").minDate(e.date);
        });

        $("#tgl_to").on("dp.change", function(e) {
            $('#tgl_from').data("DateTimePicker").maxDate(e.date);
        });

        toastr.options = {
            "closeButton": true,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": true
        }

        $('#data-report').on('click', '#validasi', function() {
            var id_report = $(this).attr('data-id_report');
            var konfirmasi = confirm('Apakah anda yakin ingin validasi report ' + id_report + '?');

            if (konfirmasi) {
                $.ajax({
                    url: '<?= base_url().'admin/validasi_report/' ?>' + id_report,
                    type: 'GET',
                    success: function(data) {
                        if (data == 'berhasil') {
                            toastr.success('Berhasil validasi', 'Success');
                            load_data();
                        } else {
                            toastr.error('Gagal validasi', 'Error');
                        }
                    }
                });
            }
        });

        $('#data-report').on('click', '#add_case', function() {
            var id_report = $(this).attr('data-id_report');
            var kd_booking = $(this).attr('data-kd_booking');
            var klasifikasi = $(this).attr('data-klasifikasi');
            var keterangan = $(this).attr('data-keterangan');
            var pic = $(this).attr('data-pic');
            var tanggal = $(this).attr('data-tanggal');

            $('.id_report').text(id_report);
            $('#id_report').val(id_report);
            $('.kd_booking').text(kd_booking);
            $('.klasifikasi').text(klasifikasi);
            $('.keterangan').text(keterangan);
            $('.pic').text(pic);
            $('.tanggal').text(tanggal);

            $('#modal-case').modal('show');
        });

        $('.form-case').submit(function(e) {
            e.preventDefault();
            var kronologi = $('#kronologi').val();

            if (kronologi == '') {
                toastr.warning('Kronologi tidak boleh kosong', 'Warning');
            } else {

                $.ajax({
                    url: '<?= base_url().'admin/tambah_case' ?>',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data == 'berhasil') {
                            toastr.success('Berhasil menambahkan case', 'Success');
                            $('#modal-case').modal('hide');
                        } else {
                            toastr.error('Gagal menambahkan case', 'Error');
                        }

                        load_data();
                        $('.form-case')[0].reset();
                    },
                    error: function() {
                        toastr.error('Halaman tidak dapat di akses', 'Error');
                    }
                });
            }
        });

        $('#cari-report').on('click', function() {
            var tgl_from = $('#tgl_from').val();
            var tgl_to = $('#tgl_to').val();
            if (tgl_from == '' || tgl_to == '') {
                load_data();
            } else {
                load_data(tgl_from, tgl_to);
            }
        });

    });
</script>
