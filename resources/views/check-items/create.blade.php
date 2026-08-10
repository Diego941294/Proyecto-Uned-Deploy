<x-app-layout>

    <x-slot name="header">

        <section class="gp-page-header">

            <div class="gp-page-title-row">

                <div>
                    <h2 class="gp-header-title">
                        Nuevo Item
                    </h2>

                    <p class="gp-header-subtitle">
                        Registrar un nuevo elemento de verificación para el checklist.
                    </p>
                </div>

                <a
                    href="{{ route('check-items.index') }}"
                    class="gp-action-btn secondary"
                >
                    ← Volver
                </a>

            </div>

        </section>

    </x-slot>


    <div class="gp-form-shell">

        <div class="gp-form-card">

            <form
                method="POST"
                action="{{ route('check-items.store') }}"
            >

                @csrf


                {{-- Mensajes de error --}}
                @if($errors->any())

                    <div class="gp-error-message">
                        {{ $errors->first() }}
                    </div>

                @endif


                {{-- Infraestructura --}}
                <div class="gp-form-group">

                    <label class="gp-label">
                        Infraestructura
                    </label>

                    <select
                        name="id_infraestructuras"
                        class="gp-input"
                        required
                    >

                        <option value="">
                            Seleccione una infraestructura
                        </option>

                        @foreach($infraestructuras as $infraestructura)

                            <option
                                value="{{ $infraestructura->id_infraestructuras }}"
                                @selected(
                                    old('id_infraestructuras')
                                    == $infraestructura->id_infraestructuras
                                )
                            >
                                {{ $infraestructura->area?->nombre ?? 'Área no disponible' }}
                                -
                                {{ $infraestructura->nombre }}
                            </option>

                        @endforeach

                    </select>

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
                        placeholder="Ejemplo: Pisos"
                        value="{{ old('nombre') }}"
                        required
                    >

                </div>


                {{-- Orden --}}
                <div class="gp-form-group">

                    <label class="gp-label">
                        Orden
                    </label>

                    <p class="gp-form-help">
                        El orden se asignará automáticamente dentro de la infraestructura seleccionada.
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
                        Guardar Item
                    </button>

                    <a
                        href="{{ route('check-items.index') }}"
                        class="gp-action-btn secondary"
                    >
                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>