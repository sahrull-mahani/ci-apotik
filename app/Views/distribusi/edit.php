<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Data Distribusi Alat</h1>
        <small>Silahkan Input Data Distribusi Alat Anda</small>
      </div>
    </div>

    <div class="pesan" data-pesan="<?= isset($pesan['pesan']) ? $pesan['pesan'] : ''; ?>"></div>

    <div class="callout callout-info">
      <h5><i class="fas fa-info"></i> Note:</h5>
      <p class="font-weight-bold">Pastikan setelah menambahkan alat baru. User menekan tombol <button type="button" class="btn btn-xs btn-info ml-2" style="cursor: not-allowed;"><i class="fa fa-save"></i> Simpan</button>. Jika tombol tidak ditekan maka data tidak akan di simpan!</p>
    </div>

  </div><!-- /.container-fluid -->
</section>

<!-- Main Content -->
<div class="container-fluid p-3">

  <div class="row">

    <!-- Form Input -->
    <div class="col-md-4">
      <div class="card card-default">
        <div class="card-header bg-primary">
          <h3 class="card-title">Input Alat</h3>
        </div>
        <div class="card-body">

          <form action="/distribusi/editProduk" method="POST">
            <input type="hidden" value="<?= $kodeCustomer; ?>" name="kodeCustomer">
            <label>Daftar ALat Yang Di Input</label>
            <select class="form-control" id="alatSelect" name="alatSelect">
              <option selected="#" value="">-- Alat Yang Di Input --</option>
              <?php
              foreach ($dataAlat as $data) {
                $kode_alat = strtoupper($data['kode_alat']);
                $nama_alat = ucwords($data['nama_alat']);

                if ($data['stok'] <= 0) {
                  $dis = 'disabled';
                } else {
                  $dis = '';
                }
              ?>
                <option value="<?= $kode_alat . '|' . $nama_alat; ?>" <?= $dis; ?>><?= $kode_alat; ?> -- <?= $nama_alat; ?></option>
              <?php } ?>
            </select>

            <div class="row mt-3">
              <div class="col-md">
                <label for="stok">Stok</label>
                <input type="text" name="stok" disabled="disabled" value="--- Pilih Alat" id="stok" class="form-control" style="cursor: not-allowed;">
              </div>
              <div class="col-md">
                <label for="jumlah">Jumlah</label>
                <input type="text" autocomplete="off" name="jumlah" id="jumlah" class="form-control" required="required" title="Tidak Boleh Kosong">
              </div>
              <div class="col-md">
                <label for="disc">Diskon</label>
                <input type="text" autocomplete="off" name="disc" id="disc" class="form-control" placeholder="%" title="Tidak Boleh Kosong">
              </div>
            </div>

            <button type="submit" class="btn btn-primary form-control mt-3" name="submit" id="submit">Tambahkan</button>
          </form>

        </div>
        <!-- /.Card BODY -->
        <div class="card-footer">Distribusi Alat.</div>
      </div>
      <!-- /.Card -->
    </div>
    <!-- /.FORM -->


    <!-- =========================================================== -->


    <div class="col-md-8">
      <div class="card card-default">
        <div class="card-header bg-info">
          <div class="h3 card-title">Data Alat</div>
        </div>
        <div class="card-body">

          <table class="table table-bordered table-sm table-responsive-md">
            <thead class="bg-info">
              <tr>
                <td width="15">No</td>
                <td><i class="fas fa-cogs"></i></td>
                <td>Kode Alat</td>
                <td>Keterangan</td>
                <td>Expired</td>
                <td>Qty</td>
                <td>harga + PPN</td>
                <td>Disc</td>
                <td>Jumlah</td>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($dataEdit)) : ?>
                <tr>
                  <td colspan="9" align="center">
                    <h3 class="font-weight-bold" id="blinkk">Data Belum Dimasukan</h3>
                  </td>
                </tr>
              <?php else : ?>
                <?php $i = 1; ?>
                <?php foreach ($dataEdit as $tmp) : ?>
                  <?php $total[$i] = $tmp['harga'] * $tmp['jumlah'] - ($tmp['disc'] / 100) * $tmp['harga'] * $tmp['jumlah'] ?>
                  <tr>
                    <td align="center"><?= $i++; ?></td>
                    <td align="center">
                      <a href="/distribusi/hapusEdit/<?= $tmp['kode_alat'] . '/' . $tmp['kode_customer']; ?>" class="btn btn-sm btn-danger hapus"><i class="fas fa-trash-alt"></i></a>
                    </td>
                    <td><?= $tmp['kode_alat']; ?></td>
                    <td><?= $tmp['nama_alat']; ?></td>
                    <td><?= $tmp['expired']; ?></td>
                    <td><?= $tmp['jumlah'] . ' ' . $tmp['satuan']; ?></td>
                    <td><?= rupiah($tmp['harga']) ? "Rp. " . rupiah($tmp['harga']) : "Rp . 0"; ?></td>
                    <td><?= !empty($tmp['disc']) ? $tmp['disc'] . "%" : "0%"; ?></td>
                    <td align="right"><?= "Rp. " . rupiah($tmp['jumlah'] * $tmp['harga'] - ($tmp['disc'] / 100) * $tmp['jumlah'] * $tmp['harga']); ?></td>
                  </tr>
                <?php endforeach ?>
              <?php endif ?>
            </tbody>
          </table>

          <div class="clearfix mt-3 mb-5">
            <h4 class="float-sm-right harga-total">Rp. <?= !isset($total) ? '0' : rupiah(array_sum($total)); ?></h4>
          </div>

          <div class="form-inline float-sm-right">
            <select class="form-control" id="customerSelect" disabled="disabled">
              <option selected="selected" value="<?= $kodeCustomer; ?>"><?= $kodeCustomer; ?> | <?= $namaCustomer; ?></option>
            </select>

            <button type="button" id="update" class="btn btn-info ml-2"><i class="fa fa-save"></i> Simpan</button>
          </div>

        </div>
        <!-- /.CARD BODY -->
        <div class="card-footer">Distribusi Alat.</div>
      </div>
      <!-- /.CARD -->
    </div>

  </div>
  <!-- /.ROW -->

  <!-- tampilkan Pesan -->
  <?php if (session()->getFlashdata('pesan')) : ?>
    <div class="pesanToast" data-pesan="<?= session()->getFlashdata('pesan'); ?>"></div>
  <?php endif ?>

</div>

<?= $this->endSection(); ?>