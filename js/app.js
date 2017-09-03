$(document).ready(function(){
	$("#flip1").click(function(){
        $("#panel1").slideDown("slow");
        $("#panel2").slideUp("slow");
        $("#panel3").slideUp("slow");
        $("#panel4").slideUp("slow");
    });
    
     $("#flip2").click(function(){
        $("#panel2").slideDown("slow");
        $("#panel1").slideUp("slow");
        $("#panel3").slideUp("slow");
        $("#panel4").slideUp("slow");
    });
    $("#flip3").click(function(){
        $("#panel3").slideDown("slow");
        $("#panel2").slideUp("slow");
        $("#panel1").slideUp("slow");
        $("#panel4").slideUp("slow");
    });
	$("#flip4").click(function(){
       $("#panel4").slideDown("slow");
         $("#panel2").slideUp("slow");
         $("#panel3").slideUp("slow");
         $("#panel1").slideUp("slow");
    });
    fechaPop();
 	accionElementos();
});

var fecha;
var dia;
var mes;
var año;
var codigoAuditorioCalificar;
var codigoReservaAutorizar;
var totalReservas ={};

var auditorios = angular.module('auditorios',[]);
var urlLogin="http://127.0.0.1/AuditoriosGobernacion/WebServices/loginPersona.php";	 

