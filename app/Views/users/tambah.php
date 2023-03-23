<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="register-box container">
  <div class="register-logo">
    <img src="/img/makna.png" alt="makna" class="img-fluid">
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="/users/tambahUser" method="post">
        <?= csrf_field(); ?>
        <div class="input-group mb-3">
          <input type="text" class="form-control <?= $validation->hasError('nama') ? 'is-invalid' : ''; ?>" name="nama" value="<?= old('nama'); ?>" placeholder="Full name">
          <div class="invalid-tooltip">
            <?= $validation->getError('nama'); ?>
          </div>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : ''; ?>" value="<?= old('email'); ?>" name="email" placeholder="Email">
          <div class="invalid-tooltip">
            <?= $validation->getError('email'); ?>
          </div>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control ShowPass <?= $validation->hasError('password') ? 'is-invalid' : ''; ?>" value="<?= old('password'); ?>" name="password" placeholder="Password">
          <div class="invalid-tooltip">
            <?= $validation->getError('password'); ?>
          </div>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control ShowPass <?= $validation->hasError('password2') ? 'is-invalid' : ''; ?>" value="<?= old('password2'); ?>" name="password2" placeholder="Retype password">
          <div class="invalid-tooltip">
            <?= $validation->getError('password2'); ?>
          </div>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="showPass">
              <label for="showPass">
                Lihat Password
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="regis" class="btn btn-primary btn-block">Register</button>
          </div>

          <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="pesan" data-pesan="<?= session()->getFlashdata('pesan'); ?>"></div>
          <?php endif ?>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<?= $this->endSection(); ?>