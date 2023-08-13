<main>
   <div class="container-fluid px-4">
   <h1 class="mt-4">Management Divisi</h1>
   <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Management Divisi</li>
   </ol>
   <div class="card mb-4">
      <div class="card-header">
         <i class="fas fa-table me-1"></i>
         List Divisi
         <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahDivisi">Tambah Divisi</button>
      </div>
      <div class="card-body">
         <table id="datatablesSimple">
            <thead>
               <tr>
                  <th>No</th>
                  <th>Nama Divisi</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>No</th>
                  <th>Nama Divisi</th>
                  <th>Action</th>
               </tr>
            </tfoot>
            <tbody>
               <?php foreach ($divisi as $key => $data) { ?>
               <tr>
                  <td><?php echo $key + 1; ?></td>
                  <td><?php echo $data['nama_divisi']; ?></td>
                  <td>
                     <!-- Tombol Hapus -->
                     <button class="btn btn-danger btn-sm" x-on:click="hapusDivisi(<?php echo $data['iddivisi']; ?>)">
                     <i class="fas fa-trash"></i>
                     </button>
                  </td>
               </tr>
               <?php } ?>
            </tbody>
         </table>
      </div>
   </div>
</main>
<div class="modal fade" id="modalTambahDivisi" tabindex="-1" role="dialog" aria-labelledby="modalTambahDivisiLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="modalTambahDivisiLabel">Tambah Divisi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form action="<?php echo site_url('divisi/tambahdivisi'); ?>" method="POST">
               <div class="mb-3">
                  <label for="namaDivisi" class="form-label">Nama Divisi</label>
                  <input type="text" class="form-control" id="namaDivisi" name="namaDivisi">
               </div>
               <div class="form-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">Buat Divisi</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<?php if (isset($_SESSION['success_message'])) : ?>
<script>
   Swal.fire({
       icon: 'success',
       title: 'Berhasil',
       text: '<?php echo $_SESSION['success_message']; ?>',
       showConfirmButton: false,
       timer: 1500
   });
</script>
<?php endif; ?>
<?php if (isset($_SESSION['error_message'])) : ?>
<script>
   Swal.fire({
       icon: 'error',
       title: 'Gagal',
       text: '<?php echo $_SESSION['error_message']; ?>',
       showConfirmButton: false,
       timer: 1500
   });
</script>
<?php endif; ?>
<script>
   function hapusDivisi(idDivisi) {
       Swal.fire({
           title: 'Konfirmasi Hapus',
           text: 'Apakah Anda yakin ingin menghapus data divisi ini?',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Ya',
           cancelButtonText: 'Batal',
       }).then((result) => {
           if (result.isConfirmed) {
               window.location.href = "<?php echo base_url('divisi/hapusdivisi/'); ?>" + idDivisi;
           }
       });
   }
</script>