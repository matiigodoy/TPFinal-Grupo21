-- Base de datos: `db`

-- CREACION DE LA BASE DE DATOS 
DROP DATABASE IF EXISTS db;
CREATE DATABASE IF NOT EXISTS db;
USE db;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
-- ----------------CREACIONES DE TABLAS----------------------------------------
CREATE TABLE `user`(
  id INT PRIMARY KEY AUTO_INCREMENT,
  fullname VARCHAR(50) NOT NULL,
  birth_year INT(4) NOT NULL,
  gender VARCHAR(30) NOT NULL,
  country VARCHAR(50) NOT NULL,
  latitude DECIMAL(17, 14) NOT NULL,
  longitude DECIMAL(17, 14) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  username VARCHAR(30) NOT NULL UNIQUE,
  password VARCHAR(250) NOT NULL,
  profile_picture VARCHAR(250) DEFAULT NULL,
  score INT(6) NOT NULL DEFAULT 0,
  register_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  role VARCHAR(30) NOT NULL DEFAULT 'user',
  auth_code VARCHAR(250) DEFAULT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 0
 );

CREATE TABLE `partida`(
  id INT PRIMARY KEY AUTO_INCREMENT,
  id_user INT NOT NULL,
  id_opponent INT,
  partida_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  isOpen TINYINT(1) NOT NULL DEFAULT 0,
  FOREIGN KEY (id_user) REFERENCES user(id),
  FOREIGN KEY (id_opponent) REFERENCES user(id)
 );

CREATE TABLE `question`(
  id INT PRIMARY KEY AUTO_INCREMENT,
  pregunta TEXT NOT NULL,
  category VARCHAR(100) NOT NULL,
  count_acertada INT(30) DEFAULT 1,
  count_ofrecida INT(30) DEFAULT 1,
  isCreada TINYINT(1) NOT NULL DEFAULT 1,
  reports INT(10) NOT NULL,
  active TINYINT(1) NOT NULL DEFAULT 1
);

CREATE TABLE `answer`(
  id INT PRIMARY KEY AUTO_INCREMENT,
  option_a varchar(255) NOT NULL,
  option_b varchar(255) NOT NULL,
  option_c varchar(255) NOT NULL,
  option_d varchar(255) NOT NULL,
  right_answer char(1) NOT NULL,
  question_id INT NOT NULL,
  FOREIGN KEY (question_id) REFERENCES question(id)
);

 CREATE TABLE `user_question`(
  `id` INT(30) PRIMARY KEY AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `id_question` INT NOT NULL,
  `wasRight` BOOLEAN,
  FOREIGN KEY (id_user) REFERENCES user(id),
  FOREIGN KEY (id_question) REFERENCES question(id)
 );

 INSERT INTO `user` (`id`, `fullname`, `birth_year`, `gender`, `country`, `latitude`, `longitude`, `email`, `username`, `password`, `profile_picture`, `score`, `register_date`, `role`, `auth_code`, `is_active`) VALUES
(1, 'Mariano Saldivar', 1990, 'Masculino', '', -34.67067815900575, -58.56332018874492, 'admin@grupo21.com', 'MarianCapo', '$2a$12$ispOhCnknPxb/9ScWRuYzeyP3OHujBVWu1tJCZeLbLxLPCM/ArCOO', NULL, 0, '2024-06-17 00:00:00', 'admin', NULL, 1),
(2, 'admin', 1990, 'Masculino', '', -34.67067815900575, -58.56332018874492, 'admin@gmail.com', 'admin', '$2a$12$ispOhCnknPxb/9ScWRuYzeyP3OHujBVWu1tJCZeLbLxLPCM/ArCOO', NULL, 0, '2024-06-18 11:06:26', 'admin', NULL, 1),
(3, 'user', 1990, 'Masculino', '', -34.67067815900575, -58.56332018874492, 'user@gmail.com', 'user', '$2a$12$ispOhCnknPxb/9ScWRuYzeyP3OHujBVWu1tJCZeLbLxLPCM/ArCOO', NULL, 0, '2024-06-11 11:06:26', 'user', NULL, 1),
(9, 'editor', 1990, 'Masculino', '', -34.67067815900575, -58.56332018874492, 'editor@gmail.com', 'editor', '$2a$12$ispOhCnknPxb/9ScWRuYzeyP3OHujBVWu1tJCZeLbLxLPCM/ArCOO', NULL, 0, '2024-06-11 11:06:26', 'editor', NULL, 1),
(4, 'a', 2, 'Masculino', '', -34.66869860000000, -58.56149470000000, '1@1', '1', '$2a$12$ispOhCnknPxb/9ScWRuYzeyP3OHujBVWu1tJCZeLbLxLPCM/ArCOO', 'C:\\xampp\\htdocs\\controller/../public/2Q.png', 0, '2024-06-14 11:06:26', 'admin', '8afbf6984ab131a384beb515d67a8d40', 1),
(7, '2', 2, 'Masculino', 'Argentina', -34.66869860000000, -58.56149470000000, '2@2', '2', '$2a$12$ispOhCnknPxb/9ScWRuYzeyP3OHujBVWu1tJCZeLbLxLPCM/ArCOO', 'C:\\xampp\\htdocs\\controller/../public/53e395ab-2269-44f1-a627-ddffbda7920d.jpg', 0, '2024-06-17 09:50:14', 'user', '44aa648fab6f1473e546eb5c4cd12807', 1),
(8, '3', 3, 'Masculino', 'Bolivia', -34.66869860000000, -58.56149470000000, '3@3', '3', '$2a$12$ispOhCnknPxb/9ScWRuYzeyP3OHujBVWu1tJCZeLbLxLPCM/ArCOO', 'C:\\xampp\\htdocs\\controller/../public/E-E8umqUUAU51R5.jfif', 0, '2024-06-17 11:48:56', 'user', '133ba1949154c6dd3706f38ff0c3e7c0', 1);

