<?php

namespace Controllers;

use Exception;
use Model\Usuario;
use Model\Guarda;
use Model\Almacen;
use MVC\Router;

class MenuController {
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
        $router->render('menu/index', [
            'usuario' => $usuario,
        ]);
    }

    public static function buscarAlmacen()
    {
    
        $sql = "
            SELECT inv_almacenes.alma_nombre
            FROM mper
            JOIN inv_guarda_almacen ON mper.per_catalogo = inv_guarda_almacen.guarda_catalogo
            JOIN inv_almacenes ON inv_guarda_almacen.guarda_almacen = inv_almacenes.alma_id
            WHERE mper.per_catalogo = user";
    
        try {
          
            // Ejecutar la consulta SQL para obtener nombres de almacenes para el usuario.
            $almacenes = Almacen::fetchArray($sql);
            
            // Devolver la respuesta como un array asociativo
            echo json_encode(['almacenes' => $almacenes]);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
        //console.log(data);
    }
   
    
}

