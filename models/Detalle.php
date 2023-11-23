<?php

namespace Model;



class Detalle extends ActiveRecord
{
    protected static $tabla = 'inv_deta_movimientos';
    protected static $columnasDB = ['det_mov_id', 'det_pro_id', 'det_uni_med', 'det_lote', 'det_fecha_vence', 'det_estado', 'det_cantidad', 'det_cantidad_existente', 'det_cantidad_lote', 'det_observaciones', 'det_situacion'];
    protected static $idTabla = 'det_id';

    public $det_id;
    public $det_mov_id;
    public $det_pro_id;
    public $det_uni_med;
    public $det_lote;
    public $det_fecha_vence;
    public $det_estado;
    public $det_cantidad;
    public $det_cantidad_existente;
    public $det_cantidad_lote;
    public $det_observaciones;
    public $det_situacion;

  


    public function __construct($args = [])
    {
        $this->det_id = $args['det_id'] ?? null;
        $this->det_mov_id  = $args['det_mov_id'] ?? '';
        $this->det_pro_id = $args['det_pro_id'] ?? '';
        $this->det_uni_med = $args['det_uni_med'] ?? '';
        $this->det_lote = $args['det_lote'] ?? '';
        $this->det_fecha_vence = $args['det_fecha_vence'] ?? '07/05/1999';
        $this->det_estado = $args['det_estado'] ?? '';
        $this->det_cantidad = $args['det_cantidad'] ?? '';
        $this->det_cantidad_existente = $args['det_cantidad_existente'] ?? '';
        $this->det_cantidad_lote = $args['det_cantidad_lote'] ?? '';
        $this->det_observaciones = $args['det_observaciones'] ?? '';
        $this->det_situacion = $args['det_situacion'] ?? 1;
        
    }


}