auditorios.controller('auditoriosCtrl', function ($scope,$http) {
	$scope.formDataLogin={};//datos del formulario de login
	$scope.submitLogin= function () {
		$http({
			method: "POST",
		    url: urlLogin,
			contentType: "application/json; charset=utf-8",
			data    : $.param($scope.formDataLogin), 
		    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }		   
		}).success(function(datosUser){
			if (!datosUser[0].tipo) {
				alert("Usuario y / o contraseña incorrectos");
			}else{
				$scope.datosUser=datosUser;

				$scope.datosUser[0].cedula=datosUser[0].cedula;
				$scope.datosUser[0].tipo=datosUser[0].tipo;	

				sessionStorage.cedulaUsuario=$scope.datosUser[0].cedula;
				sessionStorage.tipoUsuario=$scope.datosUser[0].tipo;
				sessionStorage.nombreUsuario=$scope.datosUser[0].nombre;
				sessionStorage.dependenciaUsuario=$scope.datosUser[0].dependencia;
				sessionStorage.celularUsuario=$scope.datosUser[0].celular;
				sessionStorage.telefonoUsuario=$scope.datosUser[0].telefono;
				sessionStorage.extensionUsuario=$scope.datosUser[0].extension;
			
				$scope.formVisibility=true;
				

				if ($scope.datosUser[0].tipo=="FU") {
					alert("Bienvenido " + datosUser[0].nombre);
			 	}else if($scope.datosUser[0].tipo=="FA"){
			 		alert("Bienvenido Administrador " + datosUser[0].nombre);
			 	}else{
			    	alert("Bienvenido Super Administrador " + datosUser[0].nombre);
			    };
				location.href="auditorio.html";			    
			    //document.getElementById("nombreUsuario").innerHTML = sessionStorage.nombreUsuario;

			    //$("#dialogLogin").dialog('close');
			}
		}).error(function(mensaje) {
		    alert("Lo sentimos");
		});
	}

	$scope.registrarUsuario= function () {
		if (sessionStorage.tipoUsuario=="SA") {
			$http({
				method: "POST",
		    	url: "http://127.0.0.1/AuditoriosGobernacion/WebServices/registroPersonaAdmin.php",
				contentType: "application/json; charset=utf-8",
				data    : $.param($scope.formData), 
		    	headers : { 'Content-Type': 'application/x-www-form-urlencoded' }		   
			}).success(function(mensaje) {
			    alert("Administrador registrado.");
		    	document.location = "moduloSuperAdmin.html";
			}).error(function(mensaje) {
			    alert("Lo sentimos.");
			});	
		}else{
			$http({
				method: "POST",
		    	url: "http://127.0.0.1/AuditoriosGobernacion/WebServices/registroPersona.php",
				contentType: "application/json; charset=utf-8",
				data    : $.param($scope.formData), 
		    	headers : { 'Content-Type': 'application/x-www-form-urlencoded' }		   
			}).success(function(mensaje) {
			    alert("Usuario registrado.");
		    	document.location = "index.html";
			}).error(function(mensaje) {
			    alert("Lo sentimos.");
			});
		}
	}

	$scope.registroCalificacion= function () {
		var datos =  "codigo="+codigoAuditorioCalificar+"&"+$.param($scope.formData);
		$http({
			method: "POST",
		    url: "http://127.0.0.1/AuditoriosGobernacion/WebServices/calificarReserva.php",
			contentType: "application/json; charset=utf-8",
			data    : datos, 
		    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }		   
		}).success(function(mensaje) {
		    alert("Tus recomendaciones y/o calificaciones se han enviado. Muchas gracias!");
		    document.location = "historialReservas.html";
		}).error(function(mensaje) {
		    alert("Lo sentimos.");
		});
	}

	$scope.autorizarReserva=function () {
		var datos="cedula="+sessionStorage.cedulaUsuario+"&"+$.param($scope.formData);
		console.log(datos);
		$http({
			method: "POST",
		    url: "http://127.0.0.1/AuditoriosGobernacion/WebServices/loginPersona.php",
			contentType: "application/json; charset=utf-8",
			data    : datos, 
		    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }		   
		}).success(function(data) {
			if (!data[0].tipo) {
				alert("Contraseña incorrecta.");
			}else{
				var datosAutorizar = "codigoReserva="+codigoReservaAutorizar+"&cedulaAprueba="+sessionStorage.cedulaUsuario;
				$http({
					method: "POST",
		    		url: "http://127.0.0.1/AuditoriosGobernacion/WebServices/autorizarReserva.php",
					contentType: "application/json; charset=utf-8",
					data    : datosAutorizar, 
		    		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }		   
				}).success(function(mensaje) {
		    		alert("La reserva se ha autorizado satisfactoriamente!");
		    		document.location = "moduloReservasAdmin.html";
				}).error(function(mensaje) {
		    		alert("Lo sentimos.");
				});				
		    }
		}).error(function(mensaje) {
		    alert("Lo sentimos.");
		});		
	}

	$scope.actualizarAdministrador=function () {
		var datos = "cedula="+sessionStorage.cedulaAdministrador+"&"+$.param($scope.formData);
		$http({
			method: "POST",
		    url: "http://127.0.0.1/AuditoriosGobernacion/WebServices/actualizarPersona.php",
			contentType: "application/json; charset=utf-8",
			data    : datos, 
		    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }		   
		}).success(function(mensaje) {
		    alert("Administrador Actualizado satisfactoriamente.");
		    document.location = "moduloSuperAdmin.html";
		}).error(function(mensaje) {
		    alert("Lo sentimos.");
		});
	}

	$scope.cerrarSesion=function () {
		sessionStorage.clear();
		location.href="index.html";
	}


});

function cargaAuditorios() {//Carga los auditorios disponibles
	var publicacionesContent=document.getElementById('contenidoAuditorios');
	var resultHTML='';
	$.getJSON('http://127.0.0.1/AuditoriosGobernacion/WebServices/cargaAuditorios.php',
		function(data) {
			$.each(data, function(i,obj){
				
				var codigo = obj.codigo;
				var nombreAuditorio = obj.nombre;
				var imagen = obj.imagen;
	   			var capacidad = obj.capacidad;
	   			var direccion = obj.direccion;
	   			var nombreFinal=nombreAuditorio.replace(/\s/g, 2);
	   			resultHTML+="<div id=caja class=itemBox  onclick=almacenarCodigo('"+codigo+"','"+nombreFinal+"');>\
	   			 				<div class=itemNombre>"+nombreAuditorio+"</div>\
	   			 				<img class=itemFoto src=http://127.0.0.1/AuditoriosGobernacion/images/"+imagen+">\
	   			 				<div class=itemCapacidad>"+capacidad+" personas</div>\
            					<div class=itemDireccion>"+direccion+" </div>\
                   	  		</div>";
			});
			publicacionesContent.innerHTML=resultHTML;
		});	
}

