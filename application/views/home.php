<main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Selamat Datang</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Aplikasi Pengajuan Cuti</li>
                        </ol>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Profil Anda
                            </div>
                            <div class="card-body">
                            <table id="pegawaiTable" class="table table-bordered">
    <tbody>
        <tr>
            <th>Nama:</th>
            <td><?php echo isset($pegawai->nama_pegawai) ? $pegawai->nama_pegawai : 'Data tidak tersedia'; ?></td>
        </tr>
        <tr>
    <th>Divisi:</th>
    <?php if (isset($pegawai->divisi)) : ?>
        <?php $divisi = $this->Divisi_model->getDivisiById($pegawai->divisi); ?>
        <td><?php echo $divisi ? $divisi->nama_divisi : 'Data tidak tersedia'; ?></td>
    <?php else : ?>
        <td>Data tidak tersedia</td>
    <?php endif; ?>
</tr>
<tr>
    <th>Jabatan:</th>
    <td>
        <?php
        if (isset($pegawai->jabatan)) {
            switch ($pegawai->jabatan) {
                case 1:
                    echo 'Admin / HRD';
                    break;
                case 2:
                    echo 'Manager';
                    break;
                case 3:
                    echo 'Staff';
                    break;
                default:
                    echo 'Data tidak tersedia';
            }
        } else {
            echo 'Data tidak tersedia';
        }
        ?>
    </td>
</tr>

        <tr>
            <th>Email:</th>
            <td><?php echo isset($pegawai->email_pegawai) ? $pegawai->email_pegawai : 'Data tidak tersedia'; ?></td>
        </tr>
        <tr>
            <th>Nomor Telepon:</th>
            <td><?php echo isset($pegawai->nomor_telepon) ? $pegawai->nomor_telepon : 'Data tidak tersedia'; ?></td>
        </tr>
        <tr>
            <th>Jumlah Cuti:</th>
            <td><?php echo isset($pegawai->jumlah_cuti) ? $pegawai->jumlah_cuti : 'Data tidak tersedia'; ?> kali</td>
        </tr>
        <tr>
            <th>Sisa Cuti:</th>
            <td><?php echo isset($pegawai->sisa_cuti) ? $pegawai->sisa_cuti : 'Data tidak tersedia'; ?> kali</td>
        </tr>
    </tbody>
</table>


                            </div>
                        </div>
                    </div>
                </main>

                 