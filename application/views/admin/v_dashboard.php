<div class="page-title" id="top">
    <div class="title_left">
        <h3>Dashboard</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <form class="form-inline form-cari">
                <div class="input-group">
                    <div class="container">
                        <input type="text" class="form-control" name="tgl_from" placeholder="From : yyyy-mm-dd" / id='tgl_from'>
                    </div>
                </div>
                <div class="input-group">
                    <div class="container">
                        <input type="text" class="form-control" name="tgl_to" placeholder="To : yyyy-mm-dd" / id='tgl_to'>
                        <span class="input-group-btn">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
              </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-3 col-xs-6">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-plane"></i></div>
            <div class="count count-booking">0</div>
            <h3>Booking</h3>
        </div>
    </div>
    <div class="col-md-3 col-xs-6">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-clock-o"></i></div>
            <div class="count count-rebook">0</div>
            <h3>Rebook</h3>
        </div>
    </div>
    <div class="col-md-3 col-xs-6">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-times-circle-o"></i></div>
            <div class="count count-refund">0</div>
            <h3>Refund</h3>
        </div>
    </div>
    <div class="col-md-3 col-xs-6">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-info-circle"></i></div>
            <div class="count count-other">0</div>
            <h3>Other</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
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
    <div class="col-md-4">
        <div class="x_panel">
            <div class="x_title">
                <h4>Top 5 Call Center</h4>
            </div>
            <div class="x_content">
                <ul class="list-unstyled top_profiles scroll-view"></ul>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function load_data(serialize) {
        $.ajax({
            url: '<?= base_url().'admin/show_dashboard' ?>',
            type: 'POST',
            dataType: 'JSON',
            data: serialize,
            success: function(data) {

                var html = '';

                $.each(data.top, function(k, v) {
                    html += `<li class="media event">`;
                    html += `<a class="pull-left">`;
                    if (v.foto == '') {
                        var foto = 'user.jpg';
                    } else {
                        var foto = v.foto;
                    }
                    html += `<img src="<?= base_url().'images/users/' ?>${foto}" class="img img-responsive img-circle" style="width: 55px; height: 55px;">`;
                    html += `</a>`;
                    html += `<div class="media-body">`;
                    html += `<a class="title">${v.nama}</a>`;
                    html += `<p><strong>${v.total_report} </strong> Total Services </p>`;
                    html += `<p> <small>registered at ${v.register_date}</small>`;
                    html += `</p>`;
                    html += `</div>`;
                    html += `</li>`;
                });

                $('.top_profiles').html(html);
                $('.count-booking').text(data.jumlah_booking);
                $('.count-rebook').text(data.jumlah_rebook);
                $('.count-refund').text(data.jumlah_refund);
                $('.count-other').text(data.jumlah_other);

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

    $(document).ready(function() {
        load_data();

        // setInterval(function(){
        //   load_data();
        // }, 5000);

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

    });
</script>
