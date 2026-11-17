-- ============================================================
-- CRUDL Edificios (PHP, DDD, Hexagonal, CQRS)
-- Script de migracion: crea el esquema y el usuario admin base.
--
-- Uso local:
--   mysql -u root -p < database/schema.sql
-- Uso en BD en la nube (la BD ya existe; no ejecutar CREATE DATABASE):
--   mysql -h HOST -P PORT -u USER -p NOMBRE_BD < database/schema_tables.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS crud_edificios
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE crud_edificios;

SOURCE database/schema_tables.sql;