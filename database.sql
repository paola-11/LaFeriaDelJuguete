CREATE TABLE PRODUCTO(
    cdpro INT NOT NULL AUTO_INCREMENT,
    nopro VARCHAR(50) NULL,
    despro VARCHAR(100) NULL,
    costpro DECIMAL(10,3) NULL,
    estado INT NULL,
    rutimg VARCHAR(100) NULL,
    CONSTRAINT pk_pro PRIMARY KEY (cdpro)
);

ALTER TABLE PRODUCTO
ADD marca VARCHAR(50) NULL;

ALTER TABLE PRODUCTO
ADD descrip VARCHAR(500) NULL;

INSERT INTO PRODUCTO (nopro, despro, costpro, estado, rutimg)
VALUES 
('Cocina','Mi Cocina Divertida Luz y Sonido con Accesorios','235.500',1,'co1.jpg'),
('Lego','Set Minecraft El Arrecife de Coral - Lego','85.000',1,'lego1.png'),
('Gimnasio para Beb&eacute','Gimnasio de Actividades para Beb&eacute; Desmontable 5 en 1','335.999',1,'bb1.jpg'),
('Pista Hot Wheels','Pista de Juguete S&uacute;per Estaci&oacuten de Bomberos - Hot Wheels','150.000',1,'pista.png'),
('Casa de Barbie','Set de Juegos - Nueva Casa de los Sue&ntilde;os de Barbie','385.500',1,'casa.webp'),
('Batidora M&aacute;gica','Creaciones de cocina Play-Doh  Batidora M&aacute;gica','79.999',1,'batidora.png'),
('Carro Control','Carro Speed Pioner Negro y Naranja','185.900',1,'carro.png'),
('Caminador 3 en 1','Caminador 3 en 1 Multicolor- Litttle Tike - 70 actividades incluye canciones','485.900',1,'Caminador.png'),
('Tapete Armable','Tapete M&aacute;gico N&uacute;meros- incluye 9 L&aacute;minas en Espuma de 29cm x 29cm','45.000',1,'tapete.png'),
('Mascota Electr&oacute;nica','Mascota Electr&oacute;nica Fur Real Friends Poopalots Grandes Paseos Perrito','129.900',1,'Mascota.png'),
('Bicicleta Impulso','Bicicleta Impulso Balance Bike Paw Patrol- Color Azul','458.000',1,'bicicleta.jpg'),
('Ba&ntilde;era Beb&eacute','Ba&ntilde;era Beb&eacute; Plegable Bium Gris- 19cm alto x 72 cm ancho x 50 cm de largo','245.000',1,'tina.jpg'),
('Scooter','Scooter Maxi Deluxe Negro/Naranja - Micro','459.900',1,'Scooter.png'),
('Rompecabezas Playa','Rompecabezas amanecer tropical - 1500 Piezas','52.900',1,'rompecabeza.webp'),
('Set Belleza','Set Muebles Rutina de Belleza - Barbie','57.000',1,'Belleza.png'),
('Comedor Beb&eacute','Silla Comedor 2 en 1 Rosado','455.000',1,'silla.png'),
('Set Dentista','Set de Masa Moldeable Dentista- Play-Doh','62.900',1,'dentista.webp'),
('Set LOL','Set Carrito-Parrilla LOL','195.500',1,'lol.png'),
('Organeta - Kiddoh','Set Organeta Electr&oacute;nica Azul con Silla','232.900',1,'Organeta.webp'),
('Ping&uuml;ino Musical','Ping&uuml;ino Baila Conmigo - Fisher Price','320.000',1,'musical.png');


CREATE TABLE USUARIO(
    cdusu INT NOT NULL AUTO_INCREMENT,
    nomusu VARCHAR(50),
    apeusu VARCHAR(50),
    emailusu VARCHAR(50) NOT NULL,
    passusu VARCHAR(20) NOT NULL,
    estado INT NOT NULL,
    CONSTRAINT pk_usuario PRIMARY KEY (cdusu)
);

INSERT INTO USUARIO (nomusu, apeusu, emailusu, passusu, estado)
VALUES ('Carmen','Trujillo','cytrujillo@poligran.edu.co','12345678',1);


CREATE TABLE PEDIDO(
    cdped INT NOT NULL AUTO_INCREMENT,
    cdusu INT NOT NULL,
    cdpro INT NOT NULL,
    fchped DATETIME NOT NULL,
    estado INT NOT NULL,
    cantidad INT NOT NULL,
    dirpedusu VARCHAR(50) NOT NULL,
    celusuped VARCHAR(15) NOT NULL,
    sub_total DECIMAL(10,3) NULL,
    CONSTRAINT pk_pedido PRIMARY KEY (cdped)
);