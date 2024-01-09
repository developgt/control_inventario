<?php


namespace Controllers;

use Exception;
use Model\Almacen;
use Model\Detalle;
use Model\Estado;
use Model\Mper;
use Model\Mdep;
use MVC\Router;
use Model\Guarda;
use Model\Medida;
use Model\Usuario;
use Model\Movimiento;
use Model\Producto;

class MovimientoController
{

    public static function index(Router $router){
        isAuth();
        try {
            $usuario = Usuario::fetchFirst("
            
            SELECT
            per_catalogo,
            TRIM(per_nom1) || ' ' || TRIM(per_nom2) || ' ' || TRIM(per_ape1) || ' ' || TRIM(per_ape2) as nombre,
            per_desc_empleo as empleo,
            dep_desc_lg as dependencia,
            gra_desc_md as grado
        FROM
            mper
        INNER JOIN
            morg ON per_plaza = org_plaza
        INNER JOIN
            mdep ON org_dependencia = dep_llave
        INNER JOIN
            grados ON per_grado = gra_codigo
        WHERE
            per_catalogo = user;

            ");
            
        } catch (Exception $e) {
            getHeadersApi();
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Error de conexión bd",
        
                "codigo" => 5,
            ]);
            exit;
        }
        $router->render('movimiento/index', [
            'usuario' => $usuario,
        ]);
    }


    public static function buscarDependenciaAPI()

    {
        $sql = "SELECT dep_llave, dep_desc_md FROM mdep";
        try {
            $dependencias = Mdep::fetchArray($sql);

            header('Content-Type: application/json');

            echo json_encode($dependencias);
        } catch (Exception $e) {
            echo json_encode([]);
        }
    }

    public static function buscarDependenciaInternaAPI()

    {
        $sql = "SELECT dep_llave, dep_desc_md FROM mper, morg, mdep where per_plaza = org_plaza and org_dependencia= dep_llave and per_catalogo = user";
        try {
            $dependencias = Mdep::fetchArray($sql);

            header('Content-Type: application/json');

            echo json_encode($dependencias);
        } catch (Exception $e) {
            
            echo json_encode([]);
        }
    }



    public static function buscarAlmacenesAPI()
    {
        $sql = "select alma_id, alma_nombre,alma_clase from inv_almacenes, inv_guarda_almacen where alma_id = guarda_almacen and guarda_catalogo = user and guarda_situacion = 1";
        try {
            $almacen = Almacen::fetchArray($sql);

            header('Content-Type: application/json');

            echo json_encode($almacen);
        } catch (Exception $e) {
           
            echo json_encode([]);
        }
    }

    
    public static function buscarAlmacenesMovimientosAPI()
    {
        $sql = "select alma_id, alma_nombre,alma_clase from inv_almacenes, inv_guarda_almacen where alma_id = guarda_almacen and guarda_catalogo = user and guarda_situacion = 1";
        try {
            $almacen = Almacen::fetchArray($sql);

            header('Content-Type: application/json');

            echo json_encode($almacen);
        } catch (Exception $e) {
         
            echo json_encode([]);
        }
    }

    //funcion para buscar oficiales

    public static function buscarOficialesAPI()
    {
        $mov_perso_entrega = $_GET['mov_perso_entrega'] ?? '';

        $sql = "SELECT  trim(gra_desc_ct) || ' DE ' || trim(arm_desc_md)  || ' ' || trim(per_ape1) || ' ' || trim(per_ape2) || ', ' || trim(per_nom1)  || ', ' || trim(per_nom2) as mov_perso_entrega_nom
              FROM mper inner join grados on per_grado = gra_codigo
              INNER JOIN armas on per_arma = arm_codigo
              where per_catalogo = $mov_perso_entrega";

        try {
            $oficial = Mper::fetchArray($sql);

            header('Content-Type: application/json');

           
            echo json_encode($oficial);
            return;
        } catch (Exception $e) {
           
            echo json_encode([]);
        }
    }



    //funcion para buscar oficiales

    public static function buscarOficialesRecibeAPI()
    {
        $mov_perso_recibe = $_GET['mov_perso_recibe'] ?? '';

        $sql = "SELECT  trim(gra_desc_ct) || ' DE ' || trim(arm_desc_md)  || ' ' || trim(per_ape1) || ' ' || trim(per_ape2) || ', ' || trim(per_nom1)  || ', ' || trim(per_nom2) as mov_perso_recibe_nom
              FROM mper inner join grados on per_grado = gra_codigo
              INNER JOIN armas on per_arma = arm_codigo
              where per_catalogo = $mov_perso_recibe";

        try {
            $oficial = Mper::fetchArray($sql);

           
            header('Content-Type: application/json');

           
            echo json_encode($oficial);
            return;
        } catch (Exception $e) {
            
            echo json_encode([]);
        }
    }



    //funcion para buscar oficiales

    public static function buscarOficialesResponsableAPI()
    {
        $mov_perso_respon = $_GET['mov_perso_respon'] ?? '';

        $sql = "SELECT  trim(gra_desc_ct) || ' DE ' || trim(arm_desc_md)  || ' ' || trim(per_ape1) || ' ' || trim(per_ape2) || ', ' || trim(per_nom1)  || ', ' || trim(per_nom2) as mov_perso_respon_nom
              FROM mper inner join grados on per_grado = gra_codigo
              INNER JOIN armas on per_arma = arm_codigo
              where per_catalogo = $mov_perso_respon";

        try {
            $oficial = Mper::fetchArray($sql);

            header('Content-Type: application/json');

            echo json_encode($oficial);
            return;
        } catch (Exception $e) {
           
            echo json_encode([]);
        }
    }

    public static function buscarEstadosAPI()
    {
        $sql = "SELECT est_descripcion, est_id 
        FROM inv_estado
        WHERE est_situacion = 1";
        try {
            $estado = Estado::fetchArray($sql);

            
            header('Content-Type: application/json');
          
            echo json_encode($estado);
        } catch (Exception $e) {
            
            echo json_encode([]);
        }
    }

    
    public static function buscarProductoAPI()
    {

        $almaSeleccionadoId = $_GET['almaSeleccionadoId'];



        $sql = "SELECT pro_id, pro_nom_articulo, 
        inv_almacenes.alma_nombre AS pro_almacen_id
        FROM inv_producto
        JOIN inv_almacenes ON inv_producto.pro_clase_id = inv_almacenes.alma_clase
        WHERE inv_almacenes.alma_id = $almaSeleccionadoId AND inv_producto.pro_situacion = 1";

        try {

            $producto = Producto::fetchArray($sql);

            header('Content-Type: application/json');

            echo json_encode($producto);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function buscarProductoModalAPI()
    {

        $almaSeleccionadoId = $_GET['almaSeleccionId'];



        $sql = "SELECT pro_id, pro_nom_articulo, inv_uni_med.uni_nombre AS pro_medida, 
                inv_almacenes.alma_nombre AS pro_almacen_id
                FROM inv_producto
                JOIN inv_uni_med ON inv_producto.pro_medida = inv_uni_med.uni_id
                JOIN inv_almacenes ON inv_producto.pro_almacen_id = inv_almacenes.alma_id
                WHERE inv_almacenes.alma_id = $almaSeleccionadoId AND inv_producto.pro_situacion = 1";

        try {

            $producto = Producto::fetchArray($sql);

            header('Content-Type: application/json');

            echo json_encode($producto);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


    
    public static function buscarMovimientosAPI()
    {

        $almaSeleccionadoId = $_GET['mov_alma'];



        $sql = "    
        SELECT m.*, 
        a.alma_nombre, 
        d.dep_desc_md,
        -- Datos de la persona que entrega
        trim(ge.gra_desc_ct) || ' DE ' || trim(ae.arm_desc_md) || ' ' || 
        trim(pe.per_ape1) || ' ' || trim(pe.per_ape2) || ', ' || 
        trim(pe.per_nom1) || ', ' || trim(pe.per_nom2) as mov_perso_entrega_nom,
        -- Datos de la persona que recibe
        trim(gr.gra_desc_ct) || ' DE ' || trim(ar.arm_desc_md) || ' ' || 
        trim(pr.per_ape1) || ' ' || trim(pr.per_ape2) || ', ' || 
        trim(pr.per_nom1) || ', ' || trim(pr.per_nom2) as mov_perso_recibe_nom,
        -- Datos de la persona responsable
        trim(g.gra_desc_ct) || ' DE ' || trim(arm.arm_desc_md) || ' ' || 
        trim(per.per_ape1) || ' ' || trim(per.per_ape2) || ', ' || 
        trim(per.per_nom1) || ', ' || trim(per.per_nom2) as mov_perso_respon_nom
        FROM inv_movimientos AS m
        JOIN inv_almacenes AS a ON m.mov_alma_id = a.alma_id
        LEFT JOIN mdep AS d ON a.alma_unidad = d.dep_llave
        LEFT JOIN inv_guarda_almacen AS ga ON a.alma_id = ga.guarda_almacen 
        -- Datos de la persona que entrega
        LEFT JOIN mper AS pe ON m.mov_perso_entrega = pe.per_catalogo
        LEFT JOIN grados AS ge ON pe.per_grado = ge.gra_codigo
        LEFT JOIN armas AS ae ON pe.per_arma = ae.arm_codigo
        -- Datos de la persona que recibe
        LEFT JOIN mper AS pr ON m.mov_perso_recibe = pr.per_catalogo
        LEFT JOIN grados AS gr ON pr.per_grado = gr.gra_codigo
        LEFT JOIN armas AS ar ON pr.per_arma = ar.arm_codigo
        -- Datos de la persona responsable
        LEFT JOIN mper AS per ON m.mov_perso_respon = per.per_catalogo
        LEFT JOIN grados AS g ON per.per_grado = g.gra_codigo
        LEFT JOIN armas AS arm ON per.per_arma = arm.arm_codigo
        WHERE 
         ga.guarda_almacen = a.alma_id 
        AND ga.guarda_catalogo = user
        AND ga.guarda_situacion = 1
        AND m.mov_tipo_mov = 'I'";

        if ($almaSeleccionadoId != '') {
            $almaSeleccionadoId = ($almaSeleccionadoId);
            $sql .= " AND a.alma_id = $almaSeleccionadoId  ORDER BY m.mov_id DESC ";
         } else {
            $sql .= " ORDER BY m.mov_id DESC ";
         }

        try {

            $movimiento = Movimiento::fetchArray($sql);

            header('Content-Type: application/json');

            echo json_encode($movimiento);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


    

    public static function buscarUnidadesAPI()
    {
        $almaSeleccionadoId = $_GET['almaSeleccionadoId'];

        $sql = "SELECT uni_nombre, uni_id 
        FROM inv_uni_med
        JOIN inv_almacenes ON inv_uni_med.uni_clase = inv_almacenes.alma_clase
        WHERE inv_almacenes.alma_id = $almaSeleccionadoId AND uni_situacion = 1";
        try {
            $medida = Medida::fetchArray($sql);

            header('Content-Type: application/json');

           
            echo json_encode($medida);
        } catch (Exception $e) {
           
            echo json_encode([]);
        }
    }

    public static function guardarAPI()
    {
        try {

            $movimiento = new Movimiento($_POST);
            $resultado = $movimiento->crear();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1,
                    'id' => $resultado['id'] // Devuelve el ID del registro recién insertado
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function buscarDetalleMovimientoAPI()
    {
        $det_mov_id = $_GET['det_mov_id'] ?? '';
      

        $sql = "SELECT m.*, d.*, e.est_descripcion, u.uni_nombre, p.pro_nom_articulo
        FROM inv_movimientos AS m
        JOIN inv_deta_movimientos AS d ON m.mov_id = d.det_mov_id
        LEFT JOIN inv_estado AS e ON d.det_estado = e.est_id
        LEFT JOIN inv_uni_med AS u ON d.det_uni_med = u.uni_id
        LEFT JOIN inv_producto AS p ON d.det_pro_id = p.pro_id
        WHERE d.det_mov_id = $det_mov_id AND d.det_situacion = 1";

        try {

            $detalle = Detalle::fetchArray($sql);

            echo json_encode($detalle);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    
    public static function buscarDetalleIngresadoAPI()
    {
        $det_mov_id = $_GET['det_mov_id'] ?? '';
      

        $sql = "SELECT m.*, 
              a.alma_nombre, 
              d.dep_desc_md,
              -- Datos de la persona que entrega
              trim(ge.gra_desc_ct) || ' DE ' || trim(ae.arm_desc_md) || ' ' || 
              trim(pe.per_ape1) || ' ' || trim(pe.per_ape2) || ', ' || 
              trim(pe.per_nom1) || ', ' || trim(pe.per_nom2) as mov_perso_entrega_nom,
              -- Datos de la persona que recibe
              trim(gr.gra_desc_ct) || ' DE ' || trim(ar.arm_desc_md) || ' ' || 
              trim(pr.per_ape1) || ' ' || trim(pr.per_ape2) || ', ' || 
              trim(pr.per_nom1) || ', ' || trim(pr.per_nom2) as mov_perso_recibe_nom,
              -- Datos de la persona responsable
              trim(g.gra_desc_ct) || ' DE ' || trim(arm.arm_desc_md) || ' ' || 
              trim(per.per_ape1) || ' ' || trim(per.per_ape2) || ', ' || 
              trim(per.per_nom1) || ', ' || trim(per.per_nom2) as mov_perso_respon_nom
       FROM inv_movimientos AS m
       JOIN inv_almacenes AS a ON m.mov_alma_id = a.alma_id
       LEFT JOIN mdep AS d ON a.alma_unidad = d.dep_llave
       -- Datos de la persona que entrega
       LEFT JOIN mper AS pe ON m.mov_perso_entrega = pe.per_catalogo
       LEFT JOIN grados AS ge ON pe.per_grado = ge.gra_codigo
       LEFT JOIN armas AS ae ON pe.per_arma = ae.arm_codigo
       -- Datos de la persona que recibe
       LEFT JOIN mper AS pr ON m.mov_perso_recibe = pr.per_catalogo
       LEFT JOIN grados AS gr ON pr.per_grado = gr.gra_codigo
       LEFT JOIN armas AS ar ON pr.per_arma = ar.arm_codigo
       -- Datos de la persona responsable
       LEFT JOIN mper AS per ON m.mov_perso_respon = per.per_catalogo
       LEFT JOIN grados AS g ON per.per_grado = g.gra_codigo
       LEFT JOIN armas AS arm ON per.per_arma = arm.arm_codigo
       WHERE m.mov_situacion = 1 AND m.mov_id = $det_mov_id";

        try {

            $detalle = Detalle::fetchArray($sql);

            echo json_encode($detalle);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

        /// para buscar la cantidad del formulario detalle 

        public static function buscarAlmacenPorDetalleMovimientoAPI()
        {
            $almacen = $_GET['det_mov_id'] ?? '';
           
    
    
            $sql ="SELECT mov_alma_id
            FROM inv_movimientos
            WHERE mov_id = $almacen";
            try {
    
                $detalle = Detalle::fetchArray($sql);
    
                echo json_encode($detalle);
            } catch (Exception $e) {
                echo json_encode([
                    'detalle' => $e->getMessage(),
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }
        }

    /// para buscar la cantidad del formulario detalle 

    public static function buscarCantidadAPI()
    {
        $det_pro_id = $_GET['det_pro_id'] ?? '';
        $det_uni_med = $_GET['det_uni_med'] ?? '';
        $alma_id = $_GET['alma_id'] ?? '';


        $sql ="SELECT 
        dm.det_cantidad_existente
    FROM 
        inv_deta_movimientos dm
    INNER JOIN 
        inv_movimientos m ON dm.det_mov_id = m.mov_id
    INNER JOIN 
        inv_almacenes a ON m.mov_alma_id = a.alma_id
    INNER JOIN 
        inv_guarda_almacen ga ON a.alma_id = ga.guarda_almacen
    WHERE 
        dm.det_pro_id = $det_pro_id 
        AND dm.det_situacion = 1 
        AND dm.det_uni_med = $det_uni_med
        AND ga.guarda_catalogo = user
        AND ga.guarda_situacion = 1
        AND m.mov_alma_id = $alma_id
        AND dm.det_id = (
            SELECT 
                MAX(det_id) 
            FROM 
                inv_deta_movimientos 
            WHERE 
                det_pro_id = $det_pro_id 
                AND det_situacion = 1 
                AND det_uni_med = $det_uni_med
        )
    GROUP BY 
        dm.det_cantidad_existente
    ";
        try {

            $detalle = Detalle::fetchArray($sql);

            echo json_encode($detalle);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    ///BUSCAR LA CANTIDAD DE ACUERDO AL LOTE Y ESTADO DEL FORM DETALLE
    public static function buscarCantidadLoteAPI()
    {
        $det_pro_id = $_GET['det_pro_id'] ?? '';
        $det_uni_med = $_GET['det_uni_med'] ?? '';
        $det_lote = $_GET['det_lote'] ?? '';
        $det_estado = $_GET['det_estado'] ?? '';
        $det_fecha_vence = $_GET['det_fecha_vence'] ?? '';
        $alma_id = $_GET['alma_id'] ?? '';




        // $sql = "SELECT det_cantidad_lote from inv_deta_movimientos where det_pro_id = $det_pro_id and det_situacion = 1 and det_uni_med = '$det_uni_med' and det_lote = '$det_lote' and det_estado = $det_estado and det_fecha_vence = '$det_fecha_vence'
        // and det_id = (select max(det_id) from  inv_deta_movimientos where det_pro_id = $det_pro_id and det_situacion = 1 and det_uni_med = '$det_uni_med' and det_lote = '$det_lote' and det_estado = $det_estado and det_fecha_vence = '$det_fecha_vence' )
        // group by det_cantidad_lote";


        $sql = "SELECT 
        dm.det_cantidad_lote
    FROM 
        inv_deta_movimientos dm
    INNER JOIN 
        inv_movimientos m ON dm.det_mov_id = m.mov_id
    INNER JOIN 
        inv_almacenes a ON m.mov_alma_id = a.alma_id
    INNER JOIN 
        inv_guarda_almacen ga ON a.alma_id = ga.guarda_almacen
    WHERE 
        dm.det_pro_id = $det_pro_id 
        AND dm.det_situacion = 1 
        AND dm.det_uni_med = '$det_uni_med' 
        AND dm.det_lote = '$det_lote' 
        AND dm.det_estado = $det_estado 
        AND dm.det_fecha_vence = '$det_fecha_vence'
        AND ga.guarda_catalogo = user
        AND ga.guarda_situacion = 1
        AND m.mov_alma_id = $alma_id

        AND dm.det_id = (
            SELECT 
                MAX(det_id) 
            FROM 
                inv_deta_movimientos 
            WHERE 
                det_pro_id = $det_pro_id 
                AND det_situacion = 1 
                AND det_uni_med = '$det_uni_med' 
                AND det_lote = '$det_lote' 
                AND det_estado = $det_estado 
                AND det_fecha_vence = '$det_fecha_vence'
        )
    GROUP BY 
        dm.det_cantidad_lote;
    ";

        try {

            $detalle = Detalle::fetchArray($sql);

            echo json_encode($detalle);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


    public static function guardarDetalleAPI()
    {
        try {

            
        $datosDetalle = $_POST;

       
        if (empty($datosDetalle['det_fecha_vence'])) {
            $datosDetalle['det_fecha_vence'] = '1999/05/07';
        }

     
        $movimiento = new Detalle($datosDetalle);
        $resultado = $movimiento->crear();

            if ($resultado['resultado'] == 1) {
                header('Content-Type: application/json');

                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1,

                ]);
            } else {
                header('Content-Type: application/json');

                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');

            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


  
    public static function buscarDetallePorIngresoAPI()
    {
        $det_mov_id = $_GET['IdMovimiento'] ?? '';


        $sql = "SELECT m.*, d.*, e.est_descripcion, u.uni_nombre, p.pro_nom_articulo
        FROM inv_movimientos AS m
        JOIN inv_deta_movimientos AS d ON m.mov_id = d.det_mov_id
        LEFT JOIN inv_estado AS e ON d.det_estado = e.est_id
        LEFT JOIN inv_uni_med AS u ON d.det_uni_med = u.uni_id
        LEFT JOIN inv_producto AS p ON d.det_pro_id = p.pro_id
        WHERE d.det_mov_id = $det_mov_id AND d.det_situacion = 1";

        try {

            $detalle = Detalle::fetchArray($sql);

            echo json_encode($detalle);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


    public static function eliminarAPI() {
        try {
            $det_id = $_POST['det_id'];
            $detalle = Detalle::find($det_id);
            $detalle->det_situacion = 0;
            $resultado = $detalle->actualizar();
    
            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => "Se ha eliminado el registro con éxito.",
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => "No se pudo eliminar el detalle",
                    'codigo' => 0
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


    public static function modificarAPI() {
        try {
            $mov_id = $_POST['mov_id'];
            $estado = Movimiento::find($mov_id);
            $estado->mov_situacion = 2;
            $resultado = $estado->actualizar();
    
            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => "Se modifico el registro",
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => "No se pudo modificar",
                    'codigo' => 0
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
    
    

}
