<?php
class Transaksi{
   private $conn = null;

   private $tableData;
   private $updateData;

   private $auth;

   private $message;
   private $eksekusi;
   private $action;

   public function __construct($connectionStatus,$sessionStatus){
      if ($sessionStatus == TRUE) {
         $this->conn = $connectionStatus;
         $this->auth = 1;

         //Income Request
         if (isset($_GET['readInc'])) {
           $this->action = "readIncome";
           $this->bacaIncome();
         }
         if (isset($_POST['addInc'])) {
           $this->action = "addIncome";
           $this->tambahIncome();
         }
         if (isset($_POST['delInc'])) {
           $this->action = "deleteIncome";
           $this->hapusIncome();
         }
         if (isset($_POST['getIncomeData'])) {
           $this->action = "getTheData";
           $this->getIncomeData();
         }
         if (isset($_POST['updateInc'])){
           $this->action = "saveTheData";
           $this->updateIncomeData();
         }

         //Outcome Request
         if(isset($_POST['addOut'])){
           $this->action = "addOutcome";
           $this->tambahOutcome();
         }
         if (isset($_GET['readOut'])) {
           $this->action = "readOutcome";
           $this->bacaOutcome();
         }
         if (isset($_POST['delOut'])) {
           $this->action = "deleteOutcome";
           $this->deleteOutcome();
         }
         if (isset($_POST['getOutcomeData'])) {
           $this->action = "getOutData";
           $this->getOutcomeData();
         }
         if (isset($_POST['updateOut'])) {
           $this->action = "saveOutData";
           $this->updateOutcomeData();
         }
      }else{
         $this->auth = 0;
      }
   }

/*
   =======================
      Income Method
   =======================
*/

   private function tambahIncome(){
      if (empty($_POST['income_from']) || empty($_POST['income_value'])) {
         $this->eksekusi = 0;
         $this->message = "Data tidak boleh kosong!";
      }else{
         try {
            $query = $this->conn->prepare("INSERT INTO income(income_from,income_date,income_value,user_id) VALUES(:income_from,:income_date,:income_value,:user_id)");
            $data = array(
              ':income_from' => $_POST['income_from'],
              ':income_date' => date("Y-m-d"),
              ':income_value' => $_POST['income_value'],
              ':user_id' => $_SESSION['id']
              );
            $query->execute($data);
            $this->eksekusi = 1;
            $this->message = "Data berhasil disimpan";
         } catch (PDOException $e) {
            $this->eksekusi = 0;
            $this->message = "Terjadi kesalahan saat menyimpan data. ".$e->getMessage();
         }
      }
   }

