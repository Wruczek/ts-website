SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `tsw_config`;
CREATE TABLE `tsw_config` (
  `identifier` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'STRING' COMMENT 'STRING, INT, FLOAT, BOOL, JSON',
  `value` text COLLATE utf8mb4_unicode_ci,
  `user_editable` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tsw_config` (`identifier`, `type`, `value`, `user_editable`) VALUES
('cache_servericons', 'INT', '600', 1),
('onlinerecord_value', 'INT', '0', 0),
('onlinerecord_date', 'INT', '0', 0),
('usingcloudflare', 'BOOL', 'false', 1),
('loginpokeclient', 'BOOL', 'true', 1),
('cache_logincode', 'INT', '120', 1),
('cache_adminstatus', 'INT', '60', 1),
('adminstatus_groups', 'JSON', '[]', 1),
('adminstatus_mode', 'INT', '2', 1),
('adminstatus_enabled', 'BOOL', 'true', 1),
('adminstatus_hideoffline', 'BOOL', 'false', 1),
('adminstatus_ignoredusers', 'JSON', '[]', 1),
('assignerconfig', 'JSON', '[]', 1),
('query_nickname', 'STRING', 'TS-website', 1),
('cache_serverinfo', 'INT', '10', 1),
('cache_banlist', 'INT', '60', 1),
('cache_clientlist', 'INT', '15', 1),
('cache_channelist', 'INT', '60', 1),
('cache_servergroups', 'INT', '60', 1),
('cache_channelgroups', 'INT', '60', 1),
('adminstatus_offlinehiddenbydefault', 'BOOL', 'false', 1),
('imprint_enabled', 'BOOL', 'false', 1),
('imprint_url', 'STRING', 'imprint.php', 1);

DROP TABLE IF EXISTS `tsw_faq`;
CREATE TABLE `tsw_faq` (
  `faqid` int(11) NOT NULL,
  `langid` int(11) NOT NULL DEFAULT '1',
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastmodify` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tsw_faq` (`faqid`, `langid`, `question`, `answer`, `lastmodify`) VALUES
(1, 1, 'What is the FAQ?', '<b>FAQ</b> section allows you to show frequently asked questions and answers to them.', '2018-12-26 13:10:32'),
(2, 1, 'How can I configure the FAQ?', 'An administrator can add, edit and remove questions in <a href=\"admin\">admin panel</a>.', '2018-12-26 12:33:18'),
(3, 1, 'Question 3', 'Answer 3 in <b>HTML</b>', '2018-12-26 13:10:32');

DROP TABLE IF EXISTS `tsw_languages`;
CREATE TABLE `tsw_languages` (
  `langid` int(11) NOT NULL,
  `englishname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nativename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `langcode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'In this format: https://bit.ly/2MCGg6M',
  `isdefault` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tsw_languages` (`langid`, `englishname`, `nativename`, `langcode`, `isdefault`) VALUES
(1, 'English', 'English', 'en', 1),
(2, 'English (US)', 'English (US)', 'en-us', 0),
(3, 'Polish', 'Polski', 'pl', 0);

DROP TABLE IF EXISTS `tsw_news`;
CREATE TABLE `tsw_news` (
  `newsid` int(11) NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `langid` int(11) NOT NULL DEFAULT '1',
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited` timestamp NULL DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tsw_news` (`newsid`, `title`, `langid`, `added`, `edited`, `content`) VALUES
(1, 'Welcome to ts-website!', 1, '2018-12-26 13:10:32', NULL, '<b>Hi there!</b> If you are reading this, it means that TS-website has been installed successfully.<br>\r\nYou can login to your <a href=\"admin\">ACP</a> to configure many parts of it.<br>\r\nNeed help? Join our <a href=\"https://t.me/tswebsite\" target=\"_blank\">Telegram group</a> for support.\r\nHave a good day!');

DROP TABLE IF EXISTS `tsw_translations`;
CREATE TABLE `tsw_translations` (
  `id` int(10) NOT NULL,
  `langid` int(10) NOT NULL,
  `identifier` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tsw_translations` (`id`, `langid`, `identifier`, `value`, `comment`) VALUES
(1, 1, 'AUTHORS', 'Wruczek <wruczekk@gmail.com>', 'Language authors'),
(2, 3, 'AUTHORS', 'Wruczek <wruczekk@gmail.com>', NULL),
(3, 1, 'COOKIEALERT_MESSAGE', '<b>Do you like cookies?</b> &#x1F36A; We use cookies to ensure you get the best experience on our website. <a href=\"http://cookiesandyou.com/\" target=\"_blank\">Learn more</a>', 'Remember to change link to a website in your language'),
(4, 3, 'COOKIEALERT_MESSAGE', '<b>Lubisz ciasteczka?</b> &#x1F36A; Używamy ciasteczek, aby zapewnić najwyższą jakość usług. <a href=\"http://wszystkoociasteczkach.pl/\" target=\"_blank\">Dowiedz się więcej</a>', NULL),
(5, 1, 'COOKIEALERT_AGREE', 'I agree', NULL),
(6, 3, 'COOKIEALERT_AGREE', 'Zgadzam się', NULL),
(7, 1, 'OUTDATED_DATA', '<b>Warning!</b> Some information cannot be obtained now. Showing outdated data from {0}.', '{0} will be replaced with fuzzy date (for example \"8 hours ago\"). Please try to match the your message grammatically'),
(8, 3, 'OUTDATED_DATA', '<b>Uwaga!</b> Niektóre dane nie mogą być teraz uzyskane. Pokazuje nieaktualne dane z {0}.', NULL),
(9, 1, 'SHOW_PROBLEMS', 'Show problems', NULL),
(10, 3, 'SHOW_PROBLEMS', 'Pokaż problemy', NULL),
(11, 1, 'PROBLEMS_DESCRIPTION', 'Problems encountered while connecting to the TeamSpeak server', NULL),
(12, 3, 'PROBLEMS_DESCRIPTION', 'Problemy napotkane podczas próby połączenia się z serwerem TeamSpeak', NULL),
(13, 1, 'NO_JAVASCRIPT_ENABLED', 'This website will not work without <a href=\"https://www.enable-javascript.com/\" target=\"_blank\">JavaScript enabled</a>.', 'Remember to change the website address to include instructions in your language'),
(14, 3, 'NO_JAVASCRIPT_ENABLED', 'Ta stronie nie będzie działać bez <a href=\"https://www.enable-javascript.com/pl/\" target=\"_blank\">włączonej obsługi JavaScript</a>.', NULL),
(15, 1, 'CANNOT_GET_DATA', 'Cannot get data for \"{0}\"! Please contact website owner.', '{0} will be replaced with component name that cannot be refreshed (for example banlist or viewer)'),
(16, 3, 'CANNOT_GET_DATA', 'Nie mogę pobrać informacji o \"{0}\"! Skontaktuj się z właścicielem strony.', NULL),
(17, 1, 'NO_REASON_SET', '<b>(no reason set)</b>', 'Please keep the \"<b>\" tags in place, as they help to distinguish a placeholder form a real message'),
(18, 3, 'NO_REASON_SET', '<b>(brak powodu)</b>', NULL),
(19, 1, 'BANS_HEADER_NAME', 'Name / IP / UID', NULL),
(20, 3, 'BANS_HEADER_NAME', 'Nazwa / IP / UID', NULL),
(21, 1, 'BANS_HEADER_REASON', 'Reason', NULL),
(22, 3, 'BANS_HEADER_REASON', 'Powód', NULL),
(23, 1, 'BANS_HEADER_INVOKER', 'Banned by', NULL),
(24, 3, 'BANS_HEADER_INVOKER', 'Zbanowany przez', NULL),
(25, 1, 'BANS_HEADER_BANDATE', 'Ban date', NULL),
(26, 3, 'BANS_HEADER_BANDATE', 'Data zbanowania', NULL),
(27, 1, 'BANS_HEADER_EXPIRES', 'Expires', NULL),
(28, 3, 'BANS_HEADER_EXPIRES', 'Wygasa', NULL),
(29, 1, 'DATATABLES_LANGUAGE_NAME', 'English', 'This language will be used to load language file for DataTables. Please choose a language from this list: https://datatables.net/plug-ins/i18n/#Translations.\r\n\r\nIf chosen correctly, this url: \"//cdn.datatables.net/plug-ins/1.10.12/i18n/{NAME}.json\" should return a valid JSON object with translations. For example: \"//cdn.datatables.net/plug-ins/1.10.12/i18n/English.json\"'),
(30, 3, 'DATATABLES_LANGUAGE_NAME', 'Polish', NULL),
(31, 1, 'BANS_NEVEREXPIRES', 'Never', NULL),
(32, 3, 'BANS_NEVEREXPIRES', 'Nigdy', NULL),
(33, 1, 'STATUS_ADDRESS', 'Address:', ''),
(34, 3, 'STATUS_ADDRESS', 'Adres:', NULL),
(35, 1, 'STATUS_CLIENTS_ONLINE', 'Online:', NULL),
(36, 3, 'STATUS_CLIENTS_ONLINE', 'Online:', NULL),
(37, 1, 'STATUS_RESERVED_SLOTS', '{0} reserved slots', NULL),
(38, 3, 'STATUS_RESERVED_SLOTS', '{0} zarezerwowanych slotów', NULL),
(39, 1, 'STATUS_TOP_ONLINE', 'Top online:', NULL),
(40, 3, 'STATUS_TOP_ONLINE', 'Rekord online:', NULL),
(41, 1, 'STATUS_TOP_ONLINE_DESC', 'Achieved on {0}', NULL),
(42, 3, 'STATUS_TOP_ONLINE_DESC', 'Ustanowiono {0}', NULL),
(43, 1, 'STATUS_UPTIME', 'Uptime:', NULL),
(44, 3, 'STATUS_UPTIME', 'Uptime:', NULL),
(45, 1, 'STATUS_VERSION', 'Version:', NULL),
(46, 3, 'STATUS_VERSION', 'Wersja:', NULL),
(47, 1, 'STATUS_VERSION_DESC', '{0} on {1}', NULL),
(48, 3, 'STATUS_VERSION_DESC', '{0} na {1}', NULL),
(49, 1, 'STATUS_PING', 'Avg. ping:', NULL),
(50, 3, 'STATUS_PING', 'Śr. ping:', NULL),
(51, 1, 'STATUS_PACKETLOSS', 'Avg. packet loss:', NULL),
(52, 3, 'STATUS_PACKETLOSS', 'Śr. utrata pakietów:', NULL),
(53, 1, 'STATUS_ERROR', 'Cannot retrieve server status', NULL),
(54, 3, 'STATUS_ERROR', 'Błąd podczas wczytywania statusu serwera', NULL),
(55, 1, 'STATUS_PANEL_TITLE', 'Server status', NULL),
(56, 3, 'STATUS_PANEL_TITLE', 'Status serwera', NULL),
(57, 1, 'MOMENTJS_LANG', 'en-gb', 'Language for Moment.js, full list: https://github.com/moment/moment/tree/develop/locale'),
(58, 2, 'MOMENTJS_LANG', 'en-us', NULL),
(59, 3, 'MOMENTJS_LANG', 'pl', NULL),
(60, 1, 'LOGIN_CONFIRMATION_CODE', 'Hi, here\'s your confirmation code to login: [b]{0}[/b]', 'You can use BBCode. Use {0} for the confirmation code.'),
(61, 3, 'LOGIN_CONFIRMATION_CODE', 'Cześć, oto twój kod potwierdzający logowanie: [b]{0}[/b]', NULL),
(62, 1, 'UNSUPPORTED_BROWSER', 'Your browser is not supported. Please switch to the latest version of Chrome, Firefox, Safari or Edge to use this website.', ''),
(63, 3, 'UNSUPPORTED_BROWSER', 'Twoja przeglądarka nie jest wspierana. Zainstaluj najnowszą wersję Chrome, Firefox, Safari lub Edge by korzystać z tej strony.', NULL),
(64, 1, 'DATATABLES_PLACEHOLDER_SEARCH', 'Search...', NULL),
(65, 3, 'DATATABLES_PLACEHOLDER_SEARCH', 'Szukaj...', NULL),
(66, 1, 'WEBSITE_TITLE', ' | TS-website English Language', NULL),
(67, 3, 'WEBSITE_TITLE', ' | TS-website Język Polski', NULL),
(68, 1, 'ADMIN_STATUS_ONLINE', 'Online', NULL),
(69, 3, 'ADMIN_STATUS_ONLINE', 'Online', NULL),
(70, 1, 'ADMIN_STATUS_AWAY', 'Away', NULL),
(71, 3, 'ADMIN_STATUS_AWAY', 'Zaraz wracam', NULL),
(72, 1, 'ADMIN_STATUS_OFFLINE', 'Offline', NULL),
(73, 3, 'ADMIN_STATUS_OFFLINE', 'Offline', NULL),
(76, 1, 'ADMIN_STATUS_EMPTY_GROUP', 'Nothing to show', NULL),
(77, 3, 'ADMIN_STATUS_EMPTY_GROUP', 'Nic do pokazania', NULL),
(78, 1, 'ADMIN_STATUS_EMPTY_STATUS', 'Admin status is empty', NULL),
(79, 3, 'ADMIN_STATUS_EMPTY_STATUS', 'Status administracji jest pusty', NULL),
(80, 1, 'ASSIGNER_PANEL_TITLE', 'Group assigner', NULL),
(81, 3, 'ASSIGNER_PANEL_TITLE', 'Przydzielanie grup', NULL),
(82, 1, 'ASSIGNER_TITLE', 'Group assigner', NULL),
(83, 3, 'ASSIGNER_TITLE', 'Przydzielanie grup', NULL),
(84, 1, 'BANS_EMPTY', 'Banlist is empty', NULL),
(85, 3, 'BANS_EMPTY', 'Lista banów jest pusta', NULL),
(86, 1, 'BANS_TITLE', 'Banlist', NULL),
(87, 3, 'BANS_TITLE', 'Lista banów', NULL),
(88, 1, 'BANS_PANEL_TITLE', 'Banlist', NULL),
(89, 3, 'BANS_PANEL_TITLE', 'Lista banów', NULL),
(90, 1, 'BANS_BANNED_ALERT_TITLE', 'Your IP has been banned by {0}', NULL),
(91, 3, 'BANS_BANNED_ALERT_TITLE', 'Twoje IP zostało zbanowane przez {0}', NULL),
(92, 1, 'BANS_BANNED_ALERT_REASON', 'Reason: {0}', NULL),
(93, 3, 'BANS_BANNED_ALERT_REASON', 'Powód: {0}', NULL),
(94, 1, 'BANS_VIEW_MORE_TIP', 'Click on a row to view more details about a ban', NULL),
(95, 3, 'BANS_VIEW_MORE_TIP', 'Kliknij na wiersz by pokazać więcej informacji o banie', NULL),
(96, 1, 'RULES_TITLE', 'Rules', NULL),
(97, 3, 'RULES_TITLE', 'Regulamin', NULL),
(98, 1, 'RULES_PANEL_TITLE', 'Rules', NULL),
(99, 3, 'RULES_PANEL_TITLE', 'Regulamin', NULL),
(100, 1, 'FAQ_COPY_LINK', 'Copy link to that answer', NULL),
(101, 3, 'FAQ_COPY_LINK', 'Kopiuj link do tej odpowiedzi', NULL),
(102, 1, 'FAQ_PANEL_TITLE', 'FAQ', NULL),
(103, 3, 'FAQ_PANEL_TITLE', 'FAQ', NULL),
(104, 1, 'FAQ_TITLE', 'FAQ', NULL),
(105, 3, 'FAQ_TITLE', 'FAQ', NULL),
(106, 1, 'FAQ_COPY_LINK_SUCCESS', 'Copied!', NULL),
(107, 3, 'FAQ_COPY_LINK_SUCCESS', 'Skopiowano!', NULL),
(108, 1, 'FAQ_COPY_LINK_ERROR', 'Error!', NULL),
(109, 3, 'FAQ_COPY_LINK_ERROR', 'Błąd!', NULL),
(110, 1, 'HOME_TITLE', 'News', NULL),
(111, 3, 'HOME_TITLE', 'Aktualności', NULL),
(112, 1, 'HOME_PANEL_TITLE', 'News', NULL),
(113, 3, 'HOME_PANEL_TITLE', 'Aktualności', NULL),
(114, 1, 'HOME_EMPTY', 'No news available at this moment', NULL),
(115, 3, 'HOME_EMPTY', 'Brak atualności', NULL),
(116, 1, 'HOME_INVALID_PAGE', 'Invalid page number', NULL),
(117, 3, 'HOME_INVALID_PAGE', 'Zły numer strony', NULL),
(118, 1, 'HOME_PREVIOUS_NEWS', 'Previous', 'This value is only used by assistive technologies (screen readers ect.)'),
(119, 3, 'HOME_PREVIOUS_NEWS', 'Poprzednia', NULL),
(120, 1, 'HOME_NEXT_NEWS', 'Next', 'This value is only used by assistive technologies (screen readers ect.)'),
(121, 3, 'HOME_NEXT_NEWS', 'Następna', NULL),
(122, 1, 'ADMIN_STATUS_PANEL_TITLE', 'Admin status', NULL),
(123, 3, 'ADMIN_STATUS_PANEL_TITLE', 'Status administracji', NULL),
(124, 1, 'ADMIN_STATUS_HIDE_OFFLINE_TIP', 'Hide offline admins', NULL),
(125, 3, 'ADMIN_STATUS_HIDE_OFFLINE_TIP', 'Ukryj administratorów offline', NULL),
(126, 1, 'ADMIN_STATUS_SHOW_OFFLINE_TIP', 'Show offline admins', NULL),
(127, 3, 'ADMIN_STATUS_SHOW_OFFLINE_TIP', 'Pokaż administratorów offline', NULL),
(128, 1, 'ADMIN_STATUS_ERROR', 'Admin status error', NULL),
(129, 3, 'ADMIN_STATUS_ERROR', 'Błąd statusu administracji', NULL),
(130, 1, 'NAV_TOGGLE', 'Toggle navigation', 'This value is only used by assistive technologies (screen readers ect.)'),
(131, 3, 'NAV_TOGGLE', 'Przełącz nawigację', NULL),
(132, 1, 'NAV_VIEWER', 'Viewer', NULL),
(133, 3, 'NAV_VIEWER', 'Podgląd', NULL),
(134, 1, 'NAV_ASSIGNER', 'Assigner', NULL),
(135, 3, 'NAV_ASSIGNER', 'Grupy', NULL),
(136, 1, 'NAV_BANS', 'Bans', NULL),
(137, 3, 'NAV_BANS', 'Bany', NULL),
(138, 1, 'NAV_RULES', 'Rules', NULL),
(139, 3, 'NAV_RULES', 'Regulamin', NULL),
(140, 1, 'NAV_FAQ', 'FAQ', NULL),
(141, 3, 'NAV_FAQ', 'FAQ', NULL),
(142, 1, 'NAV_ACCOUNT_LOGIN', 'Login', NULL),
(143, 3, 'NAV_ACCOUNT_LOGIN', 'Zaloguj się', NULL),
(144, 1, 'NAV_ACCOUNT_LOGOUT', 'Logout', NULL),
(145, 3, 'NAV_ACCOUNT_LOGOUT', 'Wyloguj się', NULL),
(146, 1, 'VIEWER_TITLE', 'Server viewer', NULL),
(147, 3, 'VIEWER_TITLE', 'Podgląd serwera', NULL),
(148, 1, 'VIEWER_PANEL_TITLE', 'Server viewer', NULL),
(149, 3, 'VIEWER_PANEL_TITLE', 'Podgląd serwera', NULL),
(150, 1, 'VIEWER_SHOW_EMPTY', 'Show empty channels', NULL),
(151, 3, 'VIEWER_SHOW_EMPTY', 'Pokaż puste kanały', NULL),
(152, 1, 'VIEWER_HIDE_EMPTY', 'Hide empty channels', NULL),
(153, 3, 'VIEWER_HIDE_EMPTY', 'Ukryj puste kanały', NULL),
(154, 1, 'VIEWER_TIP_ALERT', 'Click on a channel to join it. Hover over a user to check their info', NULL),
(155, 3, 'VIEWER_TIP_ALERT', 'Kliknij na kanał, by na niego dołączyć. Nakieruj na użytkownika, by sprawdzić informacje o nim', NULL),
(158, 1, 'ARIA_CLOSE', 'Close', 'This value is only used by assistive technologies (screen readers ect.)'),
(159, 3, 'ARIA_CLOSE', 'Zamknij', NULL),
(160, 1, 'VIEWER_ERROR', 'Viewer error', NULL),
(161, 3, 'VIEWER_ERROR', 'Błąd podglądu', NULL),
(162, 1, 'VIEWER_CONNECTION_CONFIRMATION', 'Do you want to connect to this channel?', NULL),
(163, 3, 'VIEWER_CONNECTION_CONFIRMATION', 'Czy chcesz dołączyć na ten kanał?', NULL),
(164, 1, 'VIEWER_CLIENT_LASTACTIVE', 'Last active:', NULL),
(165, 3, 'VIEWER_CLIENT_LASTACTIVE', 'Aktywny:', NULL),
(166, 1, 'VIEWER_CLIENT_ONLINE', 'Online time:', NULL),
(167, 3, 'VIEWER_CLIENT_ONLINE', 'Online przez:', NULL),
(168, 1, 'VIEWER_CLIENT_JOINED', 'First joined:', NULL),
(169, 3, 'VIEWER_CLIENT_JOINED', 'Dołączył:', NULL),
(170, 1, 'VIEWER_CLIENT_TITLE', 'Client info', NULL),
(171, 3, 'VIEWER_CLIENT_TITLE', 'Informacje o kliencie', NULL),
(172, 1, 'VIEWER_SERVER_ICON', 'Server icon', NULL),
(173, 3, 'VIEWER_SERVER_ICON', 'Ikona serwera', NULL),
(174, 1, 'VIEWER_DEFAULT_CHANNEL', 'Default channel', NULL),
(175, 3, 'VIEWER_DEFAULT_CHANNEL', 'Kanał domyślny', NULL),
(176, 1, 'VIEWER_CHANNEL_UNSUB1', ', unsubscribed', 'Please note that this string starts with \", \"'),
(177, 3, 'VIEWER_CHANNEL_UNSUB1', ', odsubskrybowany', NULL),
(178, 1, 'VIEWER_CHANNEL_OCCUPIED', 'Fully occupied', NULL),
(179, 3, 'VIEWER_CHANNEL_OCCUPIED', 'Zajęty', NULL),
(180, 1, 'VIEWER_CHANNEL_PASSWORD', 'Password-protected', NULL),
(181, 3, 'VIEWER_CHANNEL_PASSWORD', 'Zabezpieczony hasłem', NULL),
(182, 1, 'VIEWER_CHANNEL_UNSUB2', 'Unsubscribed', NULL),
(183, 3, 'VIEWER_CHANNEL_UNSUB2', 'Odsubskrybowany', NULL),
(184, 1, 'VIEWER_CHANNEL_ICON', 'Channel icon', NULL),
(185, 3, 'VIEWER_CHANNEL_ICON', 'Ikona kanału', NULL),
(186, 1, 'VIEWER_CHANNEL_MODERATED', 'Moderated', NULL),
(187, 3, 'VIEWER_CHANNEL_MODERATED', 'Moderowany', NULL),
(188, 1, 'VIEWER_CHANNEL_MUSIC_CODED', 'Music codec', NULL),
(189, 3, 'VIEWER_CHANNEL_MUSIC_CODED', 'Kodek muzyczny', NULL),
(190, 1, 'VIEWER_CLIENT_AWAY', 'Away', NULL),
(191, 3, 'VIEWER_CLIENT_AWAY', 'Zaraz wracam', NULL),
(194, 1, 'VIEWER_CLIENT_OUTPUT_DISABLED', 'Sound disabled', NULL),
(195, 3, 'VIEWER_CLIENT_OUTPUT_DISABLED', 'Głos wyłączony', NULL),
(196, 1, 'VIEWER_CLIENT_OUTPUT_MUTED', 'Deafened', NULL),
(197, 3, 'VIEWER_CLIENT_OUTPUT_MUTED', 'Głos wyciszony', NULL),
(198, 1, 'VIEWER_CLIENT_MIC_DISABLED', 'Microphone disabled', NULL),
(199, 3, 'VIEWER_CLIENT_MIC_DISABLED', 'Mikrofon wyłączony', NULL),
(200, 1, 'VIEWER_CLIENT_MIC_MUTED', 'Muted', NULL),
(201, 3, 'VIEWER_CLIENT_MIC_MUTED', 'Mikrofon wyciszony', NULL),
(202, 1, 'VIEWER_CLIENT_COMMANDER', 'Channel commander', NULL),
(203, 3, 'VIEWER_CLIENT_COMMANDER', 'Dowódca kanału', NULL),
(204, 1, 'VIEWER_CLIENT_ICON', 'Client icon', NULL),
(205, 3, 'VIEWER_CLIENT_ICON', 'Ikona klienta', NULL),
(206, 1, 'VIEWER_CLIENT_PRIORITY_SPEAKER', 'Priority speaker', NULL),
(207, 3, 'VIEWER_CLIENT_PRIORITY_SPEAKER', 'Mówca priorytetowy', NULL),
(208, 1, 'VIEWER_CLIENT_TALK_POWER_GRANTED', 'Talk power granted', NULL),
(209, 3, 'VIEWER_CLIENT_TALK_POWER_GRANTED', 'Moc konwersacji przyznana', NULL),
(210, 1, 'VIEWER_CLIENT_TALK_POWER_INSUFFICIENT', 'Insufficient talk power', NULL),
(211, 3, 'VIEWER_CLIENT_TALK_POWER_INSUFFICIENT', 'Niewystarczająca moc konwersacji', NULL),
(212, 1, 'ASSIGNER_NOT_LOGGED_IN', 'Log in before using group assigner', NULL),
(213, 3, 'ASSIGNER_NOT_LOGGED_IN', 'Zaloguj się przed przydzielaniem grup', NULL),
(214, 1, 'ASSIGNER_LOGIN_BUTTON', 'Login', NULL),
(215, 3, 'ASSIGNER_LOGIN_BUTTON', 'Zaloguj się', NULL),
(216, 1, 'ASSIGNER_SAVE_BUTTON', 'Save', NULL),
(217, 3, 'ASSIGNER_SAVE_BUTTON', 'Zapisz', NULL),
(218, 1, 'ASSIGNER_INVALID_GROUPS', 'Invalid group settings', NULL),
(219, 3, 'ASSIGNER_INVALID_GROUPS', 'Nieprawidłowe ustawienia grup', NULL),
(220, 1, 'ASSIGNER_NOT_CONFIGURED', 'Group assigner is not configured by the website administrator', NULL),
(221, 3, 'ASSIGNER_NOT_CONFIGURED', 'Przydzielanie grup nie jest skonfigurowane przez administratora strony', NULL),
(222, 1, 'ASSIGNER_SAVE_SUCCESS', 'Your groups have been updated', NULL),
(223, 3, 'ASSIGNER_SAVE_SUCCESS', 'Twoje grupy zostały zaktualizowane', NULL),
(224, 1, 'ASSIGNER_SAVE_ERROR', 'Group change error', NULL),
(225, 3, 'ASSIGNER_SAVE_ERROR', 'Błąd zmiany grup', NULL),
(226, 1, 'ASSIGNER_SAVE_NO_CHANGE', 'No changes has been made', NULL),
(227, 3, 'ASSIGNER_SAVE_NO_CHANGE', 'Nie wprowadzono żadnych zmian', NULL);


ALTER TABLE `tsw_config`
  ADD UNIQUE KEY `param` (`identifier`);

ALTER TABLE `tsw_faq`
  ADD PRIMARY KEY (`faqid`);

ALTER TABLE `tsw_languages`
  ADD PRIMARY KEY (`langid`);

ALTER TABLE `tsw_news`
  ADD PRIMARY KEY (`newsid`);

ALTER TABLE `tsw_translations`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `tsw_faq`
  MODIFY `faqid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `tsw_languages`
  MODIFY `langid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `tsw_news`
  MODIFY `newsid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `tsw_translations`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=228;
COMMIT;
