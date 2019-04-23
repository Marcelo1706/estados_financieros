<?php 

function login_usuario($config,$objBD,$carnet,$pass){

	//Hacer consulta
	$datos = $objBD->leer_uno('usuarios',"*",array('usuario' => $carnet));
	if(gettype($datos) == 'string'){
		//Manejo de errores
		echo '
			<script type="text/javascript">
				swal({
					text: "'.$datos.'",
					title: "Error",
					icon: "error"
				})
			</script>
			';
	} else {
		if(count($datos) == 1){
			$pass1 = $datos[0]['clave'];
			if($pass1 == base64_encode(md5($pass))){
				$role = $datos[0]['privilegios'];
				crear_sesion($config,$carnet,$role);
			} else {
				echo '
				<script type="text/javascript">
					swal({
						text: "La contraseña Proporcionada es Incorrecta",
						title: "Error",
						icon: "error"
					})
				</script>
				';
			}
		} else {
			echo '
			<script type="text/javascript">
				swal({
					text: "No se puede encontrar el usuario, si es correcto, verifique que el Tipo de Usuario sea el adecuado",
					title: "Error",
					icon: "error"
				})
			</script>
			';
		}
	}
}

function crear_sesion($config,$carnet,$role){
	switch($role){
		case '1':
			$_SESSION['user@cemonterrosa'] = $carnet;
			$_SESSION['location'] = "/".$config['rutaBase']."/".$config['administracion']."index";
			$_SESSION['role'] = $role;
			$_SESSION['carpeta'] = "administracion";
			header('location: '.$_SESSION['location']);
		break;
		case '2':
			$_SESSION['user@cemonterrosa'] = $carnet;
			$_SESSION['location'] = "/".$config['rutaBase']."/".$config['asistencia']."index";
			$_SESSION['role'] = $role;
			$_SESSION['carpeta'] = "asistencia";
			header('location: '.$_SESSION['location']);
		break;
	}
}

function registrar_admin($carnet,$pass1,$pass2,$objBD){
	if($pass1 != $pass2){
		echo '
			<script type="text/javascript">
				swal({
					text: "Las contraseñas no coinciden",
					icon: "warning",
					button: "Aceptar"
				})
			</script>
		';
	} else {
		if(count($objBD->leer_uno("administradores","*",array('usuario' => $carnet))) > 0){
			echo '
				<script type="text/javascript">
					swal({
						text: "Ya existe un administrador con ese carnet",
						icon: "warning",
						button: "Aceptar"
					})
				</script>
			';
		} else {
			$valores = array(
				'usuario' => $carnet,
				'clave' => base64_encode($pass2)
			);
			$exito = $objBD->insertar("administradores",$valores);
			if($exito == 1){
				echo '
					<script type="text/javascript">
						swal({
							text: "Administrador Registrado Exitosamente",
							icon: "success",
							button: "Aceptar"
						})
					</script>
				';
			}else{
				echo '<script type="text/javascript">
						swal({
							text: "Error '.$exito.'",
							icon: "error",
							button: "Aceptar"
						})
					</script>';
			}
		}
    }
}

function subir_archivo($archivo){
    if (isset($archivo)) {

        //if there was an error uploading the file
        if ($archivo["error"] > 0) {
            echo "Return Code: " . $archivo["error"] . "<br />";

        }
        else {
            //if file already exists
            if (file_exists($config['upload'] . $archivo["name"])) {
                echo $archivo["name"] . " already exists. ";
            }
            else {
                //Store file in directory "upload" with the name of "uploaded_file.txt"
                $storagename = $config['upload']."alumnos.csv";
                if(move_uploaded_file($archivo["tmp_name"], $storagename))
                    return $storagename;
                else
                    return false;
            }
        }
    } else {
            echo "No file selected <br />";
    }
}