  private function bacaIncome(){
  	if (empty($_GET['income_date'])){
  		$this->tableData = "<p class='text-center'>Anda belum memilih tanggal !</p>";
  	}else{
  		try {
  		  //Untuk menghitung range bulan
        $getDate = explode('-',$_GET['income_date']);
        $tahun = $getDate['0'];
        $bulan = $getDate['1'];
        $jumlahTanggal = cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);
        $first = array($tahun,$bulan,'01');
        $last = array($tahun,$bulan,$jumlahTanggal);
        $resultFirstDate = implode("-",$first);
        $resultLastDate = implode("-",$last);

        //Pagination Bagian 1
        $batasData = 5;
        if(empty($_GET['hal'])){
          $halamanIni = 1;
        }else{
          $halamanIni = $_GET['hal'];
        }
        $posisi = (($halamanIni - 1)*$batasData);

  		  //Jika searchbar berisi, maka akan menampilkan hasil pencarian. Jika tidak, maka akan menampilkan semua data dibulan itu
        if (isset($_GET['searchInc'])) {
          $serch = "%{$_GET['searchInc']}%";
        //No Limit
          $queryJumlahData = $this->conn->prepare("SELECT * FROM income WHERE user_id = :user_id AND income_date BETWEEN :income_date_first AND :income_date_last AND (income_from LIKE :findText OR income_date LIKE :findText OR income_value LIKE :findText)");
          $queryJumlahData->bindParam(':user_id', $_SESSION['id']);
          $queryJumlahData->bindParam(':findText', $serch);
          $queryJumlahData->bindParam(':income_date_first', $resultFirstDate);
          $queryJumlahData->bindParam(':income_date_last', $resultLastDate);

        //With Limit
          $query = $this->conn->prepare("SELECT * FROM income WHERE user_id = :user_id AND income_date BETWEEN :income_date_first AND :income_date_last AND (income_from LIKE :findText OR income_date LIKE :findText OR income_value LIKE :findText) ORDER BY income_date ASC LIMIT :posisi, :batasData");
          $query->bindParam(':user_id', $_SESSION['id']);
          $query->bindParam(':findText', $serch);
          $query->bindParam(':income_date_first', $resultFirstDate);
          $query->bindParam(':income_date_last', $resultLastDate);
          $query->bindParam(':posisi', $posisi, PDO::PARAM_INT);
          $query->bindParam(':batasData', $batasData, PDO::PARAM_INT);
        }else{
        //No Limit
          $queryJumlahData = $this->conn->prepare("SELECT * FROM income WHERE user_id = :user_id AND income_date BETWEEN :income_date_first AND :income_date_last");
          $queryJumlahData->bindParam(':user_id', $_SESSION['id']);
          $queryJumlahData->bindParam(':income_date_first', $resultFirstDate);
          $queryJumlahData->bindParam(':income_date_last', $resultLastDate);

              //With Limit
          $query = $this->conn->prepare("SELECT * FROM income WHERE user_id = :user_id AND income_date BETWEEN :income_date_first AND :income_date_last ORDER BY income_date ASC LIMIT :posisi, :batasData");
          $query->bindParam(':user_id', $_SESSION['id']);
          $query->bindParam(':income_date_first', $resultFirstDate);
          $query->bindParam(':income_date_last', $resultLastDate);
          $query->bindParam(':posisi', $posisi, PDO::PARAM_INT);
          $query->bindParam(':batasData', $batasData, PDO::PARAM_INT);
        }

        $query->execute();
        $queryJumlahData->execute();

        //Hitung jumlah data pada page itu
        $jumlahDataShow = $query->rowCount();

        //Pagination Bagian 2
        $jumlahData = $queryJumlahData->rowCount();
        $jumlahPage = ceil($jumlahData/$batasData);

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
          $incomeData[] = $row;
        }

        if (empty($incomeData)) {
          $this->tableData = "<div class='alert alert-warning'><p class='text-center'><i class='fa fa-fw fa-warning'></i>&nbsp;Tidak ditemukan</p></div>";
        }else{
  			//Hitung total bulan ini
         $query2 = $this->conn->prepare("SELECT SUM(income_value) AS total FROM income WHERE user_id = :user_id AND income_date BETWEEN :income_date_first AND :income_date_last");
         $data2 = array(
          ':user_id' => $_SESSION['id'],
          ':income_date_first' => $_GET['income_date']."-01",
          ':income_date_last' => $_GET['income_date']."-".$jumlahTanggal
          );
         $query2->execute($data2);
         $total = $query2->fetch(PDO::FETCH_ASSOC);

        /*
        ** Bagian Pagination
        */

        $tableData = "<div class='text-left'>";
        $tableData .= "<ul class='pagination'>";
        if($halamanIni < 2){
          $tableData .= "<li class='disabled'><a href='#'>&laquo;</a></li>";
        }else{
          $tableData .= "<li><a href='#' onclick='loadIncome(".($halamanIni - 1).")'>&laquo;</a></li>";
        }

        //Pagination active class
        $activePagin = array();
        for ($i=1; $i <= $jumlahPage; $i++) {
          $activePagin[$i] = $i;
          if ($halamanIni == $activePagin[$i]) {
            $activePagin[$i] = "class='active'";
          }else{
            $activePagin[$i] = "";
          }
        }

        //Menetukan dimulai dari mana
        $position = $halamanIni;
        $selisihPos = $jumlahPage - $halamanIni;

        //Pejwan
        if ($position == 1) {
          $startFrom = $position;
          if($selisihPos < 2){
            $endTo = $position + $selisihPos;
          }else{
            $endTo = $position + 2;
          }
        }
        //Pejlas
        elseif ($position == $jumlahPage) {
          if(($position - 2) < 1){
            $startFrom = $position - 1;
          }else{
            $startFrom = $position - 2;
          }
          $endTo = $position;
        }
        //Tengah - tengah
        else{
          $startFrom = $position - 1;
          $endTo = $position + 1;
        }

        for($i=$startFrom; $i <= $endTo; $i++){
          $tableData .= "
          <li ".$activePagin[$i]."><a href='#' onclick='loadIncome(".$i.")'>".$i."</a></li>
          ";
        }

        if(($jumlahPage - $halamanIni) < 1){
          $tableData .= "<li class='disabled'><a href='#'>&raquo</a></li>";
        }else{
          $tableData .= "<li><a href='#' onclick='loadIncome(".($halamanIni + 1).")'>&raquo</a></li>";
        }
        $tableData .= "</ul>";
        $tableData .= "</div>";

        /*
        ** Tabel Data
        */

        //Data Tabel
        $tableData .= "<table class='table table-bordered'>";
        $tableData .= "<thead>";
        $tableData .= "
        <tr>
         <th class='colNo'>No.</th>
         <th class='colFor'>Asal</th>
         <th class='colDate'>Tanggal</th>
         <th class='colValue'>Nominal</th>
         <th class='colAct'>Aksi</th>
       </tr>";
       $tableData .= "</thead>";
       $tableData .= "<tbody>";

        //Penomoran dimulai
       $no = $posisi + 1;
       foreach ($incomeData as $data) {
        $tableData .= "
        <tr>
         <td class='text-center'>".$no++."</td>
         <td>".$data['income_from']."</td>
         <td>".$data['income_date']."</td>
         <td>".$data['income_value']."</td>
         <td class='text-center'>
           <button class='btn btn-default btn-sm' onclick='getIncomeData(".$data['income_id'].")'><i class='fa fa-fw fa-edit'></i>Edit</button>
           <button class='btn btn-danger btn-sm' onclick='delIncome(".$data['income_id'].")'><i class='fa fa-fw fa-remove'></i>Delete</button>
         </td>
       </tr>";
     }
     $tableData .= "</tbody>";
     $tableData .= "</table>";
     $tableData .= "<div class='status-jumlah'><p>Pendapatan bulan ini : Rp ".$total['total']."</p></div>";
     $tableData .= "<p class='hidden' id='disPage'>".$halamanIni."</p>";
     $tableData .= "<p class='hidden' id='disCount'>".$jumlahDataShow."</p>";
     $this->tableData = $tableData;
   }
     }catch (PDOException $e) {
      $this->tableData = "Kesalahan terjadi : ".$e->getMessage();
    }
    }
    return $this->tableData;
    }

  private function hapusIncome(){
    if (empty($_POST['income_id'])) {
      $this->eksekusi = 0;
      $this->message = "ID Tidak Ditemukan";
    }else{
      try {
        $query = $this->conn->prepare("DELETE FROM income WHERE income_id = :income_id");
        $data = array(
          ':income_id' => $_POST['income_id']
          );
        $query->execute($data);
        $this->eksekusi = 1;
        $this->message = "Data berhasil dihapus";
      } catch (PDOException $e) {
        $this->eksekusi = 0;
        $this->message = "Data tidak bisa dihapus : ".$e->getMessage();
      }
    }
  }

