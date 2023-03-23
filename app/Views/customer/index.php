<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<!-- setFlashdata PESSAN -->
<?php if (session()->getFlashdata('msg')) : ?>
  <div class="pesan" data-pesan="<?= session()->getFlashdata('msg'); ?>"></div>
<?php endif ?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Customer</h1>
        <small></small>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<div class="container-fluid">

  <div class="card">
    <div class="card-header">
      <div class="card-title">Data Customer</div>
    </div>

    <div class="col-sm-4"><a href="/customer/tambah" class="btn btn-primary my-3 ml-2">Input Data Customer</a></div>

    <div class="card-body">
      <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Kode Customer</th>
              <th class="text-center">Nama Customer</th>
              <th class="text-center">Alamat Customer</th>
              <th class="text-center">Telpon Customer</th>
              <th class="text-center">Faks Customer</th>
              <th class="text-center">Email Customer</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php foreach ($customer as $c) : ?>
              <tr>
                <td class="text-center"><?= $i++; ?></td>
                <td class="text-center"><?= $c['kode_customer']; ?></td>
                <td class="text-center"><?= $c['nama_customer']; ?></td>
                <td class="text-center"><?= $c['alamat']; ?></td>
                <td class="text-center"><?= $c['telp']; ?></td>
                <td class="text-center"><?= $c['faks']; ?></td>
                <td class="text-center"><?= $c['email']; ?></td>
                <td>

                  <a href="#" class="btn btn-info" data-toggle="modal" data-target="#customer<?= $c['kode_customer']; ?>"><i class="fa fa-edit"></i></a>

                  <div class="modal fade" id="customer<?= $c['kode_customer']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Edit Data Customer</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form action="/customer/ubah/<?= $c['kode_customer']; ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                              <label>Nama Customer</label>
                              <input type="text" value="<?= $c['nama_customer']; ?>" name="nama_customer" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Alamat Customer</label>
                              <input type="text" value="<?= $c['alamat']; ?>" name="alamat" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Telpon Customer</label>
                              <input type="text" value="<?= $c['telp']; ?>" name="telp" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Faks Customer</label>
                              <input type="text" value="<?= $c['faks']; ?>" name="faks" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Email Customer</label>
                              <input type="text" value="<?= $c['email']; ?>" name="email" class="form-control">
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" name="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </div>
                        </form>
                      </div>
                      <!-- Ending Modal Edit -->
                    </div>
                    <!-- Ending Modal Content -->
                  </div>
                  <!-- Ending Modal -->
      </div>
      <!-- Ending Tombol Edit -->


      <a class="btn btn-danger hapus" href="/customer/<?= $c['kode_customer']; ?>"><i class="fa fa-trash"></i></a>

      </td>
      </tr>
    <?php endforeach ?>
    </tbody>
    </tfoot>
    </table>
    </div>
  </div>
  <!-- /.card-body -->

</div>

</div>

<?= $this->endSection(); ?>