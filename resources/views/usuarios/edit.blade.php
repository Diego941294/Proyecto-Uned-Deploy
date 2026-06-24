<x-app-layout>

    <section class="gp-page-header">
        <div class="gp-page-title-row">
            <div>
                <h2 class="gp-header-title">Editar Usuario</h2>
                <p class="gp-header-subtitle">
                    Actualice la información, rol o contraseña del usuario.
                </p>
            </div>

            <a href="{{ route('usuarios.index') }}" class="gp-action-btn secondary">
                ← Volver
            </a>
        </div>
    </section>

    <div class="gp-form-shell">
        <div class="gp-form-card">

            <form method="POST" action="{{ route('usuarios.update', $usuario) }}">
                @csrf
                @method('PUT')

                <div class="gp-form-group">
                    <label class="gp-label">Nombre</label>
                    <input type="text" name="name" class="gp-input" value="{{ old('name', $usuario->name) }}" required>
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">Correo electrónico</label>
                    <input type="email" name="email" class="gp-input" value="{{ old('email', $usuario->email) }}" required>
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">Rol</label>
                    <select name="role" class="gp-input" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}"
                                @selected(old('role', $usuario->roles->first()?->name) == $role->name)>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">Nueva contraseña</label>
                    <input type="password" name="password" class="gp-input">
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">Confirmar nueva contraseña</label>
                    <input type="password" name="password_confirmation" class="gp-input">
                </div>

                <div class="gp-report-actions">
                    <button type="submit" class="gp-action-btn primary">
                         Guardar cambios
                    </button>

                    <a href="{{ route('usuarios.index') }}" class="gp-action-btn secondary">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>
    </div>

</x-app-layout>