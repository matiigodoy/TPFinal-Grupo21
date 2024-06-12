DROP DATABASE IF EXISTS db;
CREATE DATABASE IF NOT EXISTS db;
USE db;

SET
    SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
    time_zone = "+00:00";

CREATE TABLE `user`(
                       id INT(11) PRIMARY KEY AUTO_INCREMENT,
                       fullname VARCHAR(50) NOT NULL,
                       birth_year INT(4) NOT NULL,
                       gender VARCHAR(30) NOT NULL,
                       latitude DECIMAL(17, 14) NOT NULL,
                       longitude DECIMAL(17, 14) NOT NULL,
                       email VARCHAR(255) NOT NULL UNIQUE,
                       username VARCHAR(30) NOT NULL UNIQUE,
                       password VARCHAR(250) NOT NULL,
                       profile_picture VARCHAR(250) DEFAULT NULL,
                       score INT(6) NOT NULL DEFAULT 0,
                       register_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
                       role VARCHAR(30) NOT NULL DEFAULT 'user',
                       is_active BOOLEAN NOT NULL DEFAULT TRUE
);


-- PASSWORD: 1234
INSERT INTO `user` (fullname,birth_year,gender,latitude,longitude,email,username,password,profile_picture,score, register_date, role, is_active)
VALUES ('Mariano Saldivar',1990,'Masculino',-34.670678159005746, -58.56332018874492,'admin@grupo21.com','MarianCapo','$2y$10$sra18NyRZW3RR58JMLDZkup29zmPLi8PqB.CbBHjISjjqV3JCla6.',NULL,0, '2024-06-05','admin', 0),
('admin',1990,'Masculino',-34.670678159005746, -58.56332018874492,'admin@gmail.com','admin','$2y$10$sra18NyRZW3RR58JMLDZkup29zmPLi8PqB.CbBHjISjjqV3JCla6.',NULL,0, '2024-06-05','admin', 0),
('user',1990,'Masculino',-34.670678159005746, -58.56332018874492,'user@gmail.com','user','$2y$10$sra18NyRZW3RR58JMLDZkup29zmPLi8PqB.CbBHjISjjqV3JCla6.',NULL,0, '2024-06-05','user', 0);



CREATE TABLE `question` (
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            pregunta TEXT NOT NULL,
                            category VARCHAR(100) NOT NULL
);
CREATE TABLE `answer`(
                         id INT PRIMARY KEY AUTO_INCREMENT,
                         option_a VARCHAR(255) NOT NULL,
                         option_b VARCHAR(255) NOT NULL,
                         option_c VARCHAR(255) NOT NULL,
                         option_d VARCHAR(255) NOT NULL,
                         right_answer CHAR(1) NOT NULL,
                         count_ofrecida INT DEFAULT 0,
                         count_acertada INT DEFAULT 0,
                         question_id INT NOT NULL,
                         FOREIGN KEY (question_id) REFERENCES question(id)
);

CREATE TABLE `partida`(
                          id INT PRIMARY KEY AUTO_INCREMENT,
                          id_user INT NOT NULL,
                          id_opponent INT,
                          partida_date DATE NOT NULL,
                          FOREIGN KEY (id_user) REFERENCES user(id),
                          FOREIGN KEY (id_opponent) REFERENCES user(id)
);

CREATE TABLE `user_question`(
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            id_user INT NOT NULL,
                            id_question INT NOT NULL,
                            wasRight BOOLEAN,
                            FOREIGN KEY (id_user) REFERENCES user(id),
                            FOREIGN KEY (id_question) REFERENCES question(id)
);

-- PASSWORD: 1234
INSERT INTO `user` (fullname,birth_year,gender,city, province, country,email,username,password,profile_picture,score, register_date, role, is_active)
VALUES ('Mariano Saldivar',1990,'Masculino','Buenos Aires City','Buenos Aires City', 'Argentina','admin@grupo21.com','MarianCapo','$2y$10$sra18NyRZW3RR58JMLDZkup29zmPLi8PqB.CbBHjISjjqV3JCla6.',NULL,0, '2024-06-05','admin', 0),
       ('admin',1990,'Masculino','Buenos Aires City','Buenos Aires City', 'Argentina','admin@gmail.com','admin','$2y$10$sra18NyRZW3RR58JMLDZkup29zmPLi8PqB.CbBHjISjjqV3JCla6.',NULL,0, '2024-06-05','admin', 0),
       ('user',1990,'Masculino','Buenos Aires City','Buenos Aires City', 'Argentina','user@gmail.com','user','$2y$10$sra18NyRZW3RR58JMLDZkup29zmPLi8PqB.CbBHjISjjqV3JCla6.',NULL,0, '2024-06-05','user', 0);


