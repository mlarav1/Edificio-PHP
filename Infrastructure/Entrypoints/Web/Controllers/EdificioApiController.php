<?php

declare(strict_types=1);

require_once __DIR__ . '/EdificioController.php';
require_once __DIR__ . '/Validation/EdificioFormValidator.php';

/**
 * Entrypoint REST (JSON). Reutiliza EdificioController, de modo que web y API
 * comparten exactamente los mismos casos de uso.
 */
final class EdificioApiController
{
    private EdificioController $controller;

    public function __construct(EdificioController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return array<int, array<string, string|int|float|bool>>
     */
    public function index(): array
    {
        return array_map(
            static fn(EdificioResponse $edificio): array => $edificio->toArray(),
            $this->controller->index()
        );
    }

    /**
     * @return array<string, string|int|float|bool>
     */
    public function show(string $id): array
    {
        return $this->controller->show($id)->toArray();
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, string|int|float|bool>
     */
    public function store(string $newId, array $payload): array
    {
        $this->ensureValid($payload);
        $form = $this->toForm($newId, $payload);

        return $this->controller->store(new CreateEdificioWebRequest(...$form))->toArray();
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, string|int|float|bool>
     */
    public function update(string $id, array $payload): array
    {
        $this->ensureValid($payload);
        $form = $this->toForm($id, $payload);

        return $this->controller->update(new UpdateEdificioWebRequest(...$form))->toArray();
    }

    public function delete(string $id): void
    {
        $this->controller->delete($id);
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function ensureValid(array $payload): void
    {
        $errors = EdificioFormValidator::validate($payload);

        if (!empty($errors)) {
            throw new InvalidArgumentException(json_encode($errors, JSON_UNESCAPED_UNICODE) ?: 'Datos inválidos.');
        }
    }

    /**
     * Normaliza el JSON recibido al orden de argumentos de los WebRequest.
     *
     * @param array<string, mixed> $payload
     * @return array<int, string|bool>
     */
    private function toForm(string $id, array $payload): array
    {
        $text = static fn(string $key): string => trim((string) ($payload[$key] ?? ''));

        return array(
            $id,
            $text('nombre'),
            $text('metrosCuadrados'),
            $text('altura'),
            $text('numPisos'),
            $text('numApartamentos'),
            $text('numOficinas'),
            $text('nombreParqueadero'),
            $text('numPiscinas'),
            $text('pais'),
            $text('departamento'),
            $text('ciudad'),
            filter_var($payload['tieneAscensor'] ?? false, FILTER_VALIDATE_BOOLEAN),
            $text('valorAdministracion'),
            filter_var($payload['tieneZonaSocial'] ?? false, FILTER_VALIDATE_BOOLEAN),
        );
    }
}