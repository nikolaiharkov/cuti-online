<main>
   <div class="container-fluid px-4">
   <h1 class="mt-4">Pengajuan Cuti</h1>
   <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Pengajuan Cuti</li>
   </ol>
   <div class="card mb-4">
      <div class="card-header">
         <i class="fas fa-table me-1"></i>
         List Pengajuan Cuti
         <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahCuti">Buat Cuti</button>
      </div>
      <div class="card-body">
      <div class="table-responsive">

      <table id="datatablesSimple">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Awal Cuti</th>
            <th>Tanggal Selesai Cuti</th>
            <th>Jumlah Hari Cuti</th>
            <th>Alasan Cuti</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>No</th>
            <th>Tanggal Awal Cuti</th>
            <th>Tanggal Selesai Cuti</th>
            <th>Jumlah Hari Cuti</th>
            <th>Alasan Cuti</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </tfoot>
    <tbody>
        <?php foreach ($cuti as $key => $cutiItem) { ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $cutiItem->tanggal_awal ?></td>
                <td><?= $cutiItem->tanggal_akhir ?></td>
                <td><?= $cutiItem->jumlah_cuti ?> Hari</td>
                <td><?= $cutiItem->alasan_cuti ?></td>
                <td>
    <?php
    $status = $cutiItem->status;
    if ($status == 0) {
        echo 'Cuti Dibatalkan user';
    } elseif ($status == 1) {
        echo 'Cuti Dalam Verifikasi manager';
    } elseif ($status == 2) {
        echo 'Cuti Diterima manager';
    } elseif ($status == 3) {
        echo 'Cuti Ditolak manager (Menunggu verifikasi HRD)';
    } elseif ($status == 4) {
        echo 'Cuti Dalam Verifikasi HRD';
    } elseif ($status == 5) {
        echo 'Cuti Diterima HRD';
    } elseif ($status == 6) {
        echo 'Cuti Ditolak HRD (Sisa Cuti Anda Dikembalikan)';
    } else {
        echo 'Status tidak valid';
    }
    ?>
</td>

<td>
<?php
$status = $cutiItem->status;
if ($status == 1 ) {
    echo '<button type="button" class="btn btn-sm btn-danger" onclick="confirmDeletePengajuanCuti('.$cutiItem->idpengajuan.')">Hapus Pengajuan Cuti</button>';
}
if ($status == 6 ) {
    ?>
    <button type="button" class="btn btn-sm btn-danger" onclick="getKeteranganPengajuanCuti(<?php echo $cutiItem->idpengajuan; ?>)">Alasan Penolakan</button>

    <?php
}
?>

</td>

            </tr>
        <?php } ?>
    </tbody>
</table>



</div>

      </div>
   </div>
</main>

<!-- Modal Alasan Penolakan -->
<!-- Modal Alasan Penolakan -->
<div class="modal fade" id="alasanPenolakanModal" tabindex="-1" role="dialog" aria-labelledby="alasanPenolakanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alasanPenolakanModalLabel">Alasan Penolakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Keterangan Manager: <span id="keteranganManager"></span></p>
                <p>Keterangan HRD: <span id="keteranganHRD"></span></p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<script>
function getKeteranganPengajuanCuti(idpengajuan) {
    // Mengirimkan data idpengajuan ke server melalui AJAX
    $.ajax({
    url: '<?php echo site_url('cuti/getKeteranganPengajuanCuti'); ?>',
    type: 'POST',
    dataType: 'json',
    data: {idpengajuan: idpengajuan},
    success: function(response) {
        // Mengisi keterangan manager dan keterangan HRD di modal
        $('#keteranganManager').text(response.keterangan_manager);
        $('#keteranganHRD').text(response.keterangan_hrd);
        
        // Menampilkan modal
        $('#alasanPenolakanModal').modal('show');
    },
    error: function(xhr, status, error) {
        // Menampilkan pesan jika terjadi kesalahan
        console.log(xhr.responseText);
    }
});

}
</script>



<div class="modal fade" id="modalTambahCuti" tabindex="-1" aria-labelledby="modalTambahCutiLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTambahCutiLabel">Buat Cuti</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="<?php echo site_url('cuti/buatcutistaff'); ?>" method="POST">
          <div class="mb-3">
            <label for="tanggalAwal" class="form-label">Tanggal Awal Cuti</label>
            <input type="date" class="form-control" id="tanggalAwal" name="tanggalAwal" required>
          </div>
          <div class="mb-3">
            <label for="tanggalSelesai" class="form-label">Tanggal Selesai Cuti</label>
            <input type="date" class="form-control" id="tanggalSelesai" name="tanggalSelesai" required>
          </div>
          <div class="mb-3">
    <label for="sisaCuti" class="form-label">Jumlah cuti (per hari)</label>
    <input type="text" class="form-control" id="jumlahcuti" name="jumlahcuti" >
  </div>
          <div class="mb-3">
            <label for="alasan" class="form-label">Alasan Cuti</label>
            <textarea class="form-control" id="alasan" name="alasan" rows="3" required></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function confirmDeletePengajuanCuti(idpengajuan) {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin menghapus Pengajuan cuti?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect ke halaman pegawai/hapusdata dengan mengirimkan idpegawai
            window.location.href = '<?= site_url("cuti/hapuspengajuan/") ?>' + idpengajuan;
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
