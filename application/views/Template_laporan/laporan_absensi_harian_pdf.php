<!DOCTYPE html>
<html>

<head>
</head>
<style>
    * {
        box-sizing: border-box;
    }

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
        padding: 8px;
        width: auto;

    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>

<body>

    <table>
        <tr>
            <td> <img width="80" height="60" src="<?= base_url() ?>assets/images/pkr.png"></td>
            <td width="425">
                <h4>PRESENSI KEHADIRAN PEGAWAI POLTEKKES RIAU </h4>
            </td>
            <td> <img width="80" height="60" src="<?= base_url() ?>assets/images/logo-puskesmas-32996.png"></td>
        </tr>
    </table>

    <p> Hari: <?= $tgl ?></p>
    <table>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2"> Nama</th>
            <th rowspan="2">Absensi Masuk</th>
            <th rowspan="2">Absensi Pulang</th>
            <th colspan="5" style="text-align: center;">Keterangan Keberadaan</th>

        </tr>
        <tr>
            <td>WFH</td>
            <td>Piket Kantor</td>
            <td>Piket Kantor Rengat</td>
            <td>Izin (Cuti / Sakit)</td>
            <td>DL</td>
        </tr>
        <?php
        $no = 1;
        foreach ($absensi_harian as $ah) { ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $ah->fullname . "<br>" ?><?= "($ah->nip)" ?></td>
                <td><?= $ah->absensi_masuk ?></td>
                <td><?= $ah->absensi_keluar ?></td>
                <?php
                if ($ah->ket_keberadaan == 'wfh') {
                    $wfh = 1;
                } else {
                    $wfh = 0;
                }
                if ($ah->ket_keberadaan == 'piket kantor') {
                    $pkt = 1;
                } else {
                    $pkt = 0;
                }
                if ($ah->ket_keberadaan == 'piket kantor rengat') {
                    $pktrgt = 1;
                } else {
                    $pktrgt = 0;
                }
                if ($ah->ket_keberadaan == 'izin (sakit/cuti)') {
                    $izn = 1;
                } else {
                    $izn = 0;
                }

                if ($ah->ket_keberadaan == 'dl') {
                    $dl = 1;
                } else {
                    $dl = 0;
                }
                ?>
                <td><?= $wfh ?></td>
                <td><?= $pkt ?></td>
                <td><?= $pktrgt ?></td>
                <td><?= $izn ?></td>
                <td><?= $dl ?></td>
            </tr>
        <?php $no++;
        }
        ?>
        <tr>
            <td colspan="4">Total</td>
            <td><?= $wfh_tot ?></td>
            <td><?= $pkt_tot ?></td>
            <td><?= $pkt_tot_rgt ?></td>
            <td><?= $izn_tot ?></td>
            <td><?= $dl_tot ?></td>
        </tr>
    </table>


</body>

</html>