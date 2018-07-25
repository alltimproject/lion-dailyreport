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
    <link href="<?= base_url().'assets/vendors/animate.css/animated.min.css' ?>" rel="stylesheet">
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
                                    <li><a href="#cases" class="navigasi"><i class="fa fa-home"></i> Case </a></li>
                                    <li><a href="#user" class="navigasi"><i class="fa fa-users"></i> Call Center </a></li>
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

            //   load_content(href.split('/').pop());

            var load_content = function(href) {
                $.get(`<?= base_url().'asmen/' ?>${href}`, function(content) {
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
