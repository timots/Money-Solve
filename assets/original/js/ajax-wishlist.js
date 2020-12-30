function insertDataWS(){
	var namaBarang = $("#namabarang").val();
	var nominalBarang = $("#nominalbarang").val();
	var halini = $("#halini").text();

	$.post("page/wsresponse.php?act=addData",{
		namaBrg: namaBarang,
		nominalBrg: nominalBarang
	}, function(data){
		var response = JSON.parse(data);
		if (response.status == 1) {
			alert(response.message);
			loadDataWS(halini);
			$("#namabarang").val("");
			$("#nominalbarang").val("");
			$("#add-barang").modal('hide');
		}else{
			alert(response.message);
		}
	});
}

function fetchData(id){
	$.get("page/wsresponse.php",{
		act: "fetchData",
		idBrg: id
	}, function(data){
		var fetchedData = JSON.parse(data);
		if (fetchedData.status == 0) {
			alert(fetchedData.message);
		}else{
			$("#edit-barang").modal('show');
			$("#edit-namabarang").val(fetchedData.nama_barang);
			$("#edit-nominalbarang").val(fetchedData.nominal_barang);
			$("#id-brg").val(fetchedData.id_barang);
		}
	});
}

function updateData(){
	var namaBarang = $("#edit-namabarang").val();
	var nominalBarang = $("#edit-nominalbarang").val();
	var idBarang = $("#id-brg").val();
	var halini = $("#halini").text();

	$.post("page/wsresponse.php?act=editData",{
		namaBrg: namaBarang,
		nominalBrg: nominalBarang,
		idBarang: idBarang
	}, function(data){
		var response = JSON.parse(data);
		if (response.status == 1) {
			alert(response.message);
			$("#edit-barang").modal('hide'); 
			loadDataWS(halini);
		}else{
			alert(response.message);
		}
	});
}

function delDataWS(id){
	var halini = $("#halini").text();
	var sumhalini = $("#sumhalini").text();
	var conf = confirm("Apakah anda yakin ingin menghapus?");

	if (conf == true) {
		$.post("page/wsresponse.php?act=delData",{
			idBrg: id
		}, function(data){
			var response = JSON.parse(data);
			if (response.status = 1) {
				alert(response.message);
				if (sumhalini == 1) {
					loadDataWS(parseInt(halini) - 1);
				}else{
					loadDataWS(halini);
				}
			}else{	
				alert(response.message);
			}
		});
	}
}

function loadDataWS(page){
	var search2Text = $("#searchText").val();
	if (search2Text.length == 0) {
		search = null;
	}else{
		search = search2Text;
	}
	if (page == null) {
		setpage = null;
	}else{
		setpage = page;
	}

	$.get("page/wsresponse.php",{
		act: 'getData',
		searchText: search,
		page: setpage
	}, function(data){
		$("#data-wishlist").html(data);
	});
}

function convertWishlist(id){
	var halini = $("#halini").text();
	var conf = confirm("Apakah anda yakin sudah membelinya?");
		if (conf == true) {
		$.get("page/wsresponse.php",{
			act: "convData",
			idBarang: id
		}, function(data){
			var response = JSON.parse(data);
			if (response.status == 1) {
				alert(response.message);
				loadDataWS(halini);
				initGlob();
			}else{
				alert(response.message);
			}
		});
	}
}

$(document).ready(function() {
	loadDataWS(1);
});