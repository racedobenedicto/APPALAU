--
-- Base de datos
--
CREATE DATABASE IF NOT EXISTS `bbddRaquelMiriam` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

--
-- Estructura de tabla para la tabla `alumnes`
--

CREATE TABLE `alumnes` (
  `idAlumne` int(11) NOT NULL,
  `nomAlumne` varchar(100) NOT NULL,
  `grup` varchar(12) NOT NULL,
  `direccio` varchar(100) DEFAULT NULL,
  `municipi` varchar(100) DEFAULT NULL,
  `codi_postal` varchar(10) DEFAULT NULL,
  `pare` varchar(100) NOT NULL,
  `mare` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencies_codi`
--

CREATE TABLE `asistencies_codi` (
  `idCodi` int(10) NOT NULL,
  `incidencia` varchar(2) COLLATE latin1_spanish_ci NOT NULL,
  `text` varchar(150) COLLATE latin1_spanish_ci NOT NULL,
  `pes` int(10) NOT NULL,
  `lletra` varchar(1) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencies_generals`
--

CREATE TABLE `asistencies_generals` (
  `idAsistencia` int(10) NOT NULL,
  `idProfessor` int(10) NOT NULL,
  `dia` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `hora` int(5) NOT NULL,
  `grup` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `materia` varchar(20) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencies_incidencies`
--

CREATE TABLE `asistencies_incidencies` (
  `idIncidencia` int(10) NOT NULL,
  `idAlumne` int(10) NOT NULL,
  `idProfessor` int(10) NOT NULL,
  `dia` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `hora` varchar(5) COLLATE latin1_spanish_ci NOT NULL,
  `grup` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `materia` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `incidencia` varchar(1) COLLATE latin1_spanish_ci NOT NULL,
  `codi` int(10) NOT NULL,
  `comentari` text COLLATE latin1_spanish_ci NOT NULL,
  `justificat` int(1) NOT NULL,
  `sancionat` int(1) NOT NULL,
  `justificacio` text COLLATE latin1_spanish_ci NOT NULL,
  `sms` int(1) NOT NULL DEFAULT '0',
  `datatime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curriculum`
--

CREATE TABLE `curriculum` (
  `idCurriculum` bigint(11) NOT NULL,
  `idAlumne` bigint(11) NOT NULL,
  `grup` varchar(10) NOT NULL,
  `classe` varchar(10) NOT NULL,
  `trimestre` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dates`
--

CREATE TABLE `dates` (
  `idData` int(12) NOT NULL,
  `data` varchar(12) NOT NULL,
  `dia_sem` int(12) NOT NULL,
  `setmana` int(10) DEFAULT NULL,
  `trimestre` varchar(1) NOT NULL,
  `mes` varchar(3) NOT NULL,
  `actiu` varchar(1) NOT NULL,
  `dia_mes` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentacio`
--

CREATE TABLE `documentacio` (
  `idDoc` int(10) NOT NULL,
  `data` varchar(10) NOT NULL,
  `tema` varchar(100) NOT NULL,
  `idProfessor` int(10) NOT NULL,
  `data_limit` varchar(10) NOT NULL,
  `idAlumne` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horaris`
--

CREATE TABLE `horaris` (
  `idHorari` int(12) NOT NULL,
  `idProfessor` int(12) NOT NULL,
  `dia` int(12) NOT NULL,
  `hora` int(10) NOT NULL,
  `grup` varchar(10) NOT NULL,
  `classe` varchar(10) DEFAULT NULL,
  `aula` varchar(10) NOT NULL,
  `control` int(5) NOT NULL,
  `trimestre` varchar(1) NOT NULL,
  `hora2` decimal(10,2) NOT NULL,
  `direccio` int(5) NOT NULL DEFAULT '0',
  `etapa` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacions`
--

CREATE TABLE `informacions` (
  `idInformacio` int(10) NOT NULL,
  `idUser` int(10) NOT NULL,
  `data` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `tema` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `informacio` text COLLATE latin1_spanish_ci NOT NULL,
  `perfil` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `actiu` int(1) NOT NULL,
  `vist` int(1) NOT NULL,
  `tmp_actiu` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacions_grups`
--

CREATE TABLE `informacions_grups` (
  `idInformacio` int(10) NOT NULL,
  `grup` varchar(10) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `msg_chat`
--

CREATE TABLE `msg_chat` (
  `idChat` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `idAlumne` int(10) NOT NULL,
  `materia` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `idUser` int(10) NOT NULL,
  `data` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `hora` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `msj` text COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `msg_chats_vist`
--

CREATE TABLE `msg_chats_vist` (
  `idChat` varchar(50) NOT NULL,
  `idUser` int(10) NOT NULL,
  `vist` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `professors`
--

CREATE TABLE `professors` (
  `idProfessor` int(10) NOT NULL,
  `nomProfessor` varchar(50) CHARACTER SET utf8 NOT NULL,
  `departament` varchar(10) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `codi` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `idUser` int(11) NOT NULL,
  `user` varchar(40) NOT NULL,
  `pass` varchar(40) NOT NULL,
  `tipus` varchar(40) NOT NULL,
  `idTipus` int(11) NOT NULL,
  `logins_erronis` int(11) NOT NULL DEFAULT '0',
  `bloquejat` tinyint(4) NOT NULL DEFAULT '0',
  `mobil` varchar(10) NOT NULL,
  `aut_mobil` int(2) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `aut_mail` mediumint(2) NOT NULL,
  `responsable` varchar(100) NOT NULL,
  `oneSignal` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Indices de la tabla `alumnes`
--
ALTER TABLE `alumnes`
  ADD PRIMARY KEY (`idAlumne`);

--
-- Indices de la tabla `asistencies_codi`
--
ALTER TABLE `asistencies_codi`
  ADD PRIMARY KEY (`idCodi`);

--
-- Indices de la tabla `asistencies_generals`
--
ALTER TABLE `asistencies_generals`
  ADD PRIMARY KEY (`idAsistencia`),
  ADD KEY `idAlumne` (`idProfessor`);

--
-- Indices de la tabla `asistencies_incidencies`
--
ALTER TABLE `asistencies_incidencies`
  ADD PRIMARY KEY (`idIncidencia`);

--
-- Indices de la tabla `curriculum`
--
ALTER TABLE `curriculum`
  ADD PRIMARY KEY (`idCurriculum`);

--
-- Indices de la tabla `dates`
--
ALTER TABLE `dates`
  ADD PRIMARY KEY (`idData`),
  ADD KEY `data` (`data`);

--
-- Indices de la tabla `documentacio`
--
ALTER TABLE `documentacio`
  ADD PRIMARY KEY (`idDoc`);

--
-- Indices de la tabla `horaris`
--
ALTER TABLE `horaris`
  ADD PRIMARY KEY (`idHorari`);

--
-- Indices de la tabla `informacions`
--
ALTER TABLE `informacions`
  ADD PRIMARY KEY (`idInformacio`);

--
-- Indices de la tabla `informacions_grups`
--
ALTER TABLE `informacions_grups`
  ADD PRIMARY KEY (`idInformacio`,`grup`);

--
-- Indices de la tabla `msg_chat`
--
ALTER TABLE `msg_chat`
  ADD PRIMARY KEY (`idChat`);

--
-- Indices de la tabla `msg_chats_vist`
--
ALTER TABLE `msg_chats_vist`
  ADD PRIMARY KEY (`idChat`,`idUser`);

--
-- Indices de la tabla `professors`
--
ALTER TABLE `professors`
  ADD PRIMARY KEY (`idProfessor`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `idUser` (`idUser`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencies_generals`
--
ALTER TABLE `asistencies_generals`
  MODIFY `idAsistencia` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asistencies_incidencies`
--
ALTER TABLE `asistencies_incidencies`
  MODIFY `idIncidencia` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `dates`
--
ALTER TABLE `dates`
  MODIFY `idData` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `informacions`
--
ALTER TABLE `informacions`
  MODIFY `idInformacio` int(10) NOT NULL AUTO_INCREMENT;
