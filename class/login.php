<?php
class Login{
  private $conn = null;

  public $message = "";

  public function __construct($koneksi){
    $this->conn = $koneksi;

    if (session_id() == null) {
      session_start();
    }

    if (isset($_GET['logout'])) {
      $this->Logout();
    }
    if (isset($_POST['login'])) {
      $this->Login();
    }
    if (isset($_POST['register'])) {
      $this->register();
    }
  }

  private function Login(){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $this->conn->prepare("SELECT * FROM user WHERE username = :username");
    $auth = array(':username' => $username);
    $query->execute($auth);

    $jumlah = $query->rowCount();
    $userData = $query->fetch();

    if ($jumlah == 1) {
      if (password_verify($password, $userData['password'])) {
        $_SESSION['status'] = 1;
        $_SESSION['id'] = $userData['user_id'];
        $_SESSION['username'] = $userData['username'];

        header('location:?p=dashboard');
      }else{
        $this->message = "<div class='alert alert-warning alert-dismissable'><button class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><i class='fa fa-fw fa-warning'></i>&nbsp;Username / Password salah</div>";
      }
    }else{
      $this->message = "<div class='alert alert-warning alert-dismissable'><button class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><i class='fa fa-fw fa-warning'></i>&nbsp;Username tidak ditemukan</div>";
    }
  }

  private function Register(){
    if (empty($_POST['regusername']) || empty($_POST['regpassword'])) {
      $this->message = "<div class='alert alert-warning alert-dismissable'><button class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><i class='fa fa-fw fa-warning'></i>&nbsp;Tidak boleh kosong!</div>";
    }else{
      $username = $_POST['regusername'];
      $password = password_hash($_POST['regpassword'], PASSWORD_DEFAULT);
      $fullname = $_POST['fullname'];

      try {
        $query = $this->conn->prepare("SELECT * FROM user WHERE username = :username");
        $query->bindParam(':username', $username);
        $query->execute();

        if ($query->rowCount() > 0) {
          $this->message = "<div class='alert alert-warning alert-dismissable'><button class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><i class='fa fa-fw fa-warning'></i>&nbsp;Username sudah terpakai</div>";
        }else{
          $addUser = $this->conn->prepare("INSERT INTO user(username, password, fullname) VALUES(:username, :password, :fullname)");
          $addUser->bindParam(':username', $username);
          $addUser->bindParam(':password', $password);
          $addUser->bindParam(':fullname', $fullname);
          $addUser->execute();

          header('location:?login');
        }
      } catch (PDOException $e) {
        $this->message = "Terjadi kesalahan : ".$e->getMessage();
      }
    }
  }

  public function sessionCheck(){
    if (isset($_SESSION['status'])) {
      return TRUE;
    }else{
      return FALSE;
    }
  }

  private function Logout(){
    session_unset();
    session_destroy();
    header('location?p=login');
  }
}
?>
