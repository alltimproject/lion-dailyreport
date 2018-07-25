<div class="page-title" id="top">
    <div class="title_left">
        <h3>Case</h3>
    </div>
</div>

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12" id="master-case">
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
                        </tr>
                    </thead>
                    <tbody id="data-case"></tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-0" id="detail-case">
        <div class="x_panel">
            <div class="x_title">
                <h4>Kronologis <span class="pull-right"><a class="close-link"><i class="fa fa-close"></i></a></span></h4>
            </div>
            <div class="x_content">
                <div id="detail-kronologis"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-case">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
                <h4 class="modal-title" id="myModalLabel">Update Case</h4>
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
                                <input type="hidden" name="id_case" id="id_case">
                                <textarea name="kronologis" id="kronologis" class="form-control" style="height: 200px;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" id="submit" class="btn btn-success">Update</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {


        function load_data() {
            $.ajax({
                url: '<?= base_url().'admin/show_case' ?>',
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
                            html += `<td>Acc by ${v.acc_by} <i class="fa fa-check"></i></td>`;
                        } else {
                            html += `<td><button class="btn btn-sm btn-success" id="edit-case" data-id_case="${v.id_case}" data-kronologis="${v.kronologis}" data-id_report="${v.id_report}" data-kd_booking="${v.kd_booking}" data-tanggal="${v.datetime_report}" data-klasifikasi="${v.klasifikasi}" data-keterangan="${v.keterangan}" data-pic="${v.nama}">Edit</button></td>`;
                        }

                        html += '</tr>';
                    });

                    $('#data-case').html(html);
                }
            });
        }

        load_data();
        $('#detail-case').hide();

        $('#table-case').on('click', '#edit-case', function() {
            var id_case = $(this).attr('data-id_case');
            var kronologis = $(this).attr('data-kronologis');
            var id_report = $(this).attr('data-id_report');
            var kd_booking = $(this).attr('data-kd_booking');
            var klasifikasi = $(this).attr('data-klasifikasi');
            var keterangan = $(this).attr('data-keterangan');
            var pic = $(this).attr('data-pic');
            var tanggal = $(this).attr('data-tanggal');

            $('.id_report').text(id_report);
            $('.kd_booking').text(kd_booking);
            $('.klasifikasi').text(klasifikasi);
            $('.keterangan').text(keterangan);
            $('.pic').text(pic);
            $('.tanggal').text(tanggal);

            $('#id_case').val(id_case);
            $('#kronologis').val(kronologis);
            $('#modal-case').modal('show');
        });

        $('#table-case').on('click', '#pilih', function() {
            var kronologis = $(this).attr('data-coba_kronologis');

            var selected = $(this).hasClass('clicked');
            $('#table-case, #pilih').removeClass('clicked');
            if (!selected) {
                $(this).addClass('clicked');
            }

            $('#detail-case').removeClass().addClass('col-md-4').show();;
            $('#master-case').removeClass().addClass('col-md-8');
            $('#detail-kronologis').html(kronologis);
        });

        $(document).on('click', '.close-link', function() {
            $('#master-case').removeClass().addClass('col-md-12');
            $('#detail-case').removeClass().addClass('col-md-0').hide();
        });

        $('.form-case').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '<?= base_url().'admin/edit_case' ?>',
                type: 'POST',
                data: $(this).serialize(),
                success: function(data) {
                    if (data == 'berhasil') {
                        toastr.success('Berhasil mengedit case', 'Success');
                    } else {
                        toastr.error('Tidak berhasil mengedit case', 'Error');
                    }
                    load_data();
                    $('.form-case')[0].reset();
                    $('#modal-case').modal('hide');
                    $('#detail-case').removeClass().addClass('col-md-0').hide();
                    $('#master-case').removeClass().addClass('col-md-12');
                },
                error: function() {
                    toastr.error('Halaman tidak dapat diakses', 'Error');
                }
            });
        });



    });
</script>
