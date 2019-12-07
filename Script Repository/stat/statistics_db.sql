-- Tabellenstruktur für Tabelle `www_site_stat`
--

CREATE TABLE `www_site_stat` (
  `id` int(12) UNSIGNED NOT NULL auto_increment,
  `date` datetime NOT NULL,
  `page` varchar(255) CHARACTER SET utf8mb4 NOT NULL default '',
  `ip_address` varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
  `user_agent_hash` varchar(40) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`date`),
  INDEX (`page`),
  INDEX (`ip_address`),
  INDEX (`user_agent_hash`)
) ENGINE=Aria DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- (IPv4-mapped IPv6 (45 characters) :
-- ABCD:ABCD:ABCD:ABCD:ABCD:ABCD:192.168.158.190

-- Tabellenstruktur für Tabelle `useragents`
--

CREATE TABLE `useragents` (
  `id` int(12) UNSIGNED NOT NULL auto_increment,
  `user_agent_hash` varchar(40) CHARACTER SET utf8mb4 NOT NULL,
  `user_agent_string` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_agent_hash` (`user_agent_hash`)
) ENGINE=Aria DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