INSERT INTO question (pregunta, category) VALUES
                                              ('¿Cuál es la capital de Francia?', 'cultura'),
                                              ('¿Quién escribió "Cien años de soledad"?', 'cultura'),
                                              ('¿Cuál es el país más grande del mundo?', 'cultura'),
                                              ('¿Cuál es el océano más grande del mundo?', 'cultura'),
                                              ('¿Quién pintó la Mona Lisa?', 'cultura'),
                                              ('¿Cuál es el país más grande de África?', 'cultura'),
                                              ('¿Quién escribió "Matar a un ruiseñor"?', 'cultura'),
                                              ('¿Qué país es famoso por el sushi?', 'cultura'),
                                              ('¿En qué continente se encuentra el río Amazonas?', 'cultura'),
                                              ('¿Quién pintó la Capilla Sixtina?', 'cultura'),
                                              ('¿Cuál es el símbolo químico del sodio?', 'cultura'),
                                              ('¿Cuál es el océano que rodea a las Islas Malvinas?', 'cultura'),
                                              ('¿Quién fue el primer presidente de los Estados Unidos?', 'cultura'),
                                              ('¿Cuál es la capital de Turquía?', 'cultura'),
                                              ('¿En qué año se fundó la Organización de las Naciones Unidas?', 'cultura'),
                                              ('¿Qué planeta es el más cercano al Sol?', 'cultura'),
                                              ('¿Cuál es el idioma oficial de China?', 'cultura'),
                                              ('¿Qué científico desarrolló la teoría de la evolución?', 'cultura'),
                                              ('¿Qué país tiene la mayor cantidad de población musulmana?', 'cultura'),
                                              ('¿Cuál es la capital de México?', 'cultura'),
                                              ('¿Cuál es la ciudad más grande de Brasil?', 'cultura'),
                                              ('¿Quién pintó "Las Meninas"?', 'cultura'),
                                              ('¿Cuál es el nombre de la civilización antigua que construyó las pirámides de Giza?', 'cultura'),
                                              ('¿Qué gas es conocido como el "gas de la risa"?', 'cultura'),
                                              ('¿En qué año terminó la Primera Guerra Mundial?', 'cultura'),
                                              ('¿Cuál es la capital de Suecia?', 'cultura'),
                                              ('¿Qué animal es conocido por su capacidad de cambiar de color?', 'cultura'),
                                              ('¿En qué país se encuentra la Estatua de la Libertad?', 'cultura'),
                                              ('¿Cuál es la capital de Rusia?', 'cultura'),
                                              ('¿Quién es conocido como el "Padre de la Medicina"?', 'cultura'),
                                              ('¿Cuál es el mayor océano en términos de volumen?', 'cultura'),
                                              ('¿Qué país es conocido por sus canguros?', 'cultura'),
                                              ('¿Cuál es el idioma oficial de Egipto?', 'cultura'),
                                              ('¿Cuál es el órgano principal del sistema circulatorio?', 'cultura'),
                                              ('¿Qué país es conocido por el vino tinto Malbec?', 'cultura'),
                                              ('¿Quién escribió "La divina comedia"?', 'cultura'),
                                              ('¿Cuál es la moneda oficial de Japón?', 'cultura'),
                                              ('¿Cuál es el animal más grande del mundo?', 'cultura'),
                                              ('¿Qué país es conocido como "la tierra del sol naciente"?', 'cultura'),
                                              ('¿Cuál es la capital de Egipto?', 'cultura'),
                                              ('¿Cuál es el sistema montañoso más largo del mundo?', 'cultura'),
                                              ('¿Qué país tiene forma de bota?', 'cultura'),
                                              ('¿Qué inventó Alexander Graham Bell?', 'cultura'),
                                              ('¿Qué animal es símbolo de la paz?', 'cultura'),
                                              ('¿En qué país se encuentra la ciudad de Marrakech?', 'cultura'),
                                              ('¿Quién pintó "El grito"?', 'cultura'),
                                              ('¿Cuál es la capital de Canadá?', 'cultura'),
                                              ('¿Qué escritor creó el personaje de Sherlock Holmes?', 'cultura'),
                                              ('¿Qué ciudad es conocida como "La Gran Manzana"?', 'cultura'),
                                              ('¿Cuál es la moneda oficial de Suiza?', 'cultura');

