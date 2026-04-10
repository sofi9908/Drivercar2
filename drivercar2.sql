SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";                                                           
SET NAMES utf8mb4;
CREATE DATABASE IF NOT EXISTS drivercar2;
USE drivercar2;
-- ROL
CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    tipo_rol VARCHAR(50) NOT NULL
)ENGINE=InnoDB;

INSERT INTO roles (tipo_rol) VALUES
('ADMIN'),
('ESTUDIANTE'),
('PROFESOR');

-- USUARIOS
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    tipo_documento VARCHAR(20) NOT NULL,
    numero_documento VARCHAR(20) UNIQUE NOT NULL,
    fecha_nacimiento DATE,
    telefono VARCHAR(20),
    direccion VARCHAR(100),
    ciudad VARCHAR(50),
    correo VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    id_rol INT NOT NULL,
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
)ENGINE=InnoDB;

-- ESTUDIANTES
CREATE TABLE estudiantes (
    id_estudiante INT AUTO_INCREMENT PRIMARY KEY,
    tipo_licencia_actual VARCHAR(10),
    categoria_licencia VARCHAR(5),
    vencimiento_licencia DATE,
    contacto_emergencia_nombre VARCHAR(100),
    contacto_emergencia_telefono VARCHAR(20),
    contacto_emergencia_parentesco VARCHAR(50),
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
)ENGINE=InnoDB;

-- PROFESORES
CREATE TABLE profesores (
    id_profesor INT AUTO_INCREMENT PRIMARY KEY,
    licencia_categoria VARCHAR(5),
    vencimiento_licencia DATE,
    experiencia_anios INT,
    certificado_idoneidad VARCHAR(100),
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
)ENGINE=InnoDB;

-- DIAS
CREATE TABLE dias_semana (
    id_dia INT AUTO_INCREMENT PRIMARY KEY,
    nombre_dia VARCHAR(20) NOT NULL
)ENGINE=InnoDB;

INSERT INTO dias_semana(nombre_dia) VALUES
('Lunes'),('Martes'),('Miércoles'),('Jueves'),('Viernes'),('Sábado');

-- BLOQUES
CREATE TABLE bloques_horarios (
    id_bloque INT AUTO_INCREMENT PRIMARY KEY,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL
)ENGINE=InnoDB;

INSERT INTO bloques_horarios (hora_inicio, hora_fin) VALUES
('06:00:00','08:00:00'),
('08:00:00','10:00:00'),
('10:00:00','12:00:00'),
('12:00:00','14:00:00'),
('14:00:00','16:00:00'),
('16:00:00','18:00:00');

-- DISPONIBILIDAD
CREATE TABLE disponibilidad_profesores (
    id_disponibilidad INT AUTO_INCREMENT PRIMARY KEY,
    idProfesor INT,
    id_dia INT,
    id_bloque INT,
    FOREIGN KEY (idProfesor) REFERENCES profesores(id_profesor),
    FOREIGN KEY (id_dia) REFERENCES dias_semana(id_dia),
    FOREIGN KEY (id_bloque) REFERENCES bloques_horarios(id_bloque)
)ENGINE=InnoDB;

-- COSTOS 
CREATE TABLE costos (
    id_costo INT AUTO_INCREMENT PRIMARY KEY,
    valor DECIMAL(10,2),
    cuotas VARCHAR(30),
    fecha_pago DATE,
    tipo_pase VARCHAR(10),
    metodo_pago VARCHAR(50),
    idEstudiante INT,
    FOREIGN KEY (idEstudiante) REFERENCES estudiantes(id_estudiante)
)ENGINE=InnoDB;

-- CURSOS
CREATE TABLE cursos (
    id_curso INT AUTO_INCREMENT PRIMARY KEY,
    modalidad VARCHAR(50),
    tipo_licencia VARCHAR(50),
    idCosto INT,
    idEstudiante INT,
    FOREIGN KEY (idCosto) REFERENCES costos(id_costo),
    FOREIGN KEY (idEstudiante) REFERENCES estudiantes(id_estudiante)
)ENGINE=InnoDB;

