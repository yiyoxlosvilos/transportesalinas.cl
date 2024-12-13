function ingresar(){
	let user 	 	= document.getElementById('usuario').value;
	let pass 	 	= document.getElementById('pass').value;
	let rec 	= $('#remember-check').prop("checked");
	let url_link 	= document.getElementById('url_link').value;

	if(user.length == 0){
		$("#usuario").focus();
		Swal.fire("&iquest; Alerta !", "Ingresar Usuario.", "error");
	} else if(pass.length == 0){
		$("#contrasena").focus();
		Swal.fire("&iquest; Alerta !", "Ingresar Contraseña.", "error");
	} else {

		$('.auth-content').load(url_link+"/app/recursos/img/loader.svg");

		$.ajax({
	        dataType: "json",
	        url:  url_link+"index.php?action=validar",
	        type: "POST",
	        data: {	usr:  user,
	        	   	pass: pass,
	        	   	rec:rec
	        	  },
	        success: function(data){
	          if (data.success == false) {
	          	Swal.fire(" Alerta !", data.msg, "error");
	          } else {
	            window.location=data.link;
	          }
	        },
	        error: function(response) {
	          Swal.fire("Error", response, "error");
	        }
		});
	}
}