INSERT INTO answer (question_id, option_a, option_b, option_c, option_d, right_answer) VALUES
                                                                                           (1, 'Berlín', 'Madrid', 'París', 'Roma', 'c'),
                                                                                           (2, 'Mario Vargas Llosa', 'Gabriel García Márquez', 'Isabel Allende', 'Pablo Neruda', 'b'),
                                                                                           (3, 'China', 'Rusia', 'Estados Unidos', 'Canadá', 'b'),
                                                                                           (4, 'Océano Atlántico', 'Océano Índico', 'Océano Pacífico', 'Océano Ártico', 'c'),
                                                                                           (5, 'Leonardo da Vinci', 'Claude Monet', 'Vincent van Gogh', 'Pablo Picasso', 'a'),
                                                                                           (6, 'Egipto', 'Sudáfrica', 'Argelia', 'Nigeria', 'c'),
                                                                                           (7, 'J.D. Salinger', 'Harper Lee', 'F. Scott Fitzgerald', 'Mark Twain', 'b'),
                                                                                           (8, 'China', 'Corea del Sur', 'Japón', 'Tailandia', 'c'),
                                                                                           (9, 'Asia', 'África', 'América del Sur', 'América del Norte', 'c'),
                                                                                           (10, 'Leonardo da Vinci', 'Rafael', 'Miguel Ángel', 'Caravaggio', 'c'),
                                                                                           (11, 'Na', 'S', 'N', 'O', 'a'),
                                                                                           (12, 'Océano Atlántico', 'Océano Índico', 'Océano Pacífico', 'Océano Ártico', 'a'),
                                                                                           (13, 'Thomas Jefferson', 'Abraham Lincoln', 'George Washington', 'John Adams', 'c'),
                                                                                           (14, 'Estambul', 'Ankara', 'Izmir', 'Antalya', 'b'),
                                                                                           (15, '1940', '1945', '1950', '1955', 'b'),
                                                                                           (16, 'Venus', 'Marte', 'Mercurio', 'Tierra', 'c'),
                                                                                           (17, 'Mandarín', 'Cantonés', 'Coreano', 'Japonés', 'a'),
                                                                                           (18, 'Isaac Newton', 'Galileo Galilei', 'Charles Darwin', 'Albert Einstein', 'c'),
                                                                                           (19, 'Arabia Saudita', 'Pakistán', 'Indonesia', 'Irán', 'c'),
                                                                                           (20, 'Guadalajara', 'Monterrey', 'Cancún', 'Ciudad de México', 'd'),
                                                                                           (21, 'Río de Janeiro', 'Brasilia', 'Salvador', 'São Paulo', 'd'),
                                                                                           (22, 'Francisco de Goya', 'El Greco', 'Diego Velázquez', 'Pablo Picasso', 'c'),
                                                                                           (23, 'Mayas', 'Aztecas', 'Romanos', 'Egipcios', 'd'),
                                                                                           (24, 'Oxígeno', 'Nitrógeno', 'Helio', 'Óxido nitroso', 'd'),
                                                                                           (25, '1916', '1918', '1920', '1922', 'b'),
                                                                                           (26, 'Copenhague', 'Oslo', 'Helsinki', 'Estocolmo', 'd'),
                                                                                           (27, 'Pulpo', 'Camaleón', 'Calamar', 'Pez payaso', 'b'),
                                                                                           (28, 'Francia', 'Reino Unido', 'Canadá', 'Estados Unidos', 'd'),
                                                                                           (29, 'San Petersburgo', 'Moscú', 'Kiev', 'Minsk', 'b'),
                                                                                           (30, 'Hipócrates', 'Aristóteles', 'Galeno', 'Sócrates', 'a'),
                                                                                           (31, 'Océano Atlántico', 'Océano Índico', 'Océano Pacífico', 'Océano Ártico', 'c'),
                                                                                           (32, 'Sudáfrica', 'Nueva Zelanda', 'Australia', 'Canadá', 'c'),
                                                                                           (33, 'Inglés', 'Francés', 'Árabe', 'Italiano', 'c'),
                                                                                           (34, 'Pulmones', 'Corazón', 'Hígado', 'Riñones', 'b'),
                                                                                           (35, 'Francia', 'España', 'Italia', 'Argentina', 'd'),
                                                                                           (36, 'Dante Alighieri', 'Giovanni Boccaccio', 'Petrarca', 'Torquato Tasso', 'a'),
                                                                                           (37, 'Yen', 'Won', 'Dólar', 'Euro', 'a'),
                                                                                           (38, 'Elefante', 'Ballena azul', 'Jirafa', 'Tiburón blanco', 'b'),
                                                                                           (39, 'Japón', 'China', 'Corea del Sur', 'India', 'a'),
                                                                                           (40, 'El Cairo', 'Alejandría', 'Luxor', 'Asuán', 'a'),
                                                                                           (41, 'Cordillera de los Andes', 'Himalaya', 'Montes Urales', 'Montes Apalaches', 'a'),
                                                                                           (42, 'Grecia', 'Italia', 'España', 'Portugal', 'b'),
                                                                                           (43, 'Teléfono', 'Radio', 'Televisión', 'Computadora', 'a'),
                                                                                           (44, 'Paloma', 'Águila', 'León', 'Delfín', 'a'),
                                                                                           (45, 'Marruecos', 'Egipto', 'Argelia', 'Túnez', 'a'),
                                                                                           (46, 'Edvard Munch', 'Gustav Klimt', 'Egon Schiele', 'Paul Klee', 'a'),
                                                                                           (47, 'Toronto', 'Vancouver', 'Ottawa', 'Montreal', 'c'),
                                                                                           (48, 'Agatha Christie', 'Arthur Conan Doyle', 'Ian Fleming', 'Raymond Chandler', 'b'),
                                                                                           (49, 'Los Ángeles', 'Chicago', 'Nueva York', 'San Francisco', 'c'),
                                                                                           (50, 'Euro', 'Dólar', 'Franco suizo', 'Libra esterlina', 'c');
