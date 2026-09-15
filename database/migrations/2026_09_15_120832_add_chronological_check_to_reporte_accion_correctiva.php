<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            DB::statement("
                CREATE TRIGGER IF NOT EXISTS chk_reporte_accion_correctiva_horas_insert
                BEFORE INSERT ON reporte_accion_correctiva
                FOR EACH ROW
                WHEN NEW.hora_causa IS NOT NULL
                  AND NEW.hora_accion IS NOT NULL
                  AND NEW.hora_accion < NEW.hora_causa
                BEGIN
                    SELECT RAISE(
                        ABORT,
                        'La hora de la accion correctiva no puede ser anterior a la hora de la causa'
                    );
                END
            ");

            DB::statement("
                CREATE TRIGGER IF NOT EXISTS chk_reporte_accion_correctiva_horas_update
                BEFORE UPDATE OF hora_causa, hora_accion
                ON reporte_accion_correctiva
                FOR EACH ROW
                WHEN NEW.hora_causa IS NOT NULL
                  AND NEW.hora_accion IS NOT NULL
                  AND NEW.hora_accion < NEW.hora_causa
                BEGIN
                    SELECT RAISE(
                        ABORT,
                        'La hora de la accion correctiva no puede ser anterior a la hora de la causa'
                    );
                END
            ");
        }

        if ($driver === 'mysql') {
            DB::statement("
                ALTER TABLE reporte_accion_correctiva
                ADD CONSTRAINT chk_reporte_accion_correctiva_horas
                CHECK (
                    hora_causa IS NULL
                    OR hora_accion IS NULL
                    OR hora_accion >= hora_causa
                )
            ");
        }
    }

    public function down(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            DB::statement("
                DROP TRIGGER IF EXISTS chk_reporte_accion_correctiva_horas_insert
            ");

            DB::statement("
                DROP TRIGGER IF EXISTS chk_reporte_accion_correctiva_horas_update
            ");
        }

        if ($driver === 'mysql') {
            DB::statement("
                ALTER TABLE reporte_accion_correctiva
                DROP CHECK chk_reporte_accion_correctiva_horas
            ");
        }
    }
};