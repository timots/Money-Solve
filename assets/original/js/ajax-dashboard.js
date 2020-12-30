function init(){
  $.get("page/rsettings.php",{
    act: "fetchData"
  }, function(data) {
      var user = JSON.parse(data);
      $("#saldo").text(user.saldo);
      $("#incNow").text(user.income);
      $("#outNow").text(user.outcome);
  });
}

function date(){
  var hari_indo = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
  var bulan_indo = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

  var date = new Date();
  var tahun = date.getFullYear();
  var bulan = date.getMonth();
  var hari = date.getDay();
  var tanggal = date.getDate();

  for (var j = 0; j < hari_indo.length; j++) {
    if (hari == hari_indo.indexOf(hari_indo[j])) {
      hari = hari_indo[j];
    }
  }

  for (var i = 0; i < bulan_indo.length; i++) {
    if (bulan == bulan_indo.indexOf(bulan_indo[i])) {
      bulan = bulan_indo[i];
    }
  }
  
  var join = hari+", "+tanggal+" "+bulan+" "+tahun;

  console.log(join);
}

$(document).ready(function(){
  init();
  date();
});