private function getIncomeData(){
  try {
    $query = $this->conn->prepare("SELECT * FROM income WHERE income_id = :income_id AND user_id = :user_id");
    $data = array(
      ':income_id' => $_POST['income_id'],
      ':user_id' => $_SESSION['id']
      );
    $query->execute($data);

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      $incomeData = $row;
    }
    $this->updateData = $incomeData;
  } catch (PDOException $e) {
    $this->message = "Kesalahan Terjadi : ".$e->getMessage();
  }
}

private function updateIncomeData(){
  if(empty($_POST['upIncFrom']) && empty($_POST['upIncValue'])){
    $this->message = "Data tidak boleh kosong!";
    $this->eksekusi = 0;
  }else{
    try{
     $query = $this->conn->prepare("UPDATE income SET income_from = :income_from, income_value = :income_value WHERE income_id = :income_id");
     $data = array(
      ':income_id'	=> $_POST['upIncID'],
      ':income_from' 	=> $_POST['upIncFrom'],
      ':income_value' => $_POST['upIncValue']
      );
     $query->execute($data);
     $this->message = "Data berhasil diupdate!";
     $this->eksekusi = 1;
   }catch(PDOException $e){
     $this->message = "Data gagal diupdate : ".$e->getMessage();
     $this->eksekusi = 0;
   }
 }
}

