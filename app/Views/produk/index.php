<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Produk</h1>
        <small>Silahkan Input Data Produk Anda</small>
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
      <div class="card-title">Data Produk</div>
    </div>

    <div class="col-sm-4" style="padding:20px;">

      <div class="btn-group" role="group" aria-label="Basic example">
        <a href="/produk/tambah" class="btn btn-primary">Input Data Produk</a>
        <a href="#" class="btn bg-gradient-success"><i class="far fa-file-excel"></i> Export Excel</a>
        <a href="/produk/import" class="btn btn-outline-success"><i class="far fa-file-excel"></i> Import Excel</a>
      </div>
    </div>
    <!-- setFlashdata PESSAN -->
    <?php if (session()->getFlashdata('pesan')) : ?>
      <div class="pesan" role="alert" data-pesan="<?= session()->getFlashdata('pesan'); ?>"></div>
    <?php endif ?>

    <div class="card-body">
      <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="text-center" width="10">No</th>
              <th class="text-center">Nama Produk</th>
              <th class="text-center">Kode Produk</th>
              <th class="text-center">Satuan</th>
              <th class="text-center">Expired</th>
              <th class="text-center">Harga</th>
              <th class="text-center">Stok</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php foreach ($produk as $k) : ?>
              <tr>
                <td class="text-center"><?= $i++; ?></td>
                <td class="text-center" class="text-capitalize"><?= ucwords($k['nama_alat']); ?></td>
                <td class="text-center" class="text-uppercase"><?= strtoupper($k['kode_alat']); ?></td>
                <td class="text-center" class="text-capitalize"><?= ucwords($k['satuan']); ?></td>
                <td class="text-center" class="text-capitalize"><?= $k['expired']; ?></td>
                <td class="text-center">Rp. <?= rupiah($k['harga']); ?></td>
                <td class="text-center"><?= $k['stok']; ?></td>
                <td class="text-center">

                  <a href="#" class="btn btn-info" data-toggle="modal" data-target="#editProduk<?= $k['id']; ?>"><i class="fa fa-edit"></i></a>

                  <div class="modal fade" id="editProduk<?= $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Edit Data Customer {<?= strtoupper($k['kode_alat']); ?>}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form action="/produk/ubah/<?= $k['id']; ?>" method="post">
                            <?= csrf_field(); ?>
                            <input type="hidden" value="<?= $k['kode_alat']; ?>" style="text-transform: uppercase;" name="kode_alat" class="form-control">
                            <div class="form-group">
                              <label>Nama Produk</label>
                              <input type="text" value="<?= $k['nama_alat']; ?>" style="text-transform: capitalize;" name="nama_alat" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Satuan</label>
                              <input type="text" value="<?= $k['satuan']; ?>" style="text-transform: capitalize;" name="satuan" class="form-control">
                            </div>
                            <div class="form-group">
                              <label class="font-italic">Expired</label>
                              <input type="text" value="<?= $k['expired']; ?>" data-expired="expired" autocomplete="off" name="expired" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Harga</label>
                              <input type="text" value="<?= $k['harga']; ?>" id="harga" name="harga" data-a-sign="Rp. " data-a-dec="," data-a-sep="." placeholder="Rp." class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Jumlah</label>
                              <input type="text" value="<?= $k['stok']; ?>" name="stok" class="form-control">
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

      <a class="btn btn-danger hapus" href="/produk/<?= $k['id']; ?>"><i class="fa fa-trash"></i></a>
      <!-- <form action="/pages/<?= $k['id']; ?>" method="post" class="d-inline">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="btn btn-danger hapus"><i class="fa fa-trash"></i></button>
      </form> -->

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