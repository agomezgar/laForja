<?php
   include("conectarse.php");
   include ("../config.php");
header("Content-type: text/html; charset=utf-8");
   $link=Conectarse();
mysqli_set_charset('utf8');

$crealumnos="CREATE TABLE IF NOT EXISTS alumnos(
`alumno` varchar( 6 ) NOT NULL ,
`apellidos` text NOT NULL ,
`nombre` text NOT NULL ,
`sexo` text NOT NULL ,
`dni` varchar( 8 ) NOT NULL ,
`nie` varchar( 8 ) NOT NULL ,
`fecha` text NOT NULL ,
`locnac` text NOT NULL ,
`provnac` text NOT NULL ,
`correspondencia` text NOT NULL ,

`dom` text NOT NULL ,
`loc` text NOT NULL ,
`prov` text NOT NULL ,
`tf` text NOT NULL ,
`cp` varchar( 6 ) NOT NULL ,
`padre` text NOT NULL ,
`dnipadre` text NOT NULL ,
`madre` text NOT NULL ,
`dnimadre` text NOT NULL ,
`pais` text NOT NULL ,
`nacion` text NOT NULL ,
`a` varchar( 20 ) NOT NULL ,
`b` varchar( 20 ) NOT NULL ,
`c` varchar( 20 ) NOT NULL ,
`d` varchar( 20 ) NOT NULL ,
`e` varchar( 20 ) NOT NULL ,
`f` varchar( 20 ) NOT NULL ,
`g` varchar( 20 ) NOT NULL ,
`h` varchar( 20 ) NOT NULL ,
PRIMARY KEY ( `alumno` )
) ";
echo "Creando la tabla alumnos";
mysqli_query($link,$crealumnos) or die ("nO HE PODIDO CREAR LA TABLA DE ALUMNOS
");

$creamatriculas="CREATE TABLE `matriculas` (
  `alumno` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` text COLLATE utf8_unicode_ci NOT NULL,
  `nombre` text COLLATE utf8_unicode_ci NOT NULL,
  `matricula` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `etapa` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `anno` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `estudios` text COLLATE utf8_unicode_ci NOT NULL,
  `grupo` text COLLATE utf8_unicode_ci NOT NULL,
  `repetidor` text COLLATE utf8_unicode_ci NOT NULL,
  `fechamatricula` text COLLATE utf8_unicode_ci NOT NULL,
  `centro` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `procedencia` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `estadomatricula` text COLLATE utf8_unicode_ci NOT NULL,
  `fecharesolucionmatricula` text COLLATE utf8_unicode_ci NOT NULL,
  `numexpcentro` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
PRIMARY KEY (`alumno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
 ";
mysqli_query($link,$creamatriculas) or die ("NO HE PODIDO CREAR LA TABLA DE MATRICULAS...
".mysqli_error($link));


$grupos="gruposinf";
$creargrupos="CREATE TABLE IF NOT EXISTS $grupos(
id int(2)unsigned NOT NULL auto_increment,
`nombre` text NOT NULL ,
PRIMARY KEY ( `id` )
)";
mysqli_query($link,$creargrupos);
mysqli_free_result;
$claves="claves";
$crearclaves="
CREATE TABLE IF NOT EXISTS `claves` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` text NOT NULL,
  `contra` text NOT NULL,
 `perfil` text NOT NULL,
  PRIMARY KEY (`id`)
)"  ;

mysqli_query($link,$crearclaves) or die("NO HE PODIDO CREAR LA TABLA DE CLAVES");
$usuario2=$usuario;
$contra2=md5($contra);
mysqli_query($link,"insert into claves (nombre,contra,perfil) values ('$usuario2','$contra2','jefe')")or die("No he podido introducir nombre y clave de administrador");
mysqli_free_result;
$crearprofesorespormateria="
CREATE TABLE IF NOT EXISTS `profesorespormateria` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` text NOT NULL,
  `materia` text NOT NULL,

  PRIMARY KEY (`id`)
)"  ;
mysqli_query($link,$crearprofesorespormateria) or die ("No he podido crear la tabla de relación profesor-materia");
$creaCompetencias="
CREATE TABLE `competencias` (
  `id` int(2) NOT NULL,
  `competencia` text COLLATE utf8_spanish_ci NOT NULL,
  `codigo` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
";
mysqli_query($link,$creaCompetencias) or die ("No he podido crear la tabla de competencias");
$rellenaCompetencias="
INSERT INTO `competencias` (`id`, `competencia`, `codigo`) VALUES
(1, 'Competencia Matemática', 'CM'),
(2, 'Competencia Lingüística', 'CL'),
(3, 'Competencia Digital', 'CD'),
(4, 'Sentido de la Iniciativa y Espíritu Emprendedor', 'SI'),
(5, 'Conciencia y Expresiones Culturales', 'CEC'),
(6, 'Competencias Sociales y Cívicas', 'CSC'),
(7, 'Aprender a Aprender', 'AA');
";
mysqli_query($link,utf8_decode($rellenaCompetencias)) or die ("No he podido rellenar la tabla de competencias");

$creaPrioridades="
CREATE TABLE `prioridades` (
  `prioridad` int(1) NOT NULL,
  `peso` int(3) NOT NULL,
PRIMARY KEY (`prioridad`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
";
$rellenaPrioridades="
INSERT INTO `prioridades` (`prioridad`, `peso`) VALUES
(1, 65),
(2, 25),
(3, 10);
";

mysqli_query($link,$creaPrioridades)or die ("un momento.".mysqli_error($link));
mysqli_query($link,$rellenaPrioridades)or die ("Error rellenando tabla de prioridades: ".$mysqli_error($link));
$crearestandaresTecnologia="
CREATE TABLE `estandarestecnologia` (
  `id` int(5) NOT NULL,
  `curso` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `bloque` text COLLATE utf8_unicode_ci NOT NULL,
  `criterio` text COLLATE utf8_unicode_ci NOT NULL,
  `estandar` text COLLATE utf8_unicode_ci NOT NULL,
  `prioridad` varchar(5) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
";
mysqli_query($link,$crearestandaresTecnologia)or die ("un momento.".mysqli_error($link));
$rellenaestandaresTecnologia="
INSERT INTO `estandarestecnologia` (`id`, `curso`, `bloque`, `criterio`, `estandar`, `prioridad`) VALUES
(0, 'curso', 'bloque', 'criterio', 'estandar', 'prior'),
(2111, '2', '1.Proceso de resolución de problemas tecnológicos', '1.Identificar las etapas necesarias par la creación de un producto tecnológico desde su origen hasta su comercialización describiendo cada una de ellas, investigando su influencia en la sociedad y proponiendo mejoras tanto desde el punto de vista de su utilidad como de su posible impacto social.', '1.1.Describe las etapas del proceso de resolución técnica de problemas para dar solución a un problema técnico.', ''),
(2112, '2', '1.Proceso de resolución de problemas tecnológicos', '1.Identificar las etapas necesarias par la creación de un producto tecnológico desde su origen hasta su comercialización describiendo cada una de ellas, investigando su influencia en la sociedad y proponiendo mejoras tanto desde el punto de vista de su utilidad como de su posible impacto social.', '1.2.Busca información en internet y otros medios, de forma crítica y selectiva, para encontrar soluciones a problemas técnicos sencillos.', ''),
(2113, '2', '1.Proceso de resolución de problemas tecnológicos', '1.Identificar las etapas necesarias par la creación de un producto tecnológico desde su origen hasta su comercialización describiendo cada una de ellas, investigando su influencia en la sociedad y proponiendo mejoras tanto desde el punto de vista de su utilidad como de su posible impacto social.', '1.3. Diseña un prototipo que dé solución a un problema técnico, mediante el proceso de resolución de problemas tecnológicos.', ''),
(2114, '2', '1.Proceso de resolución de problemas tecnológicos', '1.Identificar las etapas necesarias par la creación de un producto tecnológico desde su origen hasta su comercialización describiendo cada una de ellas, investigando su influencia en la sociedad y proponiendo mejoras tanto desde el punto de vista de su utilidad como de su posible impacto social.', '1.4. Valora la influencia en la sociedad de la actividad tecnológica describiendo el impacto social de ésta.', ''),
(2121, '2', '1.Proceso de resolución de problemas tecnológicos', '2. Realizar las operaciones técnicas previstas en un plan de trabajo utilizando los recursos materiales y organizativos con criterios de economía, seguridad y respeto al medio ambiente y valorando las condiciones del entorno de trabajo.', '2.1. Elabora un plan de trabajo secuenciado en el taller con especial atención a las normas de seguridad y salud.', ''),
(2122, '2', '1.Proceso de resolución de problemas tecnológicos', '2. Realizar las operaciones técnicas previstas en un plan de trabajo utilizando los recursos materiales y organizativos con criterios de economía, seguridad y respeto al medio ambiente y valorando las condiciones del entorno de trabajo.', '2.2. Realiza las operaciones técnicas previstas en un plan de trabajo, respetando las normas de seguridad y salud en el trabajo y aplicando criterios de economía.', ''),
(2123, '2', '1.Proceso de resolución de problemas tecnológicos', '2. Realizar las operaciones técnicas previstas en un plan de trabajo utilizando los recursos materiales y organizativos con criterios de economía, seguridad y respeto al medio ambiente y valorando las condiciones del entorno de trabajo.', '2.3. Reconoce las consecuencias medioambientales de la actividad tecnológica y actúa responsablemente para reducir su impacto.', ''),
(2124, '2', '1.Proceso de resolución de problemas tecnológicos', '2. Realizar las operaciones técnicas previstas en un plan de trabajo utilizando los recursos materiales y organizativos con criterios de economía, seguridad y respeto al medio ambiente y valorando las condiciones del entorno de trabajo.', '2.4. Colabora y participa activamente en el trabajo en grupo para la resolución de problemas tecnológicos, respetando las ideas y opiniones de los demás miembros.', ''),
(2211, '2', '2. Expresión y comunicación técnica', '1. Interpretar croquis y bocetos como elementos de información de productos tecnológicos.', '1.1. Dibuja bocetos y croquis de objetos y sistemas técnicos con limpieza y orden, siguiendo la normalización básica en dibujo técnico.', ''),
(2212, '2', '2. Expresión y comunicación técnica', '1. Interpretar croquis y bocetos como elementos de información de productos tecnológicos.', '1.2. Utiliza croquis y bocetos como elementos de información de productos tecnológicos.', ''),
(2221, '2', '2. Expresión y comunicación técnica', '2. Representar objetos mediante vistas y perspectivas aplicando criterios de normalización y escalas.', '2.1. Representa vistas de objetos (planta, alzada y perfil) empleando criterios normalizados con claridad y limpieza.', ''),
(2222, '2', '2. Expresión y comunicación técnica', '2. Representar objetos mediante vistas y perspectivas aplicando criterios de normalización y escalas.', '2.2. Dibuja a mano alzada y de forma proporcionada objetos y sistemas técnicos en perspectiva.', ''),
(2223, '2', '2. Expresión y comunicación técnica', '2. Representar objetos mediante vistas y perspectivas aplicando criterios de normalización y escalas.', '2.3. Utiliza medios informáticos para la representación de objetos y sistemas técnicos.', ''),
(2231, '2', '2. Expresión y comunicación técnica', '3. Explicar mediante documentación técnica las distintas fases de un producto desde su diseño hasta su comercialización.', '3.1. Integra los documentos necesarios en la memoria técnica de un proyecto empleando cuando sea necesario software específico de apoyo.', ''),
(2232, '2', '2. Expresión y comunicación técnica', '3. Explicar mediante documentación técnica las distintas fases de un producto desde su diseño hasta su comercialización.', '3.2. Expone, con apoyo de material escrito y gráfico, el proceso de resolución técnica de problemas relacionado con la construcción de un proyecto técnico concreto.', ''),
(2233, '2', '2. Expresión y comunicación técnica', '3. Explicar mediante documentación técnica las distintas fases de un producto desde su diseño hasta su comercialización.', '3.3. Presenta documentación técnica con claridad, orden y limpieza.', ''),
(2311, '2', '3. Materiales de uso técnico', '1. Analizar las propiedades de los materiales utilizados en la construcción de objetos tecnológicos reconociendo su estructura interna y relacionándola con las propiedades que presentan y las modificaciones que se puedan producir.', '1.1. Identifica las propiedades de la madera y sus derivados y los metales (mecánicas, térmicas, eléctricas,...).', ''),
(2312, '2', '3. Materiales de uso técnico', '1. Analizar las propiedades de los materiales utilizados en la construcción de objetos tecnológicos reconociendo su estructura interna y relacionándola con las propiedades que presentan y las modificaciones que se puedan producir.', '1.2. Reconoce los materiales de los que están hechos objetos de uso habitual, relacionando sus aplicaciones con sus propiedades.', ''),
(2313, '2', '3. Materiales de uso técnico', '1. Analizar las propiedades de los materiales utilizados en la construcción de objetos tecnológicos reconociendo su estructura interna y relacionándola con las propiedades que presentan y las modificaciones que se puedan producir.', '1.3. Valora el impacto ambiental de la extracción, uso y deshecho de la madera y sus derivados y los metales y propone medidas de consumo responsable de estos materiales técnicos.', ''),
(2321, '2', '3. Materiales de uso técnico', '2. Manipular y mecanizar materiales convencionales asociando la documentación técnica al proceso de producción de un objeto, respetando sus características y empleando técnicas y herramientas adecuadas con especial atención a las normas de seguridad y salud.', '2.1. Manipula, respetando las normas de seguridad y salud en el trabajo, las herramientas del taller en operaciones básicas de mecanizado, unión y acabado de la madera y los metales.', ''),
(2322, '2', '3. Materiales de uso técnico', '2. Manipular y mecanizar materiales convencionales asociando la documentación técnica al proceso de producción de un objeto, respetando sus características y empleando técnicas y herramientas adecuadas con especial atención a las normas de seguridad y salud.', '2.2. Construye prototipos que den solución a un problema técnico siguiendo el plan de trabajo previsto.', ''),
(2411, '2', '4. Estructuras y mecanismos: máquinas y sistemas.', '1. Analizar y describir los esfuerzos a los que están sometidas las estructuras experimentando en prototipos.', '1.1. Describe, utilizando un vocabulario apropiado, apoyándose en información escrita, audiovisual o digital, las características propias que configuran las tipologías de las estructuras y sus elementos.', ''),
(2412, '2', '4. Estructuras y mecanismos: máquinas y sistemas.', '1. Analizar y describir los esfuerzos a los que están sometidas las estructuras experimentando en prototipos.', '1.2. Identifica los esfuerzos característicos y la transmisión de los mismos en los elementos que configuran la estructura, realizando prácticas sencillas con prototipos.', ''),
(2421, '2', '4. Estructuras y mecanismos: máquinas y sistemas.', '2. Identificar y analizar los mecanismos y elementos responsables de transformar y transmitir movimientos, en máquinas y sistemas, integrados en una estructura.', '2.1. Explica la función de los elementos que configuran una máquina o sistema, desde el punto de vista estructural y mecánico.', ''),
(2422, '2', '4. Estructuras y mecanismos: máquinas y sistemas.', '2. Identificar y analizar los mecanismos y elementos responsables de transformar y transmitir movimientos, en máquinas y sistemas, integrados en una estructura.', '2.2. Describe el funcionamiento general de una máquina sencilla explicando cómo se transforma o transmite el movimiento y la fuerza.', ''),
(2423, '2', '4. Estructuras y mecanismos: máquinas y sistemas.', '2. Identificar y analizar los mecanismos y elementos responsables de transformar y transmitir movimientos, en máquinas y sistemas, integrados en una estructura.', '2.3. Diseña y construye proyectos tecnológicos sencillos que permitan la transmisión y transformación de movimiento.', ''),
(2431, '2', '4. Estructuras y mecanismos: máquinas y sistemas.', '3. Relacionar los efectos de la energía eléctrica y su capacidad de conversión en otras manifestaciones energéticas.', '3.1. Explica los principales efectos de la corriente eléctrica y su conversión aplicándolos a situaciones cotidianas.', ''),
(2441, '2', '4. Estructuras y mecanismos: máquinas y sistemas.', '4. Diseñar y simular circuitos con simbología adecuada y montar circuitos con elementos eléctricos.', '4.1. Diseña utilizando software específico y la simbología adecuada circuitos eléctricos básicos y simula su funcionamiento.', ''),
(2442, '2', '4. Estructuras y mecanismos: máquinas y sistemas.', '4. Diseñar y simular circuitos con simbología adecuada y montar circuitos con elementos eléctricos.', '4.2. Analiza el funcionamiento de circuitos eléctricos básicos, identificando sus componentes y describiendo su función en el conjunto.', ''),
(2443, '2', '4. Estructuras y mecanismos: máquinas y sistemas.', '4. Diseñar y simular circuitos con simbología adecuada y montar circuitos con elementos eléctricos.', '4.3. Realiza el montaje de circuitos con componentes eléctricos básicos.', ''),
(2444, '2', '4. Estructuras y mecanismos: máquinas y sistemas.', '4. Diseñar y simular circuitos con simbología adecuada y montar circuitos con elementos eléctricos.', '4.4. Utiliza dispositivos eléctricos básicos en la construcción de prototipos.', ''),
(2511, '2', '5. Tecnologías de la Información y la Comunicación.', '1. Describir las partes operativas de un equipo informático y su función.', '1.1. Identifica las partes de un ordenador y su función en el conjunto.', ''),
(2512, '2', '5. Tecnologías de la Información y la Comunicación.', '1. Describir las partes operativas de un equipo informático y su función.', '1.2. Utiliza adecuadamente equipos informáticos y dispositivos electrónicos de forma autónoma y responsable.', ''),
(2513, '2', '5. Tecnologías de la Información y la Comunicación.', '1. Describir las partes operativas de un equipo informático y su función.', '1.3. Conoce los elementos básicos del sistema operativo y los utiliza correctamente.', ''),
(2514, '2', '5. Tecnologías de la Información y la Comunicación.', '1. Describir las partes operativas de un equipo informático y su función.', '1.4. Realiza operaciones básicas de organización y almacenamiento de la información.', ''),
(2515, '2', '5. Tecnologías de la Información y la Comunicación.', '1. Describir las partes operativas de un equipo informático y su función.', '1.5. Instala y maneja programas y software básicos.', ''),
(2521, '2', '5. Tecnologías de la Información y la Comunicación.', '2. Utilizar de forma segura sistemas de intercambio de información.', '2.1. Utiliza espacios web, plataformas y otros sistemas de intercambio de información de forma responsable y crítica.', ''),
(2522, '2', '5. Tecnologías de la Información y la Comunicación.', '2. Utilizar de forma segura sistemas de intercambio de información.', '2.2. Conoce las medidas de seguridad aplicables a una situación de riesgo y emplea hábitos de protección adecuados.', ''),
(2531, '2', '5. Tecnologías de la Información y la Comunicación.', '3. Utilizar un equipo informático para elaborar y comunicar proyectos técnicos.', '3.1. Elabora documentos de texto con aplicaciones informáticas, de forma individual y colaborativa, que integren tablas, imágenes y gráficos, así como otras posibilidades de diseño.', ''),
(2532, '2', '5. Tecnologías de la Información y la Comunicación.', '3. Utilizar un equipo informático para elaborar y comunicar proyectos técnicos.', '3.2. Utiliza funciones básicas de las hojas de cálculo para elaborar el presupuesto en un proyecto tecnológico.', ''),
(2533, '2', '5. Tecnologías de la Información y la Comunicación.', '3. Utilizar un equipo informático para elaborar y comunicar proyectos técnicos.', '3.3. Crea presentaciones mediante aplicaciones informáticas.', ''),
(2541, '2', '5. Tecnologías de la Información y la Comunicación.', '4. Elaborar programas sencillos mediante entornos de aprendizaje de lenguaje de programación de entorno gráfico.', '4.1. Crea pequeños programas informáticos utilizando recursos propios fundamentales de lenguaje de programación de entorno gráfico.', ''),
(2542, '2', '5. Tecnologías de la Información y la Comunicación.', '4. Elaborar programas sencillos mediante entornos de aprendizaje de lenguaje de programación de entorno gráfico.', '4.2. Diseña y elabora la programación de un juego sencillo, animación o historia interactiva mediante un entorno de programación gráfico.', ''),
(3111, '3', '1.Proceso de resolución de problemas tecnológicos', '1.    Analizar las etapas necesarias para la creación de un producto tecnológico desde su origen hasta su comercialización, investigando su influencia en la sociedad y proponiendo mejoras tanto desde el punto de vista de su utilidad como de su posible impacto social. ', '1.1.    Realiza el análisis desde distintos puntos de vista objetos y sistemas técnicos y su influencia en la sociedad. ', ''),
(3112, '3', '1.Proceso de resolución de problemas tecnológicos', '1.    Analizar las etapas necesarias para la creación de un producto tecnológico desde su origen hasta su comercialización, investigando su influencia en la sociedad y proponiendo mejoras tanto desde el punto de vista de su utilidad como de su posible impacto social. ', '1.2.    Busca información en internet seleccionando las fuentes adecuadas de forma crítica y selectiva.', ''),
(3113, '3', '1.Proceso de resolución de problemas tecnológicos', '1.    Analizar las etapas necesarias para la creación de un producto tecnológico desde su origen hasta su comercialización, investigando su influencia en la sociedad y proponiendo mejoras tanto desde el punto de vista de su utilidad como de su posible impacto social. ', '1.3.    Valora de forma crítica el impacto social, económico y ambiental de la creación de nuevos objetos. ', ''),
(3121, '3', '1.Proceso de resolución de problemas tecnológicos', '2.    Describir las operaciones técnicas previstas en un plan de trabajo utilizando los recursos materiales y organizativos con criterios de economía, seguridad y respeto al medio ambiente y valorando las condiciones del entorno de trabajo.', '2.1.    Elabora una hoja de proceso especificando las condiciones técnicas para la construcción de un proyecto. ', ''),
(3122, '3', '1.Proceso de resolución de problemas tecnológicos', '2.    Describir las operaciones técnicas previstas en un plan de trabajo utilizando los recursos materiales y organizativos con criterios de economía, seguridad y respeto al medio ambiente y valorando las condiciones del entorno de trabajo.', '2.2.    Reconoce las consecuencias medioambientales de la actividad tecnológica y actúa responsablemente para reducir su impacto. ', ''),
(3123, '3', '1.Proceso de resolución de problemas tecnológicos', '2.    Describir las operaciones técnicas previstas en un plan de trabajo utilizando los recursos materiales y organizativos con criterios de economía, seguridad y respeto al medio ambiente y valorando las condiciones del entorno de trabajo.', '2.3.    Colabora y participa activamente, en el trabajo en grupo para la resolución de problemas tecnológicos, respetando las ideas y opiniones de los demás miembros. ', ''),
(3211, '3', '2. Expresión y comunicación técnica', '1.    Representar objetos mediante perspectivas aplicando criterios de normalización.', '1.1.    Dibuja objetos y sistemas técnicos en perspectiva caballera e isométrica empleando criterios normalizados de acotación con claridad y limpieza.', ''),
(3212, '3', '2. Expresión y comunicación técnica', '1.    Representar objetos mediante perspectivas aplicando criterios de normalización.', '1.2.    Usa aplicaciones informáticas de diseño gráfico en dos y tres dimensiones para la representación de objetos y sistemas técnicos.', ''),
(3221, '3', '2. Expresión y comunicación técnica', '2.    Explicar mediante documentación técnica las distintas fases de un producto desde su diseño hasta su comercialización.', '2.1.    Elabora la memoria técnica de un proyecto integrando los documentos necesarios y empleando software específico de apoyo.', ''),
(3222, '3', '2. Expresión y comunicación técnica', '2.    Explicar mediante documentación técnica las distintas fases de un producto desde su diseño hasta su comercialización.', '2.2.    Presenta documentación técnica con claridad, orden y limpieza.', ''),
(3311, '3', '3. Materiales de uso técnico', '1.    Analizar las propiedades de los materiales utilizados en la construcción de objetos tecnológicos reconociendo su estructura interna y relacionándola con las propiedades que presentan y las modificaciones que se puedan producir.', '1.1.    Reconoce los materiales de los que están hechos objetos de uso habitual, relacionando sus aplicaciones con sus propiedades. ', ''),
(3312, '3', '3. Materiales de uso técnico', '1.    Analizar las propiedades de los materiales utilizados en la construcción de objetos tecnológicos reconociendo su estructura interna y relacionándola con las propiedades que presentan y las modificaciones que se puedan producir.', '1.2.    Valora el impacto ambiental de la extracción, uso y deshecho de los plásticos y propone medidas de consumo responsable de productos y materiales técnicos. ', ''),
(3313, '3', '3. Materiales de uso técnico', '1.    Analizar las propiedades de los materiales utilizados en la construcción de objetos tecnológicos reconociendo su estructura interna y relacionándola con las propiedades que presentan y las modificaciones que se puedan producir.', '1.3.    Realiza una investigación sobre las propiedades y las aplicaciones de nuevos materiales exponiendo los resultados mediante soporte informático.', ''),
(3321, '3', '3. Materiales de uso técnico', '2.    Manipular y mecanizar materiales convencionales asociando la documentación técnica al proceso de producción de un objeto, respetando sus características y empleando técnicas y herramientas adecuadas con especial atención a las normas de seguridad y salud', '2.1.    Manipula las herramientas del taller en operaciones básicas de mecanizado, conformado, unión y acabado de los plásticos materiales de uso técnico. ', ''),
(3322, '3', '3. Materiales de uso técnico', '2.    Manipular y mecanizar materiales convencionales asociando la documentación técnica al proceso de producción de un objeto, respetando sus características y empleando técnicas y herramientas adecuadas con especial atención a las normas de seguridad y salud', '2.2.    Describe el proceso de fabricación de productos mediante impresión en 3D identificando sus fases.', ''),
(3323, '3', '3. Materiales de uso técnico', '2.    Manipular y mecanizar materiales convencionales asociando la documentación técnica al proceso de producción de un objeto, respetando sus características y empleando técnicas y herramientas adecuadas con especial atención a las normas de seguridad y salud', '2.3.    Construye prototipos que den solución a un problema técnico siguiendo el plan de trabajo previsto y respetando las normas de seguridad y salud en el trabajo', ''),
(3411, '3', '4. Estructuras y mecanismos: máquinas y sistemas.', '1.    Identificar y analizar los mecanismos y elementos responsables de transformar y transmitir movimientos, en máquinas y sistemas, integrados en una estructura.', '1.1.    Analiza la ventaja mecánica en distintos mecanismos, identificando los parámetros de entrada y salida y su relación de transmisión.', ''),
(3412, '3', '4. Estructuras y mecanismos: máquinas y sistemas.', '1.    Identificar y analizar los mecanismos y elementos responsables de transformar y transmitir movimientos, en máquinas y sistemas, integrados en una estructura.', '1.2.    Explica la función de los elementos que configuran una máquina o sistema desde el punto de vista estructural y mecánico, describiendo cómo se transforma o transmite el movimiento y el funcionamiento general de la máquina.', ''),
(3413, '3', '4. Estructuras y mecanismos: máquinas y sistemas.', '1.    Identificar y analizar los mecanismos y elementos responsables de transformar y transmitir movimientos, en máquinas y sistemas, integrados en una estructura.', '1.3.    Diseña y construye proyectos tecnológicos que permitan la transmisión y transformación de movimiento.', ''),
(3421, '3', '4. Estructuras y mecanismos: máquinas y sistemas.', '2.    Relacionar los efectos de la energía eléctrica y su capacidad de conversión en otras manifestaciones energéticas, analizando su consumo energético.', '2.1.    Calcula el consumo eléctrico de diversos aparatos valorando su eficiencia energética.', ''),
(3422, '3', '4. Estructuras y mecanismos: máquinas y sistemas.', '2.    Relacionar los efectos de la energía eléctrica y su capacidad de conversión en otras manifestaciones energéticas, analizando su consumo energético.', '2.2.    Propone medidas de ahorro energético en aparatos  eléctricos y electrónicos de uso cotidiano.', ''),
(3431, '3', '4. Estructuras y mecanismos: máquinas y sistemas.', '3.    Diseñar y simular circuitos con simbología adecuada y montar circuitos con elementos eléctricos y electrónicos.', '3.1.    Diseña utilizando software específico y simbología adecuada circuitos eléctricos y electrónicos y simula su funcionamiento.', ''),
(3432, '3', '4. Estructuras y mecanismos: máquinas y sistemas.', '3.    Diseñar y simular circuitos con simbología adecuada y montar circuitos con elementos eléctricos y electrónicos.', '3.2.    Mide utilizando los instrumentos de medida adecuados el valor de las magnitudes eléctricas básicas.', ''),
(3433, '3', '4. Estructuras y mecanismos: máquinas y sistemas.', '3.    Diseñar y simular circuitos con simbología adecuada y montar circuitos con elementos eléctricos y electrónicos.', '3.3.    Resuelve circuitos eléctricos y electrónicos aplicando la ley de Ohm para calcular las magnitudes eléctricas básicas.', ''),
(3434, '3', '4. Estructuras y mecanismos: máquinas y sistemas.', '3.    Diseñar y simular circuitos con simbología adecuada y montar circuitos con elementos eléctricos y electrónicos.', '3.4.    Realiza el montaje de circuitos eléctricos y electrónicos básicos.', ''),
(3441, '3', '4. Estructuras y mecanismos: máquinas y sistemas.', '4.    Diseñar y montar circuitos de control programado, que funcionen dentro de sistema técnico, utilizando el entorno de programación y una placa controladora de forma adecuada. ', '4.1.    Utiliza correctamente los elementos eléctricos y electrónicos como sensores y actuadores en circuitos de control programado describiendo su funcionamiento.', ''),
(3442, '3', '4. Estructuras y mecanismos: máquinas y sistemas.', '4.    Diseñar y montar circuitos de control programado, que funcionen dentro de sistema técnico, utilizando el entorno de programación y una placa controladora de forma adecuada. ', '4.2.    Diseña y monta circuitos de control automático que realicen las tareas propuestas para un prototipo de forma autónoma.', ''),
(3443, '3', '4. Estructuras y mecanismos: máquinas y sistemas.', '4.    Diseñar y montar circuitos de control programado, que funcionen dentro de sistema técnico, utilizando el entorno de programación y una placa controladora de forma adecuada. ', '4.3.    Elabora un programa informático que controle el funcionamiento de un sistema técnico.', ''),
(3511, '3', '5. Tecnologías de la Información y la Comunicación.', '1.    Utilizar de forma segura sistemas de intercambio de información.', '1.1.    Maneja espacios web, plataformas y otros sistemas de intercambio de información a través de internet de forma colaborativa de forma responsable y crítica. ', ''),
(3512, '3', '5. Tecnologías de la Información y la Comunicación.', '1.    Utilizar de forma segura sistemas de intercambio de información.', '1.2.    Conoce las medidas de seguridad aplicables a una situación de riesgo en la conexión a internet y emplea hábitos de protección adecuados.', ''),
(3521, '3', '5. Tecnologías de la Información y la Comunicación.', '2.    Utilizar un equipo informático para elaborar y comunicar proyectos técnicos.', '2.1.    Utiliza hojas de cálculo para elaborar la documentación técnica necesaria en un proyecto tecnológico, que incluyan resultados textuales, numéricos y gráficos.', ''),
(3522, '3', '5. Tecnologías de la Información y la Comunicación.', '2.    Utilizar un equipo informático para elaborar y comunicar proyectos técnicos.', '2.2.    Crea presentaciones mediante aplicaciones informáticas que integren elementos multimedia.', ''),
(3523, '3', '5. Tecnologías de la Información y la Comunicación.', '2.    Utilizar un equipo informático para elaborar y comunicar proyectos técnicos.', '2.3.    Edita archivos de imagen, audio y vídeo con aplicaciones de equipos informáticos y dispositivos móviles.', ''),
(5111, '5', '1.Recursos energéticos', '1. Analizar la importancia que los recursos energéticos tienen en la sociedad actual, describiendo las formas de producción de cada una de ellas, así como sus debilidades y fortalezas en el desarrollo de una sociedad sostenible.', '1.1 Resuelve problemas de conversión de energías y cálculo de trabajo, potencias y rendimientos empleando las unidades adecuadas.', ''),
(5112, '5', '1.Recursos energéticos', '1. Analizar la importancia que los recursos energéticos tienen en la sociedad actual, describiendo las formas de producción de cada una de ellas, así como sus debilidades y fortalezas en el desarrollo de una sociedad sostenible.', '1.2. Describe las diferentes fuentes de energía relacionándolas con el coste de producción, el impacto ambiental que produce y la sostenibilidad.', ''),
(5113, '5', '1.Recursos energéticos', '1. Analizar la importancia que los recursos energéticos tienen en la sociedad actual, describiendo las formas de producción de cada una de ellas, así como sus debilidades y fortalezas en el desarrollo de una sociedad sostenible.', '1.3. Dibuja diagramas de bloques de diferentes tipos de centrales de producción de energía explicando cada uno de sus bloques constitutivos y relacionándolos entre sí.', ''),
(5121, '5', '1.Recursos energéticos', '2. Realizar propuestas de reducción de consumo energético para viviendas o locales, con la ayuda de programas informáticos, y la información de consumo de los mismos.', '2.1. Explica las ventajas que supone desde el punto de vista del consumo que un edificio esté certificado energéticamente.', ''),
(5122, '5', '1.Recursos energéticos', '2. Realizar propuestas de reducción de consumo energético para viviendas o locales, con la ayuda de programas informáticos, y la información de consumo de los mismos.', '2.2. Analiza y calcula las facturas de los distintos consumos energéticos en una vivienda utilizando una hoja de cálculo.', ''),
(5123, '5', '1.Recursos energéticos', '2. Realizar propuestas de reducción de consumo energético para viviendas o locales, con la ayuda de programas informáticos, y la información de consumo de los mismos.', '2.3. Elabora planes de reducción de costes de consumo energético en viviendas, identificando aquellos puntos donde el consumo pueda ser reducido.', ''),
(5124, '5', '1.Recursos energéticos', '2. Realizar propuestas de reducción de consumo energético para viviendas o locales, con la ayuda de programas informáticos, y la información de consumo de los mismos.', '2.4. Investiga recursos en la red o programas informáticos que ayuden a reducir los costes de consumo energético en la vivienda.', ''),
(5211, '5', '2. Máquinas y sistemas', '1. Analizar los bloques constitutivos de sistemas y/o máquinas, interpretando su interrelación y describiendo los principales elementos que los componen, utilizando el vocabulario relacionado con el tema.', '1.1. Describe la función de los elementos que constituyen una máquina dada, explicando de forma clara y con el vocabulario técnico adecuado su contribución al conjunto.', ''),
(5212, '5', '2. Máquinas y sistemas', '1. Analizar los bloques constitutivos de sistemas y/o máquinas, interpretando su interrelación y describiendo los principales elementos que los componen, utilizando el vocabulario relacionado con el tema.', '1.2. Desmonta máquinas de uso común realizando un análisis mecánico de las mismas.', ''),
(5213, '5', '2. Máquinas y sistemas', '1. Analizar los bloques constitutivos de sistemas y/o máquinas, interpretando su interrelación y describiendo los principales elementos que los componen, utilizando el vocabulario relacionado con el tema.', '1.3. Explica la conversión de movimientos que tiene lugar en máquinas.', ''),
(5214, '5', '2. Máquinas y sistemas', '1. Analizar los bloques constitutivos de sistemas y/o máquinas, interpretando su interrelación y describiendo los principales elementos que los componen, utilizando el vocabulario relacionado con el tema.', '1.4. Calcula las magnitudes mecánicas más características de una máquina.', ''),
(5221, '5', '2. Máquinas y sistemas', '2. Verificar el funcionamiento de circuitos eléctrico-electrónicos, neumáticos e hidráulicos, analizando sus características técnicas, interpretando sus esquemas, utilizando los aparatos y equipos de medida adecuados, interpretando y valorando los resultados obtenidos apoyándose en el montaje o simulación física de los mismos.', '2.1. Monta, simula y comprueba circuitos eléctricos y electrónicos reales en el aula-taller.', ''),
(5222, '5', '2. Máquinas y sistemas', '2. Verificar el funcionamiento de circuitos eléctrico-electrónicos, neumáticos e hidráulicos, analizando sus características técnicas, interpretando sus esquemas, utilizando los aparatos y equipos de medida adecuados, interpretando y valorando los resultados obtenidos apoyándose en el montaje o simulación física de los mismos.', '2.2. Analiza y compara las características técnicas de diferentes modelos de electrodomésticos utilizando catálogos de fabricantes como documentación.', ''),
(5223, '5', '2. Máquinas y sistemas', '2. Verificar el funcionamiento de circuitos eléctrico-electrónicos, neumáticos e hidráulicos, analizando sus características técnicas, interpretando sus esquemas, utilizando los aparatos y equipos de medida adecuados, interpretando y valorando los resultados obtenidos apoyándose en el montaje o simulación física de los mismos.', '2.3. Identifica todos los componentes de un sistema neumático, ya sea en visión directa, en simulador informático o en esquema sobre papel.', ''),
(5224, '5', '2. Máquinas y sistemas', '2. Verificar el funcionamiento de circuitos eléctrico-electrónicos, neumáticos e hidráulicos, analizando sus características técnicas, interpretando sus esquemas, utilizando los aparatos y equipos de medida adecuados, interpretando y valorando los resultados obtenidos apoyándose en el montaje o simulación física de los mismos.', '2.4. Interpreta y valora los resultados obtenidos de circuitos eléctrico-electrónicos, neumáticos o hidráulicos.', ''),
(5231, '5', '2. Máquinas y sistemas', '3. Realizar esquemas de circuitos que dan solución a problemas técnicos mediante circuitos eléctrico-electrónicos, neumáticos o hidráulicos con ayuda de simuladores informáticos y calcular los parámetros característicos de los mismos.', '3.1. Calcula los parámetros eléctricos de un circuito eléctrico de una o más mallas, a partir de un esquema dado aplicando las leyes de Kirchhoff.', ''),
(5232, '5', '2. Máquinas y sistemas', '3. Realizar esquemas de circuitos que dan solución a problemas técnicos mediante circuitos eléctrico-electrónicos, neumáticos o hidráulicos con ayuda de simuladores informáticos y calcular los parámetros característicos de los mismos.', '3.2. Diseña circuitos eléctricos utilizando programas de simulación.', ''),
(5233, '5', '2. Máquinas y sistemas', '3. Realizar esquemas de circuitos que dan solución a problemas técnicos mediante circuitos eléctrico-electrónicos, neumáticos o hidráulicos con ayuda de simuladores informáticos y calcular los parámetros característicos de los mismos.', '3.3. Diseña circuitos neumáticos utilizando programas de simulación.', ''),
(5311, '5', '3. Programación y robótica', '1. Adquirir las habilidades y los conocimientos necesarios para elaborar programas informáticos estructurados, utilizaNdo recursos de programación tales como: variables de diferentes tipos, bucles, sentencias condicionales y funciones de programación.', '1.1. Realiza programas capaces de resolver problemas sencillos, realizando el diagrama de flujo correspondiente.', ''),
(5312, '5', '3. Programación y robótica', '1. Adquirir las habilidades y los conocimientos necesarios para elaborar programas informáticos estructurados, utilizaNdo recursos de programación tales como: variables de diferentes tipos, bucles, sentencias condicionales y funciones de programación.', '1.2. Desarrolla programas utilizando diferentes tipos de variables, bucles y sentencias condicionales.', ''),
(5313, '5', '3. Programación y robótica', '1. Adquirir las habilidades y los conocimientos necesarios para elaborar programas informáticos estructurados, utilizaNdo recursos de programación tales como: variables de diferentes tipos, bucles, sentencias condicionales y funciones de programación.', '1.3. Elabora un programa informático estructurado que resuelva un problema relacionado con la robótica.', ''),
(5321, '5', '3. Programación y robótica', '2. Diseñar y construir robots con los actuadores y sensores adecuados cuyo funcionamiento solucione un problema planteado.', '2.1. Comprende y utiliza sensores y actuadores utilizados habitualmente en un robot.', ''),
(5322, '5', '3. Programación y robótica', '2. Diseñar y construir robots con los actuadores y sensores adecuados cuyo funcionamiento solucione un problema planteado.', '2.2. Diseña y construye un robot con los actuadores y sensores adecuados para que su funcionamiento solucione un problema planteado.', ''),
(5323, '5', '3. Programación y robótica', '2. Diseñar y construir robots con los actuadores y sensores adecuados cuyo funcionamiento solucione un problema planteado.', '2.3. Participa como integrante de un equipo de trabajo de forma activa, en el diseño y montaje de un robot.', ''),
(5411, '5', '4. Introducción a la Ciencia de los Materiales', '1. Analizar las propiedades de los materiales utilizados en la construcción de objetos tecnológicos, reconociendo su estructura interna y relacionándola con las propiedades que presentan y las modificaciones que se puedan producir.', '1.1. Establece la relación que existe entre la estructura interna de los materiales y sus propiedades.', ''),
(5412, '5', '4. Introducción a la Ciencia de los Materiales', '1. Analizar las propiedades de los materiales utilizados en la construcción de objetos tecnológicos, reconociendo su estructura interna y relacionándola con las propiedades que presentan y las modificaciones que se puedan producir.', '1.2. Explica cómo se pueden modificar las propiedades de los materiales teniendo en cuenta su estructura interna.', ''),
(5413, '5', '4. Introducción a la Ciencia de los Materiales', '1. Analizar las propiedades de los materiales utilizados en la construcción de objetos tecnológicos, reconociendo su estructura interna y relacionándola con las propiedades que presentan y las modificaciones que se puedan producir.', '1.3. Reconoce las propiedades de los materiales y sus aplicaciones tecnológicas.', ''),
(5421, '5', '4. Introducción a la Ciencia de los Materiales', '2. Relacionar productos tecnológicos actuales/novedosos con los materiales que posibilitan su producción asociando las características de éstos con los productos fabricados, utilizando ejemplos concretos y analizando el impacto social producido en los países productores.', '2.1. Describe apoyándose en la información que le pueda proporcionar Internet algún material nuevo o novedoso que se utilice para la obtención de nuevos productos tecnológicos.', ''),
(5511, '5', '5. Procedimientos de fabricación', '1. Describir las técnicas utilizadas en los procesos de fabricación tipo, así como el impacto medioambiental que puede producir.', '1.1. Explica las principales técnicas utilizadas en el proceso de fabricación de un producto dado.', ''),
(5512, '5', '5. Procedimientos de fabricación', '1. Describir las técnicas utilizadas en los procesos de fabricación tipo, así como el impacto medioambiental que puede producir.', '1.2. Conoce el impacto medioambiental que pueden producir las técnicas de producción utilizadas y propone alternativas para reducir dicho impacto.', ''),
(5521, '5', '5. Procedimientos de fabricación', '2. Identificar las máquinas y herramientas utilizadas, así como las condiciones de seguridad propias de cada una de ellas, apoyándose en la información proporcionada en las web de los fabricantes.', '2.1. Identifica las máquinas y las herramientas utilizadas en los procedimientos de fabricación.', ''),
(5522, '5', '5. Procedimientos de fabricación', '2. Identificar las máquinas y herramientas utilizadas, así como las condiciones de seguridad propias de cada una de ellas, apoyándose en la información proporcionada en las web de los fabricantes.', '2.2. Realiza prácticas de procedimientos de fabricación con las máquinas-herramientas disponibles en el aula-taller teniendo en cuenta las principales condiciones de seguridad tanto desde el punto de vista del espacio como de la seguridad personal.', ''),
(5531, '5', '5. Procedimientos de fabricación', '3. Conocer las diferentes técnicas de fabricación en impresión 3D.', '3.1. Describe las fases del proceso de fabricación en impresión 3D', ''),
(5532, '5', '5. Procedimientos de fabricación', '3. Conocer las diferentes técnicas de fabricación en impresión 3D.', '3.2. Reconoce los diferentes tipos de impresión 3D y su aplicación en la industria.', ''),
(5533, '5', '5. Procedimientos de fabricación', '3. Conocer las diferentes técnicas de fabricación en impresión 3D.', '3.3. Construye una pieza sencilla con la impresora 3D, diseñándola o utilizando repositorios de piezas imprimibles en Internet.', ''),
(5611, '5', '6. Recursos tecnológicos', '1. Identificar las etapas necesarias para la creación de un producto tecnológico desde su origen hasta su comercialización, describiendo cada una de ellas.', '1.1. Diseña la propuesta de un nuevo producto tomando como base una idea dada, explicando el objetivo de cada una de las etapas significativas necesarias para lanzar el producto al mercado.', ''),
(5621, '5', '6. Recursos tecnológicos', '2. Investigar la influencia de un producto tecnológico en la sociedad y proponer mejoras tanto desde el punto de vista de su utilidad como de su posible impacto social.', '2.1. Analiza la influencia en la sociedad de la introducción de nuevos productos tecnológicos.', ''),
(5631, '5', '6. Recursos tecnológicos', '3. Explicar las diferencias y similitudes entre un modelo de excelencia y un sistema de gestión de la calidad identificando los principales actores que intervienen, valorando críticamente la repercusión que su implantación puede tener sobre losproductos desarrollados y exponiéndolo de forma oral con el soporte de una presentación.', '3.1. Desarrolla el esquema de un sistema de gestión de la calidad y/o posible modelo de excelencia, razonando la importancia de cada uno de los agentes implicados, con el apoyo de un soporte informático.', ''),
(5632, '5', '6. Recursos tecnológicos', '3. Explicar las diferencias y similitudes entre un modelo de excelencia y un sistema de gestión de la calidad identificando los principales actores que intervienen, valorando críticamente la repercusión que su implantación puede tener sobre losproductos desarrollados y exponiéndolo de forma oral con el soporte de una presentación.', '3.2. Valora de forma crítica la implantación de un modelo de excelencia o de un sistema de gestión de calidad en el diseño, producción y comercialización de productos.', '');
";

mysqli_query($link,utf8_decode($rellenaestandaresTecnologia))or die ("algo fallo...");
$crearestandaresRobotica="
CREATE TABLE `estandaresrobotica` (
  `id` int(5) NOT NULL,
  `curso` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `bloque` text COLLATE utf8_unicode_ci NOT NULL,
  `criterio` text COLLATE utf8_unicode_ci NOT NULL,
  `estandar` text COLLATE utf8_unicode_ci NOT NULL,
  `prioridad` varchar(5) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
";
mysqli_query($link,$crearestandaresRobotica)or die ("un momento.".mysqli_error($link));
$rellenaestandaresRobotica="INSERT INTO `estandaresrobotica` (`id`, `curso`, `bloque`, `criterio`, `estandar`, `prioridad`) VALUES
(4111, 4, '1. ELECTRÓNICA ANALÓGICA Y DIGITAL', '1. Analizar y describir el funcionamiento de los componentes electrónicos analógicos y bloques funcionales electrónicos utilizados en robótica', '1.1. Identifica los elementos que componen un circuito electrónico analógicos.', ''),
(4112, 4, '1. ELECTRÓNICA ANALÓGICA Y DIGITAL', '1. Analizar y describir el funcionamiento de los componentes electrónicos analógicos y bloques funcionales electrónicos utilizados en robótica', '1.2. Explica las características y funcionamiento básico de los componentes electrónicos analógicos aplicados a la robótica', ''),
(4121, 4, '1. ELECTRÓNICA ANALÓGICA Y DIGITAL', '2. Entender los sistemas de numeración y codificación básicos así como los principios y leyes de la electrónica digital aplicándolos al diseño y solución de problemas relacionados con la robótica', '2.1. Realiza ejercicios de conversión entre los diferentes sistemas de numeración y codificación', ''),
(4122, 4, '1. ELECTRÓNICA ANALÓGICA Y DIGITAL', '2. Entender los sistemas de numeración y codificación básicos así como los principios y leyes de la electrónica digital aplicándolos al diseño y solución de problemas relacionados con la robótica', '2.2. Distinguir y conocer el funcionamiento de puertas lógicas básicas en circuitos electrónicos digitales.', ''),
(4131, 4, '1. ELECTRÓNICA ANALÓGICA Y DIGITAL', '3. Diseñar circuitos sencillos de electrónica analógica y digital verificando su funcionamiento mediante software de simulación, realizando el montaje real de los mismos.', '3.1. Emplea simuladores para el diseño y análisis de circuitos electrónicos, utilizando la simbología adecuada.', ''),
(4132, 4, '1. ELECTRÓNICA ANALÓGICA Y DIGITAL', '3. Diseñar circuitos sencillos de electrónica analógica y digital verificando su funcionamiento mediante software de simulación, realizando el montaje real de los mismos.', '3.2. Realiza el montaje de circuitos electrónicos básicos diseñados previamente, verificando su funcionamiento y siguiendo las normas de seguridad adecuadas en el aula-taller.', ''),
(4211, 4, '2. SISTEMAS DE CONTROL', '1. Analizar sistemas automáticos, diferenciando los diferentes tipos de sistemas de control, describiendo los componentes que los integran y valorando la importancia de estos sistemas en la vida cotidiana.', '1.1. Analiza el funcionamiento de automatismos en diferentes dispositivos técnicos habituales, diferenciando entre lazo abierto y cerrado.', ''),
(4212, 4, '2. SISTEMAS DE CONTROL', '1. Analizar sistemas automáticos, diferenciando los diferentes tipos de sistemas de control, describiendo los componentes que los integran y valorando la importancia de estos sistemas en la vida cotidiana.', '1.2. Identifica y clasifica los diferentes componentes que forman un sistema automático de control', ''),
(4213, 4, '2. SISTEMAS DE CONTROL', '1. Analizar sistemas automáticos, diferenciando los diferentes tipos de sistemas de control, describiendo los componentes que los integran y valorando la importancia de estos sistemas en la vida cotidiana.', '1.3. Interpreta un esquema de un sistema de control', ''),
(4311, 4, '3. PROGRAMACIÓN DE SISTEMAS TÉCNICOS', '1. Adquirir las habilidades y los conocimientos básicos para elaborar programas informáticos', '1.1. Conoce la sintaxis y las diferentes instrucciones o estructuras del lenguaje de programación elegido para usar una plataforma de control', ''),
(4312, 4, '3. PROGRAMACIÓN DE SISTEMAS TÉCNICOS', '1. Adquirir las habilidades y los conocimientos básicos para elaborar programas informáticos', '1.2. Realiza programas sencillos utilizando un lenguaje de programación, aplicando dichos programas a una plataforma de control', ''),
(4321, 4, '3. PROGRAMACIÓN DE SISTEMAS TÉCNICOS', '2. Saber aplicar programas informáticos a plataformas de control para resolver problemas tecnológicos', '2.1. Utiliza correctamente la plataforma de control, realizando el montaje de los diferentes componentes electrónicos que necesita para resolver un problema tecnológico.', ''),
(4411, 4, '4. ROBÓTICA', '1. Analizar y describir los elementos básicos que componen un robot y los principios que rigen su funcionamiento.', '1.1. Identifica y conoce los elementos básicos que forman un robot.', ''),
(4412, 4, '4. ROBÓTICA', '1. Analizar y describir los elementos básicos que componen un robot y los principios que rigen su funcionamiento.', '1.2. Comprueba mediante programas de simulación el funcionamiento de sensores y actuadores, y realiza su montaje físico en el aula-taller.', ''),
(4413, 4, '4. ROBÓTICA', '1. Analizar y describir los elementos básicos que componen un robot y los principios que rigen su funcionamiento.', '1.3. Realiza programas informáticos que son utilizados en plataformas de hardware libre para resolver problemas de control y verifica su funcionamiento físicamente.', ''),
(4421, 4, '4. ROBÓTICA', '2. Describir los sistemas de comunicación que puede utilizar una plataforma de control, así como conocer las aplicaciones que tienen en los distintos campos de la robótica.', '2.1. Describe las características de comunicaciones USB, Bluetooth, WIFI y las empleadas en la telefonía móvil para comunicar o monitorizar el robot.', ''),
(4431, 4, '4. ROBÓTICA', '3. Comprender los movimientos y la forma de localizar o posicionar un robot conociendo la relación entre las articulaciones y grados de libertad del mismo.', '3.1. Indica la manera de posicionar el elemento terminal de un robot estático y de localizar un dispositivo móvil.', ''),
(4441, 4, '4. ROBÓTICA', '4. Diseñar, proyectar y construir un robot que resuelva un problema tecnológico planteado buscando la solución más adecuada y elaborando la documentación técnica necesaria del proyecto.', '4.1. Diseña y proyecta un robot que funcione de forma autónoma en función de la realimentación que recibe del entorno y elabora la documentación técnica del proyecto.', ''),
(4442, 4, '4. ROBÓTICA', '4. Diseñar, proyectar y construir un robot que resuelva un problema tecnológico planteado buscando la solución más adecuada y elaborando la documentación técnica necesaria del proyecto.', '4.2. Comprueba mediante programas de simulación el funcionamiento de un robot, y realiza su montaje físico en el aula taller.', ''),
(4451, 4, '4. ROBÓTICA', '5. Conocer las diferentes técnicas de fabricación en impresión en 3D y los pasos necesarios para imprimir una pieza.', '5.1. Describe las fases necesarias para crear una pieza en impresión 3D.', ''),
(4452, 4, '4. ROBÓTICA', '5. Conocer las diferentes técnicas de fabricación en impresión en 3D y los pasos necesarios para imprimir una pieza.', '5.2. Construye una pieza sencilla con la impresora 3D diseñándola o utilizando repositorios de piezas imprimibles en Internet.', ''),
(4461, 4, '4. ROBÓTICA', '6. Aprender a trabajar en equipo con actitudes de respeto y tolerancia hacia las ideas de los demás participando activamente en la consecución de los objetivos planteados.', '6.1. Trabaja en grupo de forma participativa y creativa, buscando información adicional y aportando ideas para el diseño y construcción de un robot.', '');
";

mysqli_query($link,utf8_decode($rellenaestandaresRobotica))or die ("algo fallo...");
$creargrupos="CREATE TABLE IF NOT EXISTS gruposinf(
id int(2)unsigned NOT NULL auto_increment,
`nombre` text NOT NULL ,
PRIMARY KEY ( `id` )
)";
mysqli_query($link,$creargrupos)or die("NO HE PODIDO CREAR LA TABLA DE GRUPOS");
mysqli_free_result;
$crearMaterias="
CREATE TABLE `materias` (
  `id` int(3) NOT NULL,
  `materia` text COLLATE utf8_unicode_ci NOT NULL,
  `codigo` text COLLATE utf8_unicode_ci NOT NULL,PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
"  ;
mysqli_query($link,$crearMaterias)or die ("NO HE PODIDO CREAR LA TABLA DE MATERIAS");

$llenarMaterias="INSERT INTO `materias` (`id`,  `materia`, `codigo`) VALUES
(1,  'Lengua', 'lengua'),
(2,  'Educación Plástica', 'plastica'),
(3,  'Educación Física', 'edfisica'),
(4,  'Física y Química', 'fisquim'),
(5,  'Ciencias Naturales', 'naturales'),
(6,  'Tecnología', 'tecnologia'),
(7,  'Matemáticas', 'matematicas'),
(8,  'Biología y Geología', 'biogeo'),
(9,  'Ciencias Sociales', 'sociales'),
(10,  'Tecnología Robótica', 'robotica');

";
mysqli_query($link,utf8_decode($llenarMaterias))or die ("No he podido rellenar la tabla de materias");
mysqli_free_result;
$crearEvaluacionGeneral="CREATE TABLE IF NOT EXISTS `evaluaciongeneral` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(15) NOT NULL,
  `profesor` varchar(20) NOT NULL,
  `materia` varchar(30) NOT NULL,
  `fecha` text DEFAULT NULL,
  `conocenormas` varchar(15) NOT NULL,
  `respetanormas` varchar(15) NOT NULL,
  `homogeneo` varchar(15) NOT NULL,
  `nivelacademico` varchar(15) NOT NULL,
  `climaenaula` varchar(15) NOT NULL,
  `actitudalumnoprofesor` varchar(15) NOT NULL,
  `actitudentrealumnos` varchar(15) NOT NULL,
  `otros` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
)";
mysqli_query($link,$crearEvaluacionGeneral)or die ("NO HE PODIDO CREAR LA TABLA DE EVALUACION GENERAL");
mysqli_free_result;
$crearNotasIndividuales="CREATE TABLE IF NOT EXISTS `notasindividuales` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `idalumno` int(6) DEFAULT NULL,
  `nombre` varchar(25) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `grupo` varchar(10) DEFAULT NULL,
  `profesor` varchar(50) DEFAULT NULL,
  `materia` varchar(50) DEFAULT NULL,
  `texto` text,
  `fecha` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ";
mysqli_query($link,$crearNotasIndividuales)or die ("NO HE PODIDO CREAR LA TABLA DE NOTAS INDIVIDUALES");
mysqli_free_result;
echo "<meta http-equiv=\"refresh\" content=\"0;URL=elige.php\">";
?>
