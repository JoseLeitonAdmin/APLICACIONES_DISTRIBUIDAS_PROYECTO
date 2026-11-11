<?php

$conexion = stream_socket_client('tcp://127.0.0.1:9000', $codigo, $error, 10);
echo "Conectado al servidor \n";

// $mensaje = fgets($conexion);
// echo "El servidor dijo: $mensaje";

echo "El servidor dijo: ".fgets($conexion);

while (($linea = fgets(STDIN)) !== false) {
    fwrite($conexion, $linea);
    echo"La respuesta es: ".fgets($conexion);

}

fclose($conexion);

?>