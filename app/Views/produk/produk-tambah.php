<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content-header">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>Data Tambah Produk</h1>
      <small>Silahkan Input Data Produk Anda</small>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Tambah Data Produk</h3>
      </div>
      <form action="/produk/simpan" method="post">
        <?= csrf_field(); ?>
        <div class="card-body">

          <div class="form-group">
            <label for="nama_alat">Nama Produk</label>
            <input type="text" class="form-control <?= ($validation->hasError('nama_alat')) ? 'is-invalid' : ''; ?>" id="nama_alat" name="nama_alat" style="text-transform: capitalize" placeholder="Contoh : Paracetamol" value="<?= old('nama_alat'); ?>">
            <div id="validationServer04Feedback" class="invalid-feedback">
              <?= $validation->getError('nama_alat'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="kode_alat">Kode Produk</label>
            <input type="text" class="form-control <?= ($validation->hasError('kode_alat')) ? 'is-invalid' : ''; ?>" id="kode_alat" name="kode_alat" onkeyup="this.value = this.value.toUpperCase();" placeholder="Contoh : GUI01" value="<?= old('kode_alat'); ?>">
            <div id="validationServer04Feedback" class="invalid-feedback">
              <?= $validation->getError('kode_alat'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="satuan">Satuan</label>
            <input type="text" class="form-control <?= ($validation->hasError('satuan')) ? 'is-invalid' : ''; ?>" id="satuan" name="satuan" style="text-transform: capitalize;" placeholder="Pcs/Box/ Dan Lainnya" value="<?= old('satuan'); ?>">
            <div id="validationServer04Feedback" class="invalid-feedback">
              <?= $validation->getError('satuan'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="expired" class="font-italic">Expired</label>
            <input type="text" class="form-control" id="expired" autocomplete="off" name="expired" style="text-transform: capitalize;" placeholder="DD-MM-YYYY" value="<?= old('expired'); ?>">
          </div>

          <div class="form-group">
            <label for="harga">Harga Alat</label>
            <input type="text" class="form-control <?= ($validation->hasError('harga')) ? 'is-invalid' : ''; ?>" id="harga" name="harga" data-a-sign="Rp. " data-a-dec="," data-a-sep="." placeholder="Rp." value="<?= old('harga'); ?>">
            <div id="validationServer04Feedback" class="invalid-feedback">
              <?= $validation->getError('harga'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="stok">Stok Produk</label>
            <input type="number" class="form-control <?= ($validation->hasError('stok')) ? 'is-invalid' : ''; ?>" id="stok" name="stok" placeholder="Masukkan Jumlah Stok sesuai Data yang tersedia" value="<?= old('stok'); ?>">
            <div id="validationServer04Feedback" class="invalid-feedback">
              <?= $validation->getError('stok'); ?>
            </div>
          </div>

          <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-danger">Reset</button>
          </div>

        </div>
      </form>
</section>

<?= $this->endSection(); ?>