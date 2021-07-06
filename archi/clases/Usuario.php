<?php

    require_once 'Conexion.php';

    class Usuario extends Conectar{

        public function agregarUsuario($datos){
            
            $conexion = Conectar::conexion();

            if(self::buscarUsuarioRepetido($datos['usuario'])){
                return 2;
            }else{
                $sql = "INSERT INTO t_usuarios(nombre,
                                            fechaNacimiento,
                                            email,
                                            usuario,
                                            password)                                             
                                            values(?, ?, ?, ?, ?)";

            $query = $conexion->prepare($sql);
            $query->bind_param('sssss',$datos['nombre'],
                                        $datos['fechaNacimiento'],
                                        $datos['email'],
                                        $datos['usuario'],
                                        $datos['password'],);

            $exito = $query->execute();
            $query->close();
            return $exito;
        }
        }
        public  function buscarUsuarioRepetido($usuario){
            $conexion = Conectar::conexion();

            $sql = "SELECT usuario
                    FROM t_usuarios
                    WHERE usuario = '$usuario'";
            $result = mysqli_query($conexion,$sql);

            $datos = mysqli_fetch_array($result);
            $datos = isset($datos['usuario']);

            if($datos == true){
                return 1;
            }else{
                return 0;
            }
        }

        public function login($usuario,$password){
            $conexion = Conectar::conexion();

            $sql = "SELECT count(*) as existeUsuario
                        FROM t_usuarios 
                        WHERE usuario = '$usuario'
                        AND password = '$password'";
            $result = mysqli_query($conexion,$sql) ;

            $respuesta = mysqli_fetch_array($result)['existeUsuario']; //nos regresa un contador de registros, mando a llamra por un nombre como si fuera asociativo 

            if($respuesta > 0 ){
                $_SESSION['usuario'] = $usuario;//creamos una seccion 
                    //creamos una consulta pedimos el ode de ususraio 
                $sql = "SELECT id_usuarios 
                        FROM t_usuarios
                        WHERE usuario = '$usuario'
                        AND password = '$password'";
                $result = mysqli_query($conexion,$sql) ; 
                $idUsuario = mysqli_fetch_row($result)[0];///aqui en el fech_row mando a llamar  por numero de arreglo los campos e convierten en arreglos 

                $_SESSION['idUsuario'] = $idUsuario; // agregamos id usuario 

                return 1;
            }else{
                return 0;
            }
        }
    }

?>