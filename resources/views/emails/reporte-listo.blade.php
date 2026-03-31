<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
<title>Reporte de Productos</title>
</head>
<body style="font-family: sans-serif; background-color: #f1f5f9; padding: 20px; margin: 0;">
<div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 40px; border-radius: 12px; text-align: center; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
<h1 style="color: #1e293b; margin-bottom: 20px; font-size: 24px;">¡Tu reporte está listo!</h1>

    <p style="color: #475569; font-size: 16px; margin-bottom: 30px; line-height: 1.5;">
        El archivo CSV con la lista de productos se ha generado correctamente y está listo para ser descargado.
    </p>

    <div style="margin: 30px 0;">
        <a href="{{ $url }}" 
           style="display: inline-block; padding: 14px 32px; background-color: #1e293b; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px;">
            Descargar Reporte CSV
        </a>
    </div>

    <p style="margin-top: 40px; font-size: 12px; color: #94a3b8; border-top: 1px solid #f1f5f9; padding-top: 20px;">
        <strong>Generado el:</strong> {{ $fecha }} <br>
        ZurielitoApp - Práctica 16: Jobs y Colas
    </p>
</div>


</body>
</html>