-- AUTOS
CREATE TABLE autos (
    id_auto INT AUTO_INCREMENT PRIMARY KEY,
    placa VARCHAR(50) UNIQUE,
    tecnomecanica_vencimiento DATE,
    tipo_vehiculo VARCHAR(50),
    modelo VARCHAR(50),
    tipo_licencia VARCHAR(50),
    idProfesor INT,
    FOREIGN KEY (idProfesor) REFERENCES profesores(id_profesor)
)ENGINE=InnoDB;

-- CLASES
CREATE TABLE clases_programadas (
    id_clase INT AUTO_INCREMENT PRIMARY KEY,
    idEstudiante INT,
    idProfesor INT,
    id_auto INT,
    id_dia INT,
    id_bloque INT,
    fecha DATE,
    estado VARCHAR(20) DEFAULT 'Pendiente',
    FOREIGN KEY (idEstudiante) REFERENCES estudiantes(id_estudiante),
    FOREIGN KEY (idProfesor) REFERENCES profesores(id_profesor),
    FOREIGN KEY (id_auto) REFERENCES autos(id_auto),
    FOREIGN KEY (id_dia) REFERENCES dias_semana(id_dia),
    FOREIGN KEY (id_bloque) REFERENCES bloques_horarios(id_bloque)
)ENGINE=InnoDB;

-- NOTAS
CREATE TABLE notas (
    id_nota INT AUTO_INCREMENT PRIMARY KEY,
    modalidad VARCHAR(50),
    observacion VARCHAR(255),
    idProfesor INT,
    idEstudiante INT,
    FOREIGN KEY (idProfesor) REFERENCES profesores(id_profesor),
    FOREIGN KEY (idEstudiante) REFERENCES estudiantes(id_estudiante)
)ENGINE=InnoDB;
-- 
INSERT INTO usuarios (nombre, apellido, tipo_documento, numero_documento, fecha_nacimiento, telefono, 
direccion, ciudad, correo, contrasena, id_rol) VALUES
('Administrador General','Rojas','CC','1234567891','2000-10-16','30022234567','carrera 12B #23-34','Bogota DC','admin@drivercar.com','123456',1),
('Sofía','Martínez','CC','102030001','2000-05-10','3001111111','Calle 10','Bogotá','sofia.martinez1@correo.com','123456',2),
('Juan','Perez','CC','102030002','1999-08-15','3002222222','Carrera 20','Bogotá','juan.perez2@correo.com','123456',2),
('María','Gómez','CC','102030003','2001-02-21','3003333333','Calle 30','Medellín','maria.gomez3@correo.com','123456',2),
('Luis','Rodríguez','CC','102030004','1998-11-03','3004444444','Av Siempre Viva','Cali','luis.rodriguez4@correo.com','123456',2),
('Ana','Torres','CC','102030005','2002-03-17','3005555555','Calle 45','Bogotá','ana.torres5@correo.com','123456',2),
('Carlos','Hernández','CC','102030006','2000-07-04','3006666666','Calle 9','Barranquilla','carlos.hernandez6@correo.com','123456',2),
('Valentina','López','CC','102030007','2001-10-25','3007777777','Carrera 50','Bogotá','valentina.lopez7@correo.com','123456',2),
('Diego','Sánchez','CC','102030008','1997-09-12','3008888888','Calle 100','Medellín','diego.sanchez8@correo.com','123456',2),
('Camila','Castro','CC','102030009','2003-01-09','3009999999','Calle 8','Cali','camila.castro9@correo.com','123456',2),
('Daniel','Romero','CC','102030010','2000-12-30','3011111111','Transversal 90','Bogotá','daniel.romero10@correo.com','123456',2),
('Laura','Medina','CC','102030011','1999-06-14','3012222222','Carrera 12','Pereira','laura.medina11@correo.com','123456',2),
('Felipe','Vargas','CC','102030012','1998-01-19','3013333333','Calle 7','Manizales','felipe.vargas12@correo.com','123456',2),
('Nancy','Silva','CC','102030013','2002-04-09','3014444444','Calle 65','Bogotá','nancy.silva13@correo.com','123456',2),
('Ricardo','Pardo','CC','102030014','2001-09-28','3015555555','Carrera 40','Neiva','ricardo.pardo14@correo.com','123456',2),
('Juliana','Ruiz','CC','102030015','2000-03-03','3016666666','Av 30','Bogotá','juliana.ruiz15@correo.com','123456',2),
('Esteban','Mora','CC','102030016','1997-05-26','3017777777','Calle 80','Medellín','esteban.mora16@correo.com','123456',2),
('Paula','Ríos','CC','102030017','2001-08-08','3018888888','Carrera 22','Cali','paula.rios17@correo.com','123456',2),
('Mateo','Molina','CC','102030018','1999-10-10','3019999999','Calle 90','Bogotá','mateo.molina18@correo.com','123456',2),
('Daniela','Salazar','CC','102030019','2002-02-14','3021111111','Cra 55','Medellín','daniela.salazar19@correo.com','123456',2),
('Sebastián','León','CC','102030020','1998-11-11','3022222222','Calle 13','Bogotá','sebastian.leon20@correo.com','123456',2),

