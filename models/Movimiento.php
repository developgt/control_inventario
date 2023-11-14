<?php

namespace Model;



class Movimiento extends ActiveRecord
{
    protected static $tabla = 'inv_movimientos';
    protected static $columnasDB = ['mov_tipo_mov', 'mov_tipo_trans', 'mov_alma_id', 'mov_perso_entrega', 'mov_perso_recibe', 'mov_perso_respon', 'mov_fecha', 'mov_proce_destino', 'mov_descrip', 'mov_situacion'];
    protected static $idTabla = 'mov_id';

    public $mov_id;
    public $mov_tipo_mov;
    public $mov_tipo_trans;
    public $mov_alma_id;
    public $mov_perso_entrega;
    public $mov_perso_recibe;
    public $mov_perso_respon;
    public $mov_fecha;
    public $mov_proce_destino;
    public $mov_descrip;
    public $mov_situacion;

  


    public function __construct($args = [])
    {
        $this->mov_id = $args['mov_id'] ?? null;
        $this->mov_tipo_mov = $args['mov_tipo_mov'] ?? '';
        $this->mov_tipo_trans = $args['mov_tipo_trans'] ?? '';
        $this->mov_alma_id = $args['mov_alma_id'] ?? '';
        $this->mov_perso_entrega = $args['mov_perso_entrega'] ?? '';
        $this->mov_perso_recibe = $args['mov_perso_recibe'] ?? '';
        $this->mov_perso_respon = $args['mov_perso_respon'] ?? '';
        $this->mov_fecha = $args['mov_fecha'] ?? date('Y-m-d');
        $this->mov_proce_destino = $args['mov_proce_destino'] ?? '';
        $this->mov_descrip = $args['mov_descrip'] ?? '';
        $this->mov_situacion = $args['mov_situacion'] ?? 1;
        
    }


}






