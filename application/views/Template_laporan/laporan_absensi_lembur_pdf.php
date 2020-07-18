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
        /* fon  t-size: 10px; */
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
            <td width="425" style="text-align: center;">
                <h4>PRESENSI LEMBUR PEGAWAI POLTEKKES RIAU </h4>
            </td>
            <td> <img width="80" height="60" src="<?= base_url() ?>assets/images/logo-puskesmas-32996.png"></td>
        </tr>
    </table>

    <p> Hari: <?= $tgl ?></p>
    <table>
        <tr>
            <th>No</th>
            <th> Nama</th>
            <th>Absensi Masuk</th>
            <th>Absensi Pulang</th>
            <th>Jam Kerja</th>
            <!-- <th>Lembur</th> -->
        </tr>

        <?php
        $no = 1;
        foreach ($lembur_absensi as $ah) { ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $ah->fullname . "<br>" ?> <?= " ($ah->nip)" ?></td>
                <td><?= $ah->absensi_masuk ?></td>
                <td><?= $ah->absensi_keluar ?></td>
                <td>
                    <?php
                    $diff    = strtotime($ah->absensi_keluar) - strtotime($ah->absensi_masuk);
                    $jam    = floor($diff / (60 * 60));
                    $menit    = $diff - $jam * (60 * 60);
                    echo  $jam .  ' jam, ' . floor($menit / 60) . ' menit'
                    ?>
                </td>
                <!-- <?php
                        if ($ah->ket_keberadaan == 'lembur') {
                            $lembur = 1;
                        } else {
                            $lembur = 0;
                        }
                        ?>
                <td><?= $lembur ?></td> -->
            </tr>
        <?php $no++;
        }
        ?>
        <tr>
            <td colspan="2">Total Pegawai Lembur </td>
            <td colspan="3"><?= $lembur_tot ?> Pegawai</td>
        </tr>
    </table>


</body>

</html>