<?php
  class Page{
    private $page;
    private $activePage = array('dashboard' => '', 'income' => '', 'outcome' => '', 'wishlist' => '', 'settings' => '');

    //Untuk memberikan nilai awal, agar lebih mudah saat Initiasinya
    public function __construct($getPage, $sessionStatus, $connectionStatus){
      if ($connectionStatus == FALSE) {
        $this->page = "error";
      }elseif (empty($getPage)) {
        if ($sessionStatus == TRUE) {
          header('location:?p=dashboard');
        }else{
          header('location:?p=login');
        }
      }elseif($getPage == "dashboard" || $getPage == "income" || $getPage == "outcome" || $getPage == "wishlist" || $getPage == "login" || $getPage == "register" || $getPage == "settings"){
        if ($sessionStatus == FALSE) {
          if ($getPage == "login" || $getPage == "register") {
            $this->page = $getPage;
          }else{
            $this->page = "nosession";
          }
        }elseif ($sessionStatus == TRUE) {
          if ($getPage == "login" || $getPage == "register") {
            $this->page = "sessiondetect";
          }else{
            $this->page = $getPage;
          }
        }
      }else{
        $this->page = "404";
      }
      return $this->page;
    }

    public function setTitle(){
      if ($this->page == "dashboard") {
        $title = "Dashboard - Nabung";
      }elseif ($this->page == "income") {
        $title = "Income - Nabung";
      }elseif ($this->page == "outcome") {
        $title = "Outcome - Nabung";
      }elseif ($this->page == "wishlist") {
        $title = "Wishlist - Nabung";
      }elseif ($this->page == "settings") {
        $title = "Pengaturan - Nabung";
      }elseif ($this->page == "error") {
        $title = "Terjadi Kesalahan! ";
      }elseif ($this->page == "login") {
        $title = "Login ke Nabung";
      }elseif ($this->page == "nosession") {
        $title = "No Session Detected";
      }elseif ($this->page == "sessiondetect") {
        $title = "Session Detected";
      }elseif ($this->page == "register") {
        $title = "Daftar Pengguna Baru";
      }else{
        $title = "404 Not Found";
      }
      return $title;
    }

    public function setPage(){
      if ($this->page == "dashboard") {
        include_once 'page/dashboard.php';
      }elseif($this->page == "income"){
        include_once 'page/income.php';
      }elseif($this->page == "outcome") {
        include_once 'page/outcome.php';
      }elseif($this->page == "wishlist"){
        include_once 'page/wishlist.php';
      }elseif($this->page == "settings"){
        include_once 'page/settings.php';
      }elseif ($this->page == "error") {
        include_once 'page/error.php';
      }elseif ($this->page == "login") {
        include_once 'page/login.php';
      }elseif ($this->page == "nosession") {
        include_once 'page/errorLogin.php';
      }elseif ($this->page == "sessiondetect") {
        include_once 'page/sessionDetected.php';
      }elseif ($this->page == "register") {
        include_once 'page/register.php';
      }else{
        include_once 'page/404.php';
      }
    }

    public function setSidebar(){
      if ($this->page == "dashboard" || $this->page == "income" || $this->page == "outcome" || $this->page == "wishlist" || $this->page == "settings") {
        include_once 'page/sidebar.php';
      }
    }

    public function setActive(){
      if ($this->page == "dashboard") {
        $this->activePage['dashboard'] = " class='active'";
      }elseif ($this->page == "income") {
        $this->activePage['income'] = " class='active'";
      }elseif ($this->page == "outcome") {
        $this->activePage['outcome'] = " class='active'";
      }elseif ($this->page == "wishlist") {
        $this->activePage['wishlist'] = " class='active'";
      }elseif ($this->page == "settings") {
        $this->activePage['settings'] = " class='active'";
      }
      return $this->activePage;
    }

    public function setLibrary(){
      if ($this->page == "income") {
        $library = "<script type='text/javascript' src='assets/original/js/ajax-income.js'></script>";
      }elseif ($this->page == "outcome") {
        $library = "<script type='text/javascript' src='assets/original/js/ajax-outcome.js'></script>";
      }elseif ($this->page == "wishlist") {
        $library = "<script type='text/javascript' src='assets/original/js/ajax-wishlist.js'></script>";
      }elseif ($this->page == "settings") {
        $library = "<script type='text/javascript' src='assets/original/js/settings.js'></script>";
      }elseif ($this->page == "dashboard") {
        $library = "<script type='text/javascript' src='assets/original/js/ajax-dashboard.js'></script>";
      }else{
        $library = "<!-- No Library Loaded -->";
      }
      return $library;
    }
  }
?>