-- PROFESORES
('Andrés','Porras','CC','9001000012','1990-05-10','3101111111','Calle 12','Cartagena','andres.prof1@drivercar.com','123456',3),
('Camilo','Hernandez','CC','900100002','1988-03-18','3102222222','Carrera 20','Bogota','camilo.prof2@drivercar.com','123456',3),
('Diana','Pineda','CC','900100003','1992-11-02','3103333333','Calle 45','Cali','diana.prof3@drivercar.com','123456',3),
('Javier','Gomez','CC','900100004','1987-07-15','3104444444','Av 30','Boyaca','javier.prof4@drivercar.com','123456',3),
('Karina','Bernal','CC','900100005','1991-09-30','3105555555','Calle 123','Armero','karina.prof5@drivercar.com','123456',3),
('Miguel','Cruz','CC','900100006','1985-01-20','3106666666','Calle 98','Bogota','miguel.prof6@drivercar.com','123456',3),
('Natalia','Suarez','CC','900100007','1993-12-11','3107777777','Cra 72','Huila','natalia.prof7@drivercar.com','123456',3),
('Oscar','Bello','CC','900100008','1989-06-06','3108888888','Calle 8','Medellin','oscar.prof8@drivercar.com','123456',3),
('Paula','Hurtado','CC','900100009','1994-04-17','3109999999','Carrera 60','Cucuta','paula.prof9@drivercar.com','123456',3),
('Sandra','Semanate','CC','900100010','1986-08-08','3111111111','Calle 15','Bogota','sandra.prof10@drivercar.com','123456',3);

INSERT INTO estudiantes (tipo_licencia_actual, categoria_licencia, vencimiento_licencia, contacto_emerg0encia_nombre, contacto_emergencia_telefono, contacto_emergencia_parentesco,
    id_usuario) VALUES
('A2','A','2028-05-10','Laura Martínez','3009001111','Hermana',2),
('A2','A','2029-08-15','Carlos Pérez','3009002222','Padre',3),
(NULL,NULL,NULL,'Rosa Gómez','3009003333','Madre',4),
('A1','A','2027-11-03','Pedro Rodríguez','3009004444','Tío',5),
(NULL,NULL,NULL,'Andrea Torres','3009005555','Madre',6),
('A2','A','2028-07-04','Luis Hernández','3009006666','Hermano',7),
(NULL,NULL,NULL,'María López','3009007777','Madre',8),
('B1','B','2029-09-12','Oscar Sánchez','3009008888','Padre',9),
(NULL,NULL,NULL,'Diana Castro','3009009999','Hermana',10),
('A2','A','2028-12-30','Mónica Romero','3019001111','Madre',11),
(NULL,NULL,NULL,'Juan Medina','3019002222','Padre',12),
('A1','A','2027-01-19','María Vargas','3019003333','Hermana',13),
(NULL,NULL,NULL,'Diego Silva','3019004444','Padre',14),
('A2','A','2028-09-28','Lucía Pardo','3019005555','Madre',15),
(NULL,NULL,NULL,'Claudia Ruiz','3019006666','Tía',16),
('B1','B','2029-05-26','Fernando Mora','3019007777','Padre',17),
(NULL,NULL,NULL,'Luisa Ríos','3019008888','Hermana',18),
('A2','A','2028-10-10','Julián Molina','3019009999','Padre',19),
(NULL,NULL,NULL,'Natalia Salazar','3029001111','Madre',20),
('A1','A','2027-11-11','Andrés León','3029002222','Hermano',21);

