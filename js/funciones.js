$(document).ready(function(event)
{	
	if($("#listado").length)
	{
		$("#Actualizar").click(function(event)	
		{		
			
			$.ajax(
				{
					url:"php/servidor.php",
					method:"GET",
					data:"operacion=USU-001",
					dataType:"html", //text,html,json,scrip
					
					//regresando informacion
					success: function(datos)
					{
						//alert(datos);
						$("#listado tbody").html(datos);
					},
					error: function(datos)
					{
						alert("Servidor no disponible");
					}
				}
			);
		});

		$("#Nuevo").click(function(event){
			alert("usuario nuevo");
		});

		
		$("#boton2").click(function(event)	
		{
			alert("boton 2");
			$.ajax(
				{
					url:"php/servidor.php",
					method:"GET",
					data:"operacion=USU-002",
					dataType:"json", //text,html,json,scrip
					
					//regresando informacion
					success: function(info)
					{
						if(info.tipo==1){
								$("#nombre").text(info.datos.nombre_usuario+" "+info.datos.apellido_paterno+" "+info.datos.apellido_materno)
						}else
						{
							alert(info.datos);
						}
						
					},
					error: function(datos)
					{
						alert("Error en el servidor de informacion");
					}
				}
			);	
		});
		
	}

	$("#controlUsuarios").submit(function(event)
	{
		event.preventDefault();
	});

	$("#btn-guardar").click(function(event)
	{
		event.preventDefault();
		var error=0;

		//colocar todos los campos para validar si no estan vacios
		if($("#usuarioid").val()=="")
		{
			$("#usuarioid").parent().addClass("has-error");
		}
		if($("#nombre_usuario").val()=="")
		{
			$("#nombre_usuario").parent().addClass("has-error");
		}
		if($("#apellido_paterno").val()=="")
		{
			$("#apellido_paterno").parent().addClass("has-error");
		}
		if($("#apellido_materno").val()=="")
		{
			$("#apellido_materno").parent().addClass("has-error");
		}
		if($("#contraseña").val()=="")
		{
			$("#contraseña").parent().addClass("has-error");
		}
		if(error==0)
		{
			console.log("operacion=USU-003&"+ $("#controlUsuarios").serialize());
			$.ajax(
				{
					url:"php/servidor.php",
					method:"GET",
					data:"operacion=USU-003&"+ $("#controlUsuarios").serialize(),
					dataType:"json", //text,html,json,scrip
					
					//regresando informacion
					success: function(info)
					{
						if(info.tipo==1){
								$("#usuarioid").val("");
								$("#nombre_usuario").val("");
								$("#apellido_paterno").val("");
								$("#apellido_materno").val("");
								$("#contraseña").val("");

								//alert("Inserción realizada")
								Swal.fire({
  									type: 'success',
  									title: 'bien...',
  									text: 'Registro Hecho!'
								})
								$("#miVentana").modal("hide");
						}else
						{
							Swal.fire({
  							type: 'error',
  							title: 'A chinga',
  							text: 'Te equivocaste!'
						})
						}
						
					},
					error: function(datos)
					{
						alert("Error en el servidor de informacion");
						
					}
				});
		}	
	});

	$("#usuarioid,#nombre_usuario,#apellido_paterno,#apellido_materno,#contraseña").keyup(function(event){
		$(this).parent().removeClass("has-error");
	});

	$("#listado").on("click",".btnEliminar",function(event)
	{
		var idusuariodato= $(this).attr("data-id");

		$.ajax(
				{
					url:"php/servidor.php",
					method:"GET",
					data:"operacion=USU-004&valor="+idusuariodato,
					dataType:"json", //text,html,json,scrip
					
					//regresando informacion
					success: function(info)
					{
						if(info.tipo==1){
								Swal.fire({
  									type: 'success',
  									title: 'bien...',
  									text: 'Eliminacion Hecho!'
								})
						}
						else
						{
							Swal.fire({
  								type: 'error',
  								title: 'A chinga',
  								text: 'No lo borro!'
							})
						}
						
					},
					error: function(datos)
					{
						alert("Error en el servidor de informacion");
						
					}
				});
		$(this).parent().parent().remove();



	});
});

$(document).ajaxStart(function()
	{
		$.LoadingOverlay("show");
	}
	).ajaxStop(function()
	{
		$.LoadingOverlay("hide");	
	}
);