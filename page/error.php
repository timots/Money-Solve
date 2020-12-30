<?php
  $database = new Koneksi();
  $database->dapetKoneksi();
?>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <center><i class="fa fa-fw fa-chain-broken error-icon fc-danger-light"></i></center>
          <h2 class="error-title text-center">Connection Error!</h2>
          <div class="alert alert-danger error-box">
            <h4><span class="fa fa-fw fa-warning"></span>Terjadi kesalahan</h4>
            <p class="error-message error-message-danger"><?php echo $database->kesalahan();?></p>
            <a class="btn btn-danger error-button" data-toggle="modal" data-target="#laporkan">Laporkan</a>
          </div>
        </div>
      </div>
    </div>

    <div id="laporkan" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Laporkan</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-xs-12">
                <div class="form-group">
                  <label class="control-label" for="#emailText">Email</label>
                  <input id="emailText" class="form-control" placeholder="Email anda">
                </div>
                <div class="form-group">
                  <label class="control-label" for="#detailMasalah">Deskripsi</label>
                  <textarea id="detailMasalah" class="form-control" placeholder="Deskripsi masalah"></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-danger">Laporkan</button>
          </div>
        </div>
      </div>
    </div>