INSERT INTO question (pregunta, category) VALUES
                                              ('¿Quién ganó la Copa del Mundo de la FIFA en 2018?', 'deportes'),
                                              ('¿En qué deporte se utiliza una pelota más pequeña?', 'deportes'),
                                              ('¿Quién es el máximo goleador en la historia de la selección brasileña de fútbol?', 'deportes'),
                                              ('¿Qué equipo de fútbol americano tiene el récord de más Super Bowls ganados?', 'deportes'),
                                              ('¿Cuál es el nombre del estadio del FC Barcelona?', 'deportes'),
                                              ('¿Quién es el máximo goleador en la historia de la selección argentina de fútbol?', 'deportes'),
                                              ('¿En qué deporte se compite por el Trofeo Heisman?', 'deportes'),
                                              ('¿En qué deporte se compite por la Copa del Mundo de Rugby Sevens?', 'deportes'),
                                              ('¿Quién es el máximo goleador en la historia de la selección portuguesa de fútbol?', 'deportes'),
                                              ('¿Quién ganó la medalla de oro en el salto de altura masculino en los Juegos Olímpicos de 2020?', 'deportes'),
                                              ('¿Quién es el máximo goleador en la historia de la selección española de fútbol?', 'deportes'),
                                              ('¿Quién es el máximo goleador en la historia de la Liga Premier de Inglaterra?', 'deportes'),
                                              ('¿En qué deporte se compite por el Trofeo de la Copa Davis?', 'deportes'),
                                              ('¿En qué año se celebraron los Juegos Olímpicos de Verano en Sydney?', 'deportes'),
                                              ('¿Quién es el máximo goleador en la historia de la selección alemana de fútbol?', 'deportes'),
                                              ('¿Quién es el máximo goleador en la historia de la Liga de Campeones de la UEFA?', 'deportes'),
                                              ('¿Qué país ganó la Copa América en 2021?', 'deportes'),
                                              ('¿En qué año ganó España su primer y único Mundial de fútbol?', 'deportes'),
                                              ('¿Qué país ganó el Mundial de Clubes de la FIFA en 2021?', 'deportes'),
                                              ('¿Qué tenista femenina ha ganado más títulos de Grand Slam?', 'deportes');

