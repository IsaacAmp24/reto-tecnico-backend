<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        Division::query()->delete();

        $create = function (
            string $name,
            ?int $parentId = null,
            ?string $ambassador = null
        ): Division {
            return Division::create([
                'name' => $name,
                'parent_id' => $parentId,
                'level' => random_int(1, 10),
                'collaborators' => random_int(1, 50),
                'ambassadors' => $ambassador,
            ]);
        };

        // Nivel raíz
        $ceo = $create('CEO', null, 'Juan Pérez');
        $presidencia = $create('Presidencia', null, 'Laura Méndez');

        // Bajo CEO
        $direccionGeneral = $create('Dirección general', $ceo->id, 'María López');
        $finanzas = $create('Finanzas', $ceo->id, 'Andrés Herrera');
        $talentoHumano = $create('Talento humano', $ceo->id, 'Paula Gómez');
        $legal = $create('Legal', $ceo->id, null);

        // Bajo Presidencia
        $planeacion = $create('Planeación estratégica', $presidencia->id, 'Camila Rojas');
        $auditoria = $create('Auditoría interna', $presidencia->id, null);

        // Bajo Dirección general
        $producto = $create('Producto', $direccionGeneral->id, 'Carlos Ramírez');
        $operaciones = $create('Operaciones', $direccionGeneral->id, 'Sofía Castro');
        $comercial = $create('Comercial', $direccionGeneral->id, 'Miguel Sánchez');
        $marketing = $create('Marketing', $direccionGeneral->id, 'Valentina Ruiz');
        $tecnologia = $create('Tecnología', $direccionGeneral->id, 'Daniel Ortega');
        $experienciaCliente = $create('Experiencia cliente', $direccionGeneral->id, null);

        // Bajo Producto
        $create('Growth', $producto->id, 'Ana Torres');
        $create('Strategy Producto', $producto->id, 'Luis García');
        $create('Diseño producto', $producto->id, 'Juliana Vega');
        $create('Research producto', $producto->id, null);
        $create('Producto Core', $producto->id, 'Esteban Cruz');

        // Bajo Operaciones
        $soporte = $create('Soporte', $operaciones->id, 'Diego Mendoza');
        $create('Calidad operativa', $operaciones->id, 'Natalia Pardo');
        $create('Logística', $operaciones->id, 'Felipe Castro');
        $create('Procesos internos', $operaciones->id, null);

        // Bajo Soporte
        $create('Soporte técnico', $soporte->id, 'Ricardo Molina');
        $create('Mesa ayuda', $soporte->id, null);

        // Bajo Comercial
        $ventasB2B = $create('Ventas B2B', $comercial->id, 'Jorge Silva');
        $ventasB2C = $create('Ventas B2C', $comercial->id, 'Carolina Peña');
        $alianzas = $create('Alianzas', $comercial->id, null);

        // Bajo ventas / alianzas
        $create('Canal corporativo', $ventasB2B->id, null);
        $create('Canal digital', $ventasB2C->id, 'Manuela Ríos');
        $create('Partners estratégicos', $alianzas->id, 'Tomás Acosta');

        // Bajo Marketing
        $create('Contenido', $marketing->id, 'Sara Romero');
        $create('Performance marketing', $marketing->id, 'Iván Duarte');
        $create('Marca', $marketing->id, null);
        $create('Eventos', $marketing->id, 'Lorena Gil');

        // Bajo Tecnología
        $ingenieria = $create('Ingeniería', $tecnologia->id, 'Santiago León');
        $datos = $create('Datos', $tecnologia->id, 'Mariana Suárez');
        $infraestructura = $create('Infraestructura', $tecnologia->id, null);
        $seguridad = $create('Seguridad informática', $tecnologia->id, 'Sebastián Toro');

        // Bajo Ingeniería
        $create('Frontend', $ingenieria->id, 'Valeria Núñez');
        $create('Backend', $ingenieria->id, 'Cristian Mejía');
        $create('QA', $ingenieria->id, null);
        $create('Arquitectura software', $ingenieria->id, 'Tatiana Rincón');

        // Bajo Datos
        $create('Analítica', $datos->id, 'Gabriela Ortiz');
        $create('Ciencia datos', $datos->id, null);
        $create('Ingeniería datos', $datos->id, 'Nicolás Arias');

        // Bajo Experiencia cliente
        $create('Atención cliente', $experienciaCliente->id, 'Paola Serrano');
        $create('Customer Success', $experienciaCliente->id, null);

        // Bajo Finanzas
        $create('Contabilidad', $finanzas->id, 'Marcela Díaz');
        $create('Tesorería', $finanzas->id, null);
        $create('Planeación financiera', $finanzas->id, 'Óscar Prieto');

        // Bajo Talento humano
        $create('Selección', $talentoHumano->id, 'Adriana Flores');
        $create('Desarrollo organizacional', $talentoHumano->id, null);
        $create('Nómina', $talentoHumano->id, 'Héctor Lozano');

        // Bajo Legal
        $create('Contratos', $legal->id, null);
        $create('Cumplimiento', $legal->id, 'Verónica Salas');

        // Bajo Planeación / Auditoría
        $create('PMO', $planeacion->id, 'Alejandro Mora');
        $create('Transformación', $planeacion->id, null);
        $create('Control interno', $auditoria->id, 'Beatriz Cárdenas');
    }
}