<div class="page-title">
    <div class="title_left">
        <h3>Data Master</h3>
    </div>
</div>

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-6 col-xs-12">
        <div class="row">
            <div class="col-md-6 col-xs-6">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-plane"></i></div>
                    <div class="count count-booking">0</div>
                    <h3>Booking</h3>
                </div>
            </div>
            <div class="col-md-6 col-xs-6">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-clock-o"></i></div>
                    <div class="count count-rebook">0</div>
                    <h3>Rebook</h3>
                </div>
            </div>
            <div class="col-md-6 col-xs-6">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-times-circle-o"></i></div>
                    <div class="count count-refund">0</div>
                    <h3>Refund</h3>
                </div>
            </div>
            <div class="col-md-6 col-xs-6">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-info-circle"></i></div>
                    <div class="count count-other">0</div>
                    <h3>Other</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h4>Cari Data</h4>
            </div>
            <div class="x_content">
                <form class="form-inline form-cari">
                    <div class="input-group">
                        <label>From</label>
                        <div class="container">
                            <input type="text" class="form-control" name="tgl_from" placeholder="yyyy-mm-dd" id='tgl_from'>
                        </div>
                    </div>
                    <div class="input-group">
                        <label>To</label>
                        <div class="container">
                            <input type="text" class="form-control" name="tgl_to" placeholder="yyyy-mm-dd" id='tgl_to'>
                            <span class="input-group-btn">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12" id="content-master">
        <div class="x_panel">
            <div class="x_title">
                <h4>All Report
                    <span class="pull-right">
            <button type="button" class="btn btn-md btn-success" id="refresh" name="button">Refresh <i class="fa fa-refresh"></i></button>
          </span>
                </h4>

            </div>
            <div class="x_content table-responsive">
                <table class="table jambo_table" id="all-report">
                    <thead>
                        <tr class="headings">
                            <th width="10%">No</th>
                            <th>Kode Booking</th>
                            <th>Tanggal/Waktu</th>
                            <th>Klasifikasi</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="data"></tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-0" id="content-form">
        <div class="x_panel">
            <div class="x_title">
                <h4>Edit Report</h4>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <br />

                <form class="form-horizontal form-label-left input_mask form-edit">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Kode Booking</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="hidden" name="id_report" id="id_report">
                            <input type="text" name="kd_booking" id="kd_booking" class="form-control" maxlength="6">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Klasifikasi</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" name="klasifikasi" id="klasifikasi">
                                <option value="">-- Pilih Klasifikasi --</option>
                                <option value="Booking">Booking</option>
                                <option value="Rebook">Rebook</option>
                                <option value="Refund">Refund</option>
                                <option value="Other">Other</option>
                              </select>
                        </div>
                    </div>
                    <div class="form-group form-keterangan">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="7"></textarea>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
                            <button type="submit" class="btn btn-success" id="submit">Edit</button>
                            <button class="btn btn-default" type="button" id="batal">Batal</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {

        function load_data(serialize) {
            $.ajax({
                url: '<?= base_url().'call/all_report' ?>',
                type: 'POST',
                dataType: 'JSON',
                data: serialize,
                success: function(data) {
                    var no = 0;
                    var html_report = '';

                    $('.count-booking').text(data.jumlah_booking);
                    $('.count-rebook').text(data.jumlah_rebook);
                    $('.count-refund').text(data.jumlah_refund);
                    $('.count-other').text(data.jumlah_other);

                    $.each(data.report, function(k, v) {
                        no++;
                        html_report += `<tr>`;
                        html_report += `<td>${no}</td>`;
                        html_report += `<td>${v.kd_booking}</td>`;
                        html_report += `<td>${v.datetime_report}</td>`;
                        html_report += `<td>${v.klasifikasi}</td>`;
                        html_report += `<td>${v.keterangan}</td>`;

                        if (v.status == 'Valid') {
                            html_report += `<td>${v.status} <i class="fa fa-check"></i></td>`;
                        } else {
                            html_report += `<td><button type="button" class="btn btn-success btn-sm" id="edit-master" data-id_report="${v.id_report}" data-kd_booking="${v.kd_booking}" data-klasifikasi="${v.klasifikasi}" data-keterangan="${v.keterangan}"> Edit </button></td>`;
                        }
                        html_report += `</tr>`;
                    });

                    $('#data').html(html_report);
                }
            });
        }

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

        load_data();
        $('#content-form').hide();

        $('.form-cari').submit(function() {
            var tgl_from = $('#tgl_from').val();
            var tgl_to = $('#tgl_to').val();
            if (tgl_from == '' || tgl_to == '') {
                toastr.warning('Field pencarian harus diisi', 'Warning');
            } else {
                var data = $(this).serialize();
                load_data(data);
            }
            return false;
        });

        $('#refresh').on('click', function() {
            load_data();
            $('#content-master').removeClass().addClass('col-md-12');
            $('#content-form').removeClass().addClass('col-md-0').hide();
            $('.form-cari')[0].reset();
            $('.form-edit')[0].reset();
        });

        $(document).on('click', '#edit-master', function() {
            var id_report = $(this).attr('data-id_report');
            var kd_booking = $(this).attr('data-kd_booking');
            var klasifikasi = $(this).attr('data-klasifikasi');
            var keterangan = $(this).attr('data-keterangan');

            if (klasifikasi == 'Booking' || klasifikasi == '') {
                $('.form-keterangan').hide();
            } else if (klasifikasi == 'Rebook' || klasifikasi == 'Refund') {
                $('.form-keterangan').show();
            } else {
                $('.form-keterangan').show();
            }

            $('#id_report').val(id_report);
            $('#kd_booking').val(kd_booking);
            $('#klasifikasi').val(klasifikasi);
            $('#keterangan').val(keterangan);

            $("html, body").animate({
                scrollTop: $('.form-cari').offset().top
            }, 1000);

            $('#content-master').removeClass().addClass('col-md-6');
            $('#content-form').removeClass().addClass('col-md-6').show();
        });

        $('#klasifikasi').on('change', function() {
            var klasifikasi = $(this).val();
            if (klasifikasi == 'Booking' || klasifikasi == '') {
                $('.form-keterangan').hide();
            } else if (klasifikasi == 'Rebook' || klasifikasi == 'Refund') {
                $('.form-keterangan').show();
                $('#keterangan').focus();
            } else {
                $('.form-keterangan').show();
                $('#keterangan').focus();
            }
        });

        $('#batal').on('click', function() {
            $('#content-master').removeClass().addClass('col-md-12');
            $('#content-form').removeClass().addClass('col-md-0').hide();
            $('.form-edit')[0].reset();
        });

        $('.form-edit').on('submit', function(e) {
            var kd_booking = $('#kd_booking').val();
            var klasifikasi = $('#klasifikasi').val();

            e.preventDefault();

            if (kd_booking == '' || klasifikasi == '') {
                toastr.warning('Field Kode Booking dan Klasifikasi tidak boleh kosong', 'Warning');
            } else {
                $.ajax({
                    url: '<?= base_url('call/edit_report') ?>',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data == 'berhasil') {
                            toastr.success('Berhasil mengupdate Report', 'Success');
                            $('#content-master').removeClass().addClass('col-md-12');
                            $('#content-form').removeClass().addClass('col-md-0').hide();
                            $('.form-edit')[0].reset();
                            load_data();
                        } else {
                            toastr.error('Tidak berhasil mengupdate Report', 'Error');
                        }
                    }
                });
            }
        });

    });
</script>