function almacenarCodigo (codigo, nombreAuditorio) {//Funcion que carga el pop-up de ingreso de fechas
	sessionStorage.nombreAuditorio=nombreAuditorio;
	sessionStorage.codigoAuditorio=codigo;
	location.href='#popUp';
}

function consultaFechaReserva() {
	var fechaInicio = document.getElementById('fechaInicioC').value;
	var fechaFinal = document.getElementById('fechaFinC').value;
	var horaInicio = document.getElementById('horaInicioC').value;
	var horaFinal = document.getElementById('horaFinC').value;
	$.getJSON('http://127.0.0.1/AuditoriosGobernacion/WebServices/consultaDisponibilidadReserva.php?codigoAuditorio='+sessionStorage.codigoAuditorio+'&fechaInicio='+fechaInicio+'%20'+horaInicio+'&fechaFinal='+fechaFinal+'%20'+horaFinal,
	 	function(data){
	 		if (data[0].respuesta==0){//No hay reservas apartadas
	 			sessionStorage.fechaInicio=fechaInicio+" "+horaInicio;
	 			sessionStorage.fechaFinal=fechaFinal+" "+horaFinal;
				location.href="formatosolicitud.html";
	 		}else{
				alert("En este momento ya se encuentra una reserva para ese auditorio y fecha.");
			}
	});
}

function fechaPop() {
	fecha = new Date();
	dia = fecha.getDate();
	mes = fecha.getMonth()+1;
	año = fecha.getFullYear();
	if(dia<10){ 
  		dia='0'+dia;
  	}
	if(mes<10) {
    	mes='0'+mes;
	}
	fechaInicioA = document.getElementById('fechaInicioC');
	fechaFinalA = document.getElementById('fechaFinC');
	fechaInicioA.value=año+"-"+mes+"-"+dia;
	fechaFinalA.value=año+"-"+mes+"-"+dia;
	fechaInicioA.min=año+"-"+mes+"-"+dia;
	fechaFinalA.min=año+"-"+mes+"-"+dia;
}

function cargarFormularioSolicitud() {
	var nombrePersona = document.getElementById('nombreFormS');
	var sectorialPersona = document.getElementById('SectorialFormS');
	var celularPersona = document.getElementById('celularFormS');
	var telefonoPersona = document.getElementById('telefonoFormS');
	var fechaActual = document.getElementById('fechaSolicitudFormS');
	var nombreAuditorio = document.getElementById('NombreAuditorioFormS');
	var fechaInicio = document.getElementById('fechaInicioFormS');
	var fechaFinal = document.getElementById('fechafinFormS');

	nombrePersona.value=sessionStorage.nombreUsuario;
	sectorialPersona.value=sessionStorage.dependenciaUsuario;
	celularPersona.value=sessionStorage.celularUsuario;
	nombreAuditorio.value=sessionStorage.nombreAuditorio.replace(/\d/g, " ");
	fechaActual.value=año+"-"+mes+"-"+dia;

	var fechaInicioUnion = sessionStorage.fechaInicio.split(" ");
	var fechaFinalUnion = sessionStorage.fechaFinal.split(" ");

	fechaInicio.value = fechaInicioUnion[0];
	fechaFinal.value = fechaFinalUnion[0];	

	if (sessionStorage.telefonoUsuario!="null") {
		telefonoPersona.value=sessionStorage.telefonoUsuario;	
	}
}

function getXMLHttp(){
	var xmlHttp;
	try{
		//Firefox, Opera 8.0+, Safari
		xmlHttp = new XMLHttpRequest();
	}catch(e){
		//Internet Explorer
		try{
			xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e){
		try{
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e){
			alert("Tu navegador no soporta AJAX!")
			return false;
			}
		}
	}
	return xmlHttp;
}


