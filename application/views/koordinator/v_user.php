<div class="page-title" id="top">
    <div class="title_left">
        <h3>Data Call Center</h3>
    </div>
    <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
                <input type="text" name="cari" class="form-control" id="search" placeholder="Cari nama..">
                <span class="input-group-btn">
          <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
        </span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-history">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                <h4 class="modal-title" id="myModalLabel">History Sanksi</h4>
            </div>
            <div class="modal-body">
                <div id="data-sanksi"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<div id="content-user"></div>

<script type="text/javascript">
    $(document).ready(function() {

        var save_method;

        function load_data(cari) {
            $.ajax({
                url: '<?= base_url().'koordinator/show_user' ?>',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    cari: cari
                },
                success: function(data) {
                    var html = '';
                    var foto;

                    html += '<div class="row">';
                    $.each(data.user, function(k, v) {
                      html += '<div class="col-md-4">';
                      html += '<div class="profile_details">';
                      html += '<div class="well profile_view">';
                      html += '<div class="col-sm-12">';
                      html += '<div class="left col-xs-7">';
                      html += `<h4>${v.nama}</h4>`;
                      html += `<p><strong>NIP: </strong> ${v.nip} </p>`;
                      html += `<p><strong>Jabatan: </strong> ${v.jabatan} </p>`;
                      html += '</div>';
                      html += '<div class="right col-xs-5 text-center">';
                      if (v.foto != '') {
                          foto = v.foto;
                      } else {
                          foto = 'user.jpg';
                      }
                      html += '<img src="<?= base_url().'images/users/' ?>' + foto + '" alt="" class="img-circle img-responsive" style="width: 120px; height: 120px;">';
                      html += '</div>';
                      html += '</div>';
                      html += '<div class="col-xs-12 bottom text-center">';
                      html += '<div class="col-xs-12 col-sm-6 col-md-12 emphasis">';
                      html += `<button type="button" class="btn btn-warning btn-xs" id="history-sanksi" data-nip="${v.nip}">`;
                      html += '<i class="fa fa-bars"></i> Daftar Sanksi';
                      html += '</button>';
                      html += '</div>';
                      html += '</div>';
                      html += '</div>';
                      html += '</div>';
                      html += '</div>';
                    });
                    html += '</div>';

                    $('#content-user').html(html);
                }
            });
        }

        load_data();

        $('#search').keyup(function() {
            var cari = $(this).val();
            if (cari == '') {
                load_data();
            } else {
                load_data(cari);
            }
        });

        $(document).on('click', '#history-sanksi', function() {
            $('#modal-history').modal('show');
            var nip = $(this).attr('data-nip');
            var html = '';

            $.ajax({
                url: '<?= base_url().'koordinator/history_sanksi/' ?>' + nip,
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {

                    if (data.sanksi.length != 0) {
                        html += `<table class="table">`;
                        html += `<tr> <th>ID Sanksi</th>  <th>Tanggal Sanksi</th> <th>Jenis Sanksi</th> <th><i class="fa fa-print"></i></th> </tr>`;
                        $.each(data.sanksi, function(k, v) {
                            html += `<tr>`;
                            html += `<td>${v.id_sanksi}</td>`;
                            html += `<td>${v.tanggal_sanksi}</td>`;
                            html += `<td>${v.jenis_sanksi}</td>`;
                            html += `<td><a href="<?= base_url().'asmen/print_sanksi/' ?>${v.id_sanksi}" target="_blank" class="btn btn-info btn-xs"> Print <i class="fa fa-print"></i></a></td>`;
                            html += `</tr>`;
                        });
                        html += `</table>`;

                        $('#data-sanksi').html(html);
                    } else {
                        $('#data-sanksi').html('<center>Tidak ada history sanksi</center>');
                    }
                }
            });
        });
    });
</script>
