<?php
$database = new Koneksi();
$koneksi = $database->dapetKoneksi();

$login = new Login($koneksi);
$user = new User($koneksi, $login->sessionCheck(), $_SESSION['id']);
$halamannya = new Page($_GET['p'],$login->sessionCheck(),$koneksi);
$activePage = $halamannya->setActive();
?>
    <aside class="main-sidebar">
        <div class="user-profile">
            <img src="upload/user-default.png" class="img-responsive img-circle" id="profile-pict">
            <div class="profile-status">
                <h5 id="profile-name"><?php echo $user->name ?></h5>
                <h6 id="profile-balance"></h6>
            </div>
        </div>
        <hr/>
      <ul class="nav nav-pills nav-stacked">
        <li<?php echo $activePage['dashboard'] ;?>><a href="?p=dashboard"><i class="fa fa-fw fa-dashboard"></i>&nbsp; Dashboard</a></li>
        <li<?php echo $activePage['income'] ;?>><a href="?p=income"><i class="fa fa-fw fa-arrow-circle-o-down"></i>&nbsp; Income</a></li>
        <li<?php echo $activePage['outcome'] ;?>><a href="?p=outcome"><i class="fa fa-fw fa-arrow-circle-o-up"></i>&nbsp; Outcome</a></li>
        <li<?php echo $activePage['wishlist'] ;?>><a href="?p=wishlist"><i class="fa fa-fw fa-shopping-cart"></i>&nbsp; Wishlist</a></li>
        <li class="spacer"><hr></li>
        <li<?php echo $activePage['settings'] ;?>><a href="?p=settings"><i class="fa fa-fw fa-cog"></i>&nbsp; Settings</a></li>
        <li><a href="#" data-toggle="modal" data-target="#confirmation"><i class="fa fa-fw fa-sign-out"></i>&nbsp; Logout</a></li>
      </ul>
    </aside>
