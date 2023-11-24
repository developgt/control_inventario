<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reporte de Kardex</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
            .report-header { text-align: center; margin-top: 20px; }
            .report-details { text-align: center; margin-top: 5px; }
            .report-title { font-size: 24px; margin: 20px 0; color: #333; }
            .styled-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.9em;
                margin-bottom: 30px;
            }
            .styled-table th {
                background-color: #f2f2f2; 
                color: #000000;
            }
            .styled-table td {
                color: #000000; 
            }
            .styled-table th, .styled-table td {
                padding: 12px 15px;
                border: 1px solid #050505;
            }
            .signature-section {
                text-align: center;
                margin-top: 60px;
            }
            .signature-recibi-entregue {
                float: left;
                width: 30%;
            }
            .signature-entregue {
                float: right; 
                width: 30%; 
            }
            .signature-line {
                border-top: 2px solid #000;
                margin: 10px;
                width: 80%; 
            }
            .signature-name {
                font-size: 0.7em;
                text-align: center;
                margin-top: 5px;
            }
            .firma {
                font-size: 0.9em;
                text-align: center;
                margin-top: 5px;
                margin-bottom: 50px;
                font-weight: bold;
                color: #333;
            }
            .signature-responsable {
                display: block;
                margin: 150px auto;
                width: 30%;
            }
            .fecha {
                float: right;
                width: 40%;
            }
            .ingreso {
                float: left;
                width: 40%;
            }
        </style>
    </head>
    <body>
        <div class="report-header">
            <h1 class="report-title">Kardex de Productos</h1>
            <div class="ingreso">
                <span class="left">No. de ingreso: ${datos.length > 0 ? datos[0].mov_id : ''}</span>
            </div>
            <div class="fecha">
                <span class="right">Fecha del Reporte: ${new Date().toLocaleDateString()}</span>
            </div>
        </div>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Inventario al que Ingreso</th>
                    <th>Tipo de Movimiento</th>
                    <th>Fecha</th>
                    <th>Nombre del Producto</th>
                    <th>Estado del Insumo</th>
                    <th>Unidad de Medida</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Cantidad</th>
                    <th>Procedencia</th>
                </tr>
            </thead>
            <tbody>
                ${datos.map((movimiento, index) => `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${movimiento.alma_nombre}</td>
                        <td>${movimiento.mov_tipo_trans == 'I' ? 'Ingreso Interno' : (movimiento.mov_tipo_trans == 'E' ? 'Ingreso Externo' : movimiento.mov_tipo_trans)}</td>
                        <td>${movimiento.mov_fecha}</td>
                        <td>${movimiento.pro_nom_articulo}</td>
                        <td>${movimiento.est_descripcion}</td>
                        <td>${movimiento.uni_nombre}</td>
                        <td>${movimiento.det_fecha_vence == '1999-05-07' ? 'Sin fecha de vencimiento' : movimiento.det_fecha_vence}</td>
                        <td>${movimiento.det_cantidad}</td>
                        <td>${movimiento.dep_desc_md}</td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    </body>
    </html>