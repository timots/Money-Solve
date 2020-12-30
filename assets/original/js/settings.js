function saveName(){
	var fullname = $("#fullname-input").val();

	$.post("page/rsettings.php?act=changeName",{
		name: fullname
	}, function(data){
		var response = JSON.parse(data);
		if (response.status != 0) {
			//Sembunyikan form
			$("#form-fullname").hide(0,function(){
				$("#fullname-setting").show();
			});

			//Sembunyikan tombol save
			$("#saveEditFullname").hide(0, function(){
				$("#cancelEditFullname").hide();
				$("#editFullname").show();
			});

			alert(response.message);

			//load data kembali
			loadData();
		}else{
			alert(response.message);
		}
	});
}

function savePassword(){
	var oldpass = $("#oldpass-input").val();
	var newpass = $("#newpass-input").val();
	var retrypass = $("#retrypass-input").val();

	$.post("page/rsettings.php?act=changePassword",{
		oldPassword: oldpass,
		newPassword: newpass,
		retryPassword: retrypass
	}, function(data){
		var response = JSON.parse(data);
		if (response.status != 0) {
			$("#passwordView").show(300,function(){
				$("#form-password").slideUp();
			});
			alert(response.message);
		}else{
			alert(response.message);
		}
	});
}

function saveGoal(){
	var goal = $("#goalInput").val();

	$.post("page/rsettings.php?act=changeGoal",{
		goal: goal
	}, function(data){
		var response = JSON.parse(data);
		if (response.status != 0) {
			$("#saveGoal").hide(0, function(){
				$("#editGoal").show();
				$("#cancelEditGoal").hide();
				$("#goalInput").attr('readonly', 1);
			});
			alert(response.message);
			loadData();
		}else{
			alert(response.message);
		}
	});
}

function loadData(){
	$.get("page/rsettings.php",{
		act: "getUserData"
	},function(data){
		var userdata = JSON.parse(data);
		$("#fullname-setting").text(userdata.name);
		$("#fullname-input").val(userdata.name);
		$("#username-setting").text(userdata.username);
		$("#goalInput").val(userdata.goal);
		$("#userimage").attr('src', userdata.profilePict);
	});
}

$("#form-upimage").on('submit', function(e) {
	e.preventDefault();
	var data = new FormData(this);
	$.ajax({
		type: 'POST',
		url: 'page/rsettings.php?act=changePict',
		data: data,
		contentType: false,
		processData:false

	}).success(function(data) {
		var response = JSON.parse(data);
		if (response.status == 1) {
			alert(response.message);
			loadData();
			refrPict();
		}else{
			alert(response.message);
		}
		
	});
});

$(document).ready(function(){
	//Tombol Edit Nama
	$("#editFullname").click(function(){
		$("#fullname-setting").hide(0,function(){
			$("#form-fullname").show();
		});
		$("#editFullname").hide(0,function(){
			$("#saveEditFullname").show();
			$("#cancelEditFullname").show();
		});
	});

	$("#cancelEditFullname").click(function(){
		$("#form-fullname").hide(0,function(){
			$("#fullname-setting").show();
		});
		$("#saveEditFullname").hide(0, function(){
			$("#cancelEditFullname").hide();
			$("#editFullname").show();
		});
	});

	//Tombol Password
	$("#editPassword").click(function(){
		$("#passwordView").hide(function(){
			$("#form-password").slideDown();
		});
	});

	$("#cancelEditPassword").click(function(){
		$("#passwordView").show(300,function(){
			$("#oldpass-input").val("");
			$("#newpass-input").val("");
			$("#retrypass-input").val("");
			$("#form-password").slideUp();
		});
	});

	//Tombol Goal
	$("#editGoal").click(function(){
		$("#editGoal").hide(0, function(){
			$("#saveGoal").show();
			$("#cancelEditGoal").show();
			$("#goalInput").removeAttr('readonly');
		});
	});

	$("#cancelEditGoal").click(function(){
		$("#saveGoal").hide(0, function(){
			$("#editGoal").show();
			$("#cancelEditGoal").hide();
			$("#goalInput").attr('readonly', 1);
		});
	});

	//Load Data
	loadData();
});