-- PROFESORES
INSERT INTO profesores (licencia_categoria, vencimiento_licencia, experiencia_anios, certificado_idoneidad, id_usuario) VALUES
('A1','2027-03-15',5,'cert_andres.pdf',22),
('C1','2026-08-22',3,'cert_camilo.pdf',23),
('C2','2028-01-10',7,'cert_diana.pdf',24),
('A2','2025-12-05',4,'cert_javier.pdf',25),
('B2','2027-06-30',6,'cert_karina.pdf',26),
('A1','2026-09-18',8,'cert_miguel.pdf',27),
('A1','2028-11-27',2,'cert_natalia.pdf',28),
('B1','2027-02-14',5,'cert_oscar.pdf',29),
('B1','2026-05-09',9,'cert_paula.pdf',30),
('C1','2025-10-21',10,'cert_sandra.pdf',31);

-- disponibilidad_profesores
INSERT INTO disponibilidad_profesores (idProfesor, id_dia, id_bloque) VALUES
-- PROFESOR 1 (Lunes, Miércoles, Viernes)
(1, 1, 2), (1, 1, 3),
(1, 3, 2), (1, 3, 3),
(1, 5, 2), (1, 5, 3),

-- PROFESOR 2 (Martes, Jueves, Viernes)
(2, 2, 3), (2, 2, 4),
(2, 4, 3), (2, 4, 4),
(2, 5, 3), (2, 5, 4),

-- PROFESOR 3 (Lunes, Martes, Miércoles)
(3, 1, 1), (3, 1, 2),
(3, 2, 1), (3, 2, 2),
(3, 3, 1), (3, 3, 2),

-- PROFESOR 4 (Martes, Jueves, Viernes)
(4, 2, 4), (4, 2, 5),
(4, 4, 4), (4, 4, 5),
(4, 5, 4), (4, 5, 5),

-- PROFESOR 5 (Lunes, Miércoles, Jueves)
(5, 1, 5), (5, 1, 6),
(5, 3, 5), (5, 3, 6),
(5, 4, 5), (5, 4, 6),

-- PROFESOR 6 (Martes, Miércoles, Viernes)
(6, 2, 2), (6, 2, 3),
(6, 3, 2), (6, 3, 3),
(6, 5, 2), (6, 5, 3),

-- PROFESOR 7 (Lunes, Jueves, Viernes)
(7, 1, 3), (7, 1, 4),
(7, 4, 3), (7, 4, 4),
(7, 5, 3), (7, 5, 4),

-- PROFESOR 8 (Miércoles, Jueves, Viernes)
(8, 3, 1), (8, 3, 2),
(8, 4, 1), (8, 4, 2),
(8, 5, 1), (8, 5, 2),

-- PROFESOR 9 (Lunes, Martes, Viernes)
(9, 1, 4), (9, 1, 5),
(9, 2, 4), (9, 2, 5),
(9, 5, 4), (9, 5, 5),

-- PROFESOR 10 (Martes, Miércoles, Jueves)
(10, 2, 5), (10, 2, 6),
(10, 3, 5), (10, 3, 6),
(10, 4, 5), (10, 4, 6);

