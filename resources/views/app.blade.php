<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- CDN de jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <!-- CDN de Datatables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
        <script src="https://cdn.jsdelivr.net/npm/vue@3"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

        <!-- Material icons -->
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead

        <script>
            // Función que muestra un toast
            function showToast(message, type) {
                const toast = document.createElement('div');

                if(type === 'error') {
                    toast.classList.add('bg-red-500');
                } else {
                    toast.classList.add('bg-green-500');
                }

                toast.classList.add('fixed', 'bottom-0', 'right-0', 'm-5', 'w-fit', 'z-50', 'p-5', 'text-white');
                toast.innerHTML = `<p>${message}</p>`;

                // Añadir el toast al body
                document.body.appendChild(toast);
            
                // Remover el toast del DOM una vez que la transición termine
                setTimeout(() => {
                        toast.remove();
                    }, 1500); // Este tiempo debe coincidir con la duración de la transición CSS
            
            }

        </script>

        
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