INSERT INTO answer (question_id, option_a, option_b, option_c, option_d, right_answer, count_ofrecida, count_acertada) VALUES
                                                                                                                           (51, 'Alemania', 'Brasil', 'Francia', 'Croacia', 'c', 0, 0),
                                                                                                                           (52, 'Fútbol', 'Baloncesto', 'Tenis', 'Golf', 'd', 0, 0),
                                                                                                                           (53, 'Ronaldo Nazário', 'Neymar Jr.', 'Pelé', 'Romário', 'c', 0, 0),
                                                                                                                           (54, 'Green Bay Packers', 'New England Patriots', 'Pittsburgh Steelers', 'Dallas Cowboys', 'b', 0, 0),
                                                                                                                           (55, 'Santiago Bernabéu', 'Old Trafford', 'Camp Nou', 'San Siro', 'c', 0, 0),
                                                                                                                           (56, 'Lionel Messi', 'Diego Maradona', 'Gabriel Batistuta', 'Hernán Crespo', 'a', 0, 0),
                                                                                                                           (57, 'Fútbol americano', 'Baloncesto', 'Béisbol', 'Atletismo', 'a', 0, 0),
                                                                                                                           (58, 'Rugby', 'Cricket', 'Fútbol', 'Golf', 'a', 0, 0),
                                                                                                                           (59, 'Cristiano Ronaldo', 'Eusébio', 'Luis Figo', 'Nuno Gomes', 'a', 0, 0),
                                                                                                                           (60, 'Mutaz Essa Barshim', 'Gianmarco Tamberi', 'Derek Drouin', 'Bohdan Bondarenko', 'a', 0, 0),
                                                                                                                           (61, 'Raúl González', 'Fernando Torres', 'David Villa', 'David Silva', 'c', 0, 0),
                                                                                                                           (62, 'Alan Shearer', 'Wayne Rooney', 'Thierry Henry', 'Sergio Agüero', 'a', 0, 0),
                                                                                                                           (63, 'Tenis', 'Golf', 'Fútbol', 'Cricket', 'a', 0, 0),
                                                                                                                           (64, '2000', '1996', '2004', '2008', 'a', 0, 0),
                                                                                                                           (65, 'Gerd Müller', 'Miroslav Klose', 'Thomas Müller', 'Lukas Podolski', 'b', 0, 0),
                                                                                                                           (66, 'Cristiano Ronaldo', 'Lionel Messi', 'Robert Lewandowski', 'Karim Benzema', 'a', 0, 0),
                                                                                                                           (67, 'Argentina', 'Brasil', 'Uruguay', 'Chile', 'a', 0, 0),
                                                                                                                           (68, '2010', '2006', '1982', '1994', 'a', 0, 0),
                                                                                                                           (69, 'Bayern Múnich', 'Chelsea FC', 'Real Madrid', 'FC Barcelona', 'b', 0, 0),
                                                                                                                           (70, 'Serena Williams', 'Margaret Court', 'Steffi Graf', 'Martina Navratilova', 'b', 0, 0);

INSERT INTO question (pregunta, category) VALUES
                                              ('¿Cuál fue el nombre del líder militar y político francés que dirigió la resistencia contra la invasión alemana durante la Segunda Guerra Mundial?', 'historia'),
                                              ('¿Qué evento histórico marcó el fin de la Segunda Guerra Mundial en Europa?', 'historia'),
                                              ('¿Cuál fue el nombre del líder de la Revolución Mexicana que luchó por la reforma agraria y los derechos de los trabajadores?', 'historia'),
                                              ('¿Quién fue el líder político y militar japonés durante la Segunda Guerra Mundial?', 'historia'),
                                              ('¿Cuál fue el nombre del tratado que puso fin a la Guerra de Independencia de Estados Unidos en 1783?', 'historia'),
                                              ('¿Quién fue el líder del movimiento de independencia de Haití en el siglo XIX?', 'historia'),
                                              ('¿En qué año comenzó la Revolución Industrial en Gran Bretaña?', 'historia'),
                                              ('¿Cuál fue el nombre del líder político y militar que unificó a Italia en el siglo XIX?', 'historia'),
                                              ('¿Quién fue el presidente de Estados Unidos durante la Guerra de Vietnam?', 'historia'),
                                              ('¿Cuál fue el nombre del líder político y militar alemán durante la Primera Guerra Mundial?', 'historia'),
                                              ('¿Cuál fue el nombre del líder político y militar británico durante la Segunda Guerra Mundial?', 'historia'),
                                              ('¿Qué evento histórico marcó el fin de la Guerra Fría en 1991?', 'historia'),
                                              ('¿Cuál fue el nombre del líder político y militar español que gobernó el país durante la dictadura franquista?', 'historia'),
                                              ('¿Quién fue el líder político y militar alemán durante la Segunda Guerra Mundial?', 'historia'),
                                              ('¿Cuál fue el nombre del movimiento que promovió la abolición de la esclavitud en Estados Unidos en el siglo XIX?', 'historia'),
                                              ('¿Quién fue el líder político y militar soviético durante la Segunda Guerra Mundial?', 'historia'),
                                              ('¿Cuál fue el nombre del líder político y militar estadounidense que dirigió las fuerzas aliadas en Europa durante la Segunda Guerra Mundial?', 'historia'),
                                              ('¿Qué tratado puso fin a la Guerra de Vietnam en 1973?', 'historia'),
                                              ('¿Cuál fue el nombre del líder político y militar japonés que estuvo en el poder durante la Segunda Guerra Mundial?', 'historia'),
                                              ('¿Quién fue el líder del movimiento independentista de Argelia en el siglo XX?', 'historia');

