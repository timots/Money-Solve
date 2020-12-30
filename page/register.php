<?php
$database = new Koneksi();
$koneksi = $database->dapetKoneksi();
$login = new Login($koneksi);
?>
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <div class="login-form">
            <div id="log-status">
              <?php echo $login->message ;?>
            </div>
            <form method="POST">
                <div class="form-group">
                  <input type="text" name="fullname" class="form-control" placeholder="Full Name">
                </div>
                <div class="form-group">
                  <input type="text" name="regusername" class="form-control" placeholder="Username">
                </div>
                <div class="form-group">
                  <input type="password" name="regpassword" class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                  <button class="btn btn-danger btn-block" name="register" type="submit">Daftar</button>
                  <a class="btn btn-link btn-block" href="?p=login">Punya akun? Kembali ke Login!</a>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>