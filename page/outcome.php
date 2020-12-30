    <main class="main-content">
      <section class="content-header">
        <div class="row">
          <div class="col-xs-12">
            <div class="breadcrumb breadcrumb-arrow">
              <li class="active"><a href="?dashboard"><i class="fa fa-fw fa-dashboard"></i>&nbsp; Dashboard</a></li>
              <li class="active"><span><i class="fa fa-fw fa-arrow-circle-o-up"></i>&nbsp;Outcome</span></li>
            </div>
          </div>
        </div>
      </section>
      <!-- content box (User data) -->
      <section class="content-box">
        <div class="row">
          <div class="col-xs-12">
            <h3 class="page-title">Pengeluaran</h3>
            <hr>
          </div>
        </div>
        <!-- Input Bulan -->
        <div class="row">
          <div class="col-md-10">
            <div class="form-group">
              <div class="input-group">
                <input type="month" class="form-control" id="outShowDate">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-primary" onclick="loadOutcome(1)" name="button">Tampilkan</button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#modal-addout">Tambah Data</button>
            </div>
          </div>
        </div>

        <!-- Tampil data -->
        <div class="row">
          <div class="col-md-12">
          <!-- Search Bar -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-fw fa-search"></i></span>
                <input type="text" disabled id="outFindText" class="form-control" onkeyup="loadOutcome(1)" placeholder="Pencarian">
              </div>
            </div>
          
            <div class="alert alert-warning" id="alertNotShow" style="display:none;">
              <p class="text-center"><i class="fa fa-fw fa-warning"></i>&nbsp;Anda harus memilih tanggal !</p>
            </div>
            <!-- Data -->
            <div class="table-responsive" id="tableOutcome"></div>
          </div>
        </div>
      </section>
      <!-- end Section -->
    </main>

    <!-- Modal Outcome -->
    <div id="modal-addout" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tambah Pengeluaran</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="control-label" for="#outFor">Untuk</label>
              <input type="text" id="outUntuk" class="form-control" placeholder="Tujuan Pengeluaran">
            </div>
            <div class="form-group">
              <label class="control-label" for="#outValue">Nominal</label>
              <input type="number" id="outValue" class="form-control" placeholder="Nominal Pengeluaran">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" id="addOutcome">Tambahkan</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Edit Income -->
    <div id="modal-editout" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Data</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="control-label" for="editFromInc">Untuk</label>
              <input type="text" class="form-control" id="editForOut" placeholder="Tujuan Pengeluaran">
            </div>
            <div class="form-group">
              <label class="control-label" for="editValueInc">Nominal</label>
              <input type="text" class="form-control" id="editValueOut" placeholder="Nominal Pengeluaran">
            </div>
          </div>
          <div class="modal-footer">
      <input type="hidden" id="idOut">
            <button type="button" data-dismiss="modal" class="btn btn-default">Batal</button>
            <button type="button" class="btn btn-primary" onclick="updateOutcomeData()">Simpan</button>
          </div>
        </div>
      </div>
    </div>