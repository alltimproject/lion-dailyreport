<div class="page-title" id="top">
    <div class="title_left">
        <h3>Data User
            <button type="button" class="btn btn-primary btn-sm" id="tambah">+ Tambah</button>
        </h3>
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

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-user">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <form class="form-user">
                <div class="modal-body">
                    <div class="form-group">
                        <label>NIP</label>
                        <input type="hidden" name="nip" id="nip">
                        <input type="text" name="new-nip" class="form-control" id="new-nip">
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" id="nama">
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <select class="form-control" name="jabatan" id="jabatan">
                                <option value="">-- Pilih Jabatan --</option>
                                <option value="Call Center"> Call Center </option>
                                <option value="Special Case"> Special Case </option>
                                <option value="Call Center BFF"> Call Center BFF </option>
                                <option value="Call Center English"> Call Center English </option>
                                <option value="Call Center Parcel"> Call Center Parcel </option>
                                <option value="Customer Care"> Customer Care </option>
                                <option value="Koordinator"> Koordinator </option>
                                <option value="Asisten Manajer"> Asisten Manajer </option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" id="submit-user"></button>
                </div>

            </form>

        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-upload">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Upload Foto</h4>
            </div>
            <form class="form-upload" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="nip" id="nip_upload">
                        <input type="file" name="foto_user" id="foto_user" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>




<script type="text/javascript">
    $(document).ready(function() {

        var save_method;

        function load_data(cari) {
            $.ajax({
                url: '<?= base_url().'admin/show_user' ?>',
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
                        html += `<button type="button" class="btn btn-default btn-xs" id="upload" data-nip="${v.nip}">`;
                        html += '<i class="fa fa-image"></i> Upload Foto';
                        html += '</button>';
                        html += `<button type="button" id="edit" class="btn btn-success btn-xs" data-nip="${v.nip}" data-nama="${v.nama}" data-jabatan="${v.jabatan}">`;
                        html += '<i class="fa fa-pencil"></i> Edit User';
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

        $('#tambah').on('click', function() {
            save_method = "add";
            $('#modal-user').modal('show');
            $('.form-user')[0].reset();
            $('.modal-title').text('Tambah User');
            $('#submit-user').removeClass().addClass('btn btn-info').text('Simpan');
        });

        $(document).on('click', '#edit', function() {
            var nip = $(this).attr('data-nip');
            var nama = $(this).attr('data-nama');
            var jabatan = $(this).attr('data-jabatan');
            save_method = "edit";

            $('#modal-user').modal('show');
            $('.modal-title').text('Edit User');
            $('#submit-user').removeClass().addClass('btn btn-success').text('Update');

            $('#new-nip').val(nip);
            $('#nip').val(nip);
            $('#nama').val(nama);
            $('#jabatan').val(jabatan);
        });

        $(document).on('click', '#upload', function() {
            var nip = $(this).attr('data-nip');
            $('#nip_upload').val(nip);
            $('#modal-upload').modal('show');
        });

        $('.form-user').submit(function() {
            var nip = $('#new-nip').val();
            var jabatan = $('#jabatan').val();
            var nama = $('#nama').val();

            if (save_method == "add") {
                var link = '<?= base_url().'admin/add_user' ?>';
            } else {
                var link = '<?= base_url().'admin/edit_user' ?>';
            }

            if (nip == '' || jabatan == '' || nama == '') {
                toastr.warning('Harap mengisi form dengan lengkap', 'Warning');
            } else {

                $.ajax({
                    url: link,
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data == 'berhasil') {
                            toastr.success('Berhasil menambah user', 'Success');
                        } else {
                            toastr.error('Gagal menambah user', 'Error');
                        }
                        $('#modal-user').modal('hide');
                        load_data();
                    }
                });
            }

            return false;
        });

        $('#search').keyup(function() {
            var cari = $(this).val();
            if (cari == '') {
                load_data();
            } else {
                load_data(cari);
            }
        });

        $('#foto_user').change(function() {
            var file = $(this)[0].files[0];
            var type = file.type;
            var name = file.name;
            var match_type = ["image/png", "image/jpeg"];
            if (!((type == match_type[0]) || (type == match_type[1]))) {
                toastr.warning('Format yang diperbolehkan hanya .png atau .jpg', 'Warning');
                $('#foto_user').val('');
            }
        });

        $('.form-upload').submit(function() {
            var file_tugas = $('#foto_user').val();

            if (file_tugas == '') {
                toastr.warning('Silahkan pilih foto user', 'Warning')
            } else {
                $.ajax({
                    url: '<?= base_url().'admin/upload_user' ?>',
                    type: 'POST',
                    data: new FormData(this),
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data == "berhasil") {
                            toastr.success(`File berhasil diupload`, 'Success');
                            $('#foto_user').val('');
                            $('#modal-upload').modal('hide');
                            load_data();
                        } else {
                            toastr.error(`File tidak berhasil diupload`, 'Error');
                        }
                        // $('#modalUpload').modal('hide');
                        // toastr.info(data, 'Success');
                    },
                    error: function() {
                        toastr.error('Tidak dapat memproses Data', 'Error');
                    }
                });
            }
            return false;
        });



    });
</script>
