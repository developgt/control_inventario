<?php

namespace Model;

class Unimedida extends ActiveRecord
{
    protected static $tabla = 'inv_uni_med';
    protected static $columnasDB = ['uni_nombre', 'uni_almacen', 'uni_situacion'];
    protected static $idTabla = 'uni_id';

    public $uni_id;
    public $uni_nombre;
    public $uni_almacen;
    public $uni_situacion;
   

    public function __construct($args = [])
    {
        $this->uni_id = $args['uni_id'] ?? null;
        $this->uni_nombre = $args['uni_nombre'] ?? '';
        $this->uni_almacen = $args['uni_almacen'] ?? '';
        $this->uni_situacion = $args['uni_situacion'] ?? 1;
    }
}
