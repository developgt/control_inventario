<?php


namespace Controllers;

use Exception;
use Model\Almacen;
use Model\Estado;
use Model\Mper;
use MVC\Router;
use Model\Guarda;
use Model\Medida;
use Model\Producto;
use Model\Usuario;

class ProductoController
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
        $router->render('producto/index', [
            'usuario' => $usuario,
        ]);
    }


    //funcion para buscar almacenes


    public static function buscarAlmacenesAPI()
    {
        $sql = "select alma_nombre, alma_id from inv_almacenes, mper, morg, mdep where per_plaza = org_plaza and org_dependencia= dep_llave and alma_unidad = dep_llave and per_catalogo = user
        and alma_situacion = 1";
        try {
            $almacen = Almacen::fetchArray($sql);

            header('Content-Type: application/json');

            echo json_encode($almacen);
        } catch (Exception $e) {
        
            echo json_encode([]);
        }
    }

    public static function buscarUnidadesAPI()
    {
        $sql = "SELECT uni_nombre, uni_id, inv_almacenes.alma_id, inv_almacenes.alma_nombre as uni_almacen 
        FROM inv_uni_med
        JOIN inv_almacenes ON inv_uni_med.uni_almacen = inv_almacenes.alma_id
        JOIN mdep ON inv_almacenes.alma_unidad = mdep.dep_llave
        JOIN morg ON mdep.dep_llave = morg.org_dependencia
        JOIN mper ON morg.org_plaza = mper.per_plaza
        WHERE mper.per_catalogo = user AND inv_uni_med.uni_situacion = 1;
        ";
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

     
            foreach ($_POST as $key => $value) {
                $_POST[$key] = strtoupper($value);
            }

            $guarda = new Producto($_POST);
            $resultado = $guarda->crear();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1
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


    public static function buscarAPI()
    {

        $pro_almacen_id = $_GET['pro_almacen_id'] ?? '';
        $pro_medida = $_GET['pro_medida'] ?? '';
        $pro_nom_articulo = $_GET['pro_nom_articulo'] ?? '';
        $pro_descripcion = $_GET['pro_descripcion'] ?? '';


        $sql = "SELECT pro_id, pro_nom_articulo, pro_descripcion, inv_uni_med.uni_nombre AS pro_medida, 
        inv_almacenes.alma_nombre AS pro_almacen_id
        FROM inv_producto
        JOIN inv_uni_med ON inv_producto.pro_medida = inv_uni_med.uni_id
        JOIN inv_almacenes ON inv_producto.pro_almacen_id = inv_almacenes.alma_id
        JOIN mdep ON inv_almacenes.alma_unidad = mdep.dep_llave
        JOIN morg ON mdep.dep_llave = morg.org_dependencia
        JOIN mper ON morg.org_plaza = mper.per_plaza
        WHERE mper.per_catalogo = user AND inv_producto.pro_situacion = 1
";

        if ($pro_almacen_id != '') {
            $pro_almacen_id = strtolower($pro_almacen_id);
            $sql .= " AND LOWER(pro_almacen_id) LIKE '%$pro_almacen_id%' ";
        }
        if ($pro_medida != '') {
            $pro_medida = strtolower($pro_medida);
            $sql .= " AND LOWER(pro_medida) LIKE '%$pro_medida%' ";
            }
            if ($pro_nom_articulo != '') {
                $pro_nom_articulo = strtolower($pro_nom_articulo);
                $sql .= " AND LOWER(pro_nom_articulo) LIKE '%$pro_nom_articulo%' ";
                 }
                    if ($pro_descripcion != '') {
                        $pro_descripcion = strtolower($pro_descripcion);
                        $sql .= " AND LOWER(pro_descripcion) LIKE '%$pro_descripcion%' ";
                    }


        try {

            $producto = Producto::fetchArray($sql);

            echo json_encode($producto);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
}
