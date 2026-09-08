<x-app-layout>

    <section class="gp-page-header">
        <div class="gp-page-title-row">
            <div>
                <h2 class="gp-header-title">Usuarios del sistema</h2>
                <p class="gp-header-subtitle">
                    Administración de usuarios y roles del sistema.
                </p>
            </div>

            <div class="gp-header-actions">
                <a href="{{ route('super-admin.dashboard') }}" class="gp-action-btn secondary">
                    ← Volver
                </a>

                <a href="{{ route('usuarios.create') }}" class="gp-action-btn primary">
                    + Nuevo Usuario
                </a>
            </div>
        </div>
    </section>

    <div class="gp-reports-panel">

        <div class="gp-reports-toolbar">
            <div>
                <h3>Usuarios registrados</h3>
                <p>Consulta, edita o elimina usuarios del sistema.</p>
            </div>
        </div>

        <div class="gp-table-modern-wrap">
            <table class="gp-table-modern">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($usuarios as $usuario)
                       <tr>
    <td data-label="Nombre">{{ $usuario->name }}</td>
    <td data-label="Correo">{{ $usuario->email }}</td>
    <td data-label="Rol">{{ $usuario->roles->pluck('name')->join(', ') ?: 'Sin rol' }}</td>
    <td data-label="Acciones" class="text-center">
        <div class="gp-action-group">
            <a href="{{ route('usuarios.edit', $usuario) }}" class="gp-view-button">✏️ Editar</a>
            <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}" onsubmit="return confirm('¿Desea eliminar este usuario?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="gp-delete-button">🗑 Eliminar</button>
            </form>
        </div>
    </td>
</tr>
                    @empty
                        <tr>
                            <td colspan="5" class="gp-empty-table">
                                No hay usuarios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>


</x-app-layout>