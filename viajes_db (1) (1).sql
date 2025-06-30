

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `emisor_id` int(11) NOT NULL,
  `receptor_id` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `jefe_id` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `paquetes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `moneda` varchar(10) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `portada` text DEFAULT NULL,
  `destino` varchar(255) DEFAULT NULL,
  `tipoDestino` varchar(50) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL,
  `fechaSalida` date DEFAULT NULL,
  `tipoServicio` varchar(50) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `paquete_id` int(11) NOT NULL,
  `fecha_reserva` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','confirmada','cancelada') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `rol` enum('cliente','jefe') NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`id`, `email`, `password`, `nombre`, `rol`, `fecha_registro`) VALUES
(1, 'cliente@test.com', '7159bbe0c8ca2a67230a26b72dea7557', 'Cliente Demo', 'cliente', '2025-06-15 05:27:50'),
(2, 'jefe@test.com', '954cb22b39f0ce9f8ab770210d09aefe', 'Jefe Demo', 'jefe', '2025-06-15 05:27:50');


ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emisor_id` (`emisor_id`),
  ADD KEY `receptor_id` (`receptor_id`);

ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jefe_id` (`jefe_id`);

ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `paquete_id` (`paquete_id`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `paquetes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`emisor_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`receptor_id`) REFERENCES `usuarios` (`id`);

ALTER TABLE `notificaciones`

ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`paquete_id`) REFERENCES `paquetes` (`id`) ON DELETE CASCADE;
COMMIT;