function insertar_csv($tabla,$archivo,$objBD){
	
	$archivo = fopen($archivo,"r");
	fseek($archivo,0);
	$cadenaInsert = array();

	while(($columnasCSV = fgetcsv($archivo)) !== false){
		$cadenaInsert[] = $columnasCSV;
	}
	fclose($archivo);

	$arrInsert = array();
	$i = 0;

	foreach($cadenaInsert as $c){
		if($i == 0){
			$arrInsert[] = "('".substr($c[0],3,strlen($c[0]))."','".$c[1]."','".$c[2]."','".$c[3]."','".$c[4]."')";			
		}else{
			$arrInsert[] = "('".$c[0]."','".$c[1]."','".$c[2]."','".$c[3]."','".$c[4]."')";			
		}
		$i++;
	}

	// var_dump($arrInsert);

    $strInsert = implode(",",$arrInsert);

	// var_dump($strInsert);
    $campos = array("id_alumno","nombre","nie","genero","id_grado");
    $exito = $objBD->bulk_insert('alumno',$campos,$strInsert);
    if($exito > 0){
        echo '
            <script type="text/javascript">
                swal({
                    text: "Registro Realizado Exitosamente",
                    icon: "success",
                    button: "Aceptar"
                })
            </script>
        ';
    }else{
        echo '<script type="text/javascript">
                swal({
                    text: "Error '.$exito.'",
                    icon: "error",
                    button: "Aceptar"
                })
            </script>';
    }
}

function llenar_opciones($objBD,$tabla){
	$opciones = $objBD->leer_uno($tabla,'*');
	if($tabla == 'justificacion'){
		foreach($opciones as $op){
			echo '<option value="'.$op['id_'.$tabla].'">'.$op['razon'].'</option>';
		}
	}else{			
		foreach($opciones as $op){
			echo '<option value="'.$op['id_'.$tabla].'">'.$op['nombre'].'</option>';
		}
	}
	
}

function insertar_json($archivo,$objBD){
	$archivo = fopen($archivo,"r");
	fseek($archivo,0);
	$arrAsistencia = array();
	$resultado = 0;
	while(!feof($archivo)){
		$arrAsistencia[] = json_decode(fgets($archivo));
	}
	if(count($arrAsistencia) == 2){
		$asistencia = $arrAsistencia[0];
		$observaciones = $arrAsistencia[1];
		$resultado+=$objBD->json_to_mysql($asistencia,"asistencia");
		$resultado+=$objBD->json_to_mysql($observaciones,"observaciones");
		if($resultado > 0){

		}
		
	} elseif(count($arrAsistencia) == 1) {
		$asistencia = $arrAsistencia[0];
		$resultado+=$objBD->json_to_mysql($asistencia,"asistencia");
	} else {
		echo "Formato Incorrecto de archivo";
	}
	if($resultado > 0){
		echo '
            <script type="text/javascript">
                swal({
                    text: "Registro Realizado Exitosamente",
                    icon: "success",
                    button: "Aceptar"
                })
            </script>
        ';
    }else{
        echo '<script type="text/javascript">
                swal({
                    text: "Error al insertar los registros",
                    icon: "error",
                    button: "Aceptar"
                })
            </script>';
    }
}

function bussiness_days($begin_date, $end_date, $type = 'array') {
	$date_1 = date_create($begin_date);
	$date_2 = date_create($end_date);
	if ($date_1 > $date_2) return FALSE;
	$bussiness_days = array();
	while ($date_1 <= $date_2) {
		$day_week = $date_1->format('w');
		if ($day_week > 0 && $day_week < 6) {
			$bussiness_days[$date_1->format('Y-m')][] = $date_1->format('d');
		}
		date_add($date_1, date_interval_create_from_date_string('1 day'));
	}
	if (strtolower($type) === 'sum') {
	    array_map(function($k) use(&$bussiness_days) {
	        $bussiness_days[$k] = count($bussiness_days[$k]);
	    }, array_keys($bussiness_days));
	}
	return $bussiness_days;
}
?>