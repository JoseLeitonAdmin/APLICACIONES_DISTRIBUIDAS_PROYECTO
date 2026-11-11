<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Subastas</title>
</head>
<body>
    <h1>Subastas</h1>

    @if (session('error'))
        <p style="color: red">{{ session('error') }}</p>
    @endif

    @foreach ($subastas as $subasta)
        <div>
            <h3>{{ $subasta->titulo }}</h3>
            <p>{{ $subasta->descripcion }}</p>
            <p>Precio actual: $<span id="precio-{{ $subasta->id }}">{{ $subasta->precio_actual }}</span></p>
            <form method="POST" action="/subastas/{{ $subasta->id }}/pujar">
                @csrf
                <input type="number" name="monto" required>
                <button type="submit">Pujar</button>
            </form>
        </div>
    @endforeach

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

        echo.channel('subastas').listen('PujaRealizada', (evento) => {
            document.getElementById('precio-' + evento.subastaId).textContent = evento.monto;
        });
    </script>
</body>
</html>