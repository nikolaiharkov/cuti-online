<main>
   <div class="container-fluid px-4">
   <h1 class="mt-4">Management Cuti</h1>
   <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Management Cuti</li>
   </ol>
   <div class="card mb-4">
      <div class="card-header">
         <i class="fas fa-table me-1"></i>
         List Management Cuti
      </div>
      <div class="card-body">
      <div class="table-responsive">

      <table id="datatablesSimple">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pegawai</th>
            <th>Tanggal Awal Cuti</th>
            <th>Tanggal Selesai Cuti</th>
            <th>Jumlah Hari Cuti</th>
            <th>Alasan Cuti</th>
            <th>Status</th>
            <th>Keterangan Manager</th>
            <th>Action</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>No</th>
            <th>Nama Pegawai</th>
            <th>Tanggal Awal Cuti</th>
            <th>Tanggal Selesai Cuti</th>
            <th>Jumlah Hari Cuti</th>
            <th>Alasan Cuti</th>
            <th>Status</th>
            <th>Keterangan Manager</th>
            <th>Action</th>
        </tr>
    </tfoot>
    <tbody>
    <?php foreach ($cuti as $key => $cutiItem) {
        $idPegawai = $cutiItem->idpegawai;
        $this->db->select('nama_pegawai');
        $this->db->from('pegawai');
        $this->db->where('idpegawai', $idPegawai);
        $query = $this->db->get();
        $pegawai = $query->row();

        if ($pegawai) {
            echo '<tr>';
            echo '<td>' . ($key + 1) . '</td>';
            echo '<td>' . $pegawai->nama_pegawai . '</td>';
            echo '<td>' . $cutiItem->tanggal_awal . '</td>';
            echo '<td>' . $cutiItem->tanggal_akhir . '</td>';
            echo '<td>' . $cutiItem->jumlah_cuti . ' Hari</td>';
            echo '<td>' . $cutiItem->alasan_cuti . '</td>';
            echo '<td>';
            
            $status = $cutiItem->status;
            if ($status == 0) {
                echo 'Dibatalkan user';
            } elseif ($status == 1) {
                echo 'Dalam Verifikasi manager';
            } elseif ($status == 2) {
                echo 'Diterima manager';
            } elseif ($status == 3) {
                echo 'Ditolak manager';
            } elseif ($status == 4) {
                echo 'Dalam Verifikasi HRD';
            } elseif ($status == 5) {
                echo 'Diterima HRD';
            } elseif ($status == 6) {
                echo 'Ditolak HRD';
            } else {
                echo 'Status tidak valid';
            }
            
            echo '</td>';
            echo '<td>' . $cutiItem->keterangan_manager . '</td>';

            echo '<td>';
            if ($status == 2 || $status == 3 || $status == 4 ) {
                echo '<button type="button" class="btn btn-sm btn-success" onclick="confirmAcceptPengajuanCuti('.$cutiItem->idpengajuan.')">Terima Cuti</button>';
                echo '&nbsp;';
                echo '<button type="button" class="btn btn-sm btn-danger" onclick="confirmRejectPengajuanCuti('.$cutiItem->idpengajuan.')">Tolak Cuti</button>';
            }
            echo '</td>';
            
            
            echo '</tr>';
        } else {
            echo 'Nama Pegawai tidak ditemukan';
        }
    } ?>
</tbody>

</table>
</div>

      </div>
   </div>
</main>

<script>
function confirmRejectPengajuanCuti(idpengajuan) {
    Swal.fire({
        title: "Apakah Anda yakin ingin menolak cuti?",
        input: "text",
        inputLabel: "Keterangan Penolakan Cuti",
        showCancelButton: true,
        confirmButtonText: "Tolak",
        cancelButtonText: "Batal",
        inputValidator: (value) => {
            if (!value) {
                return "Keterangan penolakan harus diisi";
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const keterangan = result.value;
            // Lakukan pengiriman ke controller cuti/tolakmanager dengan menggunakan AJAX atau submit form
            // Contoh menggunakan AJAX
            $.ajax({
                url: "<?php echo base_url('cuti/tolakadmin'); ?>",
                type: "post",
                data: { idpengajuan: idpengajuan, keterangan: keterangan },
                success: function (response) {
    // Berhasil, lakukan tindakan yang diinginkan setelah tolak cuti
    Swal.fire("Cuti ditolak!", "Cuti telah berhasil ditolak.", "success").then(function () {
        location.reload(); // Refresh halaman
    });
},

                error: function (xhr, status, error) {
                    // Gagal, lakukan tindakan yang diinginkan saat terjadi kesalahan
                    Swal.fire("Terjadi kesalahan!", "Cuti tidak dapat ditolak.", "error");
                }
            });
        }
    });
}
</script>


<script>
function confirmAcceptPengajuanCuti(idpengajuan) {
    Swal.fire({
        title: "Apakah Anda Yakin Menerima Cuti?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Ya",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to the "accmanager" method in the "cuti" controller with the selected "idpengajuan"
            window.location.href = "<?= base_url('cuti/accadmin/') ?>" + idpengajuan;
        }
    });
}
</script>



<!-- Display flashdata SweetAlert -->
<?php if ($this->session->flashdata('error')) : ?>
    <script>
        Swal.fire({
            title: 'Error',
            text: '<?php echo $this->session->flashdata("error"); ?>',
            icon: 'error',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
<?php endif; ?>

<!-- Display flashdata SweetAlert -->
<?php if ($this->session->flashdata('success')) : ?>
    <script>
        Swal.fire({
            title: 'Success',
            text: '<?php echo $this->session->flashdata("success"); ?>',
            icon: 'success',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
<?php endif; ?>
