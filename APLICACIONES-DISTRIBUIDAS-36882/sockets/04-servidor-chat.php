<?php
$servidor = stream_socket_server('tcp://0.0.0.0:9000', $codigo, $error);
echo "Servidor (select) escuchando en el puerto 9000\n";

$clientes = [];

while (true) {
    $lectura = $clientes;
    $lectura[] = $servidor;
    $escritura = null;
    $excepciones = null;

    stream_select($lectura, $escritura, $excepciones, null);

    foreach ($lectura as $socket) {
        if ($socket === $servidor) {
            $nuevo = stream_socket_accept($servidor);
            $clientes[] = $nuevo;
            echo "Se conectó: " . stream_socket_get_name($nuevo, true) . "\n";
            fwrite($nuevo, "Hola, soy el servidor\n");
            continue;
        }

        $quien = stream_socket_get_name($socket, true);
        $linea = fgets($socket);

        if ($linea === false) {
            echo "Se desconectó: $quien\n";
            unset($clientes[array_search($socket, $clientes, true)]);
            fclose($socket);
            continue;
        }

        // $linea = trim($linea);
        // echo "[$quien] $linea\n";
        // fwrite($socket, strtoupper($linea) . "\n");

        $linea = trim($linea);
        echo "[$quien] $linea\n";

        foreach ($clientes as $otro) {
            if ($otro !== $socket) {
                fwrite($otro, "[$quien] $linea\n");
            }
        }

    }
}