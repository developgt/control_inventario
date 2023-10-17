<?php

namespace Model;

class Plaza extends ActiveRecord
{
    protected static $tabla = 'morg';
    protected static $columnasDB = [
        'org_plaza', 'org_ceom', 'org_dependencia', 'org_jerarquia', 'org_grado',
        'org_plaza_desc', 'org_situacion', 'org_cod_pago', 'org_hrs_trab',
        'org_fec_ult_mod', 'org_ord_gral', 'org_nominas', 'org_categoria'
    ];
    protected static $idTabla = 'org_plaza';

    public $org_plaza;
    public $org_ceom;
    public $org_dependencia;
    public $org_jerarquia;
    public $org_grado;
    public $org_plaza_desc;
    public $org_situacion;
    public $org_cod_pago;
    public $org_hrs_trab;
    public $org_fec_ult_mod;
    public $org_ord_gral;
    public $org_nominas;
    public $org_categoria;

    public function __construct($args = [])
    {
        $this->org_plaza = $args['org_plaza'] ?? null;
        $this->org_ceom = $args['org_ceom'] ?? '';
        $this->org_dependencia = $args['org_dependencia'] ?? null;
        $this->org_jerarquia = $args['org_jerarquia'] ?? '';
        $this->org_grado = $args['org_grado'] ?? null;
        $this->org_plaza_desc = $args['org_plaza_desc'] ?? '';
        $this->org_situacion = $args['org_situacion'] ?? '';
        $this->org_cod_pago = $args['org_cod_pago'] ?? '';
        $this->org_hrs_trab = $args['org_hrs_trab'] ?? null;
        $this->org_fec_ult_mod = $args['org_fec_ult_mod'] ?? null;
        $this->org_ord_gral = $args['org_ord_gral'] ?? '';
        $this->org_nominas = $args['org_nominas'] ?? '';
        $this->org_categoria = $args['org_categoria'] ?? '';
    }
}