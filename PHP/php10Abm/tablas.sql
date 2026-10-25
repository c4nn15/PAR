-- Tablas del ejercicio php10 (ABM; mismas que php09 + UNIQUE en codCliente). Importar desde phpMyAdmin (XAMPP o Clever Cloud).

CREATE TABLE IF NOT EXISTS sucursales (
    codSucursal    VARCHAR(10)  NOT NULL PRIMARY KEY,
    nombreSucursal VARCHAR(60)  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS clientes (
    idCliente               INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    codCliente              VARCHAR(10)  NOT NULL,
    codSucursal             VARCHAR(10)  NOT NULL,
    direccionEntrega        VARCHAR(100) NOT NULL,
    diaSemanalEntrega       VARCHAR(15)  NOT NULL,
    costoPromedioTransporte FLOAT        NOT NULL,
    fechaUltimaEntrega      DATE         NOT NULL,
    fotoPuntoEntrega        LONGBLOB     NULL,
    UNIQUE KEY uk_codCliente (codCliente),
    FOREIGN KEY (codSucursal) REFERENCES sucursales (codSucursal)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO sucursales (codSucursal, nombreSucursal) VALUES
('SUC01', 'CABA Centro'),
('SUC02', 'La Plata'),
('SUC03', 'Rosario'),
('SUC04', 'Cordoba Capital');

INSERT INTO clientes (codCliente, codSucursal, direccionEntrega, diaSemanalEntrega, costoPromedioTransporte, fechaUltimaEntrega) VALUES
('CLI001', 'SUC01', 'Av. Rivadavia 4520, CABA', 'Lunes', 1850, '2025-08-04'),
('CLI002', 'SUC02', 'Calle 50 N 1234, La Plata', 'Martes', 2100, '2025-08-05'),
('CLI003', 'SUC03', 'Bv. Oroño 2100, Rosario', 'Miercoles', 3200, '2025-07-30'),
('CLI004', 'SUC01', 'San Martin 890, CABA', 'Jueves', 1700, '2025-08-06'),
('CLI005', 'SUC04', 'Colon 3300, Cordoba', 'Viernes', 2900, '2025-08-01'),
('CLI006', 'SUC02', 'Calle 7 N 560, La Plata', 'Lunes', 2050, '2025-08-07'),
('CLI007', 'SUC03', 'Pellegrini 1450, Rosario', 'Martes', 3050, '2025-07-28'),
('CLI008', 'SUC04', 'Duarte Quiros 2200, Cordoba', 'Miercoles', 2750, '2025-08-03'),
('CLI009', 'SUC01', 'Corrientes 2900, CABA', 'Viernes', 1650, '2025-08-02'),
('CLI010', 'SUC02', 'Diagonal 74 N 320, La Plata', 'Jueves', 2200, '2025-08-08');

-- Si la tabla clientes ya existe (php09), agregar la unicidad una sola vez:
-- ALTER TABLE clientes ADD UNIQUE KEY uk_codCliente (codCliente);
