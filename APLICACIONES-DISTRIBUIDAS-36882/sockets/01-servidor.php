<?php

$servidor = stream_socket_server('tcp://0.0.0.0:9000', $codigo,$error);
echo "Servidor escuchando el puerto 9000 \n";

// $cliente = stream_socket_accept($servidor, -1, $quien);
// echo "Se conectó: $quien \n";

// fwrite($cliente, "Hola soy el servidor");

// fclose($cliente);

While(true){
    $cliente = stream_socket_accept($servidor, -1, $quien);
    echo "Se conectó: $quien \n";

    fwrite($cliente, "Hola soy el servidor\n");

    while(($linea = fgets($cliente))!== false){
        $linea = trim($linea);
        echo "[$quien] $linea \n";
        fwrite($cliente, strtoupper($linea)."\n");
    }
    fclose($cliente);
    echo "Se desconectó: $quien \n";
}

?>