-- COSTOS 
INSERT INTO costos (valor, cuotas, fecha_pago, tipo_pase, metodo_pago, idEstudiante)VALUES
(250000.00,'2','2026-04-12','A2','Efectivo',1),
(300000.00,'1','2027-01-25','A2','Tarjeta crédito',2),
(220000.00,NULL,'2025-11-30',NULL,'Nequi',3),
(280000.00,'3','2028-07-08','A1','Transferencia',4),
(260000.00,'1','2026-09-19',NULL,'Tarjeta débito',5),
(310000.00,'2','2027-03-14','A2','Daviplata',6),
(270000.00,NULL,'2025-12-22',NULL,'Efectivo',7),
(295000.00,'4','2028-05-17','B1','Tarjeta crédito',8),
(255000.00,'2','2026-10-03',NULL,'Nequi',9),
(240000.00,'3','2027-06-29','A2','Transferencia',10),
(330000.00,NULL,'2025-08-11',NULL,'Tarjeta débito',11),
(260000.00,'4','2028-02-24','A1','Efectivo',12),
(275000.00,'1','2026-12-07',NULL,'Daviplata',13),
(290000.00,'2','2027-09-16','A2','Nequi',14),
(310000.00,NULL,'2025-10-28',NULL,'Tarjeta crédito',15),
(245000.00,'4','2028-03-05','B1','Transferencia',16),
(255000.00,NULL,'2026-01-21',NULL,'Efectivo',17),
(300000.00,'3','2027-11-09','A2','Tarjeta débito',18),
(265000.00,NULL,'2025-07-13',NULL,'Nequi',19),
(320000.00,'5','2028-06-27','A1','Tarjeta crédito',20);

-- cursos
INSERT INTO cursos (modalidad, tipo_licencia, idCosto, idEstudiante) VALUES
('Presencial', 'A1', 1, 1),
('Presencial', 'A2', 2, 2),
('Virtual + Práctico', 'B1', 3, 3),
('Presencial', 'B2', 4, 4),
('Práctico Intensivo', 'A1', 5, 5),
('Presencial', 'B1', 6, 6),
('Virtual + Práctico', 'A2', 7, 7),
('Presencial', 'B1', 8, 8),
('Práctico Intensivo', 'A1', 9, 9),
('Presencial', 'A2', 10, 10),
('Presencial', 'B2', 11, 11),
('Virtual + Práctico', 'B1', 12, 12),
('Presencial', 'A1', 13, 13),
('Práctico Intensivo', 'A2', 14, 14),
('Presencial', 'B1', 15, 15),
('Virtual + Práctico', 'B2', 16, 16),
('Presencial', 'A1', 17, 17),
('Práctico Intensivo', 'A2', 18, 18),
('Presencial', 'B1', 19, 19),
('Virtual + Práctico', 'B2', 20, 20);
-- AUTOS 
INSERT INTO autos (placa, tecnomecanica_vencimiento, tipo_vehiculo, modelo, tipo_licencia, idProfesor)VALUES
('ABC123','2025-02-04','carro','Renault Logan 2020','B1',1),
('XYZ456','2026-06-23','carro','Chevrolet Sail 2019','B1',2),
('JKL789','2026-12-12','carro','Mazda 2 2021','B1',3),
('MNO321','2027-01-02','carro','Kia Picanto 2018','B1',4),
('PQR654','2028-04-04','carro','Hyundai i10 2020','B1',5),
('TUV987','2027-07-31','carro','Nissan March 2021','B1',6),
('GHI112','2026-11-09','moto','Yamaha FZ25','B1',7),
('RST334','2029-01-01','moto','Honda CB190R','B2',8),
('LMN556','2026-03-17','moto','Suzuki Gixxer 250','B2',9),
('QWE778','2027-03-17','moto','KTM Duke 200','B1',10);

