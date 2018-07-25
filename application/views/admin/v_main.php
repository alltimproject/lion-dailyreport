<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= base_url().'images/bg01.png' ?>" type="image/ico" />

    <title>
        <?= $title ?>
    </title>
    <link href="<?= base_url().'assets/vendors/bootstrap/dist/css/bootstrap.min.css' ?>" rel="stylesheet">
    <link href="<?= base_url().'assets/vendors/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
    <link href="<?= base_url().'assets/vendors/nprogress/nprogress.css' ?>" rel="stylesheet">
    <link href="<?= base_url().'assets/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css' ?>" rel="stylesheet" />
    <link href="<?= base_url().'assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css' ?>" rel="stylesheet">
    <link href="<?= base_url().'assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css' ?>" rel="stylesheet">
    <link href="<?= base_url().'assets/vendors/toastr/build/toastr.min.css' ?>" rel="stylesheet">
    <link href="<?= base_url().'assets/vendors/animate.css/animate.min.css' ?>" rel="stylesheet">
    <link href="<?= base_url().'assets/vendors/jquery-ui/jquery-ui.min.css' ?>" rel="stylesheet">
    <link href="<?= base_url().'assets/build/css/custom.css' ?>" rel="stylesheet">

    <style media="screen">
        .clicked {
            background-color: #FAFAD2;
        }
    </style>
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col menu_fixed">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="index.html" class="site_title"><i><img src="<?= base_url().'images/bg01.png' ?>" style="width: 30px;"></i><span>Daily Report</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <?php
              if($this->session->userdata('foto') == ''){
                $foto = "user.jpg";
              } else {
                $foto = $this->session->userdata('foto');
              }

             ?>
                        <div class="profile clearfix">
                            <!-- <div class="profile_pic"> -->
                            <img src="<?= base_url('images/users/').$foto ?>" alt="..." class="img-circle img-responsive profile_img">
                            <!-- </div> -->
                            <!-- <div class="profile_info"> -->
                            <center>
                                <h3>
                                    <?= $this->session->userdata('nama'); ?>
                                </h3>
                                <span><?= $this->session->userdata('nip'); ?> - <?= $this->session->userdata('hak_akses'); ?></span>
                            </center>


                            <!-- </div> -->
                        </div>
                        <!-- /menu profile quick info -->

                        <br />

                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <ul class="nav side-menu">
                                    <li><a href="#dashboard" class="navigasi"><i class="fa fa-home"></i> Dashboard </a></li>
                                    <li><a href="#report" class="navigasi"><i class="fa fa-bar-chart-o"></i> Daily Report </a></li>
                                    <li><a href="#cases" class="navigasi"><i class="fa fa-home"></i> Case </a></li>
                                    <li><a href="#user" class="navigasi"><i class="fa fa-users"></i> User </a></li>
                                </ul>
                            </div>

                        </div>
                        <!-- /sidebar menu -->

                        <!-- /menu footer buttons -->
                        <div class="sidebar-footer hidden-small">
                            <a data-toggle="tooltip" data-placement="top" title="Password" id="ganti_password">
                <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
              </a>
                            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
                            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
                            <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?= base_url().'auth/logOut' ?>">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
                        </div>
                        <!-- /menu footer buttons -->
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-password">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                  </button>
                            <h4 class="modal-title" id="myModalLabel">Ganti Password</h4>
                        </div>
                        <form class="form-password">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Password Lama</label>
                                    <input type="password" name="old_password" class="form-control" id="old_password">
                                </div>
                                <div class="form-group">
                                    <label>Password Baru</label>
                                    <input type="password" name="new_password" class="form-control" id="new_password">
                                </div>
                                <div class="form-group">
                                    <label>Retype Password</label>
                                    <input type="password" name="retype_password" class="form-control" id="retype_password">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="submit" class="btn btn-md btn-info">Simpan</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li role="presentation" class="dropdown">
                                <a>
                                    <?= date("d M Y") ?>
                                </a>
                            </li>
                            <li role="presentation" class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <!-- <span id="chat-in" class="badge bg-green">6</span> -->
                  </a>
                                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu" style="height: 400px; overflow-x: scroll;">
                                    <li>
                                        <div class="text-center">
                                            <input type="text" class="form-control" name="cari" id="cari" placeholder="Search...">
                                        </div>
                                    </li>
                                    <div id="data-user"></div>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <div id="content"></div>
            </div>
            <!-- /page content -->


            <div id="user-chat"></div>


            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    made with <i class="fa fa-heart"></i> by <a href="#">AllTimProject</a>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>






    <script src="<?= base_url().'assets/vendors/jquery/dist/jquery.min.js' ?>"></script>
    <script src="<?= base_url().'assets/vendors/bootstrap/dist/js/bootstrap.min.js' ?>"></script>
    <script src="<?= base_url().'assets/vendors/fastclick/lib/fastclick.js' ?>"></script>
    <script src="<?= base_url().'assets/vendors/nprogress/nprogress.js' ?>"></script>
    <script src="<?= base_url().'assets/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js' ?>"></script>
    <script src="<?= base_url().'assets/vendors/Chart.js/dist/Chart.js' ?>"></script>
    <script src="<?= base_url().'assets/vendors/datatables.net/js/jquery.dataTables.min.js' ?>"></script>
    <script src="<?= base_url().'assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js' ?>"></script>
    <script src="<?= base_url().'assets/vendors/moment/min/moment.min.js' ?>"></script>
    <script src="<?= base_url().'assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js' ?>"></script>
    <script src="<?= base_url().'assets/vendors/toastr/build/toastr.min.js' ?>"></script>
    <script src="<?= base_url().'assets/vendors/jquery-ui/jquery-ui.min.js' ?>"></script>
    <script src="<?= base_url().'assets/build/js/custom.min.js' ?>"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var href;

            function load_user(cari) {
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

                        $.each(data.user, function(k, v) {
                            if (v.foto != '') {
                                foto = v.foto;
                            } else {
                                foto = 'user.jpg';
                            }

                            if (v.hak_akses == 'Call Center') {
                                html += `<li id="pilih" data-nip="${v.nip}" data-nama="${v.nama}">`;
                                html += `<a>`;
                                html += `<span class="image"><img src="<?= base_url().'images/users/' ?>${foto}" alt="Profile Image"/></span>`;
                                html += `<span>`;
                                html += `<span>${v.nama}</span>`;
                                if (v.jumlah_unread != 0) {
                                    html += `<span class="time badge bg-green">${v.jumlah_unread}</span>`;
                                }
                                if (v.status_user == 'online') {
                                    html += `<br><span class="label label-success">${v.status_user}</span>`;
                                } else {
                                    html += `<br><span class="label label-danger">${v.status_user}</span>`;
                                }
                                html += `</span>`;
                                html += `</a>`;
                                html += `</li>`;
                            }
                        });

                        $('#data-user').html(html);
                    }
                });
            }

            function update_status(nip) {
                $.ajax({
                    url: '<?= base_url('admin/update_pesan') ?>',
                    type: 'POST',
                    data: {
                        nip: nip
                    }
                });
            }

            function chat_dialog(nip, nama) {
                var modal_content = `<div id="user_dialog_${nip}" class="user_dialog" title="Chat with ${nama}">`;
                load_pesan(nip);
                update_status(nip);
                modal_content += `<div style="height: 400px; border: 1px solid #ccc; overflow-x: hidden; overflow-y: scroll; margin-bottom: 24px; padding: 16px;" id="chat_history_${nip}" class="chat-history" data-nip="${nip}" data-nama="${nama}"></div>`;
                modal_content += `<div class="form-group">`;
                modal_content += `<textarea class="form-control" name="chat_with_${nip}" id="chat_with_${nip}"></textarea>`;
                modal_content += `</div>`;
                modal_content += `<div class="form-group pull-right">`;
                modal_content += `<button class="btn btn-info send_chat" name="send_chat" id="${nip}">Send</button>`;
                modal_content += `</div>`;
                modal_content += '</div>';

                $('#user-chat').html(modal_content);
                scrollBottom(nip);
            }

            function scrollBottom(nip) {
                var myDiv = $("#chat_history_" + nip);
                myDiv.animate({
                    scrollTop: myDiv.prop("scrollHeight") + myDiv.height() * 50
                }, 500);
            }

            function load_pesan(nip) {
                $.ajax({
                    url: '<?= base_url().'admin/show_pesan' ?>',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        nip: nip
                    },
                    success: function(data) {
                        var html_pesan = '';

                        $.each(data.pesan, function(k, v) {

                            if (nip == v.user_from) {
                                html_pesan += `<div class="row"><div class="alert alert-success alert-dismissible fade in" role="alert" style="width: 80%">`;
                                html_pesan += `<strong>${v.user_from}</strong>`;
                                html_pesan += `<p>${v.pesan}</p>`;
                                html_pesan += `<p><i class="fa fa-clock-o"></i> ${v.tanggal_pesan}</p>`;
                                html_pesan += `</div></div>`;
                            } else {
                                html_pesan += `<div class="row"><div class="alert alert-info alert-dismissible fade in" role="alert" style="width: 80%; float: right;">`;
                                html_pesan += `<strong style="float: right;">${v.user_from}</strong><br>`;
                                html_pesan += `<p style="float: right;">${v.pesan}</p><br/>`;
                                if (v.status_pesan == 'unread') {
                                    html_pesan += `<p style="float: right;">${v.tanggal_pesan} <i class="fa fa-check"></i></p>`;
                                } else {
                                    html_pesan += `<p style="float: right;">${v.tanggal_pesan} <i class="fa fa-eye"></i></p>`;
                                }
                                html_pesan += `</div></div>`;
                            }
                        });

                        $('#chat_history_' + nip).html(html_pesan);
                    }
                });
            }

            function update_pesan() {
                $('.chat-history').each(function() {
                    var nip = $(this).attr('data-nip');
                    load_pesan(nip);
                });
            }

            //   load_content(href.split('/').pop());

            var load_content = function(href) {
                $.get(`<?= base_url().'admin/' ?>${href}`, function(content) {
                    $('#content').html(content);
                });
                // console.log(href);
            }

            $(window).on('hashchange', function() {
                href = location.hash.substr(1);
                load_content(href);
            });

            if (location.hash) {
                href = location.hash.substr(1);
                load_content(href);
            } else {
                location.hash = '#dashboard';
            }

            load_user();

            setInterval(function() {
                load_user();
                update_pesan();
            }, 5000);


            $('#cari').keyup(function() {
                var cari = $(this).val();
                if (cari == '') {
                    load_user();
                } else {
                    load_user(cari);
                }
            });

            $('#data-user').on('click', '#pilih', function() {
                var nip = $(this).attr('data-nip');
                var nama = $(this).attr('data-nama');

                chat_dialog(nip, nama);
                $('#user_dialog_' + nip).dialog({
                    autoOpen: false,
                    width: 400
                });
                $('#user_dialog_' + nip).dialog('open');
            });

            $(document).on('click', '.send_chat', function() {
                var nip = $(this).attr('id');
                var pesan = $('#chat_with_' + nip).val();

                $.ajax({
                    url: '<?= base_url().'admin/send_pesan' ?>',
                    type: 'POST',
                    data: {
                        nip: nip,
                        pesan: pesan
                    },
                    success: function(data) {
                        var pesan = $('#chat_with_' + nip).val('').focus();
                        load_pesan(nip);
                        scrollBottom(nip);
                    }
                });
            });

            $('#ganti_password').on('click', function() {
                $('.form-password')[0].reset();
                $('#modal-password').modal('show');
            });

            $('.form-password').submit(function() {
                var old_pass = $('#old_password').val();
                var new_pass = $('#new_password').val();
                var retype_pass = $('#retype_password').val();

                if (old_pass == '' || new_pass == '' || retype_pass == '') {
                    toastr.warning('Silahkan isi field dengan lengkap', 'Warning');
                } else if (new_pass != retype_pass) {
                    toastr.warning('New Password dan Retype Password tidak sama', 'Warning');
                } else if (new_pass == old_pass) {
                    toastr.warning('Password baru harus berbeda dari Password sebelumnya', 'Warning');
                } else {
                    $.ajax({
                        url: '<?= base_url().'auth/ganti_password' ?>',
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(data) {
                            if (data == 'berhasil') {
                                toastr.success('Password berhasil diganti', 'Success');
                                $('#modal-password').modal('hide');
                            } else {
                                toastr.error('Password salah, Silahkan masukkan password yang benar', 'Error');
                            }
                        }
                    });
                }
                return false;
            });

            toastr.options = {
                "closeButton": true,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": true
            }
        });
    </script>
</body>

</html>
