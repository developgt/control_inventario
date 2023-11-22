<?php

namespace Controllers;

use Exception;
use Model\Usuario;
use Model\Guarda;
use Model\Almacen;
use Model\Producto;
use Model\Movimiento;
use MVC\Router;


class KardexController {
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
        $router->render('kardex/index', [
            'usuario' => $usuario,
         ]);
       }

       public static function buscarProducto($almacenNombre)
       {
           try {
               // Obtener el id del almacén basado en el nombre
               $almacenId = self::obtenerIdAlmacenPorNombre($almacenNombre);
       
               // Verificar si se obtuvo un id de almacén válido
               if ($almacenId !== false) {
                   // Consulta SQL para obtener los productos asociados al almacén
                   $sql = "SELECT p.pro_nom_articulo
                           FROM inv_producto p
                           JOIN inv_almacenes a ON p.pro_almacen_id = a.alma_id
                           WHERE a.alma_id = :almacenId";
       
                   // Ejecutar la consulta SQL y obtener el resultado
                   $productos = Producto::fetchArray($sql, [':almacenId' => $almacenId]);
       
                   // Verificar si se obtuvieron resultados
                   if (!empty($productos)) {
                       // Devolver la respuesta como un array asociativo
                       echo json_encode(['productos' => $productos]);
                   } else {
                       // Si no hay productos asociados al almacén, devolver un mensaje indicándolo
                       echo json_encode([
                           'detalle' => 'No se encontraron productos asociados al almacén.',
                           'mensaje' => 'No hay productos',
                           'codigo' => 1
                       ]);
                   }
               } else {
                   // Si no se pudo obtener el id del almacén, devolver un mensaje de error
                   echo json_encode([
                       'detalle' => 'No se pudo obtener el id del almacén.',
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
              
   
       
}
