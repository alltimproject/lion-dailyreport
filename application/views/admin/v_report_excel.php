<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Data_Report.xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");
//disini script laporan anda
$no = 1;
?>

    <!DOCTYPE html>
    <html lang="en" dir="ltr">

    <head>
        <meta charset="utf-8">
        <title>Report Excel</title>
    </head>

    <body>
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
            <?php foreach ($data as $report): ?>
            <tr>
                <td>
                    <?= $no++ ?>
                </td>
                <td>
                    <?= $report->id_report ?>
                </td>
                <td>
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
                <td>
                    <?= $report->status ?>
                </td>
            </tr>
            <?php endforeach ?>
        </table>
    </body>

    </html>