/*
 ========================
    Outcome Method
 ========================
*/

 private function tambahOutcome(){
  $outcome_for = $_POST['outcome_for'];
  $outcome_value = $_POST['outcome_value'];
  if (empty($outcome_for) || empty($outcome_value)) {
    $this->message = "Data tidak boleh kosong";
    $this->eksekusi = 0;
  }else{
    try{
      $query = $this->conn->prepare("INSERT INTO outcome(user_id, outcome_for, outcome_date, outcome_value) VALUES(:user_id, :outcome_for, :outcome_date, :outcome_value)");
      $query->bindParam(':user_id', $_SESSION['id']);
      $query->bindParam(':outcome_for', $outcome_for);
      $query->bindParam(':outcome_date', date('Y-m-d'));
      $query->bindParam(':outcome_value', $outcome_value);
      $query->execute();

      $this->message = "Data Berhasil Disimpan !";
      $this->eksekusi = 1;
    }catch(PDOException $e){
      $this->message = "Data gagal disimpan : ".$e->getMessage();
      $this->eksekusi = 0;
    }
  }
 }

private function bacaOutcome(){
  if (empty($_GET['outcome_date'])) {
    $this->tableData = "<p class='text-center'><i class='fa fa-fw fa-warning'></i>&nbsp;Anda harus memilih tanggal !</p>";
  }else{
    $firstDate = $this->getFirstDate($_GET['outcome_date']);
    $lastDate = $this->getLastDate($_GET['outcome_date']);
    try{
        //Paginasi
      $batasData = 5;
      if (empty($_GET['hal'])) {
        $hal = 1;
      }else{
        $hal = $_GET['hal'];
      }
      $posisi = (($hal - 1)*$batasData);

        //Pencarian dan List
      if (isset($_GET['searchOut'])) {
        $searchText = "%{$_GET['searchOut']}%";

        $countData = $this->conn->prepare("SELECT * FROM outcome WHERE user_id = :user_id AND outcome_date BETWEEN :outcome_date_first AND :outcome_date_last AND (outcome_for LIKE :searchText OR outcome_date LIKE :searchText OR outcome_value LIKE :searchText) ORDER BY outcome_date ASC");
        $countData->bindParam(':user_id', $_SESSION['id']);
        $countData->bindParam(':outcome_date_first', $firstDate);
        $countData->bindParam(':outcome_date_last', $lastDate);
        $countData->bindParam(':searchText', $searchText);

        $query = $this->conn->prepare("SELECT * FROM outcome WHERE user_id = :user_id AND outcome_date BETWEEN :outcome_date_first AND :outcome_date_last AND (outcome_for LIKE :searchText OR outcome_date LIKE :searchText OR outcome_value LIKE :searchText) ORDER BY outcome_date ASC LIMIT :posisi, :batasData");
        $query->bindParam(':user_id', $_SESSION['id']);
        $query->bindParam(':outcome_date_first', $firstDate);
        $query->bindParam(':outcome_date_last', $lastDate);
        $query->bindParam(':searchText', $searchText);
        $query->bindParam(':posisi', $posisi, PDO::PARAM_INT);
        $query->bindParam(':batasData', $batasData, PDO::PARAM_INT);

      }else{
        $countData = $this->conn->prepare("SELECT * FROM outcome WHERE user_id = :user_id AND outcome_date BETWEEN :outcome_date_first AND :outcome_date_last ORDER BY outcome_date ASC");
        $countData->bindParam(':user_id', $_SESSION['id']);
        $countData->bindParam(':outcome_date_first', $firstDate);
        $countData->bindParam(':outcome_date_last', $lastDate);

        $query = $this->conn->prepare("SELECT * FROM outcome WHERE user_id = :user_id AND outcome_date BETWEEN :outcome_date_first AND :outcome_date_last ORDER BY outcome_date ASC LIMIT :posisi, :batasData");
        $query->bindParam(':user_id', $_SESSION['id']);
        $query->bindParam(':outcome_date_first', $firstDate);
        $query->bindParam(':outcome_date_last', $lastDate);
        $query->bindParam(':posisi', $posisi, PDO::PARAM_INT);
        $query->bindParam(':batasData', $batasData, PDO::PARAM_INT);
      }

        //Execute dat query
      $query->execute();
      $countData->execute();


        //Cek jumlah data pada halaman tersebut
      $disPageDataCount = $query->rowCount();

        //Cek jumlah data secara global dan mengubahnya menjadi jumlah page
      $dataCount = $countData->rowCount();
      $pageCount = ceil($dataCount/$batasData);

        //Ubah data dari database menjadi array
      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $outcomeData[] = $row;
      }

      if (empty($outcomeData)) {
        $this->tableData = "<div class='alert alert-warning'><p class='text-center'><i class='fa fa-fw fa-warning'></i>&nbsp;Tidak ditemukan</p></div>";
      }else{
          //Hitung total bulan yang dipilih
        $datMonthDataCount = $this->conn->prepare("SELECT SUM(outcome_value) AS total FROM outcome WHERE user_id = :user_id AND outcome_date BETWEEN :outcome_date_first AND :outcome_date_last");
        $datMonthDataCount->bindParam(':user_id', $_SESSION['id']);
        $datMonthDataCount->bindParam(':outcome_date_first', $firstDate);
        $datMonthDataCount->bindParam(':outcome_date_last', $lastDate);
        $datMonthDataCount->execute();

        $total = $datMonthDataCount->fetch(PDO::FETCH_ASSOC);

          //Paginasi Dimulai..
        $tableData  = "<div class='text-left'>";
        $tableData .= "<ul class='pagination'>";
        if ($hal < 2) {
          $tableData .= "<li class='disabled'><a href='#'>&laquo;</a></li>";
        }else{
          $tableData .= "<li><a href='#' onclick='loadOutcome(".($hal - 1).")'>&laquo;</a></li>";
        }

          //Menentukan starting point dari pagination
        $position = $hal;
        $selisihPos = $pageCount - $position;

          //Page yang aktif
        $activePagin = array();
        for ($i = 1; $i <= $pageCount; $i++) {
          $activePagin[$i] = $i;
          if ($position == $activePagin[$i]) {
            $activePagin[$i] = "class = 'active'";
          }else{
            $activePagin[$i] = "";
          }
        }

          //Pejwan
        if ($position == 1) {
          $startFrom = $position;
          if ($selisihPos < 2) {
            $endTo = $position + $selisihPos;
          }else{
            $endTo = $position + 2;
          }
        }
          //Pejlas
        elseif ($position == $pageCount) {
          if (($position - 2) < 1) {
            $startFrom = $position - 1;
          }else{
            $startFrom = $position - 2;
          }
          $endTo = $position;
        }
        else{
          $startFrom = $position - 1;
          $endTo = $position + 1;
        }

        for ($i = $startFrom; $i <= $endTo ; $i++) {
          $tableData .= "<li ".$activePagin[$i]."><a href='#' onclick='loadOutcome(".$i.")'>".$i."</a></li>";
        }

        if (($pageCount - $position) < 1) {
          $tableData .= "<li class='disabled'><a href='#'>&raquo</a></li>";
        }else{
          $tableData .= "<li><a href='#' onclick='loadOutcome(".($hal + 1).")'>&raquo;</a></li>";
        }
        $tableData .= "</ul>";
        $tableData .= "</div>";

          //Tabel data
        $tableData .= "<table class='table table-bordered'>";
        $tableData .= "<thead>";
        $tableData .= "
        <tr>
          <th class='colNo'>No.</th>
          <th class='colFor'>Untuk</th>
          <th class='colDate'>Tanggal</th>
          <th class='colValue'>Nominal</th>
          <th class='colAct'>Aksi</th>
        </tr>";
        $tableData .= "</thead>";
        $tableData .= "<tbody>";

          //isinya
        $no = $posisi + 1;
        foreach ($outcomeData as $data) {
          $tableData .= "
          <tr>
            <td class='text-center'>".$no++."</td>
            <td>".$data['outcome_for']."</td>
            <td>".$data['outcome_date']."</td>
            <td>".$data['outcome_value']."</td>
            <td class='text-center'>
              <button class='btn btn-default btn-sm' onclick='getOutcomeData(".$data['outcome_id'].")'><i class='fa fa-fw fa-edit'></i>Edit</button>
              <button class='btn btn-danger btn-sm' onclick='delOutcome(".$data['outcome_id'].")'><i class='fa fa-fw fa-remove'></i>Delete</button>
            </td>
          </tr>
          ";
        }
        $tableData .= "</tbody>";
        $tableData .= "</table>";
        $tableData .= "<div class='status-jumlah'><p>Pengeluaran bulan ini : Rp ".$total['total']."</p></div>";
        $tableData .= "<p class='hidden' id='disPage'>".$hal."</p>";
        $tableData .= "<p class='hidden' id='disCount'>".$disPageDataCount."</p>";

        $this->tableData = $tableData;
      }
    }catch(PDOException $e){
      $this->tableData = "Kesalahan terjadi : ".$e->getMessage();
    }
  }
}
private function deleteOutcome(){
  if (empty($_POST['outcome_id'])) {
    $this->eksekusi = 0;
    $this->message = "ID Tidak Ditemukan";
  }else{
    try {
      $query = $this->conn->prepare("DELETE FROM outcome WHERE outcome_id = :outcome_id AND user_id = :user_id");
      $query->bindParam(':user_id', $_SESSION['id']);
      $query->bindParam(':outcome_id', $_POST['outcome_id']);
      $query->execute();

      $this->eksekusi = 1;
      $this->message = "Data berhasil dihapus";
    } catch (PDOException $e) {
      $this->eksekusi = 0;
      $this->message = "Terjadi kesalahan : ".$e->getMessage();
    }
  }
}
private function getOutcomeData(){
  try {
    $query = $this->conn->prepare("SELECT * FROM outcome WHERE user_id = :user_id AND outcome_id = :outcome_id");
    $query->bindParam(':user_id', $_SESSION['id']);
    $query->bindParam(':outcome_id', $_POST['outcome_id']);
    $query->execute();

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      $outcomeData = $row;
    }

    $this->updateData = $outcomeData;
  } catch (PDOException $e) {
    $this->message = "Kesalahan terjadi : ".$e->getMessage();
  }
}
private function updateOutcomeData(){
  if (empty($_POST['upOutID']) || empty($_POST['upOutFor']) || empty($_POST['upOutVal'])) {
    $this->message = "Tidak boleh kosong!";
  }else{
    $outID = $_POST['upOutID'];
    $outFor = $_POST['upOutFor'];
    $outVal = $_POST['upOutVal'];
    try {
      $query = $this->conn->prepare("UPDATE outcome SET outcome_for = :outcome_for, outcome_value = :outcome_value WHERE user_id = :user_id AND outcome_id = :outcome_id");
      $query->bindParam(':outcome_for', $outFor);
      $query->bindParam(':outcome_value', $outVal);
      $query->bindParam(':user_id', $_SESSION['id']);
      $query->bindParam(':outcome_id', $outID);

      $query->execute();
      $this->message = "Data berhasil diupdate !";
      $this->eksekusi = 1;
    } catch (PDOException $e) {
      $this->message = "Data gagal diupdate : ".$e->getMessage();
      $this->eksekusi = 0;
    }
  }
}

