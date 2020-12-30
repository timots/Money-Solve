    <main class="main-content">
      <section class="content-header">
        <div class="row">
          <div class="col-xs-12">
            <div class="breadcrumb breadcrumb-arrow">
              <li class="active"><a href="?dashboard"><i class="fa fa-fw fa-dashboard"></i>&nbsp; Dashboard</a></li>
              <li class="active"><span><i class="fa fa-fw fa-shopping-cart"></i>&nbsp;Wishlist</span></li>
            </div>
          </div>
        </div>
      </section>
      <section class="content-box">
        <div class="row">
          <div class="col-xs-12">
            <h3 class="page-title">Wishlist</h3>
            <hr>
          </div>
        </div>
        <div class="row">
          <div class="col-md-10 col-xs-12">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-fw fa-search"></i></span>
                <input type="text" id="searchText" class="form-control" placeholder="Pencarian" onkeyup="loadDataWS()">
              </div>
            </div>
          </div>
          <div class="col-md-2 col-xs-12">
            <div class="form-group">
              <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#add-barang"><i class="fa fa-fw fa-cart-plus"></i>&nbsp;Belanja</button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div id="data-wishlist"></div>
          </div>
        </div>
      </section>
    </main>

<!-- Modal Tambah Barang -->
    <div id="add-barang" class="modal fade" role="dialog" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tambah Belanja</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="namabarang">Nama Barang</label>
              <input id="namabarang" type="text" class="form-control" placeholder="Nama Barang">
            </div>
            <div class="form-group">
              <label for="namabarang">Nominal Harga</label>
              <input id="nominalbarang" type="text" class="form-control" placeholder="Harga Barang">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" onclick="insertDataWS()">Tambahkan</button>
          </div>
        </div>
      </div>
    </div>

    <div id="edit-barang" class="modal fade" role="dialog" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Ubah Belanja</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="namabarang">Nama Barang</label>
              <input id="edit-namabarang" type="text" class="form-control" placeholder="Nama Barang">
            </div>
            <div class="form-group">
              <label for="namabarang">Nominal Harga</label>
              <input id="edit-nominalbarang" type="text" class="form-control" placeholder="Harga Barang">
            </div>
          </div>
          <input type="hidden" class="hidden" id="id-brg">
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" onclick="updateData()">Ubah</button>
          </div>
        </div>
      </div>
    </div>