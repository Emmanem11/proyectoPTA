	<?php
		include_once("base.php");
		if(isset($_GET["operacion"]))
		{//si existe el parametro de conexion
			$opc=$_GET["operacion"];

			if($opc=="USU-001")
			{
				$a=new Usuario();

				$listado=$a->consultarTodos();
				$salida="";
				for($i=0;$i<count($listado);$i++)
				{
					//Recorrido de arreglo numerico y asociativo
					$salida.="<tr>
									<td>".$listado[$i]["usuarioid"]."</td>
									<td>".$listado[$i]["nombre_usuario"]."</td>
									<td>".$listado[$i]["apellido_paterno"]."</td>
									<td>".$listado[$i]["apellido_materno"]."</td>
									<td>".$listado[$i]["tipo_usuario"]."</td>
									<td>".$listado[$i]["categoria"]."</td>
									<td><button class='btn btn-warning btnEditar' data-id='".$listado[$i]["usuarioid"]."'>

									<i class='fa fa-edit'></i></button>

									<button class='btn btn-danger btnEliminar' data-id='".$listado[$i]["usuarioid"]."'>
									<i class='fa fa-user-slash'></i></button></tr>";
				}//for
				echo $salida;
			}
			elseif($opc=="USU-002")
			{
				$a=new Usuario;
				if($a->buscar(1))
				{
					$datos=$a->consultar();

					$respuesta=array(
						"tipo"=>1,
						"datos"=>$datos
					);
				}
			}
			elseif($opc=="USU-003")
			{
				$a=new Usuario;
				$usuarioid=$_GET["usuarioid"];
				$nombre_usuario=$_GET["nombre_usuario"];
				$apellido_paterno=$_GET["apellido_paterno"];
				$apellido_materno=$_GET["apellido_materno"];
				$contraseña=$_GET["contraseña"];

				if(!$a->buscar($usuarioid))
				{
					$re=$a->agregar($usuarioid,$nombre_usuario,$apellido_paterno,$apellido_materno,$contraseña);
					if($re==1)
					{
						$respuesta=array(
							"tipo"=>1,
							"datos"=>"Insercción correcta"
						);
					}
					else
					{
						$respuesta=array(
							"tipo"=>0,
							"datos"=>"Insercción Incorrecta"
						);
					}	
				}
				else
				{
					$respuesta=array(
							"tipo"=>0,
							"datos"=>"El usuario ya existe!!"
						);
				}
				

				

				echo json_encode($respuesta);
				
			}
			elseif ($opc=="USU-004") 
			{
				$usuarioid=$_GET["valor"];
				$a=new Usuario;
				$re=$a->borrar($usuarioid);
				if($re==1)
				{
					$respuesta=array(
						"tipo"=>1,
						"datos"=>"Eliminacion realizada"
					);
				}
				else
				{
					$respuesta=array(
						"tipo"=>0,
						"datos"=>"No se pudo eliminar"
					);
				}
				echo json_encode($respuesta);
			}		
			else
			{
				$respuesta=array(
					"tipo"=>0,
					"datos"=>"usuario no localizado"
				);//codificacion json
				echo json_encode($respuesta);
			}
			

		}
		else
		{
			echo"sin parametros";
		}
		
		
		
		

	session_start();
	
	if(isset($_GET['cerrar_sesion'])){
		session_unset();
		session_destroy();
	}
	
	if(isset($_SESSION['rol'])){
		switch($_SESSION['rol']){
			case 1:
			header('location: index.html');
			break;
			case 2:
			header('location: UsuTecnico.html');
			break;
			
			default:
		}
	}
	
	if(isset($_POST['username']) && isset($_POST['password'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$db = new Database();
		$query = $db->connect()->prepare('SELECT*FROM usuarios WHERE username = :username AND password = :password');
		$query->execute(['username' => $username, 'password' => $password]);
		
		$row = $query->fetch(PDO::FETCH_NUM);
		if($row == true){
			//validar rol
			$rol = $rol[3];
			$_SESSION['rol'] = $rol;
			switch($_SESSION['rol']){
			case 1:
			header('location: index.html');
			break;
			case 2:
			header('location: UsuTecnico.html');
			break;
			
			default:
		}
		}else{
			//no existe el USUARIO
			echo "el usuario o contrasena son incorrectos";
		}
	}
	
	
	
	
	
	
	
	
	
	
?>