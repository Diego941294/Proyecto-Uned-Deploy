<x-app-layout>

    <section class="gp-page-header">
        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                    Editar Check Item
                </h2>

                <p class="gp-header-subtitle">
                    Actualizar elemento de verificación del sistema.
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


    <div class="gp-form-shell">

        <div class="gp-form-card">

            <div class="gp-detail-section-title">
                <h3>
                    Información del Check Item #{{ $checkItem->id_check_items }}
                </h3>

                <p>
                    Modifique los datos necesarios y guarde los cambios.
                </p>
            </div>


            <form
                method="POST"
                action="{{ route('check-items.update', $checkItem) }}"
            >

                @csrf
                @method('PUT')


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
                                    old(
                                        'id_infraestructuras',
                                        $checkItem->id_infraestructuras
                                    )
                                    ==
                                    $infraestructura->id_infraestructuras
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
                        value="{{ old('nombre', $checkItem->nombre) }}"
                        required
                    >

                </div>


                {{-- Orden --}}
                <div class="gp-form-group">

                    <label class="gp-label">
                        Orden
                    </label>

                    <p class="gp-form-help">
                        El orden se administra automáticamente dentro de la infraestructura.
                    </p>

                    <p class="gp-form-help">
                        Orden actual:
                        <strong>
                            {{ $checkItem->orden }}
                        </strong>
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
                            @selected(
                                old('activo', $checkItem->activo) == 1
                            )
                        >
                            Activo
                        </option>


                        <option
                            value="0"
                            @selected(
                                old('activo', $checkItem->activo) == 0
                            )
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
                        Guardar cambios
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