<main>
   <div class="container-fluid px-4">
   <h1 class="mt-4">Staff Divisi</h1>
   <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Staff Divisi</li>
   </ol>
   <div class="card mb-4">
      <div class="card-header">
         <i class="fas fa-table me-1"></i>
         List Staff
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
        </tr>
    </tfoot>
    <tbody>
    <?php foreach ($pegawai as $key => $pegawaiItem) {
        // Check if the divisi from the session matches the divisi in the table pegawai
        if ($pegawaiItem->divisi == $this->session->userdata('divisi')) { ?>
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
            </tr>
    <?php }
    } ?>
</tbody>

</table>
</div>

      </div>
   </div>
</main>

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