/*
 ========================
  Other Method
 ========================
*/
private function getFirstDate($month){
   $getDate = explode('-', $month);
  $tahun = $getDate['0'];
  $bulan = $getDate['1'];
  $jumlahTanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
  $first = array($tahun, $bulan,'01');
  $resultFirstDate = implode('-', $first);

  return $resultFirstDate;
}

private function getLastDate($month){
  $getDate = explode('-', $month);
  $tahun = $getDate['0'];
  $bulan = $getDate['1'];
  $jumlahTanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
  $last = array($tahun, $bulan, $jumlahTanggal);
  $resultLastDate = implode('-', $last);

  return $resultLastDate;
}

/*
 ========================
    Response Method
 ========================
*/

 public function response(){
  $response = array();
  if ($this->auth == 0) {
    $response['message'] = "Access Denied !";
    return json_encode($response);
  }else{
    if ($this->action == null) {
      $response['message'] = "Menunggu sebuah jawaban...";
      return json_encode($response);
    }

      //Result Income
    elseif ($this->action == "addIncome") {
      $response['message'] = $this->message;
      $response['execute'] = $this->eksekusi;
      return json_encode($response);
    }
    elseif ($this->action == "deleteIncome") {
      $response['message'] = $this->message;
      $response['execute'] = $this->eksekusi;
      return json_encode($response);
    }
    elseif ($this->action == "saveTheData"){
      $response['message'] = $this->message;
      $response['execute'] = $this->eksekusi;
      return json_encode($response);
    }
    elseif ($this->action == "getTheData") {
      return json_encode($this->updateData);
    }
    elseif ($this->action == "readIncome") {
      return $this->tableData;
    }

      //Result Outcome
    elseif ($this->action == "addOutcome") {
      $response['message'] = $this->message;
      $response['execute'] = $this->eksekusi;
      return json_encode($response);
    }elseif ($this->action == "readOutcome") {
      return $this->tableData;
    }elseif($this->action == "deleteOutcome"){
      $response['message'] = $this->message;
      $response['execute'] = $this->eksekusi;
      return json_encode($response);
    }elseif ($this->action == "getOutData") {
      return json_encode($this->updateData);
    }elseif ($this->action == "saveOutData") {
      $response['message'] = $this->message;
      $response['execute'] = $this->eksekusi;
      return json_encode($response);
    }
  }
}
}
?>
