    <main class="main-content">
      <section class="content-header">
        <div class="row">
          <div class="col-xs-12">
            <div class="breadcrumb breadcrumb-arrow">
              <li class="active"><a href="?dashboard"><i class="fa fa-fw fa-dashboard"></i>&nbsp; Dashboard</a></li>
              <li class="active"><span><i class="fa fa-fw fa-cog"></i>&nbsp;Settings</span></li>
            </div>
          </div>
        </div>
      </section>
      <section class="content-box">
        <div class="row">
          <div class="col-xs-12">
            <h3 class="page-title">Profile</h3>
            <hr>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 col-xs-12 text-center" style="margin-bottom:20px;">
            <img id="userimage" src="" style="width: 160px; height: 160px;" class="img img-thumbnail">
            <div id="bungkus" class="progress" style="margin: 8px auto; width:70%; height: 10px; display: none;"><div id="upload-progress" class="progress-bar progress-bar-default" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span class="sr-only">89%</span></div></div>
            <form id="form-upimage" enctype="multipart/form-data">
              <input type="file" name="picture" id="filenya" style="margin:12px auto; width: 200px;">
              <button type="submit" class="btn btn-primary btn-sm">Upload</button>
            </form>
          </div>
          <div class="col-md-9 col-xs-12 user-details">
            <div class="form-group">
              <label for="fullname" class="control-label">Nama Lengkap :</label><a class="miniButtonText" id="editFullname">Edit</a><a class='miniButtonText' id='saveEditFullname' onclick='saveName()' style="display: none;">Simpan</a><a class="miniButtonText" id="cancelEditFullname" style="display: none;">Batal</a>
              <p class="profile-view-only" id="fullname-setting"></p>
              <div id='form-fullname' style="display: none;">
                <div class='form-group'><input type='text' style='max-width: 50%;' id="fullname-input" class='form-control' placeholder='Nama Lengkap'></div>
              </div>
            </div>
            <div class="form-group">
              <label for="username" class="control-label">Username :</label>
              <p class="profile-view-only" id="username-setting"></p>
            </div>
            <div class="form-group">
              <label for="password" class="control-label">Password :</label>
              <p class="profile-view-only" id="passwordView">Some hashed text<a class="miniButtonText" id="editPassword">Edit</a></p>
              <div id="form-password" style="display: none;">
                <div class="form-group"><input type="password" style="max-width: 50%;" id="oldpass-input" class="form-control" placeholder="Password Lama" name=""></div>
                <div class="form-group"><input type="password" style="max-width: 50%;" id="newpass-input" class="form-control" placeholder="Password Baru" name=""></div>
                <div class="form-group"><input type="password" style="max-width: 50%;" id="retrypass-input" class="form-control" placeholder="Ulangi Password"></div>
                <button class="btn btn-primary btn-sm" id="saveEditPassword" onclick="savePassword()">Simpan</button>
                <button class="btn btn-link btn-sm" id="cancelEditPassword">Batal</button>
              </div>
            </div>
            <div class="form-group">
              <label for="goalInput" class="control-label">Goal :</label><a class="miniButtonText" id="editGoal">Edit</a><a class='miniButtonText' id='saveGoal' onclick="saveGoal()" style="display: none;">Simpan</a><a class="miniButtonText" id="cancelEditGoal" style="display: none;">Batal</a>
              <input type="number" class="form-control" id="goalInput" readonly>
            </div>
          </div>
        </div>
      </section>
    </main>