INSERT INTO answer (option_a, option_b, option_c, option_d, right_answer, question_id) VALUES
                                                                                           ('Charles de Gaulle', 'Napoleon Bonaparte', 'Louis XIV', 'Philippe Pétain', 'a', 71),
                                                                                           ('Rendición de Alemania', 'Bombardeo de Pearl Harbor', 'Caída de Berlín', 'Ataque a Normandía', 'a', 72),
                                                                                           ('Emiliano Zapata', 'Francisco Villa', 'Porfirio Díaz', 'Venustiano Carranza', 'a', 73),
                                                                                           ('Hirohito', 'Hideki Tojo', 'Isoroku Yamamoto', 'Emperor Meiji', 'b', 74),
                                                                                           ('Tratado de Versalles', 'Tratado de París', 'Tratado de Londres', 'Tratado de Gante', 'b', 75),
                                                                                           ('Toussaint Louverture', 'Jean-Jacques Dessalines', 'Henri Christophe', 'Alexandre Pétion', 'a', 76),
                                                                                           ('1750', '1800', '1850', '1900', 'a', 7),
                                                                                           ('Giuseppe Garibaldi', 'Victor Emmanuel II', 'Benito Mussolini', 'Camillo Cavour', 'a', 78),
                                                                                           ('Lyndon B. Johnson', 'Richard Nixon', 'John F. Kennedy', 'Dwight D. Eisenhower', 'a', 79),
                                                                                           ('Kaiser Wilhelm II', 'Adolf Hitler', 'Paul von Hindenburg', 'Erich Ludendorff', 'a', 80),
                                                                                           ('Winston Churchill', 'Neville Chamberlain', 'Clement Attlee', 'Margaret Thatcher', 'a', 81),
                                                                                           ('Disolución de la Unión Soviética', 'Caída del Muro de Berlín', 'Tratado de Yalta', 'Revolución de Terciopelo en Checoslovaquia', 'a', 82),
                                                                                           ('Francisco Franco', 'Juan Carlos I', 'Felipe VI', 'Adolfo Suárez', 'a', 83),
                                                                                           ('Adolf Hitler', 'Hermann Göring', 'Joseph Goebbels', 'Heinrich Himmler', 'a', 84),
                                                                                           ('Movimiento de los Derechos Civiles', 'Movimiento Feminista', 'Movimiento Abolicionista', 'Movimiento de Independencia', 'c', 85),
                                                                                           ('Joseph Stalin', 'Vladimir Lenin', 'Nikita Jrushchov', 'Leon Trotsky', 'a', 86),
                                                                                           ('Dwight D. Eisenhower', 'George S. Patton', 'Douglas MacArthur', 'Franklin D. Roosevelt', 'a', 87),
                                                                                           ('Tratado de París', 'Tratado de Versalles', 'Tratado de Viena', 'Tratado de Roma', 'a', 88),
                                                                                           ('Emperor Hirohito', 'Hideki Tojo', 'Isoroku Yamamoto', 'Emperor Meiji', 'b', 89),
                                                                                           ('Ahmed Ben Bella', 'Houari Boumédiène', 'Abdelaziz Bouteflika', 'Ferhat Abbas', 'a', 90);
