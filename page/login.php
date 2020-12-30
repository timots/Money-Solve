<?php
$database = new Koneksi();
$koneksi = $database->dapetKoneksi();
$login = new Login($koneksi);
?>
<link href="main.css" rel="stylesheet" type="text/css" media="screen">

    <div class="container">
		

      <div class="row">
        <div class="col-xs-12">
          <div class="login-form">
            <div id="log-status">
              <?php echo $login->message ;?>
				
            </div>
            <form method="POST">
                <div class="form-group">
                  <input type="text" name="username" class="form-control" placeholder="Username">
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                  <button class="btn btn-primary btn-block" name="login" type="submit">Masuk</button>
                  <a class="btn btn-link btn-block" href="?p=register">Tidak punya akun? Daftar!</a>
                </div>
            </form>
          </div>
        </div>
      </div>
</div>