function registrarReserva() {
	var checkboxTipoReserva = new Array(); 
	$('input[name="div3"]:checked').each(function() { //recorremos todos los checkbox seleccionados con .each
		checkboxTipoReserva += $(this).val() + ",";
	});
	var otrosTipoReserva = document.getElementById('otrosTipo');
	checkboxTipoReserva=checkboxTipoReserva+" Otros: "+otrosTipoReserva.value;

	var checkboxApoyoLogistico = new Array(); 
	$('input[name="div4"]:checked').each(function() { //recorremos todos los checkbox seleccionados con .each
		checkboxApoyoLogistico +=$(this).val()+ ",";
	});
	var otrosApoyoLogistico = document.getElementById('otrosApoyo');
	checkboxApoyoLogistico=checkboxApoyoLogistico+" Otros: "+otrosApoyoLogistico.value;

	var descripcionSolicitud = document.getElementById('textDescripcionSolicitud').value;
	var fechaActual = año+"-"+mes+"-"+dia;
	var xmlHttp = getXMLHttp();
	xmlHttp.open("POST", "http://127.0.0.1/AuditoriosGobernacion/WebServices/reservarAuditorio.php", true); 
	var parameters = "cedula="+sessionStorage.cedulaUsuario+"&auditorio="+sessionStorage.codigoAuditorio+"&fechaInicio="+sessionStorage.fechaInicio+"&fechaFinal="+sessionStorage.fechaFinal+"&tipo="+checkboxTipoReserva+"&apoyo="+checkboxApoyoLogistico+"&descripcion="+descripcionSolicitud+"&fecha="+fechaActual;
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	if(xmlHttp.send(parameters)){
		alert("Lo sentimos ha ocurrido un error, revisa los datos ingresados.");		
	}else{
		alert("La reserva se ha realizado satisfactoriamente, se te enviara una notificacion al correo cuando este aprobada.");
		document.location="auditorio.html";
	}
}

function cargarReservas() {
	var publicacionesContent=document.getElementById('reservasContenido');
	publicacionesContent.innerHTML='';
	var resultHTML='';
	var tablaReservas='';
	
	$.getJSON('http://127.0.0.1/AuditoriosGobernacion/WebServices/cargarReservas.php',
		function(data) {
			$.each(data, function(i,obj){	
				var autorizar="iconoAutorizar";
				var codigo = obj.codigo;
				var nombrePersona = obj.nombre_persona;
				var nombreAuditorio = obj.nombre_auditorio;
				var dependenciaPersona = obj.dependencia_persona;
	   			var fechaInicio = obj.fecha_inicio;
	   			var fechaFinal = obj.fecha_final;
	   			var aprobada = obj.aprobada;
	   			var nombreFinal=nombrePersona.replace(/\s/g, 2);
	   			if (aprobada==1) {
	   				autorizar="no";
	   			};
	   			resultHTML+="<tr>\
		   			 				<td>"+nombrePersona+"</td>\
		   			 				<td>"+nombreAuditorio+"</td>\
	   			 					<td>"+dependenciaPersona+"</td>\
	   			 					<td>"+fechaInicio+"</td>\
	   			 					<td>"+fechaFinal+"</td>\
	   			 					<td><div class=iconoeditar onclick=editarReserva("+codigo+");></div>\
	                                	<div class=iconoEliminar onclick=eliminarReserva("+codigo+");></div>\
                                		<div class="+autorizar+" onclick=popUpAutorizar('"+codigo+"','"+nombreFinal+"')></div>\
                                	</td>\
								</tr>";
			});
			tablaReservas= "<table id=tablaContenido>\
                        			<tr>\
                            			<th>Nombre solicitante</th>\
                            			<th>Auditorio</th>\
                            			<th>Dependencia</th>\
                            			<th>Fecha Inicio</th>\
                            			<th>Fecha Final</th>\
                            			<th id=tablaAccion>Accion</th>\
                        			</tr>";
			publicacionesContent.innerHTML+=tablaReservas+resultHTML+"</table>";                        			
		}).success(function(data) {
			});		
			
}

