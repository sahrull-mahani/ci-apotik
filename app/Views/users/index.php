<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">

  <div class="row mt-4">
    <div class="col-md">

      <!-- USERS LIST -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Daftar User</h3>

          <div class="card-tools">
            <span class="badge badge-info"><?= $jumlah <= 1 ? '0' : $jumlah; ?> user yang terdafatar</span>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
          <ul class="users-list clearfix">
            <?php foreach ($user as $r) : ?>
              <li>
                <img src="/img/profile.jpg" class="img-fluid img-thumbnail" id="online" data-id="<?= $r['id']; ?>" style="width: 100px;" alt="User Image">
                <p class="users-list-name mt-2 mb-0" href="#"><?= ucwords($r['nama']); ?></p>
                <span class="users-list-date">
                  <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="/users/hapusUser/<?= $r['id']; ?>" class="btn btn-sm btn-outline-danger hapus" class="fa fa-trash text-mute"><i class="fa fa-trash"></i> Hapus</a>
                    <a href="users/resetPass/<?= $r['id']; ?>" class="btn btn-sm btn-outline-danger resetpass" class="fa fa-trash text-mute"><i class="fa fa-undo-alt"></i> Reset Pass</a>
                  </div>
                </span>
              </li>
            <?php endforeach ?>
          </ul>
          <!-- /.users-list -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          PT.Makna Selaras | User List
        </div>
        <!-- /.card-footer -->
      </div>
      <!--/.card -->

    </div>
  </div>

  <?php if (session()->getFlashdata('pesan')) : ?>
    <div class="pesan" data-pesan="<?= session()->getFlashdata('pesan'); ?>"></div>
  <?php endif ?>

</div>
<?= $this->endSection(); ?>