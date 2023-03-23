<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Distribusi Produk</h1>
        <small>Daftar Faktur Penjualan</small>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<div class="container-fluid p-3">

  <div class="card card-default">
    <div class="card-header">
      <div class="h3 card-title">Data Invoice Pelanggan</div>
    </div>
    <div class="card-body">

      <a href="/distribusi/tambah" class="btn btn-primary mb-3">Tambah Data</a>

      <div class="table-responsive">
        <table class="table table-bordered tabled-hover" id="example1">
          <thead class="thead-dark">
            <tr>
              <th width="15">No</th>
              <th>INVOICE</th>
              <th>Nama Customer</th>
              <th>Tanggal Input</th>
              <th>Jumlah Produk</th>
              <th><i class="fa fa-cog"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php foreach ($distribusi as $q) : ?>
              <tr>
                <td align="center"><?= $i++; ?></td>
                <td data-toggle="tooltip" data-placement="top" title="Jumlah Jenis Alat <?= count($jumlah->where('kode_customer', $q['kode_customer'])->get()->getResultArray()); ?>"><strong><?= $q['invoice']; ?></strong></td>
                <td><?= $q['nama_customer']; ?></td>
                <td><?= $q['tanggal']; ?></td>
                <td data-toggle="tooltip" data-placement="right" title="Jumlah Jenis Alat <?= count($jumlah->where('kode_customer', $q['kode_customer'])->get()->getResultArray()); ?>"><?= $q['jumlah_alat']; ?></td>
                <td align="center">
                  <a href="/distribusi/hapusInv/<?= $q['kode_customer']; ?>" class="btn btn-sm btn-danger hapus"><i class="fa fa-trash-alt"></i></a>
                  <a href="/distribusi/edit/<?= $q['kode_customer']; ?>" class="btn btn-sm bg-gradient-primary"><i class="fa fa-user-edit"></i></a>
                  <a href="/distribusi/invoice/<?= $q['kode_customer']; ?>" target="_blank" class="btn btn-sm bg-gradient-info"><i class="fa fa-print"></i></a>
                  <a href="/distribusi/excel/<?= $q['kode_customer'] ?>" class="btn btn-sm bg-gradient-success" data-toggle="tooltip" data-placement="top" title="Print Excel <?= $q['kode_customer']; ?>" target="_blank"><i class="fa fa-print"></i></a>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>

    </div>
    <div class="card-footer">Distribusi Produk</div>
  </div>
  <!-- /.Card -->

</div>
<!-- /.content-wrapper -->

<!-- setFlashdata PESSAN -->
<?php if (session()->getFlashdata('pesan')) : ?>
  <div class="pesanToast" data-pesan="<?= session()->getFlashdata('pesan'); ?>"></div>
<?php endif ?>

<?= $this->endSection(); ?>