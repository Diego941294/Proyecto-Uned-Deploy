<x-app-layout>

    <section class="gp-page-header">
        <div class="gp-page-title-row">
            <div>
                <h2 class="gp-header-title">Nuevo Usuario</h2>
                <p class="gp-header-subtitle">
                    Cree un usuario interno y asigne su rol de acceso.
                </p>
            </div>

            <a href="{{ route('usuarios.index') }}" class="gp-action-btn secondary">
                ← Volver
            </a>
        </div>
    </section>

    <div class="gp-form-shell">
        <div class="gp-form-card">

            <form method="POST" action="{{ route('usuarios.store') }}">
                @csrf

                <div class="gp-form-group">
                    <label class="gp-label">Nombre</label>
                    <input type="text" name="name" class="gp-input" value="{{ old('name') }}" required>
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">Correo electrónico</label>
                    <input type="email" name="email" class="gp-input" value="{{ old('email') }}" required>
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">Contraseña</label>
                    <input type="password" name="password" class="gp-input" required>
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" class="gp-input" required>
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">Rol</label>
                    <select name="role" class="gp-input" required>
                        <option value="">Seleccione un rol</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" @selected(old('role') == $role->name)>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="gp-report-actions">
                    <button type="submit" class="gp-action-btn primary">
                         Crear Usuario
                    </button>

                    <a href="{{ route('usuarios.index') }}" class="gp-action-btn secondary">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>
    </div>

</x-app-layout>