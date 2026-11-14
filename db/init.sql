CREATE TABLE IF NOT EXISTS estudiantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    programa VARCHAR(100) NOT NULL
);

INSERT INTO estudiantes (nombre, programa)
VALUES
('Roger Mendoza', 'Ingenieria de Sistemas'),
('Alex Gonzalez', 'Ingenieria de Sistemas');