function eliminarReserva(codigoAuditorio) {
	if(confirm("¿Seguro que desea Eliminar esta reserva?")){
		var xmlHttp = getXMLHttp();
		xmlHttp.open("POST", "http://127.0.0.1/AuditoriosGobernacion/WebServices/eliminarReserva.php", true); 
		var parameters = "id="+codigoAuditorio;
		xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		for(var i in totalReservas){//Elimina inmediamente la reserva del objeto
			if (totalReservas[i].codigo==codigoAuditorio) {
				//console.log(totalReservas[i].codigo, i);
				var indexReserva = i;
				totalReservas.splice(indexReserva, 1);
				console.log(totalReservas);
				break;
			}
		}
		

		if(xmlHttp.send(parameters)){
			alert("Lo sentimos ha ocurrido un error");		
		}
  	}
  	cargarReservas();
}

function accionElementos () {
	if (sessionStorage.tipoUsuario=="FA") {
		var registroUsuarios = document.getElementById('registroFuncionarioAdmin');
		registroUsuarios.style.display='block';
		cargaAuditorios();
	}else if (sessionStorage.tipoUsuario=="SA"){
		var tituloBienvenida = document.getElementById('textoTituloAuditorio');
		tituloBienvenida.style.display='none';

		var tituloBienvenida2 = document.getElementById('textoAuditorio2');
		tituloBienvenida2.style.display = 'block';

		var botonReservas = document.getElementById('historialReserva');
		botonReservas.style.display = 'none';

		var contenedorAuditorios = document.getElementById('contenidoAuditorios');
		contenedorAuditorios.style.display = 'none';

		var registroSuperAdmin = document.getElementById('funcionarioSuperAdmin');
		registroSuperAdmin.style.display = 'block';
	}else{
		cargaAuditorios();
	}

}

function cargarReservasFuncionario () {
	var publicacionesContent=document.getElementById('contenidoReservas');
	publicacionesContent.innerHTML='';
	var resultHTML='';
	var tablaReservas='';
	var iconoAprobada="";
	$.getJSON('http://127.0.0.1/AuditoriosGobernacion/WebServices/cargarReservasFuncionario.php?cedula='+sessionStorage.cedulaUsuario,
		function(data) {
			$.each(data, function(i,obj){
				var aprobada="No Aprobada";
				var codigo = obj.codigo;
				var nombreAuditorio = obj.nombre_auditorio;
	   			var fechaInicio = obj.fecha_inicio;
	   			var fechaFinal = obj.fecha_final;
	   			var observaciones = obj.observaciones;
	   			var aprobadaReserva = obj.aprobada;
	   			console.log(aprobadaReserva, observaciones);
	   			if (aprobadaReserva==1) {
	   			 	aprobada = "Aprobada";
	   			 	if (obj.observaciones==null) {
		   				iconoAprobada = "iconoAprobar";   			 	
	   				}else{
	   					iconoAprobada = "no";
	   				}

	   			}
	   			resultHTML+="<tr>\
	   							<td><center>"+nombreAuditorio+"</td></center>\
		   			 			<td><center>"+fechaInicio+"</td></center>\
		   			 			<td><center>"+fechaFinal+"</td></center>\
	   			 				<td><center>"+aprobada+"</center></td>\
	   			 				<td><div class="+iconoAprobada+" onclick=cargarInfoPopUP("+codigo+")></div></td>\
							</tr>";
			});
			tablaReservas= "<table id=tablaContenido>\
                        			<tr>\
                            			<th>Auditorio</th>\
                            			<th>Fecha Inicio</th>\
                            			<th>Fecha Final</th>\
                            			<th>Estado Aprobación</th>\
                            			<th id=tablaAccion>Calificar</th>\
                        			</tr>";
			publicacionesContent.innerHTML+=tablaReservas+resultHTML+"</table>";                        			
		});			
}

