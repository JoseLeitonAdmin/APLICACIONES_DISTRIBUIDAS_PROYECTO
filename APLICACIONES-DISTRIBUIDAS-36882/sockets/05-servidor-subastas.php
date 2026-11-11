<?php

$servidor = stream_socket_server('tcp://0.0.0.0:9000', $codigo, $error);
echo "Servidor de Subastas escuchando en el puerto 9000\n";

$clientes = [];
$precio = 100;
$lider = 'nadie';

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
            fwrite($nuevo, "Bienvenido a la subasta. Precio actual: $precio (Lider: $lider)\n");
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

        $linea = trim($linea);

        if ($linea === '') {
            continue;
        }

        echo "[$quien] $linea\n";

        $partes = explode(' ', $linea);
        $comando = strtoupper($partes[0]);

        if ($comando === 'PRECIO') {
            fwrite($socket, "PRECIO $precio $lider\n");
        } elseif ($comando === 'PUJAR' && count($partes) === 2 && is_numeric($partes[1])) {
            $monto = (float) $partes[1];
            if ($monto <= $precio) {
                fwrite($socket, "ERROR la puja debe superar $precio\n");
            } else {
                $precio = $monto;
                $lider = $quien;
                fwrite($socket, "OK puja aceptada: $monto\n");
                foreach ($clientes as $otro) {
                    if ($otro !== $socket) {
                        fwrite($otro, "NUEVA $monto $lider\n");
                    }
                }
            }
        } else {
            fwrite($socket, "ERROR use PRECIO o PUJAR monto\n");
        }
    }
}