-- clases_programadas 
INSERT INTO clases_programadas 
(idEstudiante, idProfesor, id_auto, id_dia, id_bloque, fecha, estado) VALUES
(1, 1, 1, 1, 1, '2025-01-10', 'Pendiente'),
(2, 1, 1, 1, 2, '2025-01-10', 'Pendiente'),
(3, 2, 2, 1, 3, '2025-01-10', 'Completada'),
(4, 2, 2, 1, 4, '2025-01-10', 'Pendiente'),
(5, 3, 3, 2, 2, '2025-01-11', 'Pendiente'),
(6, 3, 3, 2, 3, '2025-01-11', 'Completada'),
(7, 4, 4, 2, 4, '2025-01-11', 'Pendiente'),
(8, 4, 4, 2, 5, '2025-01-11', 'Pendiente'),
(9, 5, 5, 3, 1, '2025-01-12', 'Pendiente'),
(10, 5, 5, 3, 2, '2025-01-12', 'Completada'),
(11, 6, 6, 3, 3, '2025-01-12', 'Pendiente'),
(12, 6, 6, 3, 4, '2025-01-12', 'Pendiente'),
(13, 7, 7, 4, 2, '2025-01-13', 'Pendiente'),
(14, 7, 7, 4, 3, '2025-01-13', 'Completada'),
(15, 8, 8, 4, 4, '2025-01-13', 'Pendiente'),
(16, 8, 8, 4, 5, '2025-01-13', 'Cancelada'),
(17, 9, 9, 5, 1, '2025-01-14', 'Pendiente'),
(18, 9, 9, 5, 2, '2025-01-14', 'Pendiente'),
(19, 10, 10, 5, 3, '2025-01-14', 'Completada'),
(20, 10, 10, 5, 4, '2025-01-14', 'Pendiente'),
(1, 1, 1, 2, 1, '2025-01-15', 'Pendiente'),
(3, 2, 2, 2, 2, '2025-01-15', 'Pendiente'),
(5, 3, 3, 3, 3, '2025-01-15', 'Completada'),
(7, 4, 4, 3, 4, '2025-01-15', 'Pendiente'),
(9, 5, 5, 4, 1, '2025-01-15', 'Pendiente'),
(11, 6, 6, 4, 2, '2025-01-15', 'Pendiente'),
(13, 7, 7, 5, 3, '2025-01-15', 'Cancelada'),
(15, 8, 8, 5, 4, '2025-01-15', 'Pendiente'),
(17, 9, 9, 1, 5, '2025-01-15', 'Pendiente'),
(19, 10, 10, 1, 6, '2025-01-15', 'Pendiente');

-- notas
INSERT INTO notas (modalidad, observacion, idProfesor, idEstudiante) VALUES
("Teorico", 'El estudiante muestra buen manejo básico del vehículo.',1, 1),
("Practico",'Debe mejorar la coordinación en cambios y embrague.',2, 2),
("Practico",'Excelente progreso en maniobras de parqueo.', 3,3),
("Teorico",'Se recomienda practicar más arranque en pendiente.',4, 4),
("Teorico",'Buena actitud y puntualidad en todas las clases.', 5,5),
("Practico",'Presenta nervios al conducir en vías concurridas.',6, 6),
("Practico", 'Mejoró notablemente el control del volante.',7, 7),
("Practico", 'Debe reforzar normas de tránsito y señales.', 8,8),
("Teorico",'Excelente desempeño en conducción preventiva.', 9,9),
("Practico", 'Le cuesta mantener velocidad constante en rectas.',10, 10),
("Teorico",'Muy buena capacidad para seguir instrucciones.', 2,11),
("Practico", 'Falta precisión al realizar giros cerrados.',8, 12),
("Teorico",'Buen manejo del retrovisor y puntos ciegos.', 3,13),
("Practico",'Debe mejorar la distancia de seguridad.', 4,14),
("Teorico",'Progreso sobresaliente en conducción nocturna.', 5,15),
("Practico",'Presenta distracción frecuente, debe concentrarse más.', 6,16),
("Practico",'Buen manejo del freno y desaceleración progresiva.', 3,17),
("Teorico",'Dificultad leve para calcular espacios en parqueo paralelo.',8, 18),
("Practico",'Excelente control del vehículo en lluvia.', 5,19),
("Practico",'Se recomienda tomar una clase extra de refuerzo.',7, 20);
COMMIT;