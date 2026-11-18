
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Privacidad | Guana Pollo</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: #f5f6f8;
            color: #263238;
            font-family: Arial, sans-serif;
            line-height: 1.7;
        }
        header {
            background: #a51e25;
            color: white;
            text-align: center;
            padding: 38px 20px;
        }
        header h1 { margin: 0; font-size: 30px; }
        header p { margin: 8px 0 0; }
        main {
            max-width: 850px;
            margin: 35px auto;
            padding: 35px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 18px rgba(0,0,0,.06);
        }
        h2 { color: #a51e25; font-size: 20px; margin-top: 28px; }
        a { color: #a51e25; }
        footer {
            text-align: center;
            padding: 25px;
            color: #666;
            font-size: 14px;
        }
        @media(max-width: 600px) {
            main { margin: 15px; padding: 22px; }
            header h1 { font-size: 25px; }
        }
    </style>
</head>
<body>
    <header>
        <h1>Guana Pollo</h1>
        <p>Política de Privacidad</p>
    </header>

    <main>
        <p><strong>Última actualización:</strong> 18 de noviembre de 2026</p>

        <p>
            Guana Pollo utiliza un sistema de gestión de reportes
            preoperacionales para registrar, consultar, revisar y aprobar
            información relacionada con sus procesos internos.
            Esta política describe el tratamiento de la información
            dentro de dicho sistema.
        </p>

        <h2>1. Información recopilada</h2>
        <p>
            El sistema puede almacenar nombres, direcciones de correo
            electrónico, credenciales protegidas, roles, firmas y
            registros de actividades realizadas por los usuarios.
            También almacena los reportes preoperacionales, sus
            observaciones, resultados y estados de aprobación.
        </p>

        <h2>2. Uso de la información</h2>
        <p>
            Los datos se utilizan para autenticar usuarios, administrar
            permisos, elaborar reportes, mantener registros de revisión
            y facilitar la gestión de los procesos preoperacionales.
        </p>

        <h2>3. Seguridad de la información</h2>
        <p>
            El sistema utiliza mecanismos de autenticación y control
            de acceso mediante roles. Las contraseñas se almacenan
            mediante funciones de hash, no como texto legible.
            Se aplican medidas técnicas para reducir los riesgos
            de acceso no autorizado.
        </p>

        <h2>4. Recuperación de contraseñas y Gmail</h2>
        <p>
            El sistema utiliza la API de Gmail de Google para enviar
            mensajes relacionados con la recuperación de contraseñas.
            Esta integración se utiliza para el envío de correos
            electrónicos del sistema y no tiene como finalidad
            consultar ni comercializar los mensajes personales
            de los usuarios.
        </p>

        <h2>5. Acceso y conservación de datos</h2>
        <p>
            El acceso a los datos del sistema está limitado según
            los permisos asignados a cada usuario. La información
            se conserva mientras resulte necesaria para los fines
            operativos y las obligaciones aplicables.
        </p>

        <h2>6. Servicios de terceros</h2>
        <p>
            Para el funcionamiento del sistema se utilizan servicios
            de infraestructura y correo electrónico, incluidos
            Railway y Google. Estos proveedores pueden tratar
            información técnica necesaria para prestar sus servicios,
            conforme a sus propias políticas.
        </p>

        <h2>7. Derechos y consultas</h2>
        <p>
            Los usuarios pueden solicitar información sobre el
            tratamiento de sus datos y consultar sobre su corrección
            o eliminación, según corresponda y conforme a la
            normativa aplicable.
        </p>

        <h2>8. Contacto</h2>
        <p>
            Para consultas relacionadas con esta política:
            <a href="mailto:sistemaguanapollo@gmail.com">
                sistemaguanapollo@gmail.com
            </a>
        </p>

        <h2>9. Actualizaciones</h2>
        <p>
            Esta política podrá actualizarse cuando cambien
            las funcionalidades del sistema, los servicios
            utilizados o las obligaciones aplicables.
        </p>
    </main>

    <footer>
        &copy; {{ date('Y') }} Guana Pollo.
        Todos los derechos reservados.
    </footer>
</body>
</html>
