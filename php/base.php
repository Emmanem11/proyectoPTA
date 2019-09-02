	<?php
	define("SERVIDOR","localhost");
	define("USUARIO","root");
	define("CONTRASEÑA","");
	define("BASED","Bitacoras");

	class ConexionDB{
		protected $conexion;//atributo de la clase
		function __construct(){//constructor inicializa los datos de los atributos
				@$this->conexion=mysqli_connect(SERVIDOR,USUARIO,CONTRASEÑA,BASED);//this indica el dato miembo que sera inicializado @elimina los warning
				if(mysqli_connect_error()){
					exit;
				}else{
					$this->conexion->query("set charset'utf8'");//configuracion de caracteres especiales en utf8
				}
		}
	} 

	class Usuario extends ConexionDB{//hereda de la clase conexiondb
		protected $id;
		function __construct(){
				parent::__construct();//manda traer el constructor de la clase padre
				$this->id=0;//hace referencia al dato miembro sino crea otra variable o dato
		}

	

	//Metodo para agregar un docente
	function agregar($id,$nom,$ap,$am,$con){
		$nom=$this->conexion->real_escape_string($nom);//limpia la cadena de cadenas especiales que recibe nombre para evitar sql inyection
		$ap=$this->conexion->real_escape_string($ap);
		$am=$this->conexion->real_escape_string($am);
		$con=$this->conexion->real_escape_string($con);

		$query="insert into Usuario values($id,'$nom','$ap','$am','$con','Docente',' ')";//comilla doble toma e interpreta el valor de la variable comilla simple es texto especifico

		if($this->conexion->query($query)){
			$this->id=$id;
			return 1;
		}else{
			//return 0;
			return mysqli_error($this->conexion);
		}
	}
	
	function agregar1($id,$nom,$ap,$am,$con,$cat)
	{//polimorfismo en poo sobre carga en estructurada
		$nom=$this->conexion->real_escape_string($nom);//limpia la cadena de cadenas especiales que recibe nombre para evitar sql inyection
		$ap=$this->conexion->real_escape_string($ap);
		$am=$this->conexion->real_escape_string($am);
		$con=$this->conexion->real_escape_string($con);
		$cat=$this->conexion->real_escape_string($cat);

		$query="insert into Usuario values($id,'$nom','$ap','$am','$con','Administrativo','$cat')";//comilla doble toma e interpreta el valor de la variable comilla simple es texto especifico

		if($this->conexion->query($query)){
			$this->id=$id;
			return 1;
		}else{
			//return 0;
			return mysqli_error($this->conexion);
		}
	}

	function borrar($id){
		$query="delete from Usuario where usuarioid=$id";
		if($this->conexion->query($query)){
			$this->id=$id;
			return 1;
		}else{
			return mysqli_error($this->conexion);
		}
	}

	function actualizar($id,$nombre,$apat,$amat){
		$this->nom=$nombre;
		$this->ap=$apat;
		$this->am=$amat;
		$query="update usuario set nombre_usuario='$nombre', apellido_paterno='$apat', apellido_materno='$amat' where usuarioid=$id";
		if($this->conexion->query($query)){
			$this->id=$id;
			return 1;
		}else{
			return mysqli_error($this->conexion);
		}
	}

	function buscar($id){
		$id=$this->conexion->real_escape_string($id);
		$query="select usuarioid from usuario where usuarioid=$id";
		$consulta=$this->conexion->query($query);

		if($consulta->num_rows>0){
			$this->id=$id;
			return 1;
		}else{
			return mysqli_error($this->conexion);
		}
	}

	function borrar1(){
		$query="delete from usuario where usuarioid=".$this->id;
		$this->conexion->query($query);
	}

	function consultar(){
		$query="select * from usuario where usuarioid=".$this->id;
		$re=$this->conexion->query($query);

		$fila=$re->fetch_array(MYSQLI_ASSOC);//regresa valores asociativos del arreglo
		//$fila=$re->fetch_array(MYSQLI_NUM);//REgresa valor numericos.
		return $fila;
	}

	function consultarTodos(){
		$query="Select * from usuario";
		$re=$this->conexion->query($query);
		
		$lista=array();
		while($fila=$re->fetch_Array(MYSQLI_ASSOC)){
			array_push($lista,$fila);
		}

		return $lista;
	}

	function consultaValor($columna, $valor){
		$query="select * from usuario where $columna regexp '$valor'";
		$re=$this->conexion->query($query);
		$lista=array();

		while($fila=$re->fetch_array(MYSQLI_ASSOC)){
			array_push($lista,$fila);
		}
		return $lista;
	}
}

	//$usuario1=new Usuario();//Crea un objeto de la clase usuario que contiene el constructor, primero tipo de dato de la clase usuario
	//echo($usuario1->agregar(1,'Vicente','Minero','Luna','long03017'));//5 parametros inserta un docente, 6 parametros inserta un administrativo
	//echo($usuario1->agregar1(10,'Jose','Gonzalez','Lima','123456','Administrador'));
	//echo($usuario1->borrar(1));
	//echo($usuario1->actualizar(1,'antonio','lima','dias'));
	//echo($usuario1->buscar(10));
	//if($usuario1->buscar(1)){$usuario1->borrar1();}
	//if($usuario1->buscar(1)){print_r($usuario1->consultar());}

	//print_r($usuario1->consultarTodos());

	//print_r($usuario1->consultaValor("nombre_usuario","v"));

?>