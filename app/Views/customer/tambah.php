<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Tambah Data Customer</h1>
        <small>Silahkan Input Data Customer</small>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Tambah Data Customer</h3>
      </div>
      <form action="/customer/simpan" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="card-body">

          <div class="form-group">
            <label for="#">Kode Customer</label>
            <input type="text" class="form-control <?= ($validation->hasError('kode_customer')) ? 'is-invalid' : ''; ?>" id="kode_customer" onkeyup="this.value = this.value.toUpperCase();" name="kode_customer" placeholder="Kode Customer : CUS" value="<?= old('kode_customer'); ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('kode_customer'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="#">Nama Customer</label>
            <input type="text" class="form-control <?= ($validation->hasError('nama_customer')) ? 'is-invalid' : ''; ?>" id="nama_customer" name="nama_customer" placeholder="Contoh : PT. Berobat Dimana" value="<?= old('nama_customer'); ?>">
            <div class=" invalid-feedback">
              <?= $validation->getError('nama_customer'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="#">Alamat Customer</label>
            <input type="text" class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>" id="alamat" name="alamat" placeholder="Contoh : Jlan jalanin aja dulu" value="<?= old('alamat'); ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('alamat'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="#">Telpon Customer</label>
            <input type="text" class="form-control <?= ($validation->hasError('telp')) ? 'is-invalid' : ''; ?>" id="telp" name="telp" placeholder="+62" value="<?= old('telp'); ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('telp'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="#">Faks Customer</label>
            <input type="text" class="form-control <?= ($validation->hasError('faks')) ? 'is-invalid' : ''; ?>" id="faks" name="faks" placeholder="(+62)" value="<?= old('faks'); ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('faks'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="#">Email Customer</label>
            <input type="text" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="Contoh : iniemail@gmail.com" value="<?= old('email'); ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('email'); ?>
            </div>
          </div>

          <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-danger">Reset</button>
          </div>

        </div>
</section>
<?= $this->endSection(); ?>