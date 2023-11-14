<?php

namespace Model;

class Mdep extends ActiveRecord
{
    protected static $tabla = 'mdep';
    protected static $columnasDB = ['dep_llave', 'dep_desc_lg', 'dep_desc_md', 'dep_desc_ct', 'dep_clase', 'dep_precio', 'dep_ejto'];
    protected static $idTabla = 'dep_llave';

    public $dep_llave;
    public $dep_desc_lg;
    public $dep_desc_md;
    public $dep_desc_ct;
    public $dep_clase;
    public $dep_precio;
    public $dep_ejto;

    public function __construct($args = [])
    {
        $this->dep_llave = $args['dep_llave'] ?? null;
        $this->dep_desc_lg = $args['dep_desc_lg'] ?? '';
        $this->dep_desc_md = $args['dep_desc_md'] ?? '';
        $this->dep_desc_ct = $args['dep_desc_ct'] ?? '';
        $this->dep_clase = $args['dep_clase'] ?? '';
        $this->dep_precio = $args['dep_precio'] ?? '';
        $this->dep_ejto = $args['dep_ejto'] ?? '';
    }
}