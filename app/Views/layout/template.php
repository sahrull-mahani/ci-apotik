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
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.css">

  <!-- JQVMap -->
  <link rel="stylesheet" href="/plugins/jqvmap/jqvmap.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- jQueryUI -->
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/plugins/summernote/summernote-bs4.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
  <!-- my CSS -->
  <link rel="stylesheet" href="/dist/css/style.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <div class="preloader">
    <div class="loading">
      <img src="/img/makna2-loading.gif" width="80">
      <p>Harap Tunggu</p>
    </div>
  </div>

  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="/" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
        </li>
      </ul>

    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="/" class="brand-link">
        <img src="/img/makna2.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">PT. Makna</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="/img/<?= isset($session['pic']) ? $session['pic'] : 'profile.jpg'; ?>" class="img-circle pic" alt="User Image">
          </div>
          <div class="info">
            <a href="/home/changePass" class="d-block text-capitalize"><?= isset($session['nama']) ? $session['nama'] : 'No Name'; ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="/" class="nav-link">
                <i class="fa fa-home nav-icon"></i>
                <p>Beranda</p>
              </a>
            </li>

            <li class="nav-header">MASTER DATA</li>
            <li class="nav-item">
              <a href="/produk" class="nav-link">
                <i class="fa fa-medkit nav-icon"></i>
                <p>Produk</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/customer" class="nav-link">
                <i class="fa fa-users nav-icon"></i>
                <p>Customer</p>
              </a>
            </li>
            <li class="nav-header">DATA DISTRIBUSI</li>
            <li class="nav-item">
              <a href="/distribusi" class="nav-link">
                <i class="fa fa-shopping-cart nav-icon"></i>
                <p>Distribusi Produk</p>
              </a>
            </li>

            <li class="nav-header">Users</li>
            <li class="nav-item">
              <a href="/users/tambah" class="nav-link">
                <i class="fa fa-user-plus nav-icon"></i>
                <p>Tambah User</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/users" class="nav-link">
                <i class="fa fa-user-friends nav-icon"></i>
                <p>Daftar User</p>
              </a>
            </li>

            <li class="nav-header">UTILITY</li>
            <li class="nav-item has-treeview">
            <li class="nav-item">
              <a href="/home/logout" class="nav-link keluar">
                </i><i class="fas fa-sign-out-alt nav-icon"></i>
                <p>keluar</p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <?= $this->renderSection('content'); ?>

    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>PT.Makna Selaras Karya</strong>
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 2.0.0
      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script src="/plugins/datatables/jquery.dataTables.js"></script>
  <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
  <script src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Select2 -->
  <script src="/plugins/select2/js/select2.full.min.js"></script>
  <!-- ChartJS -->
  <script src="/plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="/plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="/plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="/plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="/plugins/moment/moment.min.js"></script>
  <script src="/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/dist/js/adminlte.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="/dist/js/pages/dashboard.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="/dist/js/demo.js"></script>
  <!-- SweetAlert2 -->
  <script src="/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="/plugins/toastr/toastr.min.js"></script>
  <!-- push -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.8/push.min.js"></script>

  <!-- AutoNumeric -->
  <script src="/dist/js/autoNumeric.js"></script>

  <script src="/dist/js/push.js"></script>

  <!-- Custom Script JS -->
  <script src="/dist/js/script.js"></script>
  <!-- img preview -->
  <script src="/dist/js/img-preview.js"></script>
</body>

</html>