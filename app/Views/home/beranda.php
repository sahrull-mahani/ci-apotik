<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid mt-3">

  <div class="row">
    <div class="col-md">

      <!-- small card -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3 id="info-dal">0</h3>

          <p>Distribusi Produk</p>
        </div>
        <div class="icon">
          <i class="fas fa-shopping-cart"></i>
        </div>
        <a href="dal" class="small-box-footer">
          More info <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>

    </div>

    <div class="col-md">

      <!-- small card -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3 id="info-al">0</h3>

          <p>Jumlah Produk</p>
        </div>
        <div class="icon">
          <i class="fas fa-medkit"></i>
        </div>
        <a href="/produk" class="small-box-footer">
          More info <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>

    </div>

    <div class="col-md">

      <!-- small card -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3 id="info-cs">0</h3>

          <p>Jumlah Customers</p>
        </div>
        <div class="icon">
          <i class="fas fa-users"></i>
        </div>
        <a href="/customer" class="small-box-footer">
          More info <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>

    </div>
  </div>

  <div class="row">
    <div class="col-md">

      <!-- PRODUCT LIST -->
      <div class="card card-outline card-info">
        <div class="card-header">
          <h3 class="card-title">Daftar Product Terbaru</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
          <ul class="products-list product-list-in-card pl-2 pr-2" data-alat>
            <li class='item'>
              <div class='product-info'>
                <p class='product-title'>
          </ul>
        </div>
        <!-- /.card-body -->
        <div class="card-footer text-center">
          <a href="/produk" class="uppercase">Lihat Semua Products</a>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

    </div>

    <div class="col-md">

      <!-- PRODUCT LIST -->
      <div class="card card-outline card-success">
        <div class="card-header">
          <h3 class="card-title">Daftar Customer</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
          <ul class="products-list product-list-in-card pl-2 pr-2" data-cus></ul>
        </div>
        <!-- /.card-body -->
        <div class="card-footer text-center">
          <a href="/customer" class="uppercase">Lihat Semua Customer</a>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

    </div>
  </div>
  <!-- pesan -->
  <?php if (session()->getFlashData('pesan')) : ?>
    <div class="pesan" data-pesan="<?= session()->getFlashdata('pesan'); ?>"></div>
  <?php endif ?>

</div>
<?= $this->endSection(); ?>