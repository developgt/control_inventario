<?php

namespace Model;

class Estado extends ActiveRecord
{
    protected static $tabla = 'inv_estado';
    protected static $columnasDB = ['est_descripcion', 'est_dependencia', 'est_situacion'];
    protected static $idTabla = 'est_id';

    public $est_id;
    public $est_descripcion;
    public $est_dependencia;
    public $est_situacion;
   

    public function __construct($args = [])
    {
        $this->est_id = $args['est_id'] ?? null;
        $this->est_descripcion = $args['est_descripcion'] ?? '';
        $this->est_dependencia = $args['est_dependencia'] ?? '';
        $this->est_situacion = $args['est_situacion'] ?? 1;
    }
}
