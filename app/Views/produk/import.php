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
    <div class="card-body">
      <h5 class="card-title">Import Excel Produk</h5>

      <?= form_open_multipart('/produk/import_excel'); ?>

      <div class="input-group mb-3 mt-5">
        <div class="custom-file">
          <input type="file" class="custom-file-input" name="importexcel" id="inputGroupFile02">
          <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
        </div>
        <div class="input-group-append">
          <button class="btn btn-outline-success" type="submit">Import Data</button>
        </div>
      </div>
      <?= form_close(); ?>

      <a href="/produk" class="card-link">Kembali</a>
      <a href="/produk/template_excel" class="btn btn-success btn-sm">Download Template</a>
    </div>
    <div class="card-footer">
      <!-- setFlashdata PESSAN -->
      <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-danger" role="alert">
          <?= session()->getFlashdata('pesan'); ?>
        </div>
      <?php endif ?>

      <!-- setFlashdata PESSAN -->
      <?php if (session()->getFlashdata('sukses')) : ?>
        <div class="pesanInfo" data-pesan="<?= session()->getFlashdata('sukses'); ?>"></div>
      <?php endif ?>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>