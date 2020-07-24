<!DOCTYPE html>
<html lang="en">

<head>
</head>

<style>
    .kapalo {
        border-collapse: collapse;
        width: 100%;
        font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";

    }

    .tbl-isi {
        border-collapse: collapse;
        width: 100%;
        margin: auto;
        font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";
        font-size: 10px;
    }

    .tbl-isi td,
    .tbl-isi th,
    .kapalo td,
    .kapalo th,
        {
        border: 1px solid black;
        text-align: left;
        padding: 8px;
    }

    #customers {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        margin: auto;
    }

    #customers td,
    #customers th {
        /* border: 1px solid #ddd; */
        padding: 8px;
        font-size: 10px;
    }
</style>

<body>
    <table class="kapalo">
        <tr>
            <td> <img width="80" height="60" src="<?= base_url() ?>assets/images/pkr.png"></td>
            <td width="425" style="text-align: center;">
                <h4>LAPORAN ABSENSI PEGAWAI POLTEKKES RIAU</h4>
            </td>
            <td> <img width="80" height="60" src="<?= base_url() ?>assets/images/logo-puskesmas-32996.png"></td>
        </tr>
    </table>
    <p style="font-size: 11px; ">Periode : <?= date_indo($priode1) ?> s/d <?= date_indo($priode2) ?></p>


    <table class="tbl-isi">
        <tr>
            <th>Tanggal</th>
            <th>Absensi Masuk</th>
            <th>Absensi Pulang</th>
            <th>Terlambat</th>
            <th>Total Jam Kerja</th>
            <th>Keterangan Keberadaan</th>
        </tr>

        <?php
        for ($i = 0; $i < count($range); $i++) { ?>


            <tr>
                <td><?= date_indo($range[$i]); ?></td>
                <td><?= $absensi_masuk[$i] ?></td>
                <td><?= $absensi_keluar[$i] ?></td>
                <td>
                    <?php
                    if ($ket_keberadaan[$i] != 'lembur' && $ket_keberadaan[$i] != '' && $ket_keberadaan[$i] != 'dl' && $ket_keberadaan[$i] != 'izin (sakit/cuti)' && $ket_keberadaan[$i] != 'wfh') {
                        $diff    = strtotime($absensi_masuk[$i]) - strtotime($jdwl_jam_masuk[$i]);
                        $jam    = floor($diff / (60 * 60));
                        $menit    = $diff - $jam * (60 * 60);
                        if ($jam) {
                            echo  $jam .  ' jam, ' . floor($menit / 60) . ' menit';
                        } elseif ($menit != '' && $jam == '') {
                            echo   floor($menit / 60) . ' menit';
                        }
                    } else {
                        echo "-";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($absensi_masuk[$i] != "" && $absensi_keluar[$i] != "00:00:00" && $ket_keberadaan[$i] != 'dl' && $ket_keberadaan[$i] != 'izin (sakit/cuti)' && $ket_keberadaan[$i] != 'wfh') {
                        $diff    = strtotime($absensi_keluar[$i]) - strtotime($absensi_masuk[$i]);
                        $jam    = floor($diff / (60 * 60));
                        $menit    = $diff - $jam * (60 * 60);
                        if ($jam) {
                            echo  $jam .  ' jam, ' . floor($menit / 60) . ' menit';
                        } elseif ($menit != '' && $jam == '') {
                            echo   floor($menit / 60) . ' menit';
                        }
                    } else {
                        echo "-";
                    }
                    ?>
                </td>
                <td style="text-transform: capitalize;">
                    <?php
                    if ($ket_keberadaan[$i]) {
                        echo $ket_keberadaan[$i];
                    } else {
                        echo "Tanpa Keterangan";
                    }
                    ?>
                </td>
            </tr>
        <?php }
        ?>
    </table>

    <table id="customers">
        <tr>
            <td style="width: 55%;"></td>
            <td><?= "Pekanbaru, " . date_indo(date("Y-m-d")) ?></td>
        </tr>
        <tr>
            <td>
                <label>Direktur,</label>
            </td>
            <td>
                <label>Pegawai Ybs,</label>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <label><?= $direktur->fullname ?></label>
                <br><label>NIK. <?= $direktur->nip ?></label>
            </td>
            <td>
                <label><?= $pegawai->fullname ?></label>
                <br><label>NIK. <?= $pegawai->nip ?></label>
            </td>
        </tr>

    </table>

</body>

</html>