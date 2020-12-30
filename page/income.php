    <main class="main-content">
      <!-- content header (Breadcrumb) -->
      <section class="content-header">
        <div class="row">
          <div class="col-xs-12">
            <div class="breadcrumb breadcrumb-arrow">
              <li class="active"><a href="?dashboard"><i class="fa fa-fw fa-dashboard"></i>&nbsp; Dashboard</a></li>
              <li class="active"><span><i class="fa fa-fw fa-arrow-circle-o-down"></i>&nbsp;Income</span></li>
            </div>
          </div>
        </div>
      </section>

      <!-- content box (User data) -->
      <section class="content-box">
        <div class="row">
          <div class="col-xs-12">
            <h3 class="page-title">Pendapatan</h3>
            <hr>
          </div>
        </div>
        <!-- Input Bulan -->
        <div class="row">
          <div class="col-md-10">
            <div class="form-group">
              <div class="input-group">
                <input type="month" class="form-control" id="incShowDate">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-primary" onclick="loadIncome(1)" name="button">Tampilkan</button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#modal-addinc">Tambah Data</button>
            </div>
          </div>
        </div>

        <!-- Tampil data -->
        <div class="row">
          <div class="col-md-12">
                <!-- Search bar -->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-fw fa-search"></i>
                    </span>
                    <input type="text" disabled id="findText" class="form-control" onkeyup="loadIncome(1)" placeholder="Pencarian">
                  </div>
                </div>
				
                <!-- Tabel data -->
                <div class="alert alert-warning" id="alertNotShow" style="display:none;">
                  <p class="text-center"><i class="fa fa-fw fa-warning"></i>&nbsp;Anda harus memilih tanggal !</p>
                </div>
                <div class="table-responsive" id="tableIncome"></div>
          </div>
        </div>
      </section>
      <!-- end Section -->
    </main>

    <!-- Modal Add Income -->
    <div id="modal-addinc" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tambah Pendapatan</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="control-label" for="#incDari">Dari</label>
              <input type="text" id="incDari" class="form-control" placeholder="Asal Pendapatan">
            </div>
            <div class="form-group">
              <label class="control-label" for="#incValue">Nominal</label>
              <input type="number" id="incValue" class="form-control" placeholder="Nominal Pendapatan">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" id="addIncome">Tambahkan</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Edit Income -->
    <div id="modal-editinc" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Data</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="control-label" for="editFromInc">Dari</label>
              <input type="text" class="form-control" id="editFromInc" placeholder="Asal">
            </div>
            <div class="form-group">
              <label class="control-label" for="editValueInc">Nominal</label>
              <input type="text" class="form-control" id="editValueInc" placeholder="Nominal">
            </div>
          </div>
          <div class="modal-footer">
			<input type="hidden" id="idInc">
            <button type="button" data-dismiss="modal" class="btn btn-default">Batal</button>
            <button type="button" class="btn btn-primary" onclick="updateIncomeData()">Simpan</button>
          </div>
        </div>
      </div>
    </div>
