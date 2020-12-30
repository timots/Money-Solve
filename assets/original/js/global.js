function initGlob(){
	$.get("page/rsettings.php",{
		act: "fetchData"
	}, function (data){
		var user = JSON.parse(data);
		$("#profile-balance").text("Rp. "+user.saldo);
	});
}

function refrPict(){
	$.get("page/rsettings.php",{
		act: "getUserData"
	},function(data){
		var userdata = JSON.parse(data);
		$("#profile-pict").attr('src', userdata.profilePict);
	});
}

$(document).ready(function() {
	initGlob();
	refrPict();
});