<?php

namespace Model;

class Guarda extends ActiveRecord
{
    protected static $tabla = 'inv_guarda_almacen';
    protected static $columnasDB = ['guarda_catalogo', 'guarda_almacen', 'guarda_situacion'];
    protected static $idTabla = 'guarda_id';

    public $guarda_id;
    public $guarda_catalogo;
    public $guarda_almacen;
    public $guarda_situacion;
   

    public function __construct($args = [])
    {
        $this->guarda_id = $args['guarda_id'] ?? null;
        $this->guarda_catalogo = $args['guarda_catalogo'] ?? '';
        $this->guarda_almacen = $args['guarda_almacen'] ?? '';
        $this->guarda_situacion = $args['guarda_situacion'] ?? 1;
    }
}
