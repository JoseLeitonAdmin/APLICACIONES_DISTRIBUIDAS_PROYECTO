<?php
$conexion = stream_socket_client('tcp://127.0.0.1:9000', $codigo, $error, 5);
echo "Conectado al servidor\n";

while (true) {
    $lectura = [STDIN, $conexion];
    $escritura = null;
    $excepciones = null;

    stream_select($lectura, $escritura, $excepciones, null);

    if (in_array(STDIN, $lectura, true)) {
        $linea = fgets(STDIN);
        if ($linea === false) {
            break;
        }
        fwrite($conexion, $linea);
    }

    if (in_array($conexion, $lectura, true)) {
        $mensaje = fgets($conexion);
        if ($mensaje === false) {
            echo "El servidor cerró la conexión\n";
            break;
        }
        echo $mensaje;
    }
}

fclose($conexion);