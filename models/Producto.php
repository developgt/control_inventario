<?php

namespace Model;

class Producto extends ActiveRecord
{
    protected static $tabla = 'inv_producto';
    protected static $columnasDB = ['pro_almacen_id', 'pro_medida', 'pro_nom_articulo', 'pro_estado', 'pro_no_serie', 'pro_vencimiento', 'pro_descripcion', 'pro_situacion'];
    protected static $idTabla = 'pro_id';

    public $pro_id;
    public $pro_almacen_id;
    public $pro_medida;
    public $pro_nom_articulo;
    public $pro_estado;
    public $pro_no_serie;
    public $pro_vencimiento;
    public $pro_descripcion;
    public $pro_situacion;
  


    public function __construct($args = [])
    {
        $this->pro_id = $args['pro_id'] ?? null;
        $this->pro_almacen_id = $args['pro_almacen_id'] ?? '';
        $this->pro_medida = $args['pro_medida'] ?? '';
        $this->pro_nom_articulo = $args['pro_nom_articulo'] ?? '';
        $this->pro_estado = $args['pro_estado'] ?? '';
        $this->pro_no_serie = $args['pro_no_serie'] ?? '';
        $this->pro_vencimiento = $args['pro_vencimiento'] ?? '';
        $this->pro_descripcion = $args['pro_descripcion'] ?? '';
        $this->pro_situacion = $args['pro_situacion'] ?? 1;

    }
}




