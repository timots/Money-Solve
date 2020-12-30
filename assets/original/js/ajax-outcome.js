// TODO: Langsung menampilkan tanggal sekarang (auto show)
function init(){
	var today = new Date();
	var bulan = today.getMonth() + 1;
	var tahun = today.getFullYear();

	var date = tahun+"-"+bulan;

	$("#outShowDate").val(date);
	loadOutcome(1);
}

$("#addOutcome").click(function(){
	var outcome_for = $("#outUntuk").val();
	var outcome_value = $("#outValue").val();
	var page = $("#disPage").text();

	$.post("page/response.php",{
		addOut: true,
		outcome_for: outcome_for,
		outcome_value: outcome_value
	},function(data){
		var response = JSON.parse(data);
		if (response.execute == 1) {
			alert(response.message);
			$("#outUntuk").val("");
			$("#outValue").val("");
			if ($("#outShowDate").val() != "") {
				loadOutcome(page);
			}
			$("#modal-addout").modal("hide");
			initGlob();
		}else{
			alert(response.message);
		}
	});
});

function delOutcome(id){
	var bool = confirm("Apakah anda yakin ingin menghapus ini?");
	var page = $("#disPage").text();
	var pageData = $("#disCount").text();

	if (bool == true) {
		$.post("page/response.php",{
			delOut: 1,
			outcome_id: id
		}, function(data){
			var response = JSON.parse(data);
			if (response.execute == 1) {
				alert(response.message);
				if (pageData == 1) {
					loadOutcome(parseInt(page)-1);
				}else{
					loadOutcome(page);
				}
				initGlob();
			}else{
				alert(response.message);
			}
		});
	}
}

function getOutcomeData(id){
	$.post("page/response.php",{
		outcome_id: id,
		getOutcomeData: 1
	},function(data){
		var outData = JSON.parse(data);
		$("#idOut").val(outData.outcome_id);
		$("#editForOut").val(outData.outcome_for);
		$("#editValueOut").val(outData.outcome_value);
		$("#modal-editout").modal("show");
	});
}

function updateOutcomeData(){
	var outcome_id = $("#idOut").val();
	var outcome_for = $("#editForOut").val();
	var outcome_value = $("#editValueOut").val();
	var page = $("#disPage").text();

	$.post("page/response.php",{
		upOutID: outcome_id,
		upOutFor: outcome_for,
		upOutVal: outcome_value,
		updateOut: 1
	},function(data){
		var response = JSON.parse(data);
		if (response.execute == 1) {
			alert(response.message);
			$("#modal-editout").modal("hide");
			loadOutcome(page);
			initGlob();
		}else{
			alert(response.message);
		}
	});
}

function loadOutcome(page){
	var date2show = $("#outShowDate").val();
	var text2find = $("#outFindText").val();

	if (date2show == "") {
		$("#outFindText").attr("disabled", 1);
		$("#alertNotShow").fadeIn(300, function(){
			$("#alertNotShow").delay(1000).fadeOut(300);
		});
		$("#tableOutcome").html("");
	}else{
		$("#outFindText").removeAttr("disabled");
		if (text2find == "") {
			$.get("page/response.php",{
				readOut: 1,
				outcome_date: date2show,
				hal: page
			},function(data){
				$("#tableOutcome").html(data);
			});
		}else{
			$.get("page/response.php",{
				readOut: 1,
				searchOut: text2find,
				outcome_date: date2show,
				hal: page
			},function(data){
				$("#tableOutcome").html(data);
			});
		}
	}
}

$(document).ready(function() {
	init();
});
