<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $judul; ?></title>
  <link rel="shorcut icon" href="/favicon.ico">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/dist/css/adminlte.min.css">
  <!-- my CSS -->
  <link rel="stylesheet" href="/dist/css/style.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">

  <!-- loading -->
  <div class="preloader">
    <div class="loading">
      <img src="/img/makna2-loading.gif" width="80">
      <p>Harap Tunggu</p>
    </div>
  </div>
  <!-- /.loading -->

  <div class="login-box">
    <div class="login-logo">
      <img src="/img/makna.png" alt="makna" class="img-fluid" style="padding: 10px;">
    </div>
    <div class="pesan" data-pesan="<?= isset($pesan['pesan']) ? $pesan['pesan'] : ''; ?>"></div>
    <!-- /.login-logo -->
    <div class="card" style="margin-right: 20px; margin-top:20px; margin-bottom: 150px;">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Masukkan Email Dan Password</p>
        <form action="/login/login" method="post">
          <div class="input-group">
            <input type="email" class="form-control admin <?= $validation->hasError('email') ? 'is-invalid' : ''; ?>" value="<?= old('email'); ?>" name="email" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <small class="text-danger mb-3"><?= $validation->getError('email'); ?></small>
          <div class="input-group mt-3">
            <input type="password" class="form-control ShowPass <?= $validation->hasError('password') ? 'is-invalid' : ''; ?>" value="<?= old('password'); ?>" name=" password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <small class="text-danger mb-3"><?= $validation->getError('password'); ?></small>
          <div class="row">
            <div class="col-12">
              <div class="icheck-primary">
                <input type="checkbox" id="showPass" name="show">
                <label for="showPass">Lihat Password</label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-12 mt-3">
              <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
              <button id="push" type="button" class="btn btn-block btn-success">PUSH</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <!-- pesan -->
        <?php if (session()->getFlashdata('gagal')) : ?>
          <div class="gagal" data-pesan="<?= session()->getFlashdata('gagal'); ?>"></div>
        <?php endif ?>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/dist/js/adminlte.min.js"></script>
  <!-- Toastr -->
  <script src="/plugins/toastr/toastr.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="/dist/js/push.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.8/push.min.js"></script>

  <script src="/dist/js/scriptLogin.js"></script>

</body>

</html>