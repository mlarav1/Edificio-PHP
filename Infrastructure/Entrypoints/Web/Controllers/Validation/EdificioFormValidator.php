<?php

declare(strict_types=1);

/**
 * Valida el formato de los datos de entrada (formulario web o JSON) antes de
 * llegar a la capa de aplicacion. Las reglas de negocio las aplican los
 * Value Objects del dominio; aqui solo se garantiza que los datos sean
 * convertibles a los tipos esperados.
 */
final class EdificioFormValidator
{
    /**
     * @param array<string, mixed> $form
     * @return array<string, string>
     */
    public static function validate(array $form): array
    {
        $errors = array();

        $requiredTexts = array(
            'nombre' => 'El nombre es obligatorio.',
            'nombreParqueadero' => 'El nombre del parqueadero es obligatorio.',
            'pais' => 'El país es obligatorio.',
            'departamento' => 'El departamento es obligatorio.',
            'ciudad' => 'La ciudad es obligatoria.',
        );

        foreach ($requiredTexts as $field => $message) {
            if (trim((string) ($form[$field] ?? '')) === '') {
                $errors[$field] = $message;
            }
        }

        $decimals = array(
            'metrosCuadrados' => array('Los metros cuadrados', false),
            'altura' => array('La altura', false),
            'valorAdministracion' => array('El valor de administración', true),
        );

        foreach ($decimals as $field => [$label, $allowZero]) {
            $raw = trim((string) ($form[$field] ?? ''));
            $value = str_replace(',', '.', $raw);

            if ($raw === '') {
                $errors[$field] = $label . ' es obligatorio.';
            } elseif (!is_numeric($value)) {
                $errors[$field] = $label . ' debe ser un número.';
            } elseif ((float) $value < 0 || (!$allowZero && (float) $value === 0.0)) {
                $errors[$field] = $label . ($allowZero ? ' no puede ser negativo.' : ' debe ser mayor que cero.');
            }
        }

        $integers = array(
            'numPisos' => array('El número de pisos', 1),
            'numApartamentos' => array('El número de apartamentos', 0),
            'numOficinas' => array('El número de oficinas', 0),
            'numPiscinas' => array('El número de piscinas', 0),
        );

        foreach ($integers as $field => [$label, $min]) {
            $raw = trim((string) ($form[$field] ?? ''));

            if ($raw === '') {
                $errors[$field] = $label . ' es obligatorio.';
            } elseif (filter_var($raw, FILTER_VALIDATE_INT) === false) {
                $errors[$field] = $label . ' debe ser un número entero.';
            } elseif ((int) $raw < $min) {
                $errors[$field] = $label . ' debe ser mayor o igual a ' . $min . '.';
            }
        }

        return $errors;
    }
}