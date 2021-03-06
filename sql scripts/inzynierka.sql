-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 02 Sie 2021, 22:29
-- Wersja serwera: 10.4.19-MariaDB
-- Wersja PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `inzynierka`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `id_walk` int(10) NOT NULL,
  `id_sending_user` int(10) NOT NULL,
  `Message` varchar(500) NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp(),
  `displayed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `chat`
--

INSERT INTO `chat` (`id`, `id_walk`, `id_sending_user`, `Message`, `Date`, `displayed`) VALUES
(4, 1, 4, 'Spacer został anulowany', '2021-07-18 17:03:58', 0),
(5, 1, 9, 'Testowa wiadomość', '2021-07-18 17:18:05', 1),
(6, 1, 4, 'Wiadomość została usunięta', '2021-07-18 17:37:40', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `city`
--

CREATE TABLE `city` (
  `id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `id_voivodship` int(10) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `city`
--

INSERT INTO `city` (`id`, `name`, `description`, `id_voivodship`, `deleted`) VALUES
(1, 'Lublin', 'xDxDxD', 3, 0),
(2, 'Lubartów', 'lalala', 3, 0),
(3, 'Rzesów', '', 9, 0),
(4, 'Kielce', 'Nie dodano opisu miasta', 13, 0),
(5, 'Opatów', 'Nie dodano opisu miasta', 13, 0),
(6, 'Łódź', 'Nie dodano opisu miasta', 5, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dog`
--

CREATE TABLE `dog` (
  `id` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `size` varchar(30) NOT NULL,
  `opis` varchar(300) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `dog`
--

INSERT INTO `dog` (`id`, `id_user`, `name`, `size`, `opis`, `image_path`) VALUES
(1, 4, 'admin', 'Średni', 'dsa', 'xd'),
(3, 9, 'Buffy', 'Duży', 'Fajne doggo', NULL),
(4, 10, 'a', 'Mały', 'a', '1.bpmn.png');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `id_user` int(10) NOT NULL,
  `id_reported_user` int(10) NOT NULL,
  `reason` varchar(500) NOT NULL,
  `id_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `notification`
--

INSERT INTO `notification` (`id`, `id_user`, `id_reported_user`, `reason`, `id_status`) VALUES
(3, 4, 9, 'xadsads', 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reminder`
--

CREATE TABLE `reminder` (
  `id` int(11) NOT NULL,
  `id_user` int(10) NOT NULL,
  `id_sending_user` int(10) NOT NULL,
  `Message` varchar(500) NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp(),
  `displayed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `reminder`
--

INSERT INTO `reminder` (`id`, `id_user`, `id_sending_user`, `Message`, `Date`, `displayed`) VALUES
(1, 4, 5, 'Bla bla Bla', '2021-07-15 16:25:29', 1),
(2, 4, 5, 'asdfdasdfsa', '2021-07-15 17:09:52', 1),
(3, 9, 5, 'Maciek no prosze cie', '2021-07-19 15:59:49', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `spot`
--

CREATE TABLE `spot` (
  `id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `id_city` int(10) NOT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `spot`
--

INSERT INTO `spot` (`id`, `name`, `id_city`, `description`, `deleted`) VALUES
(1, 'Jakis plac', 1, 'Jednak dodano xDxD', 0),
(2, 'Plac wolności', 5, 'Nie dodano opisu miejsca', 0),
(3, 'Placyk', 1, 'Nie dodano opisu miejsca', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `status`
--

INSERT INTO `status` (`id`, `status`) VALUES
(1, 'Nie odczytano'),
(2, 'W trakcie'),
(3, 'Zaakceptowano'),
(4, 'Odrzucono');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `suggestions`
--

CREATE TABLE `suggestions` (
  `id` int(11) NOT NULL,
  `suggestion` varchar(500) NOT NULL,
  `id_user` int(10) NOT NULL DEFAULT 1,
  `id_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `suggestions`
--

INSERT INTO `suggestions` (`id`, `suggestion`, `id_user`, `id_status`) VALUES
(2, 'Dodacie cos nowego?', 4, 3),
(3, 'Dodacie Ostrowiec Świętokrzyski?', 4, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `email` varchar(256) NOT NULL,
  `id_city` int(10) DEFAULT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT 0,
  `password` varchar(255) NOT NULL,
  `login` varchar(30) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `email`, `id_city`, `description`, `blocked`, `password`, `login`, `deleted`, `admin`) VALUES
(4, 'Piotr', 'Czajka', 'p.czajka.1998@gmail.com', 1, 'Jednak dodano', 2, '$2y$10$ID2JP974mujHV.M8bF49Sun9lEFEC1nR66COfCS7aRYXBDqVJubX2', 'Rollermix', 0, 0),
(5, 'Piotr', 'Czajka', 'xd@o2.pl', NULL, 'xd', 0, '$2y$10$PFeo.ffHSg/YHfkveNz7sutU1t1lo8AbgIWHfb85OML3BlzskwTye', 'admin', 0, 1),
(6, 'Tomek', 'Atomek', 'tomek@gmail.com', NULL, 'nie wiem', 0, '$2y$10$5cDXX7pcolXKgUGKQAYI7e.4zMRzgccFkYa9t3AHl8zWQ4dM7DFGu', 'tomek', 0, 0),
(7, 'Mateusz', 'Kowalski', 'kowal@gmail.com', 4, '', 0, '$2y$10$mYCROPzTJIZvHc2EwHvW2erZ.IvgsDRvWmukmQ4RtqATYHricZZ0e', 'Kowal', 0, 0),
(8, 'Bożena', 'Czajka', 'boz@gmail.com', NULL, '', 0, '$2y$10$Xi/dp0.SyVrUlVSh0b1Ge.x9aiP1lZ0jZ8pCPqGUdNu79.ekDn5oS', 'boz', 0, 0),
(9, 'Maciek', 'Tomasz', 'maciek@gmail.com', 1, 'XD', 0, '$2y$10$wJICAedHXqGSDV6tr64FuuLQRvaI/cgBV.WHCsFGuL65RX20Ng.Aa', 'maciek', 0, 0),
(10, 'a', 'a', 'a@gmail.com', 1, 'a', 0, '$2y$10$JkBdQp84T2WG/NdqoLEsr.pV2JnJS0ZFmSP2AfK30VNM8PVnGRntu', 'a', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `voivodship`
--

CREATE TABLE `voivodship` (
  `id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `voivodship`
--

INSERT INTO `voivodship` (`id`, `name`, `description`) VALUES
(1, 'dolnośląskie', NULL),
(2, 'kujawsko-pomorskie', NULL),
(3, 'lubelskie', NULL),
(4, 'lubuskie', NULL),
(5, 'łódzkie', NULL),
(6, 'małopolskie', NULL),
(7, 'mazowieckie', NULL),
(8, 'opolskie', NULL),
(9, 'podkarpackie', NULL),
(10, 'podlaskie', NULL),
(11, 'pomorskie', NULL),
(12, 'śląskie', NULL),
(13, 'świętokrzyskie', NULL),
(14, 'warmińsko-mazurskie', NULL),
(15, 'wielkopolskie', NULL),
(16, 'zachodniopomorskie', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `walk`
--

CREATE TABLE `walk` (
  `id` int(10) NOT NULL,
  `id_spot` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `id_accompanied_user` int(10) DEFAULT NULL,
  `time` datetime NOT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `cancelled` tinyint(4) NOT NULL DEFAULT 0,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `last_edited` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `walk`
--

INSERT INTO `walk` (`id`, `id_spot`, `id_user`, `id_accompanied_user`, `time`, `description`, `cancelled`, `approved`, `last_edited`) VALUES
(1, 1, 4, 9, '2021-07-08 19:20:00', 'fads', 0, 1, NULL),
(2, 3, 9, NULL, '2021-07-16 20:10:00', 'Nie dodano opisu', 0, 0, NULL),
(3, 1, 4, NULL, '2021-07-28 17:58:00', 'Jednak dodano', 0, 0, '2021-07-18 16:18:08');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKchat596580` (`id_walk`),
  ADD KEY `FKchat467053` (`id_sending_user`);

--
-- Indeksy dla tabeli `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKcity606152` (`id_voivodship`);

--
-- Indeksy dla tabeli `dog`
--
ALTER TABLE `dog`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_user` (`id_user`),
  ADD KEY `FKdog558857` (`id_user`);

--
-- Indeksy dla tabeli `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKnotificati278779` (`id_user`),
  ADD KEY `FKnotificati756946` (`id_reported_user`),
  ADD KEY `FKnotificati39996` (`id_status`);

--
-- Indeksy dla tabeli `reminder`
--
ALTER TABLE `reminder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKreminder856056` (`id_user`),
  ADD KEY `FKreminder122589` (`id_sending_user`);

--
-- Indeksy dla tabeli `spot`
--
ALTER TABLE `spot`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `FKspot905617` (`id_city`);

--
-- Indeksy dla tabeli `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `suggestions`
--
ALTER TABLE `suggestions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKsuggestion180896` (`id_user`),
  ADD KEY `FKsuggestion551911` (`id_status`);

--
-- Indeksy dla tabeli `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `FKuser967770` (`id_city`);

--
-- Indeksy dla tabeli `voivodship`
--
ALTER TABLE `voivodship`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `walk`
--
ALTER TABLE `walk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKwalk976711` (`id_spot`),
  ADD KEY `FKwalk101018` (`id_user`),
  ADD KEY `FKwalk779242` (`id_accompanied_user`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `city`
--
ALTER TABLE `city`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `dog`
--
ALTER TABLE `dog`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `reminder`
--
ALTER TABLE `reminder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `spot`
--
ALTER TABLE `spot`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `suggestions`
--
ALTER TABLE `suggestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `voivodship`
--
ALTER TABLE `voivodship`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `walk`
--
ALTER TABLE `walk`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `FKchat467053` FOREIGN KEY (`id_sending_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FKchat596580` FOREIGN KEY (`id_walk`) REFERENCES `walk` (`id`);

--
-- Ograniczenia dla tabeli `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `FKcity606152` FOREIGN KEY (`id_voivodship`) REFERENCES `voivodship` (`id`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `dog`
--
ALTER TABLE `dog`
  ADD CONSTRAINT `FKdog558857` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `FKnotificati278779` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FKnotificati39996` FOREIGN KEY (`id_status`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `FKnotificati756946` FOREIGN KEY (`id_reported_user`) REFERENCES `user` (`id`);

--
-- Ograniczenia dla tabeli `reminder`
--
ALTER TABLE `reminder`
  ADD CONSTRAINT `FKreminder122589` FOREIGN KEY (`id_sending_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FKreminder856056` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Ograniczenia dla tabeli `spot`
--
ALTER TABLE `spot`
  ADD CONSTRAINT `FKspot905617` FOREIGN KEY (`id_city`) REFERENCES `city` (`id`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `suggestions`
--
ALTER TABLE `suggestions`
  ADD CONSTRAINT `FKsuggestion180896` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FKsuggestion551911` FOREIGN KEY (`id_status`) REFERENCES `status` (`id`);

--
-- Ograniczenia dla tabeli `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FKuser967770` FOREIGN KEY (`id_city`) REFERENCES `city` (`id`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `walk`
--
ALTER TABLE `walk`
  ADD CONSTRAINT `FKwalk101018` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FKwalk779242` FOREIGN KEY (`id_accompanied_user`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FKwalk976711` FOREIGN KEY (`id_spot`) REFERENCES `spot` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
