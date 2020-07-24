
<!DOCTYPE html>
<html lang="en">

<head>
</head>

<style>
 
    .kapalo{
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
     .tbl-isi th, .kapalo td,
     .kapalo th, {
        border: 1px solid black;
        text-align: left;
        padding:8px;
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
            <p style="font-size: 13px; font-weight: bold;">Periode : <?= date_indo($priode1) ?> s/d <?= date_indo($priode2) ?></p>


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

                for ($i = 0; $i < count($range); $i++) {?>
                    <?php
                        if ($range[$i] == @$absensi[$i]) {
                        $ket_keb= $absensi[$i]->tanggal ;
                        } else {
                        $ket_keb= "  tanpa Keterangan  " ;
                        $warna= "color: red";   
                    }
                    ?>
                    <tr>
                        <td><?= date_indo($range[$i]) ;?></td>       
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                           <?= $ket_keb?>  
                        </td>
                    </tr>
                <?php }
            ?>

        </table>
        
    </body>

</html>