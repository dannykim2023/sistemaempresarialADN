<div id="search-results">
    <!-- Información del empleado -->
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            <i class="fas fa-user text-blue-600 mr-2"></i>Información del Empleado
        </h2>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600">Nombre completo</p>
                <p class="font-semibold text-lg">{{ $empleado->nombre }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">DNI</p>
                <p class="font-semibold text-lg">{{ $empleado->dni }}</p>
            </div>
        </div>
    </div>

    <!-- Sin resultados -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
            <i class="fas fa-exclamation-triangle text-yellow-600 text-3xl mb-4"></i>
            <h3 class="text-lg font-semibold text-yellow-800 mb-2">No se encontraron certificados</h3>
            <p class="text-yellow-700">El empleado no tiene certificados activos registrados en el sistema.</p>
        </div>
    </div>
</div>