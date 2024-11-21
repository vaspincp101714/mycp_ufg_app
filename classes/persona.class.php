<?php
require("conn.class.php");
require("validaciones.inc.php");

class Persona{
    public $idpersona;
    public $nombres;
    public $apelidos;
    public $fnac;
    public $telefono;
    public $email;
    public $conexion;
    public $validacion;

    /*CONEXIONES E <INTANCIAS></INTANCIAS*/
    public function __construct(){
        $this->conexion = new DB();
        $this->validacion = new Validaciones();
    }

    /*
    *GETTERS Y SETTERS
    */
    //GETTER Y SETTER DEL ATRIBUTO ID_PERSONA
    public function getIdPersona($idpersona){
        $this->idpersona = intval($idpersona);
    }

    public function getIdPersona(){
        return intval($this->idpersona);
    }

    //GETTER Y SETTER DEL ATRIBUTO NOMBRES
    public function getIdNombres($nombres){
        $this->nombres = $nombres;
    }

    public function getNombres(){
        return $this->nombres;
    }

     //GETTER Y SETTER DEL ATRIBUTO APELLIDO
     public function getApellidos($apellidos){
        $this->setApellidos = $apellidos;
    }

    public function getApellidos(){
        return $this->apellidos;
    }

    //GETTER Y SETTER DEL ATRIBUTO FNAC
    public function setFnac($fnac){
        $this->fnac = $fnac;
    }

    public function getFnac(){
        return $this->fnac;
    }

    //GETTER Y SETTER DEL ATRIBUTO TELEFONO
    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }

    public function getTelefono(){
        return $this->telefono;
    }

    //GETTER Y SETTER DEL ATRIBUTO EMAIL
    public function setEmail($email){
        $this->email = $email;
    }

    public function getEmail(){
        return $this->email;
    }

    /**
     * FIN DE LOS GETTER Y SETTER
     */
    #---------------------------------------------------#
    /**
     * INICIO DE LOS METODOS PARA PROCESAMIENTO DE DATOS
     */

     public function obtenerPersona(int $idpersona){
        if($idpersona > 0){
            $resultado = $this->conexion->run("SELECT * FROM persona WHERE id_persona=" .$idpersona);
            $array = array("mensaje"=>"Registros encontrados","valores"=>$resultado->fetch());
            return $array;
        }else{
            $array = array("mensaje"=>"No se pudo ejecutar la consulta, el parametro ID es incorrecto","valores"=>"");
        }
     }

     public function nuevapersona($nombres,$apelidos,$fnac,$telefono,$email){
        $bandera_validacion = 0;
        //VALIDAMOS LOS NOMBRES
        if($this->validacion::verificar_solo_letras(trim($nombres),true)){
            $this->setNombres($nombres);
        }else{
            $bandera_validacion++;
        }
        //VALIDAMOS LOS APELLIDOS
        if($this->validacion::verificar_solo_letras(trim($apellidos),true)){
            $this->setApellidos($apellidos);
        }else{
            $bandera_validacion++;
        }
        //VALIDAMOS LA FECHA DE NACIMIENTO
        if($this->validacion::verificar_fecha($fnac, "Y-m-d")){
            $this->setFnac($fnac);
        }else{
            $bandera_validacion++;
        }
         //VALIDAMOS NUMERO TELEFONICO
         if($this->validacion::verificar_telefono($telefono)){
            $this->setTelefono($telefono);
        }else{
            $bandera_validacion++;
        }
         //VALIDAMOS EL CORREO ELECTRONICO
         if($this->validacion::verificar_email($email)){
            $this->setEmail($email);
        }else{
            $bandera_validacion++;
        }

        if($bandera_validacion === 0){
            $parametros = array(
                "nom" =>$this->getNombres(),
                "ape" =>$this->getApellidos(),
                "fnac" =>$this->getFnac(),
                "email" =>$this->getEmail()
            );
            $resultado = $this->conexion->run("INSERT INTO persona(nombre,apellidos,fnac,telefono,email)VALUE(:nom,:ape,fnac,:tel,;email);",$parametros);
            if($this->conexion->n > 0 and $this->conexion->id > 0){
                //SI SE INSERTARON LOS DATOS
                $resultado = $this->obtenerPersona($this->conxion->id);
                $array = array("mensaje"=>"Se ha registrado la persona correctamente","valores"=>$resultado);
                return $array;
            }else{
                $array = array("mensaje"=>"Hubo un problema al registrar la persona","valores"=>"");
                return $array;
            }

        }else{
            $array = array("mensaje"=>"Existe al menos un campo obligatorio que no se ha enviado","valores"=>"");
                return $array;
        }
     }

}

?>