function cargarInfoPopUP (codigo) {
	codigoAuditorioCalificar = codigo;
	var nombreCalifica = document.getElementById('nombreCalificacion');
	nombreCalifica.value = sessionStorage.nombreUsuario;
	var fechaCalificacion = document.getElementById('fechaCalificacion');
	fechaCalificacion.value =año+"-"+mes+"-"+dia;
	location.href="#popUp";
}

function historialReservas(){
	if (sessionStorage.tipoUsuario=="FU") {
		location.href="historialReservas.html";
	}else{
		location.href="moduloReservasAdmin.html";
	}
}


function cambiarHora() {
	var horaInicio = document.getElementById('horaInicioC');
	var horaFinal = document.getElementById('horaFinC');
	if (horaInicio.value=="14:00:00") {
		horaFinal.value="19:00:00";
	}
	if (horaFinal.value=="12:00:00") {
		horaInicio.value="07:00:00";
	};
}

function popUpAutorizar (codigoReserva, nombrePersona) {
	codigoReservaAutorizar = codigoReserva
	var nombreFinal = nombrePersona.replace(/\d/g, " ");
	window.location = 'moduloReservasAdmin.html#popUpp';
	var text=$('#tituloAutorizar').text("Desea autorizar la solicitud del funcionario: " +nombreFinal+"?");	

}

function cargarAdministradores () {
	var publicacionesContent=document.getElementById('contenidoModuloReservas');
	publicacionesContent.innerHTML='';
	var resultHTML='';
	var tablaReservas='';
	$.getJSON('http://127.0.0.1/AuditoriosGobernacion/WebServices/cargarAdministradores.php',
		function(data) {
			$.each(data, function(i,obj){	
				var cedula = obj.cedula;
				var nombrePersona = obj.nombre;
				var dependenciaPersona = obj.dependencia;
	   			var correo = obj.correo;
	   			var celular = obj.celular;

	   			resultHTML+="<tr>\
		   			 			<td>"+nombrePersona+"</td>\
		   			 			<td>"+dependenciaPersona+"</td>\
	   			 				<td>"+correo+"</td>\
	   			 				<td>"+celular+"</td>\
	   			 				<td><div class=iconoeditarAdmin onclick=editarAdministrador("+cedula+");></div>\
                                </td>\
							</tr>";
			});
			tablaReservas= "<table id=tablaContenido>\
                        			<tr>\
                            			<th>Nombre Administrador</th>\
                            			<th>Dependencia</th>\
                            			<th>Correo</th>\
                            			<th>Celular</th>\
                            			<th id=tablaAccion>Editar</th>\
                        			</tr>";
			publicacionesContent.innerHTML+=tablaReservas+resultHTML+"</table>";                        			
		}).success(function(data) {
			});	
}

function editarAdministrador (cedula) {
	location.href='moduloSuperAdmin.html#popUp';
	sessionStorage.cedulaAdministrador = cedula;
	// var nombreFuncionario = document.getElementById('nombreFormSa');
	// var dependenciaFuncionario = document.getElementById('NombreDependenciaFormSa');
	// var correoFuncionario = document.getElementById('CorreoSuperAdForm');
	// var celularFuncionario = document.getElementById('CelularSuperAdForm');

}