INSERT INTO `question` (`id`, `pregunta`, `category`) VALUES
(1, '¿Cuál es la capital de Francia?', 'cultura'),
(2, '¿Quién escribió "Cien años de soledad"?', 'cultura'),
(3, '¿Cuál es el país más grande del mundo?', 'cultura'),
(4, '¿Cuál es el océano más grande del mundo?', 'cultura'),
(5, '¿Quién pintó la Mona Lisa?', 'cultura'),
(6, '¿Cuál es el país más grande de África?', 'cultura'),
(7, '¿Quién escribió "Matar a un ruiseñor"?', 'cultura'),
(8, '¿Qué país es famoso por el sushi?', 'cultura'),
(9, '¿En qué continente se encuentra el río Amazonas?', 'cultura'),
(10, '¿Quién pintó la Capilla Sixtina?', 'cultura'),
(11, '¿Cuál es el símbolo químico del sodio?', 'cultura'),
(12, '¿Cuál es el océano que rodea a las Islas Malvinas?', 'cultura'),
(13, '¿Quién fue el primer presidente de los Estados Unidos?', 'cultura'),
(14, '¿Cuál es la capital de Turquía?', 'cultura'),
(15, '¿En qué año se fundó la Organización de las Naciones Unidas?', 'cultura'),
(16, '¿Qué planeta es el más cercano al Sol?', 'cultura'),
(17, '¿Cuál es el idioma oficial de China?', 'cultura'),
(18, '¿Qué científico desarrolló la teoría de la evolución?', 'cultura'),
(19, '¿Qué país tiene la mayor cantidad de población musulmana?', 'cultura'),
(20, '¿Cuál es la capital de México?', 'cultura'),
(21, '¿Cuál es la ciudad más grande de Brasil?', 'cultura'),
(22, '¿Quién pintó "Las Meninas"?', 'cultura'),
(23, '¿Cuál es el nombre de la civilización antigua que construyó las pirámides de Giza?', 'cultura'),
(24, '¿Qué gas es conocido como el "gas de la risa"?', 'cultura'),
(25, '¿En qué año terminó la Primera Guerra Mundial?', 'cultura'),
(26, '¿Cuál es la capital de Suecia?', 'cultura'),
(27, '¿Qué animal es conocido por su capacidad de cambiar de color?', 'cultura'),
(28, '¿En qué país se encuentra la Estatua de la Libertad?', 'cultura'),
(29, '¿Cuál es la capital de Rusia?', 'cultura'),
(30, '¿Quién es conocido como el "Padre de la Medicina"?', 'cultura'),
(31, '¿Cuál es el mayor océano en términos de volumen?', 'cultura'),
(32, '¿Qué país es conocido por sus canguros?', 'cultura'),
(33, '¿Cuál es el idioma oficial de Egipto?', 'cultura'),
(34, '¿Cuál es el órgano principal del sistema circulatorio?', 'cultura'),
(35, '¿Qué país es conocido por el vino tinto Malbec?', 'cultura'),
(36, '¿Quién escribió "La divina comedia"?', 'cultura'),
(37, '¿Cuál es la moneda oficial de Japón?', 'cultura'),
(38, '¿Cuál es el animal más grande del mundo?', 'cultura'),
(39, '¿Qué país es conocido como "la tierra del sol naciente"?', 'cultura'),
(40, '¿Cuál es la capital de Egipto?', 'cultura'),
(41, '¿Cuál es el sistema montañoso más largo del mundo?', 'cultura'),
(42, '¿Qué país tiene forma de bota?', 'cultura'),
(43, '¿Qué inventó Alexander Graham Bell?', 'cultura'),
(44, '¿Qué animal es símbolo de la paz?', 'cultura'),
(45, '¿En qué país se encuentra la ciudad de Marrakech?', 'cultura'),
(46, '¿Quién pintó "El grito"?', 'cultura'),
(47, '¿Cuál es la capital de Canadá?', 'cultura'),
(48, '¿Qué escritor creó el personaje de Sherlock Holmes?', 'cultura'),
(49, '¿Qué ciudad es conocida como "La Gran Manzana"?', 'cultura'),
(50, '¿Cuál es la moneda oficial de Suiza?', 'cultura'),
(51, '¿Quién ganó la Copa del Mundo de la FIFA en 2018?', 'deportes'),
(52, '¿En qué deporte se utiliza una pelota más pequeña?', 'deportes'),
(53, '¿Quién es el máximo goleador en la historia de la selección brasileña de fútbol?', 'deportes'),
(54, '¿Qué equipo de fútbol americano tiene el récord de más Super Bowls ganados?', 'deportes'),
(55, '¿Cuál es el nombre del estadio del FC Barcelona?', 'deportes'),
(56, '¿Quién es el máximo goleador en la historia de la selección argentina de fútbol?', 'deportes'),
(57, '¿En qué deporte se compite por el Trofeo Heisman?', 'deportes'),
(58, '¿En qué deporte se compite por la Copa del Mundo de Rugby Sevens?', 'deportes'),
(59, '¿Quién es el máximo goleador en la historia de la selección portuguesa de fútbol?', 'deportes'),
(60, '¿Quién ganó la medalla de oro en el salto de altura masculino en los Juegos Olímpicos de 2020?', 'deportes'),
(61, '¿Quién es el máximo goleador en la historia de la selección española de fútbol?', 'deportes'),
(62, '¿Quién es el máximo goleador en la historia de la Liga Premier de Inglaterra?', 'deportes'),
(63, '¿En qué deporte se compite por el Trofeo de la Copa Davis?', 'deportes'),
(64, '¿En qué año se celebraron los Juegos Olímpicos de Verano en Sydney?', 'deportes'),
(65, '¿Quién es el máximo goleador en la historia de la selección alemana de fútbol?', 'deportes'),
(66, '¿Quién es el máximo goleador en la historia de la Liga de Campeones de la UEFA?', 'deportes'),
(67, '¿Qué país ganó la Copa América en 2021?', 'deportes'),
(68, '¿En qué año ganó España su primer y único Mundial de fútbol?', 'deportes'),
(69, '¿Qué país ganó el Mundial de Clubes de la FIFA en 2021?', 'deportes'),
(70, '¿Qué tenista femenina ha ganado más títulos de Grand Slam?', 'deportes'),
(71, '¿Cuál fue el nombre del líder militar y político francés que dirigió la resistencia contra la invasión alemana durante la Segunda Guerra Mundial?', 'historia'),
(72, '¿Qué evento histórico marcó el fin de la Segunda Guerra Mundial en Europa?', 'historia'),
(73, '¿Cuál fue el nombre del líder de la Revolución Mexicana que luchó por la reforma agraria y los derechos de los trabajadores?', 'historia'),
(74, '¿Cuál fue el nombre del explorador que dirigió la primera expedición europea que llegó a Brasil en 1500?', 'historia'),
(75, '¿Cuál fue el nombre del tratado que puso fin a la Guerra de Independencia de Estados Unidos en 1783?', 'historia'),
(76, '¿Quién fue el líder del movimiento de independencia de Haití en el siglo XIX?', 'historia'),
(77, '¿En qué año comenzó la Revolución Industrial en Gran Bretaña?', 'historia'),
(78, '¿Cuál fue el nombre del líder político y militar que unificó a Italia en el siglo XIX?', 'historia'),
(79, '¿Quién fue el presidente de Estados Unidos durante la Guerra de Vietnam?', 'historia'),
(80, '¿Cuál fue el nombre del líder político y militar alemán durante la Primera Guerra Mundial?', 'historia'),
(81, '¿Cuál fue el nombre del líder político y militar británico durante la Segunda Guerra Mundial?', 'historia'),
(82, '¿Qué evento histórico marcó el fin de la Guerra Fría en 1991?', 'historia'),
(83, '¿Cuál fue el nombre del líder político y militar español que gobernó el país durante la dictadura franquista?', 'historia'),
(84, '¿Quién fue el líder político y militar alemán durante la Segunda Guerra Mundial?', 'historia'),
(85, '¿Cuál fue el nombre del movimiento que promovió la abolición de la esclavitud en Estados Unidos en el siglo XIX?', 'historia'),
(86, '¿Quién fue el líder político y militar soviético durante la Segunda Guerra Mundial?', 'historia'),
(87, '¿Cuál fue el nombre del líder político y militar estadounidense que dirigió las fuerzas aliadas en Europa durante la Segunda Guerra Mundial?', 'historia'),
(88, '¿Qué tratado puso fin a la Guerra de Vietnam en 1973?', 'historia'),
(89, '¿Cuál fue el nombre del líder político y militar japonés que estuvo en el poder durante la Segunda Guerra Mundial?', 'historia'),
(90, '¿Quién fue el líder del movimiento independentista de Argelia en el siglo XX?', 'historia'),
(91, '¿Quién fue el primer presidente de los Estados Unidos?', 'historia'),
(92, '¿En qué año cayó el Imperio Romano de Occidente?', 'historia'),
(93, '¿Cuál fue el nombre del faraón que unificó el Alto y Bajo Egipto?', 'historia'),
(94, '¿Qué evento inició la Primera Guerra Mundial?', 'historia'),
(95, '¿Quién fue el líder revolucionario argentino que participó en la independencia de varios países sudamericanos?', 'historia'),
(96, '¿Qué país fue el primero en usar tanques en combate durante la Primera Guerra Mundial?', 'historia'),
(97, '¿En qué año se firmó la Declaración de Independencia de Estados Unidos?', 'historia'),
(98, '¿Quién fue el primer emperador de China?', 'historia'),
(99, '¿Qué líder indio encabezó la lucha por la independencia de la India con su política de no violencia?', 'historia'),
(100, '¿Qué tratado puso fin a la Guerra de los Cien Años?', 'historia');

