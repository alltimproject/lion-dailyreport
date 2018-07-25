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

<div class="clearfix"></div>

<div id="content-user"></div>

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-sanksi">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                <h4 class="modal-title" id="myModalLabel">Tambah Sanksi</h4>
            </div>
            <form class="form-sanksi">
                <div class="modal-body">
                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" name="nip" id="nip" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Jenis Sanksi</label>
                        <select class="form-control" name="jenis_sanksi" id="jenis_sanksi">
                                <option value="">-- Pilih Sanksi -- </option>
                                <option value="SP1">SP1</option>
                                <option value="SP2">SP2</option>
                                <option value="SP3">SP3</option>
                              </select>
                    </div>
                    <div class="form-group">
                        <label>Kesalahan</label>
                        <textarea name="keterangan_sanksi" rows="8" cols="80" class="form-control" id="keterangan_sanksi"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submit" class="btn btn-info btn-md">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>

            </form>

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






<script type="text/javascript">
    $(document).ready(function() {

        function load_data(cari) {
            $.ajax({
                url: '<?= base_url().'asmen/show_user' ?>',
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
                        html += `<button type="button" id="tambah-sanksi" class="btn btn-danger btn-xs" data-nip="${v.nip}" data-nama="${v.nama}" data-jabatan="${v.jabatan}">`;
                        html += '<i class="fa fa-warning"></i> Tambah Sanksi';
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

        $(document).on('click', '#tambah-sanksi', function() {
            $('#nip').val($(this).attr('data-nip'));
            $('#nama').val($(this).attr('data-nama'));
            $('#jabatan').val($(this).attr('data-jabatan'));

            $('#modal-sanksi').modal('show');
        });

        $(document).on('click', '#history-sanksi', function() {
            $('#modal-history').modal('show');
            var nip = $(this).attr('data-nip');
            var html = '';

            $.ajax({
                url: '<?= base_url().'asmen/history_sanksi/' ?>' + nip,
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

        $('.form-sanksi').submit(function(e) {

            e.preventDefault();

            var jenis = $('#jenis_sanksi').val();
            var keterangan = $('#keterangan_sanksi').val();

            if (jenis == '' || keterangan == '') {
                toastr.warning('Field harus diisi dengan lengkap', 'Warning');
            } else {
                $.ajax({
                    url: '<?= base_url().'asmen/tambah_sanksi' ?>',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data == 'berhasil') {
                            toastr.success('Berhasil memberikan Sanksi', 'Success');
                            $('.form-sanksi')[0].reset();
                            $('#modal-sanksi').modal('hide');
                        } else {
                            toastr.error('Gagal memberikan Sanksi', 'Error');
                        }
                    }
                });
            }
        });


        $('#search').keyup(function() {
            var cari = $(this).val();
            if (cari == '') {
                load_data();
            } else {
                load_data(cari);
            }
        });

    });
</script>
