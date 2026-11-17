-- ============================================================
-- Tablas y datos semilla (compatible con MySQL 8 / MariaDB 10.5+)
-- Idempotente: se puede ejecutar mas de una vez.
-- ============================================================

CREATE TABLE IF NOT EXISTS users (
    id          VARCHAR(36)  NOT NULL,
    name        VARCHAR(100) NOT NULL,
    email       VARCHAR(150) NOT NULL,
    password    VARCHAR(255) NOT NULL,
    role        VARCHAR(20)  NOT NULL DEFAULT 'MEMBER',
    status      VARCHAR(20)  NOT NULL DEFAULT 'PENDING',
    created_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS edificios (
    id                    VARCHAR(36)       NOT NULL,
    nombre                VARCHAR(120)      NOT NULL,
    metros_cuadrados      DECIMAL(12,2)     NOT NULL,
    altura                DECIMAL(7,2)      NOT NULL,
    num_pisos             SMALLINT UNSIGNED NOT NULL,
    num_apartamentos      INT UNSIGNED      NOT NULL DEFAULT 0,
    num_oficinas          INT UNSIGNED      NOT NULL DEFAULT 0,
    nombre_parqueadero    VARCHAR(100)      NOT NULL,
    num_piscinas          SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    pais                  VARCHAR(100)      NOT NULL,
    departamento          VARCHAR(100)      NOT NULL,
    ciudad                VARCHAR(100)      NOT NULL,
    tiene_ascensor        TINYINT(1)        NOT NULL DEFAULT 0,
    valor_administracion  DECIMAL(12,2)     NOT NULL DEFAULT 0.00,
    tiene_zona_social     TINYINT(1)        NOT NULL DEFAULT 0,
    created_at            TIMESTAMP         NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at            TIMESTAMP         NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_edificios_nombre_ciudad (nombre, ciudad)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Usuario administrador base (correo: admin@crud.com / clave: admin123).
-- La clave se guarda con hash bcrypt, igual que UserPassword::fromPlainText().
INSERT INTO users (id, name, email, password, role, status)
VALUES (
    '00000000-0000-4000-8000-000000000001',
    'Administrador',
    'admin@crud.com',
    '$2y$10$Nhz3CvyL/X0/PamBt5NoxevaEMuOlTXsKzNf85UZNWupKoL.KSREG',
    'ADMIN',
    'ACTIVE'
)
ON DUPLICATE KEY UPDATE name = VALUES(name);

SELECT id, name, email, role, status FROM users;
