<?php

namespace Model;

class Almacen extends ActiveRecord{
    protected static $tabla = 'inv_almacenes'; 
    protected static $columnasDB = ['alma_nombre', 'alma_descripcion', 'alma_unidad', 'alma_situacion'];
    protected static $idTabla = 'alma_id'; 
   

    public $alma_id;
    public $alma_nombre;
    public $alma_descripcion;
    public $alma_unidad;
    public $alma_situacion;

    public function __construct($args = []){
        $this->alma_id = $args['alma_id'] ?? null;
        $this->alma_nombre = $args['alma_nombre'] ?? '';
        $this->alma_descripcion = $args['alma_descripcion'] ?? '';
        $this->alma_unidad = $args['alma_unidad'] ?? '';
        $this->alma_situacion = $args['alma_situacion'] ?? 1;
    }
}
