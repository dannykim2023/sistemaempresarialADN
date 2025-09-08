<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Certificados - Agencia DN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-block p-4 bg-white rounded-full shadow-lg mb-6">
                <i class="fas fa-file-certificate text-4xl text-blue-600"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Consulta de Certificados</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Ingresa tu número de DNI para consultar tus certificados emitidos
            </p>
        </div>

        <!-- Formulario de búsqueda -->
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-2xl p-8 mb-8">
            <form id="search-form">
                @csrf
                
                <div class="mb-6">
                    <label for="dni" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-id-card text-blue-600 mr-2"></i>Número de DNI
                    </label>
                    <input 
                        type="text" 
                        id="dni" 
                        name="dni" 
                        required 
                        maxlength="12"
                        placeholder="Ingresa tu DNI (solo números)"
                        pattern="[0-9]+"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    >
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-105"
                    id="search-button"
                >
                    <i class="fas fa-search mr-2"></i>Buscar Certificados
                </button>
            </form>

            <!-- Loading spinner (oculto inicialmente) -->
            <div id="loading" class="hidden mt-6 text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                <p class="text-gray-600 mt-2">Buscando certificados...</p>
            </div>
        </div>

        <!-- Área de resultados (inicialmente vacía) -->
        <div id="results-container" class="max-w-6xl mx-auto">
            <!-- Los resultados se cargarán aquí via AJAX -->
        </div>

        <!-- Información adicional -->
        <div class="max-w-4xl mx-auto mt-16 grid md:grid-cols-3 gap-8">
            <div class="text-center p-6 bg-white rounded-xl shadow-lg">
                <div class="text-blue-600 text-3xl mb-4">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="font-semibold text-lg mb-2">Seguro</h3>
                <p class="text-gray-600">Tus datos están protegidos y se manejan con confidencialidad.</p>
            </div>

            <div class="text-center p-6 bg-white rounded-xl shadow-lg">
                <div class="text-green-600 text-3xl mb-4">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3 class="font-semibold text-lg mb-2">Rápido</h3>
                <p class="text-gray-600">Obtén tus certificados en segundos con solo tu DNI.</p>
            </div>

            <div class="text-center p-6 bg-white rounded-xl shadow-lg">
                <div class="text-purple-600 text-3xl mb-4">
                    <i class="fas fa-print"></i>
                </div>
                <h3 class="font-semibold text-lg mb-2">Imprimible</h3>
                <p class="text-gray-600">Descarga tus certificados en formato PDF para imprimir.</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-16">
            <p class="text-gray-500">
                <i class="fas fa-building text-blue-600 mr-2"></i>
                Agencia DN - Sistema de Gestión de Certificados
            </p>
            <p class="text-sm text-gray-400 mt-2">
                &copy; {{ date('Y') }} Todos los derechos reservados
            </p>
        </div>
    </div>

    <!-- JavaScript para AJAX -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('search-form');
            const resultsContainer = document.getElementById('results-container');
            const loading = document.getElementById('loading');
            const searchButton = document.getElementById('search-button');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const dni = document.getElementById('dni').value.trim();
                
                if (!dni) {
                    alert('Por favor ingresa un número de DNI');
                    return;
                }

                // Mostrar loading
                loading.classList.remove('hidden');
                searchButton.disabled = true;
                resultsContainer.innerHTML = '';

                // Hacer petición AJAX
                fetch('{{ route("certificados.buscar.ajax") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ dni: dni })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        resultsContainer.innerHTML = data.html;
                    } else {
                        resultsContainer.innerHTML = data.html;
                    }
                })
                .catch(error => {
                    resultsContainer.innerHTML = `
                        <div class="bg-red-50 border border-red-200 rounded-xl p-6 text-center">
                            <i class="fas fa-exclamation-triangle text-red-600 text-3xl mb-4"></i>
                            <h3 class="text-lg font-semibold text-red-800 mb-2">Error</h3>
                            <p class="text-red-700">Ocurrió un error al procesar la búsqueda.</p>
                        </div>
                    `;
                })
                .finally(() => {
                    loading.classList.add('hidden');
                    searchButton.disabled = false;
                });
            });
        });
    </script>
</body>
</html>