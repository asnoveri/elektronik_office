<!DOCTYPE html>
<html>

<head>
</head>

<style>
    table {
        border-collapse: collapse;
        width: 100%;
        margin: auto;
        font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";
        font-size: 8px;
    }

    td,
    th {
        border: 1px solid black;
        text-align: left;
        padding: 5px;


    }
</style>

<body>
    <h4 style="text-align: center;">REKAP KEHADIRAN PEGAWAI POLTEKKES RIAU </h4>
    <p style="font-size: 14px;">Periode : <?= date_indo($priode1) ?> - <?= date_indo($priode2) ?></p>

    <table>
        <tr>
            <th>NO</th>
            <th>Nama</th>
            <th>WFH</th>
            <th>Piket Kantor</th>
            <th>Piket Kantor Rengat</th>
            <th>Izin (Cuti / Sakit)</th>
            <th>DL</th>
            <th>Tanpa Berita</th>
            <th>Total Kehadiran</th>
        </tr>

        <?php
        for ($i = 0; $i < count($user); $i++) { ?>
            <tr>
                <td><?= $no = $i + 1 ?></td>
                <td><?= $user[$i] . "<br>" ?><?= "($nip[$i])" ?></td>
                <td><?= $tot_wfh[$i] . " Hari" ?></td>
                <td><?= $tot_pkt[$i] . " Hari" ?></td>
                <td><?= $tot_pkt_rengat[$i] . " Hari" ?></td>
                <td><?= $tot_izn[$i] . " Hari" ?></td>

                <td><?= $tot_dl[$i] . " Hari" ?></td>
                <td><?= $range - ($tot_wfh[$i] + $tot_pkt[$i] + $tot_pkt_rengat[$i] + $tot_izn[$i] + $tot_dl[$i]) - $tot_sabtu - $tot_minggu - $tot_tglmerah . " Hari" ?></td>
                <td><?= $tot_wfh[$i] + $tot_pkt[$i] + $tot_dl[$i] + $tot_pkt_rengat[$i] . " Hari" ?></td>
            </tr>
        <?php }
        ?>
    </table>
</body>

</html>