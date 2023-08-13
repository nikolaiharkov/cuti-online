<main>
   <div class="container-fluid px-4">
   <h1 class="mt-4">Management Pegawai</h1>
   <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Management Pegawai</li>
   </ol>
   <div class="card mb-4">
      <div class="card-header">
         <i class="fas fa-table me-1"></i>
         List Pegawai
         <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPegawai">Tambah Pegawai</button>
      </div>
      <div class="card-body">
      <div class="table-responsive">

      <table id="datatablesSimple" >
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pegawai</th>
            <th>Divisi</th>
            <th>Jabatan</th>
            <th>Email Pegawai</th>
            <th>Nomor Telepon</th>
            <th>Jumlah Cuti</th>
            <th>Sisa Cuti</th>
            <th>Action</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>No</th>
            <th>Nama Pegawai</th>
            <th>Divisi</th>
            <th>Jabatan</th>
            <th>Email Pegawai</th>
            <th>Nomor Telepon</th>
            <th>Jumlah Cuti</th>
            <th>Sisa Cuti</th>
            <th>Action</th>
        </tr>
    </tfoot>
    <tbody>
        <?php foreach ($pegawai as $key => $pegawaiItem) { ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $pegawaiItem->nama_pegawai ?></td>
                <td><?= $pegawaiItem->nama_divisi ?></td>
                <td>
    <?php
    if ($pegawaiItem->jabatan == 1) {
        echo 'Admin / HRD';
    } elseif ($pegawaiItem->jabatan == 2) {
        echo 'Manager';
    } elseif ($pegawaiItem->jabatan == 3) {
        echo 'Staff';
    } else {
        echo 'Jabatan Tidak Diketahui';
    }
    ?>
</td>

                <td><?= $pegawaiItem->email_pegawai ?></td>
                <td><?= $pegawaiItem->nomor_telepon ?></td>
                <td><?= $pegawaiItem->jumlah_cuti ?> Hari</td>
                <td><?= $pegawaiItem->sisa_cuti ?> Hari</td>
                <td>
                <button type="button" class="btn btn-sm btn-primary" onclick="openEditModal(<?= $pegawaiItem->idpegawai ?>)">Edit Pegawai</button>

                <button type="button" class="btn btn-sm btn-warning" onclick="confirmResetCuti(<?= $pegawaiItem->idpegawai ?>)">Reset Cuti</button>
                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDeleteCuti(<?= $pegawaiItem->idpegawai ?>)">Hapus Pegawai</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</div>

      </div>
   </div>
</main>

<div class="modal fade" id="modalTambahPegawai" tabindex="-1" aria-labelledby="modalTambahPegawaiLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTambahPegawaiLabel">Tambah Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo site_url('pegawai/tambahpegawai'); ?>" method="POST">
          <div class="mb-3">
            <label for="divisi" class="form-label">Divisi</label>
            <select class="form-select" id="divisi" name="divisi">
              <?php foreach ($divisi as $row) : ?>
              <option value="<?php echo $row['iddivisi']; ?>"><?php echo $row['nama_divisi']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="namaPegawai" class="form-label">Nama Pegawai</label>
            <input type="text" class="form-control" id="namaPegawai" name="namaPegawai">
          </div>
          <div class="mb-3">
            <label for="emailPegawai" class="form-label">Email Pegawai</label>
            <input type="email" class="form-control" id="emailPegawai" name="emailPegawai">
          </div>
          <div class="mb-3">
            <label for="nomorTelepon" class="form-label">Nomor Telepon</label>
            <input type="tel" class="form-control" id="nomorTelepon" name="nomorTelepon">
          </div>
          <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <select class="form-select" id="jabatan" name="jabatan">
              <option value="1">Admin / HRD</option>
              <option value="2">Manager</option>
              <option value="3">Staff</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="jumlahCuti" class="form-label">Jumlah Cuti (pertahun)</label>
            <input type="number" class="form-control" id="jumlahCuti" name="jumlahCuti">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>
          <div class="mb-3">
            <label for="rePassword" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control" id="rePassword" name="rePassword">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Tambah Pegawai</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEditPegawai" tabindex="-1" aria-labelledby="modalEditPegawaiLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditPegawaiLabel">Edit Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo site_url('pegawai/Editpegawai'); ?>" method="POST">
        <input type="hidden" id="editIdPegawai" name="idpegawai" value="">
          <div class="mb-3">
            <label for="divisi" class="form-label">Divisi</label>
            <select class="form-select" id="divisi" name="divisi">
              <?php foreach ($divisi as $row) : ?>
              <option value="<?php echo $row['iddivisi']; ?>"><?php echo $row['nama_divisi']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="namaPegawai" class="form-label">Nama Pegawai</label>
            <input type="text" class="form-control" id="namaPegawai" name="namaPegawai">
          </div>
          <div class="mb-3">
            <label for="emailPegawai" class="form-label">Email Pegawai</label>
            <input type="email" class="form-control" id="emailPegawai" name="emailPegawai">
          </div>
          <div class="mb-3">
            <label for="nomorTelepon" class="form-label">Nomor Telepon</label>
            <input type="tel" class="form-control" id="nomorTelepon" name="nomorTelepon">
          </div>
          <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <select class="form-select" id="jabatan" name="jabatan">
              <option value="1">Admin / HRD</option>
              <option value="2">Manager</option>
              <option value="3">Staff</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="jumlahCuti" class="form-label">Jumlah Cuti (pertahun)</label>
            <input type="number" class="form-control" id="jumlahCuti" name="jumlahCuti">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>
          <div class="mb-3">
            <label for="rePassword" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control" id="rePassword" name="rePassword">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Edit Pegawai</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

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

<script>
  function openEditModal(idpegawai) {
    document.getElementById('editIdPegawai').value = idpegawai;
    var modal = new bootstrap.Modal(document.getElementById('modalEditPegawai'));
    modal.show();
  }
</script>

<script>
function confirmResetCuti(idpegawai) {
  Swal.fire({
    title: 'Konfirmasi Reset Cuti Pegawai',
    text: 'Apakah Anda yakin ingin mereset cuti Pegawai?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "<?php echo site_url('pegawai/resetcuti/'); ?>" + idpegawai;
    }
  });
}
</script>

<script>
  function confirmDeleteCuti(idpegawai) {
    Swal.fire({
      title: 'Konfirmasi',
      text: 'Apakah Anda yakin ingin menghapus pegawai?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, Hapus',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        // Redirect ke halaman pegawai/hapusdata dengan mengirimkan idpegawai
        window.location.href = '<?= site_url("pegawai/hapusdata/") ?>' + idpegawai;
      }
    });
  }
</script>