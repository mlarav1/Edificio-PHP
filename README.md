# CRUDL de Edificios — PHP, DDD, Arquitectura Hexagonal y CQRS

Actividad de Desarrollo Web (Unidad 2). Ejercicio **13: Edificio**, construido sobre el repositorio base del docente
([arrietajohn/hexagonal-ddd-example-php](https://github.com/arrietajohn/hexagonal-ddd-example-php)).
Se conserva la entidad común **Usuario** (login/sesión) y se añade el CRUDL de **Edificio**.

**Atributos de negocio:** nombre, metrosCuadrados, altura, numPisos, numApartamentos, numOficinas, nombreParqueadero,
numPiscinas, pais, departamento, ciudad, tieneAscensor, valorAdministracion, tieneZonaSocial.

## Tecnologías
PHP 8.3 · MySQL 8 (PDO) · Apache + mod_rewrite · Docker · GitHub Actions · Render

## Arquitectura
| Capa | Contenido de Edificio |
|---|---|
| Domain | `EdificioModel`, 11 Value Objects (`EdificioNombre`, `EdificioUbicacion`...), excepciones, eventos `Edificio{Created,Updated,Deleted}DomainEvent` |
| Application | Puertos de entrada (5 casos de uso), puertos de salida (6), Commands/Queries (CQRS), `EdificioApplicationMapper`, 5 servicios |
| Infrastructure/Adapters | `EdificioRepositoryMySQL` (PDO), DTO, Entity y mapper de persistencia |
| Infrastructure/Entrypoints | `EdificioController`, `EdificioApiController` (JSON), DTO request/response, `EdificioWebMapper`, vistas |
| Common | `ClassLoader`, `EnvLoader`, `DependencyInjection` |

Reglas de dominio: `nombre`+`ciudad` únicos; `numPisos ≥ 1`; medidas > 0; el edificio debe tener al menos un
apartamento u oficina; altura ≥ 2 m por piso.

## Ejecución local
```bash
cp .env.example .env            # ajustar credenciales
mysql -u root -p < database/schema.sql   # o database/schema_tables.sql sobre una BD existente
# Apache con la raíz del proyecto como DocumentRoot, o:
php -S localhost:8080
```
Abrir `http://localhost:8080/public/index.php` — usuario base: `admin@crud.com` / `admin123`.

### Docker
```bash
docker compose up --build       # http://localhost:8080/public/index.php
```

## Pruebas
```bash
php tests/EdificioCrudlTest.php                  # dominio + aplicación (sin BD)
php tests/EdificioRepositoryIntegrationTest.php  # adaptador MySQL (requiere BD)
```
Colección Postman: `postman/Edificios.postman_collection.json` · OpenAPI: `docs-api/openapi.yaml`.

## Despliegue en la nube
1. **BD MySQL en la nube** (p. ej. Aiven, TiDB Cloud): crear la BD y ejecutar `database/schema_tables.sql`.
2. **Render**: crear *Web Service* (Docker) desde este repo (`render.yaml`) y definir `DB_HOST`, `DB_PORT`,
   `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `DB_SSL=true`.
3. **GitHub Actions** (`.github/workflows/ci.yml`): lint + pruebas + build Docker; el despliegue usa el secret
   `RENDER_DEPLOY_HOOK_URL`.

## Flujo de ramas
`main` ← `feature/*-layer` (domain, application, infrastructure), `feature/edificio-rest-api`, `feature/cloud-deploy`.
Commits progresivos de máximo 10 archivos.