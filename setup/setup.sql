SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `maintenance`
--
CREATE DATABASE IF NOT EXISTS `maintenance` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `maintenance`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `settings`
--

CREATE TABLE `settings` (
  `setting_name` varchar(254) NOT NULL,
  `setting_value` varchar(254) NOT NULL,
  `setting_id` int(11) NOT NULL,
  `setting_default` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tools`
--

CREATE TABLE `tools` (
  `tool_id` int(11) NOT NULL COMMENT 'ID des Tools',
  `tool_name` text NOT NULL COMMENT 'Name des Tools',
  `tool_version` text DEFAULT NULL COMMENT 'Die Version des Tools',
  `tool_path` text NOT NULL COMMENT 'Pfad des Tools',
  `tool_image_base64` text DEFAULT NULL COMMENT 'Das Tool-Icon in Base64 encodiert',
  `tool_description` text DEFAULT NULL COMMENT 'Die Beschreibung des Tools',
  `tool_url` int(11) DEFAULT NULL COMMENT 'Externe URL zum Download des Tools'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `user_id` int(254) NOT NULL COMMENT 'Nutzer ID, 1-9223372036854775807',
  `user_name` text NOT NULL COMMENT 'Nutzername oder Initialien z.B. bavan',
  `user_fullname` text NOT NULL COMMENT 'Kompletter Name des Angestellten, z.B. Bryan BXXXXX',
  `email` text NOT NULL COMMENT 'Email des Nutzers',
  `profile_picture_hash` varchar(254) DEFAULT NULL COMMENT 'Ein Hash des benutzerdefinierten Profilbildes',
  `password_hash` text NOT NULL COMMENT 'Ein Hash vom Passwort',
  `role` varchar(254) NOT NULL COMMENT 'Die Rolle des Nutzers (Admin, Employee, Technician',
  `status` int(11) NOT NULL COMMENT 'Status (active, disabled)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indizes für die Tabelle `tools`
--
ALTER TABLE `tools`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tools`
--
ALTER TABLE `tools`
  MODIFY `tool_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID des Tools';

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(254) NOT NULL AUTO_INCREMENT COMMENT 'Nutzer ID, 1-9223372036854775807';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