function editarReserva (codigoReserva) {
	sessionStorage.codigoReservaEditar = codigoReserva;
	window.location = 'moduloReservasAdmin.html#popUp';
	var resultHTML ="";
	var nombre = document.getElementById('nombreFormE');
	var dependencia = document.getElementById('NombreDependenciaFormE');
	var auditorio = document.getElementById('NombreAuditoFormE');
	var fechaSolicitud = document.getElementById('fechaEditarForm');
	var fechaInicio = document.getElementById('fechaInicioFormE');
	var fechaFinal = document.getElementById('fechafinFormE');
	var mantenimiento = document.getElementById('txtTitu1');
	var apoyo = document.getElementById('txtTitu2');
	var descripcion = document.getElementById('txtTitu3');
	var aux;
	$.getJSON('http://127.0.0.1/AuditoriosGobernacion/WebServices/cargarReservaEditar.php?codigo='+codigoReserva,
		function(data) {
			$.each(data, function(i,obj){	
				var nombrePersona = obj.nombre_persona;
				var dependenciaPersona = obj.dependencia;
				var fecha = obj.fecha;
	   			var fechaInicioFinal = obj.fecha_inicio;
	   			var fechaFinalFinal = obj.fecha_final;
	   			var tipo = obj.mantenimiento;
	   			var apoyoLogistico = obj.apoyo;
	   			var descripcionSolicitud = obj.descripcion;
				var codigoAuditorio = obj.codigo_auditorio; 
	   			var fechaUnion = fecha.split(" ");
	   			var fechaInicioUnion = fechaInicioFinal.split(" ");
	   			var fechaFinalUnion = fechaFinalFinal.split(" ");

	   			nombre.value=nombrePersona;
				dependencia.value=dependenciaPersona;
				fechaSolicitud.value = fechaUnion[0];
				fechaInicio.value= fechaInicioUnion[0];
				fechaFinal.value=fechaFinalUnion[0];
				mantenimiento.value=tipo;
				apoyo.value=apoyoLogistico;
				descripcion.value=descripcionSolicitud;
			});
		});
			
	$.getJSON('http://127.0.0.1/AuditoriosGobernacion/WebServices/cargaAuditorios.php',
		function(data) {
			$.each(data, function(i,obj){
				resultHTML+="<option value="+obj.codigo+">"+obj.nombre+"</option>";
			});
			auditorio.innerHTML = resultHTML;
		});
		resultHTML= "<option value=></option>";
}


function consultaFechaEditar () {
	var fechaInicio = document.getElementById('fechaInicioFormE').value;
	var fechaFinal = document.getElementById('fechafinFormE').value;
	var horaInicio = document.getElementById('horaInicioC').value;
	var horaFinal = document.getElementById('horaFinC').value;
	var codigoAuditorio = document.getElementById('NombreAuditoFormE').value;
	var tipo = document.getElementById('txtTitu1').value;
	var apoyoLogistico = document.getElementById('txtTitu2').value;
	var descripcion = document.getElementById('txtTitu3').value;

	console.log(fechaInicio, fechaFinal, horaInicio, horaFinal, tipo, apoyoLogistico, descripcion);
	$.getJSON('http://127.0.0.1/AuditoriosGobernacion/WebServices/consultaDisponibilidadReserva.php?codigoAuditorio='+codigoAuditorio+'&fechaInicio='+fechaInicio+'%20'+horaInicio+'&fechaFinal='+fechaFinal+'%20'+horaFinal,
	 	function(data){
	 		if (data[0].respuesta==0){//No hay reservas apartadas
	 				var xmlHttp = getXMLHttp();
					xmlHttp.open("POST", "http://127.0.0.1/AuditoriosGobernacion/WebServices/editarReserva.php", true); 
					var parameters = "codigo_reserva="+sessionStorage.codigoReservaEditar+"&codigo_auditorio="+codigoAuditorio+"&fecha_inicio="+fechaInicio+" "+horaInicio+"&fecha_final="+fechaFinal+" "+horaFinal+"&tipo="+tipo+"&apoyo_logistico="+apoyoLogistico+"&descripcion="+descripcion;
					xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
					if(xmlHttp.send(parameters)){
						alert("Lo sentimos ha ocurrido un error, revisa los datos ingresados.");		
					}else{
						alert("La reserva se ha realizado satisfactoriamente, se te enviara una notificacion al correo cuando este aprobada.");
						document.location="moduloReservasAdmin.html";
					}
	 		}else{
				alert("En este momento ya se encuentra una reserva para ese auditorio y fecha.");
			}
	});
}