INSERT INTO `answer` (question_id, option_a, option_b, option_c, option_d, right_answer) VALUES
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
(50, 'Euro', 'Dólar', 'Franco suizo', 'Libra esterlina', 'c'),
(51, 'Alemania', 'Brasil', 'Francia', 'Croacia', 'c'),
(52, 'Fútbol', 'Baloncesto', 'Tenis', 'Golf', 'd'),
(53, 'Ronaldo Nazário', 'Neymar Jr.', 'Pelé', 'Romário', 'c'),
(54, 'Green Bay Packers', 'New England Patriots', 'Pittsburgh Steelers', 'Dallas Cowboys', 'b'),
(55, 'Santiago Bernabéu', 'Old Trafford', 'Camp Nou', 'San Siro', 'c'),
(56, 'Lionel Messi', 'Diego Maradona', 'Gabriel Batistuta', 'Hernán Crespo', 'a'),
(57, 'Fútbol americano', 'Baloncesto', 'Béisbol', 'Atletismo', 'a'),
(58, 'Rugby', 'Cricket', 'Fútbol', 'Golf', 'a'),
(59, 'Cristiano Ronaldo', 'Eusébio', 'Luis Figo', 'Nuno Gomes', 'a'),
(60, 'Mutaz Essa Barshim', 'Gianmarco Tamberi', 'Derek Drouin', 'Bohdan Bondarenko', 'a'),
(61, 'Raúl González', 'Fernando Torres', 'David Villa', 'David Silva', 'c'),
(62, 'Alan Shearer', 'Wayne Rooney', 'Thierry Henry', 'Sergio Agüero', 'a'),
(63, 'Tenis', 'Golf', 'Fútbol', 'Cricket', 'a'),
(64, '2000', '1996', '2004', '2008', 'a'),
(65, 'Gerd Müller', 'Miroslav Klose', 'Thomas Müller', 'Lukas Podolski', 'b'),
(66, 'Cristiano Ronaldo', 'Lionel Messi', 'Robert Lewandowski', 'Karim Benzema', 'a'),
(67, 'Argentina', 'Brasil', 'Uruguay', 'Chile', 'a'),
(68, '2010', '2006', '1982', '1994', 'a'),
(69, 'Bayern Múnich', 'Chelsea FC', 'Real Madrid', 'FC Barcelona', 'b'),
(70, 'Serena Williams', 'Margaret Court', 'Steffi Graf', 'Martina Navratilova', 'b'),
(71, 'Charles de Gaulle', 'Napoleon Bonaparte', 'Louis XIV', 'Philippe Pétain', 'a'),
(72, 'Rendición de Alemania', 'Bombardeo de Pearl Harbor', 'Caída de Berlín', 'Ataque a Normandía', 'a'),
(73, 'Emiliano Zapata', 'Francisco Villa', 'Porfirio Díaz', 'Venustiano Carranza', 'a'),
(74, 'Cristóbal Colón', 'Fernando de Magallanes', 'Pedro Álvares Cabral', 'Vasco da Gama', 'c'),
(75, 'Tratado de Versalles', 'Tratado de París', 'Tratado de Londres', 'Tratado de Gante', 'b'),
(76, 'Toussaint Louverture', 'Jean-Jacques Dessalines', 'Henri Christophe', 'Alexandre Pétion', 'a'),
(77, '1750', '1800', '1850', '1900', 'a'),
(78, 'Giuseppe Garibaldi', 'Victor Emmanuel II', 'Benito Mussolini', 'Camillo Cavour', 'a'),
(79, 'Lyndon B. Johnson', 'Richard Nixon', 'John F. Kennedy', 'Dwight D. Eisenhower', 'a'),
(80, 'Kaiser Wilhelm II', 'Adolf Hitler', 'Paul von Hindenburg', 'Erich Ludendorff', 'a'),
(81, 'Winston Churchill', 'Neville Chamberlain', 'Clement Attlee', 'Margaret Thatcher', 'a'),
(82, 'Disolución de la Unión Soviética', 'Caída del Muro de Berlín', 'Tratado de Yalta', 'Revolución de Terciopelo en Checoslovaquia', 'a'),
(83, 'Francisco Franco', 'Juan Carlos I', 'Felipe VI', 'Adolfo Suárez', 'a'),
(84, 'Adolf Hitler', 'Hermann Göring', 'Joseph Goebbels', 'Heinrich Himmler', 'a'),
(85, 'Movimiento de los Derechos Civiles', 'Movimiento Feminista', 'Movimiento Abolicionista', 'Movimiento de Independencia', 'c'),
(86, 'Joseph Stalin', 'Vladimir Lenin', 'Nikita Jrushchov', 'Leon Trotsky', 'a'),
(87, 'Dwight D. Eisenhower', 'George S. Patton', 'Douglas MacArthur', 'Franklin D. Roosevelt', 'a'),
(88, 'Tratado de París', 'Tratado de Versalles', 'Tratado de Viena', 'Tratado de Roma', 'a'),
(89, 'Emperor Hirohito', 'Hideki Tojo', 'Isoroku Yamamoto', 'Emperor Meiji', 'b'),
(90, 'Ahmed Ben Bella', 'Houari Boumédiène', 'Abdelaziz Bouteflika', 'Ferhat Abbas', 'a'),
(91, 'Thomas Jefferson', 'George Washington', 'Abraham Lincoln', 'John Adams', 'b'),
(92, '410 d.C.', '395 d.C.', '476 d.C.', '1453 d.C.', 'c'),
(93, 'Ramsés II', 'Menes', 'Tutankamón', 'Akhenatón', 'b'),
(94, 'El hundimiento del Lusitania', 'La invasión de Polonia', 'El asesinato del archiduque Francisco Fernando', 'El tratado de Versalles', 'c'),
(95, 'Antonio José de Sucre', 'José de San Martín', 'Simón Bolívar', 'Francisco de Miranda', 'b'),
(96, 'Francia', 'Reino Unido', 'Alemania', 'Estados Unidos', 'c'),
(97, '1776', '1783', '1775', '1781', 'a'),
(98, 'Liu Bang', 'Qin Shi Huang', 'Wudi', 'Sun Yat-sen', 'b'),
(99, 'Subhas Chandra Bose', 'Jawaharlal Nehru', 'Bhagat Singh', 'Mahatma Gandhi', 'd'),
(100, 'Tratado de París', 'Tratado de Troyes', 'Tratado de Utrecht', 'Tratado de Versalles', 'b');