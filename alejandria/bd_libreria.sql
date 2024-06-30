-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-06-2024 a las 18:50:57
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_libreria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `id_libro`, `id_usuario`, `contenido`, `fecha`) VALUES
(14, 123, 26, 'Increíble\n', '2024-06-03'),
(15, 124, 26, 'Qué miedo da!!! ', '2024-06-03'),
(87, 148, 26, 'Que bueno!', '2024-06-09'),
(161, 163, 26, '¡Me ha encantado!', '2024-06-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `autor` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `portada` varchar(255) DEFAULT NULL,
  `idApi` varchar(100) DEFAULT NULL,
  `fechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  `promedio_valoraciones` decimal(3,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `titulo`, `autor`, `descripcion`, `portada`, `idApi`, `fechaCreacion`, `id_usuario`, `promedio_valoraciones`) VALUES
(123, 'El resplandor', 'Stephen King', 'Jack Torrance está en busca de un nuevo comienzo en su vida. Su esposa quiere mantener a la familia unida. Y su pequeño hijo, Danny, es el único en darse cuenta del mal que los acecha. REDRUM . Esa es la palabra que Danny había visto en el espejo. Y, aunque no sabía leer, entendió que era un mensaje de horror. Danny tenía cinco años, y a esa edad pocos niños saben que los espejos invierten las imágenes y menos aún saben diferenciar entre realidad y fantasía. Pero Danny tenía pruebas de que sus fantasías relacionadas con el resplandor del espejo acabarían cumpliéndose: REDRUM... MURDER, asesinato. Su padre necesitaba aquel trabajo en el hotel. Danny sabía que su madre pensaba en el divorcio y que su padre se obsesionaba con algo muy malo, tan malo como la muerte y el suicidio. Sí, su padre necesitaba aceptar la propuesta de cuidar de aquel hotel de lujo de más de cien habitaciones, vacío y aislado por la nieve durante seis meses. Hasta el deshielo iban a estar solos. ¿Solos?...', 'http://books.google.com/books/content?id=hGwZEAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api', 'hGwZEAAAQBAJ', '2024-06-03 14:32:15', 26, 0.00),
(124, 'Las cuatro después de medianoche', 'Stephen King', 'Miedo multiplicado por dos es igual a terror absoluto. Si conseguiste sobrevivir más allá de Las dos después de medianoche, ahora estás obligado a encontrar el secreto más horripilante que jamás ha escondido un pueblo, y a enfocar a una bestia que despedazará tu cordura. Simplemente, vuelves a estar en las manos de Stephen King, paralizado por otro extraordinario doblete de novelas que detendrá tu corazón... justo a las cuatro después de medianoche. La crítica ha dicho... «Un narrador en plenitud de facultades.» Time', 'http://books.google.com/books/content?id=OqjvdYraoMoC&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api', 'OqjvdYraoMoC', '2024-06-03 14:32:19', 26, 0.00),
(146, 'En agosto nos vemos', 'Gabriel García Márquez', 'Un maravilloso regalo inesperado para los innumerables lectores de García Márquez. « En agosto nos vemos es también otra prueba irrefutable de su talento, dedicación y amor por la literatura.Es una obra imprescindible. El broche final a una carrera y una vida únicas». Juan Cruz, El Periódico Cada mes de agosto Ana Magdalena Bach toma el transbordador hasta la isla donde está enterrada su madre para visitar la tumba en la que yace. Esas visitas acaban suponiendo una irresistible invitación a convertirse en una personadistinta durante una noche al año. Escrita en el inconfundible y fascinante estilo de García Márquez, En agosto nos vemos es un canto a la vida, a la resistencia del goce pese al paso del tiempo y al deseo femenino. Un regalo inesperado para los innumerables lectores del Nobel colombiano. «De muy pocos escritores se puede decir que han escrito libros que han cambiado el curso de la literatura. Gabriel García Márquez lo hizo». The Guardian «Ningún escritor desde Dickens ha sido tan leído y tan profundamente querido como Gabriel García Márquez». Salman Rushdie «Uno de los más grandes y visionarios escritores y uno de mis favoritos desde que era joven». Barack Obama «La prosa envolvente de indiscutible originalidad con que García Márquez nos hace saborear cuanto toca. Objetos, animales, atmósferas caribeñas, hoteles isleños de burguesía ociosa, encuentros amorosos dichos y recreados con la plasticidad envolvente de la metáfora brillante, [...], hace que la novela sea al mismo tiempo una exaltación de la vida, y una fiesta reivindicativa de la libertad femenina». José María Pozuelo Yvancos, ABC «Gabo quiere llegar al alma de una mujer, que quizá no sabía que andaba a la deriva, en un libro que tiene el barniz y el brillo de su prosa envolvente de gran narrador que, en el fondo, era un inmenso poeta que nos hacía y nos hace volar con las palabras». Antón Castro, Heraldo de Aragón «Aquí, el personaje es una mujer empoderada, fuerte, madura, que toma decisiones sobre su sexualidad. Ana Magdalena Bach –primera protagonista femenina exclusiva de una novela de García Márquez– es el único eje del libro». Xavi Ayén, La Vanguardia «García Márquez resucita con una novela erótica y feminista». Bruno Pardo, ABC «Pese a la enfermedad, García Márquez despliega esa fabulosa capacidad que tiene de usar el lenguaje para sorprendernos, de inventar metáforas, crear asociaciones entre palabras que nadie antes había pensado. En agosto nos vemos es también otra prueba irrefutable de su talento, dedicación y amor por la literatura. Es una obra imprescindible. El broche final a una carrera y una vida únicas». Álvaro Santana Acuña, El Periódico', 'http://books.google.com/books/content?id=jWndEAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api', 'jWndEAAAQBAJ', '2024-06-09 15:55:15', 25, 0.00),
(148, 'Nunca', 'Ken Follett', 'Ken Follett regresa al thriller con una vertiginosa novela que imagina lo inimaginable. En el desierto del Sáhara, dos agentes de inteligencia siguen la pista a un poderoso grupo terrorista arriesgando sus vidas -y, cuando se enamoran perdidamente, sus carreras- a cada paso. En China, un alto cargo del gobierno con grandes ambiciones batalla contra los viejos halcones del ala dura del Partido que amenazan con empujar al país a un punto de no retorno. Y en Estados Unidos, la presidenta se enfrenta a una crisis global y al asedio de sus implacables oponentes políticos. Está dispuesta a todo para evitar una guerra innecesaria. Pero cuando un acto de agresión conduce a otro y las potencias más poderosas del mundo se ven atrapadas en una compleja red de alianzas de la que no pueden escapar, comienza una frenética carrera contrarreloj. ¿Podrá alguien, incluso con las mejores intenciones y las más excepcionales habilidades, detener lo inevitable? Nunca es un thriller extraordinario, lleno de heroínas y villanos, falsos profetas, agentes de élite, políticos desencantados y cínicos revolucionarios. Follett envía un mensaje de advertencia para nuestros tiempos en una historia intensa y trepidante que transporta a los lectores hasta el filo del abismo. «Cuando me documentaba para La caída de los gigantes, me impactó darme cuenta de que la Primera Guerra Mundial fue una guerra que nadie quería. Ningún líder europeo de ninguno de los dos bandos tenía intención de que sucediera. Pero, uno por uno, los emperadores y primeros ministros tomaron decisiones -decisiones lógicas y moderadas- que nos acercaron un pasito más al conflicto más terrible que el mundo ha conocido. Llegué a creer que todo fue un trágico accidente. Y me pregunté: ¿podría volver a ocurrir?» KEN FOLLETT La crítica ha dicho: « Nunca es el mejor libro de Ken Follett. Es aterrador. Desafío a cualquiera a abandonarlo tras haber leído las primeras 150 páginas». Stephen King «Un thriller brutal. Puro Ken Follett». Jacinto Antón, El País «No pueden perderse Nunca. Lo van a pasar terriblemente bien». Pepa Fernández, RNE «Una de las mejores novelas de espías que he leído en bastante tiempo». Sergio Vila-Sanjuán, La Vanguardia «Follett tiene una de las imaginaciones más brillantes y desbordantes de la literatura contemporánea». Javier del Pino, Cadena SER «Un adictivo thriller político que ya se perfila como otro best seller mundial». El Mundo «Urgente y ferozmente apasionante». The Washington Post «Un thriller deslumbrante y una de las lecturas más emocionantes del año». Daily Express «Audaz en su escala y meticulosamente documentado, Nunca hace que el resto de libros de espionaje internacional parezcan apocados, perezosos y provincianos». The Sunday Times «Prepárense para una experiencia electrizante». CNN.com «Absolutamente fascinante... Un thriller inteligente, aterrador y muy plausible». Booklist «Fantástico... Una imponente y poderosa demostración de uno de los mejores escritores del género». Publishers Weekly Sobre el autor han dicho: «Follett es un maestro». The Washington Post «Sigo envidiando como el primer día la capacidad de Follett para entretener. Sus tramas funcionan siempre y te mantiene pegado a cada página». Juan Gómez Jurado, ABC', 'http://books.google.com/books/content?id=eR85EAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api', 'eR85EAAAQBAJ', '2024-06-09 20:00:28', 26, 0.00),
(149, 'Harry Potter y la piedra filosofal', 'J.K. Rowling', 'Con las manos temblorosas, Harry le dio la vuelta al sobre y vio un sello de lacre púrpura con un escudo de armas: un león, un águila, un tejón y una serpiente, que rodeaban una gran letra H. Harry Potter nunca había oído nada sobre Hogwarts cuando las cartas comienzan a caer en el felpudo del número cuatro de Privet Drive. Escritas en tinta verde en un pergamino amarillento con un sello morado, sus horribles tíos las han confiscado velozmente. En su undécimo cumpleaños, un hombre gigante de ojos negros llamado Rubeus Hagrid aparece con una noticia extraordinaria: Harry Potter es un mago y tiene una plaza en el Colegio Hogwarts de Magia y Hechicería. ¡Una aventura increíble está a punto de empezar! Tema musical compuesto por James Hannigan.', 'http://books.google.com/books/content?id=2zgRDXFWkm8C&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api', '2zgRDXFWkm8C', '2024-06-09 20:06:16', 26, 0.00),
(153, 'La asistenta (La asistenta 1)', 'Freida McFadden', '<p> <b>EL LIBRO DEL QUE TODO EL MUNDO HABLA</b> </p> <p> <p> <b>Novela ganadora del Premio Valencia Negra en la categoría Best Novel.</b> <br> </p> <p> <b>Un thriller psicológicoabsolutamente adictivo que los lectores de</b> <i> <b>La mujer en la ventana </b> </i> <b>y</b> <i> <b> La pareja de al lado</b> </i> <b> no</b> <b>se querrán perder.</b> </p> <p>Todos los días friego la preciosa casa de los Winchester de arriba abajo. Recojo a su hija del colegio y preparo deliciosas comidas para toda la familia antes de subir a cenar sola en mi minúscula habitación del piso superior. <br> Intento no prestar atención a Nina cuando lo ensucia todo simplemente para ver cómo lo limpio. A las extrañas mentiras que cuenta sobre su propia hija. A su marido, que cada día parece más abatido. Pero cuando miro a Andrew a los ojos, castaños, encantadores y llenos de dolor, no me resulta difícil imaginar cómo sería vivir en la piel de Nina. El gran vestidor, el coche de lujo, el esposo perfecto.</p> <p>Hasta que un día no me resisto a probarme uno de sus maravillosos vestidos blancos. Solo quiero saber qué se siente. Pero ella pronto lo descubre, y cuando me doy cuenta de que la puerta de mi habitación solo se cierra por fuera ya es demasiado tarde.</p> <p>Algo me reconforta: <b> los Winchester no saben quién soy en realidad.</b> </p> <p> <b>No saben de lo que soy capaz...</b> </p> <p> <b>*Y a partir del 9 de mayo, no te pierdas <i>El secreto de la asistenta</i> - Premio Goodreads 2023 al mejor thriller del año*</b> </p> <p> <b>Los lectores comentan:</b> <br> «¡No podía dejarlo!... ¡Una montaña rusa increíble!».</p> <p>«Adictivo... Pura perfección».</p> <p>«¡Fantástico!... Me lo leí en una sola noche de lectura compulsiva... El final te deja noqueado».</p> <p>«¡Increíble!... ¡Alucinante!... Una absoluta delicia con una oscura guarnición de exquisiteces. ¡Es todo y más!».</p> <p>«No te vas a poder creer la dirección que toma este libro... Sus giros te dejan con la boca abierta... ¡Un thriller deslumbrante!».</p> <p>«¡Un cinco estrellas perfecto!».</p> <p>«¡Todavía no he leído una novela de Freida McFadden que no me vuele la cabeza! Esta me la acabé en una sentada. El final fue absolutamente perfecto y me dejó con ganas de más».</p> <p>«Oscuro y retorcido, no podrás dejar de pasar páginas hasta su escalofriantemente delicioso final. ¡Cinco estrellas supermerecidas!».</p>', 'http://books.google.com/books/publisher/content?id=5EbOEAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE72XkweyEzKd_f7ipusWt_-wKozOmpmsD9BmNJG9VNzO3GmCrbZwnXJHW2pRCcoev7X319RVuxvPc4Ym6jBWlAx9o1FLQSFHuO_G22uW7yKYTIIlu_c1FwuUL_HukHoOJNgvJND4&s', '5EbOEAAAQBAJ', '2024-06-10 08:53:55', 25, 0.00),
(156, 'El intercambio (La tapadera 2)', 'John Grisham', '<p> <b>Hace</b> <b>quince años burló a la mafia y salió con vida. ¿Qué fue del abogado Mitch McDeere?</b> <br> <b>El protagonista del icónico thriller</b> <b> <i>LA TAPADERA</i> </b> <b>regresa en una novela aún más trepidante.</b> </p> <p>«La secuela más ansiosamente esperada de la última década». <br> <i>Daily Express</i> </p> <p> <b>DIEZ DÍAS PARA SALVAR UNA VIDA.</b> <br> <b>UN SEGUNDO PARA PONERLE FIN.</b> </p> <p>Hace quince años, Mitch McDeere esquivó a la muerte. Y a la mafia. Tras hacerse con diez millones de dólares y desaparecer, vio cómo sus enemigos acababan en la cárcel o en la tumba. Ahora Mitch y su mujer, Abby, viven en Manhattan, donde él se ha abierto camino hasta convertirse en socio del bufete más importante del mundo.</p> <p>Pero cuando su mentor en Roma le pide un favor que le llevará a Estambul y Trípoli, Mitch se ve inmerso en el centro de un siniestro complot con ramificaciones por todo el planeta y que una vez más pondrá en peligro a sus colegas, amigos y familia. Mitch se ha convertido en un experto en mantenerse un paso por delante de sus adversarios, pero ahora que el tiempo se está agotando, ¿será capaz de volver a lograrlo? Esta vez, no hay donde esconderse.</p> <p> <b>Sobre la novela han dicho...</b> <br> «La secuela más ansiosamente esperada de la última década». <br> <i>Daily Express</i> </p> <p>«Una actualización vertiginosa... Grisham, en su versión más clásica, intensifica el suspense». <br> <i>The Wall Street Journal</i> </p> <p>«Una trama maravillosamente construida... Deja sin aliento al lector». <br> <i>Daily Mail</i> </p> <p>«En esta novela Grisham nos regala la clase de narración hipnótica que siempre esperamos de él». <br> <i>Financial Times</i> </p> <p>«Fascinante». <br> <i>Irish Independent</i> </p> <p>«Los fans de Grisham lo van a devorar... La trama y el ritmo son frenéticos». <br> <i>Independent</i> </p>', 'http://books.google.com/books/publisher/content?id=YKz6EAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE733GPS1cKeSKQSZEHTRZZFECZZSWPFJQYT3NWnjaYDvu3DWQoQ2viN5JTatyFJR_NeLiNt4dU0IJSpBiY5v065lwBfHxM5ohFYTBAxmV0sDc2LZQnonHW0IU0u01jGmXTVr4XAt&s', 'YKz6EAAAQBAJ', '2024-06-10 09:24:45', 25, 0.00),
(157, 'Un Animal Salvaje / A Wild Animal', 'Joel Dicker', 'VEINTIDÓS MILLONES DE LECTORES LO ESTÁN ESPERANDO. Vuelve la «voz napoleónica, que no escribe, boxea» (El Cultural), Premio Goncourt des Lycéens, Gran Premio de Novela de la Academia Francesa, Premio Lire, Premio Qué Leer, Premio San Clemente y Premio Internacional Alicante Noir. N.o 1 en la lista de más vendidos (Libération)El 2 de julio de 2022, dos delincuentes se disponen a robar en una importante joyería de Ginebra. Un incidente que dista mucho de ser un vulgar atraco. Veinte días antes, en una lujosa urbanización a orillas del lago Lemán, Sophie Braun se prepara para celebrar su cuadragésimo cumpleaños. La vida le sonríe: vive con su familia en una mansión rodeada de bosques, pero su idílico mundo está a punto de tambalearse. Su marido anda enredado en sus pequeños secretos. Su vecino, un policía de reputación irreprochable, se ha obsesionado con ella y la espía hasta en los detalles más íntimos. Y un misterioso merodeador le hace un regalo que pone su vida en peligro. Serán necesarios varios viajes al pa sado, lejos de Ginebra, para hallar el origen de esta intriga diabólica de la que nadie saldrá indemne. Un thriller con un ritmo y un suspense sobrecogedores, que nos recuerda por qué, desde La verdad sobre el caso Harry Quebert, Joël Dicker es un fenómeno editorial en todo el mundo, con más de veinte millones de lectores.La crítica ha dicho: «El arte y la destreza de un contador de historias nato, de alguien que parece haber nacido con el don de envolver a quien le lea con su narración». Lorenzo Silva «Llega el fenómeno Dicker. El sucesor de Stieg Larsson y E. L. James: entretenimiento en vena». Antonio Lozano, La Vanguardia «Su secreto, la elaboración de tramas adictivas que se alejan del best seller convencional. [...] Dicker se reafirma como un hábil generador de atmósferas y de intrigas vertiginosas, con constantes vueltas de tuerca y en las que no hay ni un minuto para el descanso». Beatriz Martínez, El Periódico de Catalunya «Un maestro de la trama y de los desenlaces imprevisibles. Sabe sorprenderte aun cuando ya estás prevenido sobre ello. Me he tragado [Un animal salvaje] como agua fresca». Pere Sureda, Público «Dicker volverá a batir récords y superará su marca personal de más de 20 millones de lectores. [...] Un thriller con un ritmo y un suspense sobrecogedores». Begoña Alonso,Elle «Novelas que se leen al ritmo de 100 páginas por sentada. [ ] Pero algo se mueve y se vuelve más complejo en el mapa del autor suizo con cada libro que pasa». Luis Alemany, El Mundo «Es tan adictiva como las novelas anteriores de Dicker. Una vez que te atrapa con un prólogo tan eficaz como conciso, la historia de un atraco y una cuenta atrás que crea la máxima tensión desde el principio, resulta imposible dejarla». Isabelle Lesniak, Les Echos «Dicker sigue tejiendo misterios intensos, impulsados por un sentido de la acción trepidante». Élise Lépine, Le Point «Si la expresión page turner no se inventó para él, hay que reconocer que Dicker supo apropiársela como ningún otro novelista. [...] Una narrativa terriblemente eficaz». Télérama', 'http://books.google.com/books/content?id=QvWn0AEACAAJ&printsec=frontcover&img=1&zoom=1&imgtk=AFLRE70P1AEeYGqrzIJMBSJQqA6_NnukObAYWxsgGzK5kQBHUusCkSbxV6ASEAwfDYfj3VChm84_84YQ15rFep2uuBSLEPlwBZnJlCLFMeagEwHgR5EMGFMo0KSAKPSD1AxSHhfnzB50&source=gbs_api', 'QvWn0AEACAAJ', '2024-06-10 10:27:19', 25, 0.00),
(158, 'La novia gitana (La novia gitana 1)', 'Carmen Mola', '<p> <b>EXTREMA</b> </p> <p> <p> <b>MÁS DE UN MILLÓN DE LECTORES Y EL ELOGIO UNÁNIME DE LA CRÍTICA</b> </p> <p> <p>«Una novela que me encantó cuando la leí, policial y oscura, con una historia muy potente que ha enganchado a miles de lectores -y espero que ahora a miles de espectadores. [...] Elena Blanco es de los mejores personajes femeninos protagonistas que he visto en mucho tiempo y el Madrid que se muestra, callejero y violento, da mucha fuerza.» <br> <b>Paco Cabezas, director de la serie <i>La novia gitana</i>, de próxima publicación de A3MediaPlayer</b> </p> <p>«En Madrid se mata poco», le decía al joven subinspector Ángel Zárate su mentor en la policía; «pero cuando se mata, no tiene nada que envidiarle a ninguna ciudad del mundo», podría añadir la inspectora Elena Blanco, jefa de la Brigada de Análisis de Casos, un departamento creado para resolver los crímenes más complicados y abyectos.</p> <p>Susana Macaya, de padre gitano pero educada como paya, desaparece tras su fiesta de despedida de soltera. El cadáver es encontrado dos días después en la Quinta de Vista Alegre del madrileño barrio de Carabanchel. Podría tratarse de un asesinato más, si no fuera por el hecho de que la víctima ha sido torturada siguiendo un ritual insólito y atroz, y de que su hermana Lara sufrió idéntica suerte siete años atrás, también en vísperas de su boda. El asesino de Lara cumple condena desde entonces, por lo que solo caben dos posibilidades: o alguien ha imitado sus métodos para matar a la hermana pequeña, o hay un inocente encarcelado.</p> <p>Por eso el comisario Rentero ha decidido apartar a Zárate del caso y encargárselo a la veterana Blanco, una mujer peculiar y solitaria, amante de la <i> grappa</i>, el karaoke, los coches de coleccionista y las relaciones sexuales en todoterrenos. Una policía vulnerable, que se mantiene en el cuerpo para no olvidar que en su vida existe un caso pendiente, que no ha podido cerrar.</p> <p>Investigar a una persona implica conocerla, descubrir sus secretos y contradicciones, su historia. En el caso de Lara y Susana, Elena Blanco debe asomarse a la vida de unos gitanos que han renunciado a sus costumbres para integrarse en la sociedad y a la de otros que no se lo perdonan, y levantar cada velo para descubrir quién pudo vengarse con tanta saña de ambas novias gitanas.</p> <p> <b>Reseñas:</b> <br> «El seudónimo es una máscara como cualquier otra y quien se resguarda tras él tiene sus motivos. [...] Hombre o mujer, igual da. La competencia de sus novelas está probada. Y el impacto de no tener rostro, también.» <br> Antonio Lucas, <i>El Mundo</i> </p> <p>«La novela negra o muta o se ensimisma. Carmen Mola, la escritora mutante. Lo peor de ella, que no la puedes invitar a un Festival.» <br> Carlos Zanón</p> <p>«¿Quién es Carmen Mola? ¿Acaso importa? Sus novelas atrapan con una originalidad que nos somete y nos hace desear más, mucho más, cuando, horrorizados, nos damos cuenta de que estamos ya en la última página.» <br> Jordi Llobregat, Director de <i>Valencia Negra</i> </p> <p>«Desde la primera página, Carmen Mola, quienquiera que sea, demuestra tener una voz propia, y eso, en el género negro y fuera de él, ya es mucho, quizá la mitad de todo. O más.» <br> Lorenzo Silva</p> <p>«¿La Elena Ferrante española? [...]. Una estructura sólida y un argumento llevado como un clásico policial pero que al tiempo rompe varios convencionalismos.» <br> Juan Carlos Galindo, <i> El País</i> </p>', 'http://books.google.com/books/publisher/content?id=xcRODwAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71VKm7Rg5U86X9SS2N41Z_NEIvxVqIjpNtQ1CLkjOgd-ZqRolUEASl0CvZ5nHc_vYGiQpJ9U-rtUEG48OJY735uAUFKlXMofQSkzw-lOj-6RcAeivQTyz3BIOFuduIOgEGiO1Z9&s', 'xcRODwAAQBAJ', '2024-06-10 10:31:34', 25, 0.00),
(163, 'La novia gitana (La novia gitana 1)', 'Carmen Mola', '<p> <b>EXTREMA</b> </p> <p> <p> <b>MÁS DE UN MILLÓN DE LECTORES Y EL ELOGIO UNÁNIME DE LA CRÍTICA</b> </p> <p> <p>«Una novela que me encantó cuando la leí, policial y oscura, con una historia muy potente que ha enganchado a miles de lectores -y espero que ahora a miles de espectadores. [...] Elena Blanco es de los mejores personajes femeninos protagonistas que he visto en mucho tiempo y el Madrid que se muestra, callejero y violento, da mucha fuerza.» <br> <b>Paco Cabezas, director de la serie <i>La novia gitana</i>, de próxima publicación de A3MediaPlayer</b> </p> <p>«En Madrid se mata poco», le decía al joven subinspector Ángel Zárate su mentor en la policía; «pero cuando se mata, no tiene nada que envidiarle a ninguna ciudad del mundo», podría añadir la inspectora Elena Blanco, jefa de la Brigada de Análisis de Casos, un departamento creado para resolver los crímenes más complicados y abyectos.</p> <p>Susana Macaya, de padre gitano pero educada como paya, desaparece tras su fiesta de despedida de soltera. El cadáver es encontrado dos días después en la Quinta de Vista Alegre del madrileño barrio de Carabanchel. Podría tratarse de un asesinato más, si no fuera por el hecho de que la víctima ha sido torturada siguiendo un ritual insólito y atroz, y de que su hermana Lara sufrió idéntica suerte siete años atrás, también en vísperas de su boda. El asesino de Lara cumple condena desde entonces, por lo que solo caben dos posibilidades: o alguien ha imitado sus métodos para matar a la hermana pequeña, o hay un inocente encarcelado.</p> <p>Por eso el comisario Rentero ha decidido apartar a Zárate del caso y encargárselo a la veterana Blanco, una mujer peculiar y solitaria, amante de la <i> grappa</i>, el karaoke, los coches de coleccionista y las relaciones sexuales en todoterrenos. Una policía vulnerable, que se mantiene en el cuerpo para no olvidar que en su vida existe un caso pendiente, que no ha podido cerrar.</p> <p>Investigar a una persona implica conocerla, descubrir sus secretos y contradicciones, su historia. En el caso de Lara y Susana, Elena Blanco debe asomarse a la vida de unos gitanos que han renunciado a sus costumbres para integrarse en la sociedad y a la de otros que no se lo perdonan, y levantar cada velo para descubrir quién pudo vengarse con tanta saña de ambas novias gitanas.</p> <p> <b>Reseñas:</b> <br> «El seudónimo es una máscara como cualquier otra y quien se resguarda tras él tiene sus motivos. [...] Hombre o mujer, igual da. La competencia de sus novelas está probada. Y el impacto de no tener rostro, también.» <br> Antonio Lucas, <i>El Mundo</i> </p> <p>«La novela negra o muta o se ensimisma. Carmen Mola, la escritora mutante. Lo peor de ella, que no la puedes invitar a un Festival.» <br> Carlos Zanón</p> <p>«¿Quién es Carmen Mola? ¿Acaso importa? Sus novelas atrapan con una originalidad que nos somete y nos hace desear más, mucho más, cuando, horrorizados, nos damos cuenta de que estamos ya en la última página.» <br> Jordi Llobregat, Director de <i>Valencia Negra</i> </p> <p>«Desde la primera página, Carmen Mola, quienquiera que sea, demuestra tener una voz propia, y eso, en el género negro y fuera de él, ya es mucho, quizá la mitad de todo. O más.» <br> Lorenzo Silva</p> <p>«¿La Elena Ferrante española? [...]. Una estructura sólida y un argumento llevado como un clásico policial pero que al tiempo rompe varios convencionalismos.» <br> Juan Carlos Galindo, <i> El País</i> </p>', 'http://books.google.com/books/publisher/content?id=xcRODwAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE72Ns9cp5RD587cSHBRnWFh8EASvoLv81A1ZHuV3SNREPdIZQahihL1XmafhZEBcWFTxv56FHaJnZ020MWgZEK5ST10uv0ZeeuWgRQo1BuivFSYgT5L2FhlIFFUvi8nkBBGOq_yh&s', 'xcRODwAAQBAJ', '2024-06-10 13:28:39', 26, 0.00),
(164, 'Choque de reyes (Canción de hielo y fuego 2)', 'George R.R. Martin', '<p> <b>Los cinco títulos hasta ahora publicados de</b> <b>«Canción de hielo y fuego»,</b> <i> <b>Juego de tronos</b> </i> <b>,</b> <i> <b>Choque de reyes</b> </i> <b>,</b> <i> <b>Tormenta de espadas</b> </i> <b>,</b> <i> <b>Festín de cuervos</b> </i> <b> y</b> <i> <b>Danza de dragones</b> </i> <b>, llegan a las librerías en una nueva edición que conquistará tanto a los</b> <b>fans de esta saga épica como a aquellos que esperan la oportunidad perfecta para adentrarse en sus páginas por primera vez.</b> </p> <p> <b>«Larga vida a George Martin...</b> <b>Sacerdote literario, sabedor de sudon para el personaje complejo, el lenguaje vívido y la visión salvaje de los mejores narradores.»</b> <br> <i> <b>The New York Times</b> </i> </p> <p>«Llegará un día en el que te sientas segura y feliz, y de repente tu alegría se te convertirá en cenizas en la boca, y ese día sabrás que la deuda ha quedado saldada.»</p> <p>En el cielo sobre los Siete Reinos, que se hallan asolados por una guerra devastadora, aparece un siniestro cometa color sangre. ¿Acaso se trata de otro augurio terrible sobre las catástrofes que están por llegar?</p> <p>El verano ha terminado, y cuatro líderes se disputan el Trono de Hierro. Mientras tanto, al otro lado del mar, la orgullosa princesa exiliada Daenerys Targaryen está dispuesta a arriesgarlo todo con tal de recuperar la corona que le pertenece por derecho. Puede que, para ella, el cometa de sangre no sea un mal presagio, sino el heraldo de la venganza.</p> <p>Y mientras la batalla continúa, al norte, más allá del Muro, las fuerzas oscuras se vuelven cada vez más poderosas.</p> <p> <b>La crítica ha dicho:</b> <br> «Larga vida a George Martin... Sacerdote literario, sabedor de su don para el personaje complejo, el lenguaje vívido y la visión salvaje de los mejores narradores.» <br> <i>The New York Times</i> </p> <p>«La capacidad de Martin para crear historias apasionantes de intriga es indiscutible.» <br> <i>El Mundo</i> </p> <p>«Entre aquellos que se afanan en la gran tradición épica de la fantasía, Martin es, con diferencia, el mejor.» <br> <i>TIME Magazine</i> </p> <p>«El sobrecogedor alcance de esta epopeya ha hecho que otros escritores de fantasía se lleven las manos a la cabeza.» <br> <i>The Guardian</i> </p> <p>«El escritor de la famosa saga hace tiempo que ha resuelto su porvenir y ha construido su indiscutible trono: el del nuevo rey de la literatura fantástica.» <br> <i>Vanitatis</i> </p>', 'http://books.google.com/books/publisher/content?id=Oji9EAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE728OWd5K6Tc8xdAgVYtGJJU_fdSM8lb_erbhen-5M7DQonO4g_xF7goLIUmPLm82kuGM7_7BEgsWiei7uRk3jpIxqEVISmOseruYiVBS86xlRjjDMXIUIgn5FoBIpobieiLuKJh&s', 'Oji9EAAAQBAJ', '2024-06-10 15:56:00', 25, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros_listas`
--

CREATE TABLE `libros_listas` (
  `id` int(11) NOT NULL,
  `id_lista` int(11) DEFAULT NULL,
  `id_libro` int(11) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros_listas`
--

INSERT INTO `libros_listas` (`id`, `id_lista`, `id_libro`, `id_usuario`) VALUES
(123, 94, 123, 26),
(124, 94, 124, 26),
(146, 90, 146, 25),
(148, 94, 148, 26),
(149, 94, 149, 26),
(153, 90, 153, 25),
(156, 91, 156, 25),
(157, 102, 157, 25),
(158, 91, 158, 25),
(163, 93, 163, 26),
(164, 90, 164, 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listas`
--

CREATE TABLE `listas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `listas`
--

INSERT INTO `listas` (`id`, `nombre`, `id_usuario`) VALUES
(2, 'Libros que me gustaría leer', 0),
(48, 'Por leer', 9),
(76, 'Fantasia', 9),
(77, 'Novela', 9),
(78, 'No ficción', 5),
(80, 'Mis libros favoritos', 5),
(84, 'Terror', 9),
(85, 'Libros por leer', 5),
(86, 'Mejores 2023', 5),
(90, 'Libros pendientes', 25),
(91, 'Libros muy interesantes', 25),
(92, 'Mis libros favoritos', 25),
(93, 'Libros pendientes', 26),
(94, 'Libros leídos', 26),
(95, 'Mis libros favoritos', 26),
(102, 'Pa verano', 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `clave`, `email`, `fecha`, `foto`) VALUES
(5, 'Sari', '123', 'usuario@gmail.com', '2024-03-22 17:36:43', 'uploads/5.jpg'),
(9, 'Sara Reyes', '', 'sarita@gmail.com', '2024-05-10 11:15:50', NULL),
(25, 'Jesus', '$2y$10$uVo9DRHT9VDDnr09WjQB8uIxmgqywL.OYzUhW8BXMKe6RzRol7HTW', 'jesus@gmail.com', '2024-06-02 15:33:58', 'uploads/25.jpg'),
(26, 'María', '$2y$10$CgWDNX6/JfJAofXsU3jcwu3xTtInrTYXWKsmLM2FNu86ph6D9zadu', 'maria@gmail.com', '2024-06-03 14:31:35', 'uploads/26.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoraciones`
--

CREATE TABLE `valoraciones` (
  `id` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `valoracion` tinyint(4) NOT NULL CHECK (`valoracion` between 1 and 5),
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `valoraciones`
--

INSERT INTO `valoraciones` (`id`, `id_libro`, `id_usuario`, `valoracion`, `fecha`) VALUES
(65, 123, 26, 2, '2024-06-03 14:33:27'),
(66, 124, 26, 4, '2024-06-03 14:37:22'),
(67, 124, 26, 4, '2024-06-03 14:37:22'),
(94, 146, 25, 2, '2024-06-09 20:57:52');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_libro` (`id_libro`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_libros_usuario` (`id_usuario`);

--
-- Indices de la tabla `libros_listas`
--
ALTER TABLE `libros_listas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lista` (`id_lista`),
  ADD KEY `id_libro` (`id_libro`),
  ADD KEY `libros_listas_ibfk_3` (`id_usuario`);

--
-- Indices de la tabla `listas`
--
ALTER TABLE `listas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_libro` (`id_libro`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT de la tabla `libros_listas`
--
ALTER TABLE `libros_listas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT de la tabla `listas`
--
ALTER TABLE `listas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `fk_libros_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `libros_listas`
--
ALTER TABLE `libros_listas`
  ADD CONSTRAINT `libros_listas_ibfk_1` FOREIGN KEY (`id_lista`) REFERENCES `listas` (`id`),
  ADD CONSTRAINT `libros_listas_ibfk_2` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id`),
  ADD CONSTRAINT `libros_listas_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `listas`
--
ALTER TABLE `listas`
  ADD CONSTRAINT `listas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD CONSTRAINT `valoraciones_ibfk_1` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id`),
  ADD CONSTRAINT `valoraciones_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
