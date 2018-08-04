<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?= $title ?>
    </title>
    <link href="<?= base_url().'assets/vendors/bootstrap/dist/css/bootstrap.min.css' ?>" rel="stylesheet">
    <link href="<?= base_url().'assets/vendors/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
    <link href="<?= base_url().'assets/vendors/nprogress/nprogress.css' ?>" rel="stylesheet">
    <link href="<?= base_url().'assets/vendors/toastr/build/toastr.min.css' ?>" rel="stylesheet">
    <link href="<?= base_url().'assets/build/css/custom.min.css' ?>" rel="stylesheet">
    <link href="<?= base_url().'assets/preloader.css' ?>" rel="stylesheet">

    <style media="screen">
        .color-red {
            color: red;
        }

        .back-cc {
            background: linear-gradient( rgba(0, 0, 0, 0.5),
            rgba(0, 0, 0, 0.5)),
            url('<?= base_url('images/LION123.jpg') ?>');
            background-size: cover;
            position: relative;

        }
    </style>
</head>

<body class="login back-cc">

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form class="form-login">
                    <h1 class="color-red">Daily Report</h1>
                    <div>
                        <input type="text" name="nip" id="nip" class="form-control" placeholder="NIP" />
                    </div>
                    <div>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" />
                    </div>
                    <div>
                        <button type="submit" class="btn btn-default btn-xl">Log in</button>
                    </div>

                    <div class="clearfix"></div>
                    <div class="separator">
                        <div>
                            <h1>
                                <center><img src="<?= base_url().'images/bg03.png' ?>" class="img img-responsive" style="width: 50%"></center>
                            </h1>
                            <p class="color-red">made with <i class="fa fa-heart"></i> by Hesti Kurniawati. ©2018 All Rights Reserved</p>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url().'assets/vendors/jquery/dist/jquery.min.js' ?>"></script>
    <script src="<?= base_url().'assets/vendors/toastr/build/toastr.min.js' ?>"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $('.form-login').submit(function() {
                var nip = $('#nip').val();
                var password = $('#password').val();

                if (nip == '' && password == '') {
                    toastr.warning('Silahkan masukkan NIP dan Password', 'Warning');
                } else if (nip == '') {
                    toastr.warning('Silahkan masukkan NIP', 'Warning');
                } else if (password == '') {
                    toastr.warning('Silahkan masukkan Password', 'Warning');
                } else {
                    $.ajax({
                        url: '<?= base_url('auth/loginCek ') ?>',
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(data) {
                            if (data == 'gagal') {
                                toastr.warning('Username atau Password salah', 'Warning');
                            } else {
                                window.location = '<?= base_url().'main/' ?>'
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
