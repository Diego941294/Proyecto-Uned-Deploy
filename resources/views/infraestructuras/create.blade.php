<x-app-layout>

    <div class="gp-page-header">
        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                    Nueva Infraestructura
                </h2>

                <p class="gp-header-subtitle">
                    Registrar una nueva sección o infraestructura.
                </p>
            </div>

            <a
                href="{{ route('infraestructuras.index') }}"
                class="gp-action-btn secondary"
            >
                ← Volver
            </a>

        </div>
    </div>


    <div class="gp-form-shell">

        <div class="gp-form-card">

            {{-- Error enviado desde el controlador --}}
            @if(session('error'))
                <div class="gp-error-message">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Errores de validación --}}
            @if($errors->any())
                <div class="gp-error-message">
                    <strong>No se pudo guardar la infraestructura:</strong>

                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form
                method="POST"
                action="{{ route('infraestructuras.store') }}"
            >

                @csrf


                {{-- Área --}}
                <div class="gp-form-group">

                    <label class="gp-label">
                        Área
                    </label>

                    <select
                        name="id_areas"
                        class="gp-input"
                        required
                    >

                        <option value="">
                            Seleccione un área
                        </option>

                        @foreach($areas as $area)

                            <option
                                value="{{ $area->id_areas }}"
                                @selected(old('id_areas') == $area->id_areas)
                            >
                                {{ $area->nombre }}
                            </option>

                        @endforeach

                    </select>

                    @error('id_areas')
                        <p class="gp-field-error">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Nombre --}}
                <div class="gp-form-group">

                    <label class="gp-label">
                        Nombre
                    </label>

                    <input
                        type="text"
                        name="nombre"
                        class="gp-input"
                        value="{{ old('nombre') }}"
                        required
                    >

                    @error('nombre')
                        <p class="gp-field-error">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Código --}}
                <div class="gp-form-group">

                    <label class="gp-label">
                        Código asignado
                    </label>

                    <div class="gp-code-preview">
                        {{ $codigoSugerido }}
                    </div>

                    <p class="gp-help-text">
                        Este código será asignado automáticamente al guardar.
                    </p>

                </div>


                {{-- Estado --}}
                <div class="gp-form-group">

                    <label class="gp-label">
                        Estado
                    </label>

                    <select
                        name="activo"
                        class="gp-input"
                        required
                    >

                        <option
                            value="1"
                            @selected(old('activo', '1') == '1')
                        >
                            Activo
                        </option>

                        <option
                            value="0"
                            @selected(old('activo') == '0')
                        >
                            Inactivo
                        </option>

                    </select>

                </div>


                {{-- Acciones --}}
                <div class="gp-report-actions">

                    <button
                        type="submit"
                        class="gp-action-btn primary"
                    >
                        Guardar
                    </button>

                    <a
                        href="{{ route('infraestructuras.index') }}"
                        class="gp-action-btn secondary"
                    >
                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </div>


    <style>
        .gp-error-message {
            margin-bottom: 20px;
            padding: 14px 16px;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 10px;
            font-weight: 600;
        }

        .gp-error-message ul {
            margin-top: 8px;
            padding-left: 20px;
        }

        .gp-field-error {
            margin-top: 6px;
            color: #991b1b;
            font-size: 13px;
            font-weight: 600;
        }
    </style>

</x-app-layout>