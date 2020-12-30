// TODO: Langsung menampilkan tanggal sekarang (auto show)
function init(){
  var today = new Date();
  var bulan = today.getMonth() + 1;
  var tahun = today.getFullYear();

  var date = tahun+"-"+bulan;

  $("#incShowDate").val(date);
  loadIncome(1);
}

$("#addIncome").click(function () {
  var income_from = $("#incDari").val();
  var income_value = $("#incValue").val();
  var page = $("#disPage").text();

  $.post("page/response.php",{
    addInc: true,
    income_from: income_from,
    income_value: income_value
  }, function(data, status){
    var response = JSON.parse(data);
    if (response.execute == 1) {
      alert(response.message);
      $("#incDari").val("");
      $("#incValue").val("");
    	if($("#incShowDate").val() != ""){
    	  loadIncome(page);
    	}
      $("#modal-addinc").modal("hide");
      initGlob();
    }else{
      alert(response.message);
    }
  });
});

function getIncomeData(id){
  $.post("page/response.php",{
    income_id: id,
    getIncomeData: 1
  },function(data){
    var incData = JSON.parse(data);
	  $("#idInc").val(incData.income_id);
      $("#editFromInc").val(incData.income_from);
      $("#editValueInc").val(incData.income_value);
    $("#modal-editinc").modal("show");
  });

}

function updateIncomeData(){
	var income_id = $("#idInc").val();
	var income_from = $("#editFromInc").val();
	var income_value = $("#editValueInc").val();
    var page = $("#disPage").text();

  $.post("page/response.php",{
	upIncID: income_id,
	upIncFrom: income_from,
	upIncValue: income_value,
	updateInc: 1
  },function(data){
	var response = JSON.parse(data);
		if(response.execute == 1){
			alert(response.message);
			$("#modal-editinc").modal("hide");
            loadIncome(page);
            initGlob();
		}else{
			alert(response.message);
		}
  });
}

function delIncome(id){
  var bool = confirm("Anda yakin ingin menghapus ini?");
  var page = $("#disPage").text();
  var pageData = $("#disCount").text();

  if(bool == true){
	  $.post("page/response.php",{
		delInc: 1,
		income_id: id
	  }, function(data){
		var response = JSON.parse(data);
		if (response.execute == 1) {
		  alert(response.message);
        if(pageData == 1){
          loadIncome(parseInt(page) - 1);
        }else{
          loadIncome(page);
        }
        initGlob();
		}else{
		  alert(response.message);
		}
	  });
  }
}

function loadIncome(pagination) {
  var date2show = $("#incShowDate").val();
  var text2find = $("#findText").val();

  if(date2show == ""){
	$("#findText").attr("disabled",1);
	$("#alertNotShow").fadeIn(300, function(){
		$("#alertNotShow").delay(1000).fadeOut(300);
	});
	$("#tableIncome").html("");
  }else{
	  $("#findText").removeAttr("disabled");
      if(text2find == ""){
          $.get("page/response.php",{
            readInc:1,
            income_date: date2show,
            hal: pagination
          }, function(data) {
            $("#tableIncome").html(data);
          });
      }else{
          $.get("page/response.php",{
            income_date: date2show,
            searchInc: text2find,
            hal: pagination,
            readInc: 1
          }, function(data) {
            $("#tableIncome").html(data);
          });
      }
  }
}

$(document).ready(function() {
  init();
});
