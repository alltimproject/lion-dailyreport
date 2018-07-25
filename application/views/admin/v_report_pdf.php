<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Report PDF</title>
    <style>
        table {
            width: 100%;
            font-size: 13px;
        }

        th {
            border-bottom: 1px solid black;
        }

        .header {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="<?= base_url().'images/bg03.png' ?>" style="width: 20%;">
        <h3>PT. Lion Mentari Airlines</h3>
        <p>Jl. Gajah Mada no 7 Jakarta Pusat</p>
        <p>Telp: (021) 63798000</p>
    </div>

    <hr style="height: 5px; margin-bottom: 0px;">
    <hr style="margin-top: 2px;">

    <h3>Data Report tanggal
        <?= $tgl_from.' s/d '. $tgl_to ?>
    </h3>
    <table>
        <tr>
            <th>No</th>
            <th>ID Report</th>
            <th>Kode Booking</th>
            <th>Tanggal/Waktu</th>
            <th>Klasifikasi</th>
            <th>Keterangan</th>
            <th>PIC</th>
            <th>Status</th>
        </tr>
        <?php
        $no = 1;
        foreach ($data as $report):
      ?>
            <tr>
                <td align="center">
                    <?= $no++ ?>
                </td>
                <td align="center">
                    <?= $report->id_report ?>
                </td>
                <td align="center">
                    <?= $report->kd_booking ?>
                </td>
                <td>
                    <?= $report->tanggal_report ?>
                </td>
                <td>
                    <?= $report->klasifikasi ?>
                </td>
                <td>
                    <?= $report->keterangan ?>
                </td>
                <td>
                    <?= $report->nama ?>
                </td>
                <td align="center">
                    <?= $report->status ?>
                </td>
            </tr>
            <?php endforeach ?>
    </table>
</body>

</html>