<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Sala de pruebas</title>
</head>
<body>
    <h1>Sala de pruebas</h1>
    <p>Estado de la conexión: <strong id="estado">iniciando...</strong></p>
    <ul id="mensajes"></ul>

    <script src="https://cdn.jsdelivr.net/npm/pusher-js@8.4.0/dist/web/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.19.0/dist/echo.iife.js"></script>
    <script>
        const echo = new Echo({
            broadcaster: 'reverb',
            key: '{{ config('broadcasting.connections.reverb.key') }}',
            wsHost: window.location.hostname,
            wsPort: 8080,
            forceTLS: false,
            enabledTransports: ['ws'],
        });

        echo.connector.pusher.connection.bind('state_change', (estados) => {
            document.getElementById('estado').textContent = estados.current;
        });

        echo.channel('sala').listen('MensajeSala', (evento) => {
            const item = document.createElement('li');
            item.textContent = evento.texto;
            document.getElementById('mensajes').appendChild(item);
        });
    </script>
</body>
</html>