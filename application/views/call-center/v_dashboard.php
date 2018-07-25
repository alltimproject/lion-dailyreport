<div class="page-title" id="top">
    <div class="title_left">
        <h3>Dashboard</h3>
    </div>
</div>

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title">
                <h4>Form Report</h4>
                <div class="clearfix"></div>
            </div>
            
            <div class="x_content">
                <br />

                <form class="form-horizontal form-label-left input_mask form-data">
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
                            <button type="submit" class="btn btn-primary" id="submit">Simpan</button>
                            <button class="btn btn-default" type="button" id="batal">Batal</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title">
                <h4>Performance</h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <canvas id="reportChart"></canvas>
            </div>
            <div class="clearfix"></div>
            <center>
                <button type="button" class="btn btn-xs" style="background-color: #455C73; color: white;">Booking</button>
                <button type="button" class="btn btn-xs" style="background-color: #9B59B6; color: white;">Rebook</button>
                <button type="button" class="btn btn-xs" style="background-color: #BDC3C7; color: white;">Refund</button>
                <button type="button" class="btn btn-xs" style="background-color: #26B99A; color: white;">Other</button>
            </center>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12" id="master-panel">
        <div class="x_panel">
            <div class="x_title">
                <h4>Daily Report</h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table jambo_table" id="daily-report">
                    <thead>
                        <tr class="headings">
                            <th width="10%">No</th>
                            <th>Kode Booking</th>
                            <th>Klasifikasi</th>
                            <th width="10%">Edit</th>
                        </tr>
                    </thead>
                    <tbody id="data"></tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-0" id="detail-panel">
        <div class="x_panel">
            <div class="x_title">
                <h4>Detail <span class="pull-right"><a class="close-link"><i class="fa fa-close"></i></a></span></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="detail"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        var save_method = "add";

        function load_data() {
            $.ajax({
                url: '<?= base_url().'call/show_report' ?>',
                type: 'POST',
                dataType: 'JSON',
                success: function(data) {
                    var no = 0;
                    var html_report = '';

                    // console.log(data.report);

                    $.each(data.report, function(k, v) {
                        no++;
                        html_report += `<tr id="pilih" data-id_report="${v.id_report}" data-tanggal_report="${v.tanggal_report}" data-kd_booking="${v.kd_booking}" data-klasifikasi="${v.klasifikasi}" data-keterangan="${v.keterangan}">`;
                        html_report += `<td>${no}</td>`;
                        html_report += `<td>${v.kd_booking}</td>`;
                        html_report += `<td>${v.klasifikasi}</td>`;
                        html_report += `<td><button type="button" class="btn btn-success btn-md" id="edit" data-id_report="${v.id_report}" data-tanggal_report="${v.tanggal_report}" data-kd_booking="${v.kd_booking}" data-klasifikasi="${v.klasifikasi}" data-keterangan="${v.keterangan}"><i class="fa fa-pencil"></i></button></td>`;
                        html_report += `</tr>`;
                    });

                    $('#data').html(html_report);
                    $('#reportChart').replaceWith('<canvas id="reportChart"></canvas>');

                    if ($('#reportChart').length) {
                        var ctx = document.getElementById("reportChart");
                        var data = {
                            datasets: [{
                                data: [data.jumlah_booking, data.jumlah_rebook, data.jumlah_refund, data.jumlah_other],
                                backgroundColor: [
                                    "#455C73",
                                    "#9B59B6",
                                    "#BDC3C7",
                                    "#26B99A"
                                ],
                                label: 'My dataset' // for legend
                            }],
                            labels: [
                                "Booking",
                                "Rebook",
                                "Refund",
                                "Other"
                            ]
                        };

                        var reportChart = new Chart(ctx, {
                            data: data,
                            type: 'pie',
                            otpions: {
                                legend: false
                            }
                        });
                    }

                }
            });
        }

        load_data();
        $('#detail-panel').hide();
        $('.form-keterangan').hide();
        $('#kd_booking').focus();

        $(document).on('click', '.close-link', function() {
            $('#master-panel').removeClass().addClass('col-md-12');
            $('#detail-panel').removeClass().addClass('col-md-0').fadeOut();
        });

        $(document).on('click', '#pilih', function() {
            var html_detail = '';
            var detail_id = $(this).attr('data-id_report');
            var detail_kd = $(this).attr('data-kd_booking');
            var detail_klasifikasi = $(this).attr('data-klasifikasi');
            var detail_tanggal = $(this).attr('data-tanggal_report');

            var selected = $(this).hasClass('clicked');
            $('#data, #pilih').removeClass('clicked');
            if (!selected) {
                $(this).addClass('clicked');
            }

            if ($(this).attr('data-keterangan') != 0) {
                var detail_keterangan = $(this).attr('data-keterangan');
            } else {
                var detail_keterangan = '-';
            }

            $('#master-panel').removeClass().addClass('col-md-8');
            $('#detail-panel').removeClass().addClass('col-md-4').fadeIn();

            html_detail += '<table class="table">';
            html_detail += `<tr><th width="30%">ID Report</th><td width="10%"> : </td><td width="60%">${detail_id}<td></tr>`;
            html_detail += `<tr><th>Kode Booking</th><td> : </td><td>${detail_kd}<td></tr>`;
            html_detail += `<tr><th>Tanggal / Jam</th><td> : </td><td>${detail_tanggal}<td></tr>`;
            html_detail += `<tr><th>Klasifikasi</th><td> : </td><td>${detail_klasifikasi}<td></tr>`;
            html_detail += `<tr><th>Keterangan</th><td> : </td><td>${detail_keterangan}<td></tr>`;
            html_detail += '</table>';

            $('#detail').html(html_detail);
        });

        $(document).on('click', '#edit', function(e) {
            save_method = 'edit';
            var klasifikasi = $(this).attr('data-klasifikasi');

            if (klasifikasi == 'Booking' || klasifikasi == '') {
                $('.form-keterangan').hide();
            } else if (klasifikasi == 'Rebook' || klasifikasi == 'Refund') {
                $('.form-keterangan').show();
            } else {
                $('.form-keterangan').show();
            }

            $('#id_report').val($(this).attr('data-id_report'));
            $('#kd_booking').val($(this).attr('data-kd_booking'));
            $('#klasifikasi').val($(this).attr('data-klasifikasi'))
            $('#keterangan').val($(this).attr('data-keterangan'));

            $('#submit').removeClass().addClass('btn btn-success').text('Update');

            $("html, body").animate({
                scrollTop: $('#top').offset().top
            }, 1000);

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
            save_method = 'add';
            $('.form-data')[0].reset();
            $('#submit').removeClass().addClass('btn btn-primary').text('Simpan');
            $('.form-keterangan').hide();
            $('#kd_booking').focus();
        });

        $('.form-data').submit(function() {
            var kd_booking = $('#booking-kd').val();
            var klasifikasi = $('#klasifikasi').val();

            if (kd_booking == '' || klasifikasi == '') {
                toastr.warning('Kode Booking atau Klasifikasi tidak boleh kosong', 'Warning');
            } else {
                if (save_method == 'add') {
                    var link = '<?= base_url('call/tambah_report') ?>';
                } else {
                    var link = '<?= base_url('call/edit_report') ?>';
                }

                $.ajax({
                    url: link,
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data == 'berhasil') {
                            toastr.success(`Berhasil ${save_method} report`, 'Success');
                            load_data();
                            save_method = 'add';
                            $('.form-data')[0].reset();
                            $('.form-keterangan').hide();
                            $('#submit').removeClass().addClass('btn btn-primary').text('Simpan');
                            $('.close-link').click();
                            $('#kd_booking').focus();
                        } else {
                            toastr.error(`Gagal ${save_method} report`, 'Error');
                        }
                    }
                });
            }
            return false;
        });
    });
</script>
