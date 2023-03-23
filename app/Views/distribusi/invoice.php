<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $judul; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 4 -->

  <!-- Font Awesome -->
  <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/dist/css/adminlte.min.css">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- my CSS -->
  <link rel="stylesheet" href="/dist/css/styleInv.css">
</head>

<body>

  <div class="noPrint">



    <div class="print-area offset-xl-2 col-xl-8 col-md-12">
      <?php

      $rowCount = 0;
      for ($i = 1; $i <= $tot; $i++) { ?>

        <div class="header" <?= $i != 1 ? 'style="margin-top: 550px"' : ''; ?>>
          <!-- /.CONTENT TABLE -->

          <!-- HEADER -->

          <div class="container-fluid mt-3">

            <div class="row">
              <div class="col-sm-8">
                <h5><img src="/img/makna.png" alt="logo" class="logo"></h5>
              </div>
              <div class="col-sm">
                <div class="text-primary h3 d-flex justify-content-end">Invoice</div>
                <div class="row">
                  <div class="col-sm">
                    <h6 class="font-weight-bold d-flex justify-content-end">Referensi</h6>
                    <h6 class="font-weight-bold d-flex justify-content-end">Tanggal</h6>
                    <h6 class="font-weight-bold d-flex justify-content-end">Tgl. Jatuh Tempo</h6>
                  </div>
                  <div class="col-sm">
                    <h6 class="d-flex justify-content-end">EXP/2020/0001</h6>
                    <h6 class="d-flex justify-content-end">15/09/2020</h6>
                    <h6 class="d-flex justify-content-end">05/09/2020</h6>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm">
                <h6 class="font-weight-bold">Info Perusahaan</h6>
                <hr style="border-bottom: 2px solid #000420" class="mr-5 mb-3">
                <h6 class="font-weight-bold mb-3">Makna Karya Selaras</h6>
                <h6 class="m-0">Jl. Kalimantan,</h6>
                <h6 class="m-0">Gorontalo,</h6>
                <h6 class="m-0">Gorontalo, 96126</h6>
                <h6 class="m-0">Indonesia</h6>
                <h6 class="m-0">Telp: 082272838357</h6>
                <h6 class="mb-4">Email : mufidahmedika@gmail.com</h6>
              </div>
              <div class="col-sm">
                <h6 class="font-weight-bold">Info Perusahaan</h6>
                <hr style="border-bottom: 2px solid #000420">
                <h6 class="font-weight-bold mb-3"><?= $dataCustomer['nama_customer']; ?></h6>
                <h6 class="m-0">Telp : <?= $dataCustomer['telp']; ?></h6>
                <h6 class="m-0">Email : <?= $dataCustomer['email']; ?></h6>
              </div>
            </div>

          </div>
        </div>
        <!-- /.HEADER -->

        <div class="container-fluid">

          <!-- MAIN TABLE CONTENT -->
          <div class="row">
            <div class="col-12">

              <table class="table-print">
                <thead>
                  <tr>
                    <th>Produk</th>
                    <th>Kuantitas</th>
                    <th>Expired</th>
                    <th>Harga</th>
                    <th>Diskon</th>
                    <th>Pajak</th>
                    <th>Jumlah</th>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  $data = $dataPA->table('tb_pesan')->join('tb_alat', 'tb_pesan.kode_alat = tb_alat.kode_alat')->where('kode_customer', $kdCustomer)->limit($max, $rowCount)->get()->getResultArray();
                  $n = 0;
                  foreach ($data as $qd) {
                  ?>

                    <tr>
                      <td><?= $qd['nama_alat']; ?></td>
                      <td align="center"><?= $qd['jumlah']; ?></td>
                      <td align="center"><?= $qd['expired']; ?></td>
                      <td align="center"><?= rupiah($qd['harga']); ?></td>
                      <td align="center"><?= $qd['disc']; ?> %</td>
                      <td align="center">-</td>
                      <td align="right"><?= rupiah($qd['jumlah'] * $qd['harga'] - ($qd['disc'] / 100) * $qd['jumlah'] * $qd['harga']); ?></td>

                    </tr>
                  <?php } ?>
                </tbody>
              </table>

            </div>
          </div>
          <!-- /.MAIN TABLE CONTENT -->

        </div>
        <!-- /.CONTAINER FLUID -->


        <!-- TOTAL -->
        <div class="row mt-3">
          <div class="col-sm-3 offset-sm-6">
            <h5 class="total">Subtotal</h5>
          </div>
          <div class="col-sm-3">
            <div class="float-right total">Rp. <span><?= isset($total) ? rupiah(array_sum($total)) : "0"; ?></span></div>
          </div>

          <div class="col-sm-3 offset-sm-6">
            <h5 class="total">Total Diskon</h5>
          </div>
          <div class="col-sm-3">
            <div class="float-right total">Rp. <span>(0.00)</span></div>
          </div>

          <div class="col-sm-3 offset-sm-6">
            <h5 class="total">Diskon Tambahan</h5>
          </div>
          <div class="col-sm-3">
            <div class="float-right total">Rp. <span>(0.00)</span></div>
          </div>

          <div class="col-sm-3 offset-sm-6">
            <h5 class="total">Pajak</h5>
          </div>
          <div class="col-sm-3">
            <div class="float-right total">Rp. <span>0.00</span></div>
          </div>

          <div class="col-sm-3 offset-sm-6">
            <h5 class="total">Total</h5>
          </div>
          <div class="col-sm-3">
            <div class="float-right total">Rp. <span><?= isset($total) ? rupiah(array_sum($total)) : "0"; ?></span></div>
          </div>

          <div class="col-sm-3 offset-sm-6">
            <h5 class="total">Total Terbayar</h5>
          </div>
          <div class="col-sm-3">
            <div class="float-right total">Rp. <span>0.00</span></div>
          </div>

          <div class="col-sm-3 offset-sm-6">
            <h5 class="total">Sisa Tagihan:</h5>
          </div>
          <div class="col-sm-3">
            <div class="float-right total">Rp. <span style="font-size: 20px"><?= isset($total) ? rupiah(array_sum($total)) : "0"; ?></span></div>
          </div>
        </div>
        <!-- /.TOTAL -->


      <?php
        $rowCount = $rowCount + $max;
      }

      ?>


      <!-- TTD -->
      <div class="row">
        <div class="col-sm-4 offset-sm-8 mb-5">
          <h5 class="font-weight-bold"><?= date("j ") . bulanIni() . ',' . date(" Y"); ?></h5>
        </div>
        <div class="col-sm-4 offset-sm-8 mt-5 pl-3">
          <h5 class="font-weight-bold ml-5">Finance</h5>
        </div>
      </div>
      <!-- /.TTD -->

    </div>
    <!-- /.PRINT AREA -->
  </div>
  <!-- /.NO-PRINT -->

  <!-- jQuery -->
  <script src="/plugins/jquery/jquery.min.js"></script>

  <script type="text/javascript">
    window.addEventListener("load", window.print());
  </script>
</body>

</html>