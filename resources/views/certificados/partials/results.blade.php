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
            @if($empleado->email)
            <div>
                <p class="text-sm text-gray-600">Email</p>
                <p class="font-semibold">{{ $empleado->email }}</p>
            </div>
            @endif
            @if($empleado->telefono)
            <div>
                <p class="text-sm text-gray-600">Teléfono</p>
                <p class="font-semibold">{{ $empleado->telefono }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Certificados -->
    <div class="max-w-4xl mx-auto">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">
            <i class="fas fa-file-certificate text-green-600 mr-2"></i>
            Certificados Encontrados: {{ $certificados->count() }}
        </h2>

        <div class="space-y-4">
            @foreach($certificados as $certificado)
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex-1">
                        <h3 class="font-semibold text-lg text-gray-800 mb-2">
                            {{ $certificado->titulo }}
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600 mb-4">
                            <div>
                                <span class="font-medium">Número:</span> {{ $certificado->numero_certificado }}
                            </div>
                            <div>
                                <span class="font-medium">Emisión:</span> {{ $certificado->fecha_emision->format('d/m/Y') }}
                            </div>
                            <div>
                                <span class="font-medium">Tipo:</span> 
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                    {{ $certificado->tipo_certificado }}
                                </span>
                            </div>
                        </div>
                        <p class="text-gray-700 line-clamp-2">
                                            {{ strip_tags($certificado->contenido) }}
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0 md:ml-6 flex space-x-2">
                        <a href="{{ url('/certificados/ver/' . $certificado->id) }}" 
                           target="_blank"
                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                            <i class="fas fa-eye mr-2"></i>Ver
                        </a>
                        <a href="{{ url('/certificados/descargar/' . $certificado->id) }}" 
                           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                            <i class="fas fa-download mr-2"></i>PDF
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>