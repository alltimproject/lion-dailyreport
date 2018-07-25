<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>
        <?= $title ?>
    </title>
    <style>
        .header {
            text-align: center;
        }

        .title {
            text-align: center;
        }

        .body {
            margin-left: 30px;
            margin-right: 30px;
        }

        .footer {
            margin-left: 30px;
            margin-right: 30px;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="<?= base_url().'images/bg03.png' ?>" style="width: 20%;">
        <h3>PT. Lion Mentari Airlines</h3>
        <p>Jl. Gajah Mada no 7 Jakarta Pusat</p>
        <p>Telp: (021) 63798000</p>
        <hr style="height: 5px; margin-bottom: 0px;">
        <hr style="margin-top: 2px;">
    </div>

    <?php
      foreach ($data as $detail) {
        $nip = $detail->nip;
        $nama = $detail->nama;
        $jabatan = $detail->jabatan;
        $id_sanksi = $detail->id_sanksi;
        $tanggal = $detail->tanggal_sanksi;
        $jenis = $detail->jenis_sanksi;
        $keterangan = $detail->keterangan_sanksi;

        if($jenis == 'SP1')
        {
          $sp = 'Surat Peringatan Pertama';
          $sp_next = 'akan diterbitkan Surat Peringatan Kedua';
        } elseif($jenis == 'SP2') {
          $sp = 'Surat Peringatan Kedua';
          $sp_next = 'akan diterbitkan Surat Peringatan Ketiga';
        } else {
          $sp = 'Surat Peringatan Ketiga';
          $sp_next = 'karyawan akan diberhentikan';
        }
      }

     ?>

        <div class="title">
            <h3><u>Surat Peringatan</u></h3>
            <p>Nomor:
                <?= $id_sanksi ?>
            </p>
        </div>

        <div class="body">
            <p>Surat Peringatan ini ditunjukkan kepada : </p>
            <table style="width: 100%">
                <tr>
                    <td style="width: 20%">NIP</td>
                    <td>:
                        <?= $nip ?>
                    </td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:
                        <?= $nama ?>
                    </td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:
                        <?= $jabatan ?>
                    </td>
                </tr>
            </table>

            <p>Surat peringatan ini diberikan kepada saudara
                <?= $nama ?> dikarenakan karyawan yang bersangkutan melakukan kesalahan yakni
                    <?= $keterangan ?>.</p>
            <p>Sehubungan dengan pelanggaran tersebut, perusahaan memberikan
                <?= $sp ?> dengan ketentuan sebagai berikut :</p>


            <ol>
                <li>Surat peringatan ini berlaku 3 bulan sejak diterbitkan dan apabila dalam 3 bulan kedepan tidak melakukan pelanggaran maka
                    <?= $sp ?> ini sudah tidak berlaku.</li><br>
                <li>Apabila dalam kurun waktu 3 bulan kedepan saudara melakukan pelanggaran maka
                    <?= $sp_next ?>.</li>
            </ol>

            <p>Demikian Surat Peringatan ini dikeluarkan untuk menjadi bahan perenungan dan bahan perhatian.</p>
        </div>

        <div class="footer">
            <p>Jakarta,
                <?= date('d M Y', strtotime($tanggal)) ?>
            </p>
            <p>Asisten Manajer</p><br><br><br><br>
            <p>(
                <?= $this->session->userdata('nama') ?> )</p>
        </div>



</body>

</html>
