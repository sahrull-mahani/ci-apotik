<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">

  <div class="row">
    <div class="col-md-4 offset-md-4">

      <div class="login-box">
        <div class="login-logo">
          <img src="/img/makna.png" alt="makna" class="img-fluid">
        </div>
        <!-- /.login-logo -->

        <form action="/home/updatePass" enctype="multipart/form-data" method="post">
          <div class="image-upload mx-auto img-thumbnail mb-2">
            <label for="upload">
              <img src="/img/<?= $session['pic']; ?>" class="image-up" alt="gambar" id="preview">
            </label>

            <input type="file" name="upload" id="upload" name="upload" aria-describeby="upload" accept="image/*" onchange="tampilkanPreview(this, 'preview')" />
          </div>
          <small class="text-danger text-center"><?= $validation->getError('upload'); ?></small>

          <div class="card">
            <div class="card-body login-card-body">
              <p class="login-box-msg">Masukan password baru sesuai dengan keinginan anda, Pastikan konfirmasi password sama dengan password yang dimasukan.</p>

              <small class="text-danger"><?= $validation->getError('password'); ?></small>
              <div class="input-group mb-3">
                <input type="password" class="form-control <?= $validation->hasError('password') ? 'is-invalid' : ''; ?>" value="<?= old('password'); ?>" name="password" placeholder="Password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <small class="text-danger"><?= $validation->getError('password2'); ?></small>
              <div class="input-group mb-3">
                <input type="password" class="form-control <?= $validation->hasError('password2') ? 'is-invalid' : ''; ?>" value="<?= old('password2'); ?>" name="password2" placeholder="Confirm Password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <button type="submit" name="submit" class="btn btn-primary btn-block">Change</button>
                </div>
                <!-- /.col -->
              </div>
            </div>
        </form>

      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

</div>
</div>

<!-- setFlashdata PESSAN -->
<?php if (session()->getFlashdata('pesan')) : ?>
  <div class="pesan" role="alert" data-pesan="<?= session()->getFlashdata('pesan'); ?>"></div>
<?php endif ?>

</div>
<?= $this->endSection(); ?>