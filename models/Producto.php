<?php

namespace Model;

class Producto extends ActiveRecord
{
    protected static $tabla = 'inv_producto';
    protected static $columnasDB = ['pro_clase_id',  'pro_nom_articulo', 'pro_descripcion', 'pro_situacion'];
    protected static $idTabla = 'pro_id';

    public $pro_id;
    public $pro_clase_id;
    public $pro_nom_articulo;
    public $pro_descripcion;
    public $pro_situacion;
  


    public function __construct($args = [])
    {
        $this->pro_id = $args['pro_id'] ?? null;
        $this->pro_clase_id = $args['pro_clase_id'] ?? '';
        $this->pro_nom_articulo = $args['pro_nom_articulo'] ?? '';
        $this->pro_descripcion = $args['pro_descripcion'] ?? '';
        $this->pro_situacion = $args['pro_situacion'] ?? 1;

    }
}




