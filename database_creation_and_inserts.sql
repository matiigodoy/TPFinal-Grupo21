-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-06-2024 a las 23:47:42
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `answer`
--

CREATE TABLE `answer` (
  `id` int(11) NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `right_answer` char(1) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `answer`
--

INSERT INTO `answer` (`id`, `option_a`, `option_b`, `option_c`, `option_d`, `right_answer`, `question_id`) VALUES
(1, 'Berlín', 'Madrid', 'París', 'Roma', 'c', 1),
(2, 'Mario Vargas Llosa', 'Gabriel García Márquez', 'Isabel Allende', 'Pablo Neruda', 'b', 2),
(3, 'China', 'Rusia', 'Estados Unidos', 'Canadá', 'b', 3),
(4, 'Océano Atlántico', 'Océano Índico', 'Océano Pacífico', 'Océano Ártico', 'c', 4),
(5, 'Leonardo da Vinci', 'Claude Monet', 'Vincent van Gogh', 'Pablo Picasso', 'a', 5),
(6, 'Egipto', 'Sudáfrica', 'Argelia', 'Nigeria', 'c', 6),
(7, 'J.D. Salinger', 'Harper Lee', 'F. Scott Fitzgerald', 'Mark Twain', 'b', 7),
(8, 'China', 'Corea del Sur', 'Japón', 'Tailandia', 'c', 8),
(9, 'Asia', 'África', 'América del Sur', 'América del Norte', 'c', 9),
(10, 'Leonardo da Vinci', 'Rafael', 'Miguel Ángel', 'Caravaggio', 'c', 10),
(11, 'Na', 'S', 'N', 'O', 'a', 11),
(12, 'Océano Atlántico', 'Océano Índico', 'Océano Pacífico', 'Océano Ártico', 'a', 12),
(13, 'Thomas Jefferson', 'Abraham Lincoln', 'George Washington', 'John Adams', 'c', 13),
(14, 'Estambul', 'Ankara', 'Izmir', 'Antalya', 'b', 14),
(15, '1940', '1945', '1950', '1955', 'b', 15),
(16, 'Venus', 'Marte', 'Mercurio', 'Tierra', 'c', 16),
(17, 'Mandarín', 'Cantonés', 'Coreano', 'Japonés', 'a', 17),
(18, 'Isaac Newton', 'Galileo Galilei', 'Charles Darwin', 'Albert Einstein', 'c', 18),
(19, 'Arabia Saudita', 'Pakistán', 'Indonesia', 'Irán', 'c', 19),
(20, 'Guadalajara', 'Monterrey', 'Cancún', 'Ciudad de México', 'd', 20),
(21, 'Río de Janeiro', 'Brasilia', 'Salvador', 'São Paulo', 'd', 21),
(22, 'Francisco de Goya', 'El Greco', 'Diego Velázquez', 'Pablo Picasso', 'c', 22),
(23, 'Mayas', 'Aztecas', 'Romanos', 'Egipcios', 'd', 23),
(24, 'Oxígeno', 'Nitrógeno', 'Helio', 'Óxido nitroso', 'd', 24),
(25, '1916', '1918', '1920', '1922', 'b', 25),
(26, 'Copenhague', 'Oslo', 'Helsinki', 'Estocolmo', 'd', 26),
(27, 'Pulpo', 'Camaleón', 'Calamar', 'Pez payaso', 'b', 27),
(28, 'Francia', 'Reino Unido', 'Canadá', 'Estados Unidos', 'd', 28),
(29, 'San Petersburgo', 'Moscú', 'Kiev', 'Minsk', 'b', 29),
(30, 'Hipócrates', 'Aristóteles', 'Galeno', 'Sócrates', 'a', 30),
(31, 'Océano Atlántico', 'Océano Índico', 'Océano Pacífico', 'Océano Ártico', 'c', 31),
(32, 'Sudáfrica', 'Nueva Zelanda', 'Australia', 'Canadá', 'c', 32),
(33, 'Inglés', 'Francés', 'Árabe', 'Italiano', 'c', 33),
(34, 'Pulmones', 'Corazón', 'Hígado', 'Riñones', 'b', 34),
(35, 'Francia', 'España', 'Italia', 'Argentina', 'd', 35),
(36, 'Dante Alighieri', 'Giovanni Boccaccio', 'Petrarca', 'Torquato Tasso', 'a', 36),
(37, 'Yen', 'Won', 'Dólar', 'Euro', 'a', 37),
(38, 'Elefante', 'Ballena azul', 'Jirafa', 'Tiburón blanco', 'b', 38),
(39, 'Japón', 'China', 'Corea del Sur', 'India', 'a', 39),
(40, 'El Cairo', 'Alejandría', 'Luxor', 'Asuán', 'a', 40),
(41, 'Cordillera de los Andes', 'Himalaya', 'Montes Urales', 'Montes Apalaches', 'a', 41),
(42, 'Grecia', 'Italia', 'España', 'Portugal', 'b', 42),
(43, 'Teléfono', 'Radio', 'Televisión', 'Computadora', 'a', 43),
(44, 'Paloma', 'Águila', 'León', 'Delfín', 'a', 44),
(45, 'Marruecos', 'Egipto', 'Argelia', 'Túnez', 'a', 45),
(46, 'Edvard Munch', 'Gustav Klimt', 'Egon Schiele', 'Paul Klee', 'a', 46),
(47, 'Toronto', 'Vancouver', 'Ottawa', 'Montreal', 'c', 47),
(48, 'Agatha Christie', 'Arthur Conan Doyle', 'Ian Fleming', 'Raymond Chandler', 'b', 48),
(49, 'Los Ángeles', 'Chicago', 'Nueva York', 'San Francisco', 'c', 49),
(50, 'Euro', 'Dólar', 'Franco suizo', 'Libra esterlina', 'c', 50),
(51, 'Alemania', 'Brasil', 'Francia', 'Croacia', 'c', 51),
(52, 'Fútbol', 'Baloncesto', 'Tenis', 'Golf', 'd', 52),
(53, 'Ronaldo Nazário', 'Neymar Jr.', 'Pelé', 'Romário', 'c', 53),
(54, 'Green Bay Packers', 'New England Patriots', 'Pittsburgh Steelers', 'Dallas Cowboys', 'b', 54),
(55, 'Santiago Bernabéu', 'Old Trafford', 'Camp Nou', 'San Siro', 'c', 55),
(56, 'Lionel Messi', 'Diego Maradona', 'Gabriel Batistuta', 'Hernán Crespo', 'a', 56),
(57, 'Fútbol americano', 'Baloncesto', 'Béisbol', 'Atletismo', 'a', 57),
(58, 'Rugby', 'Cricket', 'Fútbol', 'Golf', 'a', 58),
(59, 'Cristiano Ronaldo', 'Eusébio', 'Luis Figo', 'Nuno Gomes', 'a', 59),
(60, 'Mutaz Essa Barshim', 'Gianmarco Tamberi', 'Derek Drouin', 'Bohdan Bondarenko', 'a', 60),
(61, 'Raúl González', 'Fernando Torres', 'David Villa', 'David Silva', 'c', 61),
(62, 'Alan Shearer', 'Wayne Rooney', 'Thierry Henry', 'Sergio Agüero', 'a', 62),
(63, 'Tenis', 'Golf', 'Fútbol', 'Cricket', 'a', 63),
(64, '2000', '1996', '2004', '2008', 'a', 64),
(65, 'Gerd Müller', 'Miroslav Klose', 'Thomas Müller', 'Lukas Podolski', 'b', 65),
(66, 'Cristiano Ronaldo', 'Lionel Messi', 'Robert Lewandowski', 'Karim Benzema', 'a', 66),
(67, 'Argentina', 'Brasil', 'Uruguay', 'Chile', 'a', 67),
(68, '2010', '2006', '1982', '1994', 'a', 68),
(69, 'Bayern Múnich', 'Chelsea FC', 'Real Madrid', 'FC Barcelona', 'b', 69),
(70, 'Serena Williams', 'Margaret Court', 'Steffi Graf', 'Martina Navratilova', 'b', 70),
(71, 'Charles de Gaulle', 'Napoleon Bonaparte', 'Louis XIV', 'Philippe Pétain', 'a', 71),
(72, 'Rendición de Alemania', 'Bombardeo de Pearl Harbor', 'Caída de Berlín', 'Ataque a Normandía', 'a', 72),
(73, 'Emiliano Zapata', 'Francisco Villa', 'Porfirio Díaz', 'Venustiano Carranza', 'a', 73),
(74, 'Hirohito', 'Hideki Tojo', 'Isoroku Yamamoto', 'Emperor Meiji', 'b', 74),
(75, 'Tratado de Versalles', 'Tratado de París', 'Tratado de Londres', 'Tratado de Gante', 'b', 75),
(76, 'Toussaint Louverture', 'Jean-Jacques Dessalines', 'Henri Christophe', 'Alexandre Pétion', 'a', 76),
(77, '1750', '1800', '1850', '1900', 'a', 7),
(78, 'Giuseppe Garibaldi', 'Victor Emmanuel II', 'Benito Mussolini', 'Camillo Cavour', 'a', 78),
(79, 'Lyndon B. Johnson', 'Richard Nixon', 'John F. Kennedy', 'Dwight D. Eisenhower', 'a', 79),
(80, 'Kaiser Wilhelm II', 'Adolf Hitler', 'Paul von Hindenburg', 'Erich Ludendorff', 'a', 80),
(81, 'Winston Churchill', 'Neville Chamberlain', 'Clement Attlee', 'Margaret Thatcher', 'a', 81),
(82, 'Disolución de la Unión Soviética', 'Caída del Muro de Berlín', 'Tratado de Yalta', 'Revolución de Terciopelo en Checoslovaquia', 'a', 82),
(83, 'Francisco Franco', 'Juan Carlos I', 'Felipe VI', 'Adolfo Suárez', 'a', 83),
(84, 'Adolf Hitler', 'Hermann Göring', 'Joseph Goebbels', 'Heinrich Himmler', 'a', 84),
(85, 'Movimiento de los Derechos Civiles', 'Movimiento Feminista', 'Movimiento Abolicionista', 'Movimiento de Independencia', 'c', 85),
(86, 'Joseph Stalin', 'Vladimir Lenin', 'Nikita Jrushchov', 'Leon Trotsky', 'a', 86),
(87, 'Dwight D. Eisenhower', 'George S. Patton', 'Douglas MacArthur', 'Franklin D. Roosevelt', 'a', 87),
(88, 'Tratado de París', 'Tratado de Versalles', 'Tratado de Viena', 'Tratado de Roma', 'a', 88),
(89, 'Emperor Hirohito', 'Hideki Tojo', 'Isoroku Yamamoto', 'Emperor Meiji', 'b', 89),
(90, 'Ahmed Ben Bella', 'Houari Boumédiène', 'Abdelaziz Bouteflika', 'Ferhat Abbas', 'a', 90);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida`
--

CREATE TABLE `partida` (
  `id` int(11) NOT NULL,
  `id_partida` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_question` int(11) NOT NULL,
  `id_opponent` int(11) DEFAULT NULL,
  `was_right` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `pregunta` text NOT NULL,
  `category` varchar(100) NOT NULL,
  `count_acertada` int(30) NOT NULL,
  `count_ofrecida` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `question`
--

INSERT INTO `question` (`id`, `pregunta`, `category`, `count_acertada`, `count_ofrecida`) VALUES
(1, '¿Cuál es la capital de Francia?', 'cultura', 0, 0),
(2, '¿Quién escribió \"Cien años de soledad\"?', 'cultura', 0, 0),
(3, '¿Cuál es el país más grande del mundo?', 'cultura', 0, 0),
(4, '¿Cuál es el océano más grande del mundo?', 'cultura', 0, 0),
(5, '¿Quién pintó la Mona Lisa?', 'cultura', 0, 0),
(6, '¿Cuál es el país más grande de África?', 'cultura', 0, 0),
(7, '¿Quién escribió \"Matar a un ruiseñor\"?', 'cultura', 0, 0),
(8, '¿Qué país es famoso por el sushi?', 'cultura', 0, 0),
(9, '¿En qué continente se encuentra el río Amazonas?', 'cultura', 0, 0),
(10, '¿Quién pintó la Capilla Sixtina?', 'cultura', 0, 0),
(11, '¿Cuál es el símbolo químico del sodio?', 'cultura', 0, 0),
(12, '¿Cuál es el océano que rodea a las Islas Malvinas?', 'cultura', 0, 0),
(13, '¿Quién fue el primer presidente de los Estados Unidos?', 'cultura', 0, 0),
(14, '¿Cuál es la capital de Turquía?', 'cultura', 0, 0),
(15, '¿En qué año se fundó la Organización de las Naciones Unidas?', 'cultura', 0, 0),
(16, '¿Qué planeta es el más cercano al Sol?', 'cultura', 0, 0),
(17, '¿Cuál es el idioma oficial de China?', 'cultura', 0, 0),
(18, '¿Qué científico desarrolló la teoría de la evolución?', 'cultura', 0, 0),
(19, '¿Qué país tiene la mayor cantidad de población musulmana?', 'cultura', 0, 0),
(20, '¿Cuál es la capital de México?', 'cultura', 0, 0),
(21, '¿Cuál es la ciudad más grande de Brasil?', 'cultura', 0, 0),
(22, '¿Quién pintó \"Las Meninas\"?', 'cultura', 0, 0),
(23, '¿Cuál es el nombre de la civilización antigua que construyó las pirámides de Giza?', 'cultura', 0, 0),
(24, '¿Qué gas es conocido como el \"gas de la risa\"?', 'cultura', 0, 0),
(25, '¿En qué año terminó la Primera Guerra Mundial?', 'cultura', 0, 0),
(26, '¿Cuál es la capital de Suecia?', 'cultura', 0, 0),
(27, '¿Qué animal es conocido por su capacidad de cambiar de color?', 'cultura', 0, 0),
(28, '¿En qué país se encuentra la Estatua de la Libertad?', 'cultura', 0, 0),
(29, '¿Cuál es la capital de Rusia?', 'cultura', 0, 0),
(30, '¿Quién es conocido como el \"Padre de la Medicina\"?', 'cultura', 0, 0),
(31, '¿Cuál es el mayor océano en términos de volumen?', 'cultura', 0, 0),
(32, '¿Qué país es conocido por sus canguros?', 'cultura', 0, 0),
(33, '¿Cuál es el idioma oficial de Egipto?', 'cultura', 0, 0),
(34, '¿Cuál es el órgano principal del sistema circulatorio?', 'cultura', 0, 0),
(35, '¿Qué país es conocido por el vino tinto Malbec?', 'cultura', 0, 0),
(36, '¿Quién escribió \"La divina comedia\"?', 'cultura', 0, 0),
(37, '¿Cuál es la moneda oficial de Japón?', 'cultura', 0, 0),
(38, '¿Cuál es el animal más grande del mundo?', 'cultura', 0, 0),
(39, '¿Qué país es conocido como \"la tierra del sol naciente\"?', 'cultura', 0, 0),
(40, '¿Cuál es la capital de Egipto?', 'cultura', 0, 0),
(41, '¿Cuál es el sistema montañoso más largo del mundo?', 'cultura', 0, 0),
(42, '¿Qué país tiene forma de bota?', 'cultura', 0, 0),
(43, '¿Qué inventó Alexander Graham Bell?', 'cultura', 0, 0),
(44, '¿Qué animal es símbolo de la paz?', 'cultura', 0, 0),
(45, '¿En qué país se encuentra la ciudad de Marrakech?', 'cultura', 0, 0),
(46, '¿Quién pintó \"El grito\"?', 'cultura', 0, 0),
(47, '¿Cuál es la capital de Canadá?', 'cultura', 0, 0),
(48, '¿Qué escritor creó el personaje de Sherlock Holmes?', 'cultura', 0, 0),
(49, '¿Qué ciudad es conocida como \"La Gran Manzana\"?', 'cultura', 0, 0),
(50, '¿Cuál es la moneda oficial de Suiza?', 'cultura', 0, 0),
(51, '¿Quién ganó la Copa del Mundo de la FIFA en 2018?', 'deportes', 0, 0),
(52, '¿En qué deporte se utiliza una pelota más pequeña?', 'deportes', 0, 0),
(53, '¿Quién es el máximo goleador en la historia de la selección brasileña de fútbol?', 'deportes', 0, 0),
(54, '¿Qué equipo de fútbol americano tiene el récord de más Super Bowls ganados?', 'deportes', 0, 0),
(55, '¿Cuál es el nombre del estadio del FC Barcelona?', 'deportes', 0, 0),
(56, '¿Quién es el máximo goleador en la historia de la selección argentina de fútbol?', 'deportes', 0, 0),
(57, '¿En qué deporte se compite por el Trofeo Heisman?', 'deportes', 0, 0),
(58, '¿En qué deporte se compite por la Copa del Mundo de Rugby Sevens?', 'deportes', 0, 0),
(59, '¿Quién es el máximo goleador en la historia de la selección portuguesa de fútbol?', 'deportes', 0, 0),
(60, '¿Quién ganó la medalla de oro en el salto de altura masculino en los Juegos Olímpicos de 2020?', 'deportes', 0, 0),
(61, '¿Quién es el máximo goleador en la historia de la selección española de fútbol?', 'deportes', 0, 0),
(62, '¿Quién es el máximo goleador en la historia de la Liga Premier de Inglaterra?', 'deportes', 0, 0),
(63, '¿En qué deporte se compite por el Trofeo de la Copa Davis?', 'deportes', 0, 0),
(64, '¿En qué año se celebraron los Juegos Olímpicos de Verano en Sydney?', 'deportes', 0, 0),
(65, '¿Quién es el máximo goleador en la historia de la selección alemana de fútbol?', 'deportes', 0, 0),
(66, '¿Quién es el máximo goleador en la historia de la Liga de Campeones de la UEFA?', 'deportes', 0, 0),
(67, '¿Qué país ganó la Copa América en 2021?', 'deportes', 0, 0),
(68, '¿En qué año ganó España su primer y único Mundial de fútbol?', 'deportes', 0, 0),
(69, '¿Qué país ganó el Mundial de Clubes de la FIFA en 2021?', 'deportes', 0, 0),
(70, '¿Qué tenista femenina ha ganado más títulos de Grand Slam?', 'deportes', 0, 0),
(71, '¿Cuál fue el nombre del líder militar y político francés que dirigió la resistencia contra la invasión alemana durante la Segunda Guerra Mundial?', 'historia', 0, 0),
(72, '¿Qué evento histórico marcó el fin de la Segunda Guerra Mundial en Europa?', 'historia', 0, 0),
(73, '¿Cuál fue el nombre del líder de la Revolución Mexicana que luchó por la reforma agraria y los derechos de los trabajadores?', 'historia', 0, 0),
(74, '¿Quién fue el líder político y militar japonés durante la Segunda Guerra Mundial?', 'historia', 0, 0),
(75, '¿Cuál fue el nombre del tratado que puso fin a la Guerra de Independencia de Estados Unidos en 1783?', 'historia', 0, 0),
(76, '¿Quién fue el líder del movimiento de independencia de Haití en el siglo XIX?', 'historia', 0, 0),
(77, '¿En qué año comenzó la Revolución Industrial en Gran Bretaña?', 'historia', 0, 0),
(78, '¿Cuál fue el nombre del líder político y militar que unificó a Italia en el siglo XIX?', 'historia', 0, 0),
(79, '¿Quién fue el presidente de Estados Unidos durante la Guerra de Vietnam?', 'historia', 0, 0),
(80, '¿Cuál fue el nombre del líder político y militar alemán durante la Primera Guerra Mundial?', 'historia', 0, 0),
(81, '¿Cuál fue el nombre del líder político y militar británico durante la Segunda Guerra Mundial?', 'historia', 0, 0),
(82, '¿Qué evento histórico marcó el fin de la Guerra Fría en 1991?', 'historia', 0, 0),
(83, '¿Cuál fue el nombre del líder político y militar español que gobernó el país durante la dictadura franquista?', 'historia', 0, 0),
(84, '¿Quién fue el líder político y militar alemán durante la Segunda Guerra Mundial?', 'historia', 0, 0),
(85, '¿Cuál fue el nombre del movimiento que promovió la abolición de la esclavitud en Estados Unidos en el siglo XIX?', 'historia', 0, 0),
(86, '¿Quién fue el líder político y militar soviético durante la Segunda Guerra Mundial?', 'historia', 0, 0),
(87, '¿Cuál fue el nombre del líder político y militar estadounidense que dirigió las fuerzas aliadas en Europa durante la Segunda Guerra Mundial?', 'historia', 0, 0),
(88, '¿Qué tratado puso fin a la Guerra de Vietnam en 1973?', 'historia', 0, 0),
(89, '¿Cuál fue el nombre del líder político y militar japonés que estuvo en el poder durante la Segunda Guerra Mundial?', 'historia', 0, 0),
(90, '¿Quién fue el líder del movimiento independentista de Argelia en el siglo XX?', 'historia', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `birth_year` int(4) NOT NULL,
  `gender` varchar(30) NOT NULL,
  `latitude` decimal(17,14) NOT NULL,
  `longitude` decimal(17,14) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(250) NOT NULL,
  `profile_picture` varchar(250) DEFAULT NULL,
  `score` int(6) NOT NULL DEFAULT 0,
  `register_date` datetime NOT NULL DEFAULT current_timestamp(),
  `role` varchar(30) NOT NULL DEFAULT 'user',
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `fullname`, `birth_year`, `gender`, `latitude`, `longitude`, `email`, `username`, `password`, `profile_picture`, `score`, `register_date`, `role`, `is_active`) VALUES
(1, 'Mariano Saldivar', 1990, 'Masculino', -34.67067815900575, -58.56332018874492, 'admin@grupo21.com', 'MarianCapo', '$2y$10$sra18NyRZW3RR58JMLDZkup29zmPLi8PqB.CbBHjISjjqV3JCla6.', NULL, 0, '2024-06-05 00:00:00', 'admin', 0),
(2, 'admin', 1990, 'Masculino', -34.67067815900575, -58.56332018874492, 'admin@gmail.com', 'admin', '$2y$10$sra18NyRZW3RR58JMLDZkup29zmPLi8PqB.CbBHjISjjqV3JCla6.', NULL, 0, '2024-06-05 00:00:00', 'admin', 0),
(3, 'user', 1990, 'Masculino', -34.67067815900575, -58.56332018874492, 'user@gmail.com', 'user', '$2y$10$sra18NyRZW3RR58JMLDZkup29zmPLi8PqB.CbBHjISjjqV3JCla6.', NULL, 10, '2024-06-05 00:00:00', 'user', 0),
(6, 'Tomas Cernik', 2003, 'Masculino', 0.00000000000000, 0.00000000000000, '1@1', '1', '$2y$10$oQb.lgj75SbdLubZwdQQYu5ZCA0IoR772yNnisrqn3V.zlEPtmUdO', 'C:\\xampp\\htdocs\\controller/../public/E1y7mk9WEAEjXNZ.jpg', 0, '2024-06-11 17:28:23', 'user', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indices de la tabla `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_question` (`id_question`);

--
-- Indices de la tabla `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de la tabla `partida`
--
ALTER TABLE `partida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`);

--
-- Filtros para la tabla `partida`
--
ALTER TABLE `partida`
  ADD CONSTRAINT `partida_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `partida_ibfk_2` FOREIGN KEY (`id_question`) REFERENCES `question` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
