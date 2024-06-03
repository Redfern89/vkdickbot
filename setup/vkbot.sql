-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июн 03 2024 г., 14:20
-- Версия сервера: 8.0.36-0ubuntu0.22.04.1
-- Версия PHP: 8.1.2-1ubuntu2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `vkbot`
--

-- --------------------------------------------------------

--
-- Структура таблицы `dicks`
--

CREATE TABLE `dicks` (
  `id` int UNSIGNED NOT NULL,
  `vkid` int UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `nick_name` varchar(255) DEFAULT NULL,
  `icon` int UNSIGNED NOT NULL,
  `peer_id` int NOT NULL,
  `len` int NOT NULL,
  `last_metr` int NOT NULL,
  `metr_available` int DEFAULT NULL,
  `photo_50` varchar(1000) DEFAULT NULL,
  `photo_100` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `photo_200` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `dicks_stats`
--

CREATE TABLE `dicks_stats` (
  `id` int UNSIGNED NOT NULL,
  `vkid` int UNSIGNED NOT NULL,
  `peer_id` int NOT NULL,
  `len` int NOT NULL,
  `val` int NOT NULL,
  `date` int NOT NULL,
  `act` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `dick_names`
--

CREATE TABLE `dick_names` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `dick_names`
--

INSERT INTO `dick_names` (`id`, `name`) VALUES
(1, 'член'),
(2, 'писюлек'),
(3, 'Пипин Короткий'),
(4, 'пожилой Валера'),
(5, 'змей горыныч'),
(6, 'Джеки Чан'),
(7, 'причендал'),
(8, 'пиструн'),
(9, 'конь'),
(10, 'жизненно важный орган'),
(11, 'удав'),
(12, 'питон'),
(13, 'дрын'),
(14, 'пиструкан'),
(15, 'одноглазый змей'),
(16, 'шалун'),
(17, 'членик'),
(18, 'стручок'),
(19, 'отросток'),
(20, 'магнум'),
(21, 'пупсик'),
(22, 'писюн'),
(23, 'Капитан Крюк'),
(24, 'малыш'),
(25, 'пипидастр'),
(26, 'горец'),
(27, 'агрегат'),
(28, 'поршень'),
(29, 'шланг'),
(30, 'пипитр'),
(31, 'коршун'),
(32, 'энерджайзер'),
(33, 'петушок');

-- --------------------------------------------------------

--
-- Структура таблицы `globals`
--

CREATE TABLE `globals` (
  `id` int UNSIGNED NOT NULL,
  `param` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `globals`
--

INSERT INTO `globals` (`id`, `param`, `value`) VALUES
(1, 'dick_len_rnd_min', '1'),
(2, 'dick_len_rnd_max', '10'),
(3, 'def_dick_len', '10'),
(4, 'time_rnd_min', '1'),
(5, 'time_rnd_max', '10800'),
(6, 'top_count', '10'),
(7, 'bonus_dick_len', '20'),
(8, 'peer_probe_start', '1'),
(9, 'peer_probe_end', '15'),
(10, 'cron_work', 'false'),
(11, 'vkapi_access_token', 'vk1.a.R_FDJAlI5GOW3pNpUsrQfVps-WndrsKs8-0PuMspbsEuKhb3fTlgOpd-lg4XStsYZS-qy4y4vECQzaazzHPJeUHEzLuSbjP-b1wu1lCQbr-Wd1Svk8BQCEJaFOnssbtz5sfdBlaSlkT654-E9X-wDptj_EYNaAcC_C7BaLCIaSSKRvhbIfWhPJfgjF-Gll_mobPJFXcBlxwG1NS4dH9PMQ'),
(12, 'vkapi_version', '5.131'),
(13, 'vkapi_secret_key', 'kCFdl8UpZwGdvc5VbqXApf3qpeHicf2A'),
(14, 'vkapi_confirmation_token', '91c473be'),
(15, 'admin_id', '220887949'),
(16, 'start_luck_cnt', '5'),
(17, 'stat_graph_cnt', '40'),
(18, 'graph_w', '1250'),
(19, 'graph_h', '671'),
(20, 'graph_bg_start', '3014929'),
(21, 'graph_bg_end', '0'),
(22, 'graph_frame_color', '8224125'),
(23, 'graph_x_lines_cnt', '30'),
(24, 'graph_x_labels_cnt', '10'),
(25, 'graph_y_lines_cnt', '10'),
(26, 'graph_title_font_size', '60'),
(27, 'graph_font', '/var/www/scyk.ru/html/ARIAL.TTF'),
(28, 'graph_font_size', '12'),
(29, 'graph_text_color', '16777215'),
(30, 'graph_line_color', '16711680'),
(31, 'bot_cmd', '!метр'),
(32, 'photo_top_count', '5'),
(33, 'photo_top_font_size', '12'),
(34, 'photo_top_size', '100'),
(35, 'small_dick_len', '30');

-- --------------------------------------------------------

--
-- Структура таблицы `icons`
--

CREATE TABLE `icons` (
  `id` int UNSIGNED NOT NULL,
  `data` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `icons`
--

INSERT INTO `icons` (`id`, `data`) VALUES
(1, '😊'),
(2, '😃'),
(3, '😉'),
(4, '😆'),
(5, '😜'),
(6, '😋'),
(7, '😍'),
(8, '😎'),
(9, '😒'),
(10, '😏'),
(11, '😔'),
(12, '😢'),
(13, '😭'),
(14, '😩'),
(15, '😨'),
(16, '😐'),
(17, '😌'),
(18, '😄'),
(19, '😇'),
(20, '😰'),
(21, '😲'),
(22, '😳'),
(23, '😷'),
(24, '😂'),
(25, '❤'),
(26, '😚'),
(27, '😕'),
(28, '😯'),
(29, '😦'),
(30, '😵'),
(31, '😠'),
(32, '😡'),
(33, '😝'),
(34, '😴'),
(35, '😘'),
(36, '😟'),
(37, '😬'),
(38, '😶'),
(39, '😪'),
(40, '😫'),
(41, '☺'),
(42, '😀'),
(43, '😥'),
(44, '😛'),
(45, '😖'),
(46, '😤'),
(47, '😣'),
(48, '😧'),
(49, '😑'),
(50, '😅'),
(51, '😮'),
(52, '😞'),
(53, '😙'),
(54, '😓'),
(55, '😁'),
(56, '😱'),
(57, '😈'),
(58, '👿'),
(59, '👽'),
(60, '👍'),
(61, '👎'),
(62, '☝'),
(63, '✌'),
(64, '👌'),
(65, '👏'),
(66, '👊'),
(67, '✋'),
(68, '🙏'),
(69, '👃'),
(70, '👆'),
(71, '👇'),
(72, '👈'),
(73, '💪'),
(74, '👂'),
(75, '💋'),
(76, '💩'),
(77, '❄'),
(78, '🍊'),
(79, '🍷'),
(80, '🍸'),
(81, '🎅'),
(82, '💦'),
(83, '👺'),
(84, '🐨'),
(85, '🔞'),
(86, '👹'),
(87, '⚽'),
(88, '⛅'),
(89, '🌟'),
(90, '🍌'),
(91, '🍺'),
(92, '🍻'),
(93, '🌹'),
(94, '🍅'),
(95, '🍒'),
(96, '🎁'),
(97, '🎂'),
(98, '🎄'),
(99, '🏁'),
(100, '🏆'),
(101, '🐎'),
(102, '🐏'),
(103, '🐜'),
(104, '🐫'),
(105, '🐮'),
(106, '🐃'),
(107, '🐻'),
(108, '🐼'),
(109, '🐅'),
(110, '🐓'),
(111, '🐘'),
(112, '💔'),
(113, '💭'),
(114, '🐶'),
(115, '🐱'),
(116, '🐷'),
(117, '🐑'),
(118, '⏳'),
(119, '⚾'),
(120, '⛄'),
(121, '☀'),
(122, '🌺'),
(123, '🌻'),
(124, '🌼'),
(125, '🌽'),
(126, '🍋'),
(127, '🍍'),
(128, '🍎'),
(129, '🍏'),
(130, '🍭'),
(131, '🌷'),
(132, '🌸'),
(133, '🍆'),
(134, '🍉'),
(135, '🍐'),
(136, '🍑'),
(137, '🍓'),
(138, '🍔'),
(139, '🍕'),
(140, '🍖'),
(141, '🍗'),
(142, '🍩'),
(143, '🎃'),
(144, '🎪'),
(145, '🎱'),
(146, '🎲'),
(147, '🎷'),
(148, '🎸'),
(149, '🎾'),
(150, '🏀'),
(151, '🏦'),
(152, '😸'),
(153, '😹'),
(154, '😼'),
(155, '😽'),
(156, '😾'),
(157, '😿'),
(158, '😻'),
(159, '🙀'),
(160, '😺'),
(161, '⏰'),
(162, '☁'),
(163, '☎'),
(164, '☕'),
(165, '♻'),
(166, '⚠'),
(167, '⚡'),
(168, '⛔'),
(169, '⛪'),
(170, '⛳'),
(171, '⛵'),
(172, '⛽'),
(173, '✂'),
(174, '✈'),
(175, '✉'),
(176, '✊'),
(177, '✏'),
(178, '✒'),
(179, '✨'),
(180, '🀄'),
(181, '🃏'),
(182, '🆘'),
(183, '🌂'),
(184, '🌍'),
(185, '🌛'),
(186, '🌝'),
(187, '🌞'),
(188, '🌰'),
(189, '🌱'),
(190, '🌲'),
(191, '🌳'),
(192, '🌴'),
(193, '🌵'),
(194, '🌾'),
(195, '🌿'),
(196, '🍀'),
(197, '🍁'),
(198, '🍂'),
(199, '🍃'),
(200, '🍄'),
(201, '🍇'),
(202, '🍈'),
(203, '🍚'),
(204, '🍛'),
(205, '🍜'),
(206, '🍝'),
(207, '🍞'),
(208, '🍟'),
(209, '🍠'),
(210, '🍡'),
(211, '🍢'),
(212, '🍣'),
(213, '🍤'),
(214, '🍥'),
(215, '🍦'),
(216, '🍧'),
(217, '🍨'),
(218, '🍪'),
(219, '🍫'),
(220, '🍬'),
(221, '🍮'),
(222, '🍯'),
(223, '🍰'),
(224, '🍱'),
(225, '🍲'),
(226, '🍳'),
(227, '🍴'),
(228, '🍵'),
(229, '🍶'),
(230, '🍹'),
(231, '🍼'),
(232, '🎀'),
(233, '🎈'),
(234, '🎉'),
(235, '🎊'),
(236, '🎋'),
(237, '🎌'),
(238, '🎍'),
(239, '🎎'),
(240, '🎏'),
(241, '🎐'),
(242, '🎒'),
(243, '🎓'),
(244, '🎣'),
(245, '🎤'),
(246, '🎧'),
(247, '🎨'),
(248, '🎩'),
(249, '🎫'),
(250, '🎬'),
(251, '🎭'),
(252, '🎯'),
(253, '🎰'),
(254, '🎳'),
(255, '🎴'),
(256, '🎹'),
(257, '🎺'),
(258, '🎻'),
(259, '🎽'),
(260, '🎿'),
(261, '🏂'),
(262, '🏃'),
(263, '🏄'),
(264, '🏇'),
(265, '🏈'),
(266, '🏉'),
(267, '🏊'),
(268, '🐀'),
(269, '🐁'),
(270, '🐂'),
(271, '🐄'),
(272, '🐆'),
(273, '🐇'),
(274, '🐈'),
(275, '🐉'),
(276, '🐊'),
(277, '🐋'),
(278, '🐌'),
(279, '🐍'),
(280, '🐐'),
(281, '🐒'),
(282, '🐔'),
(283, '🐕'),
(284, '🐖'),
(285, '🐗'),
(286, '🐙'),
(287, '🐚'),
(288, '🐛'),
(289, '🐝'),
(290, '🐞'),
(291, '🐟'),
(292, '🐠'),
(293, '🐡'),
(294, '🐢'),
(295, '🐣'),
(296, '🐤'),
(297, '🐥'),
(298, '🐦'),
(299, '🐧'),
(300, '🐩'),
(301, '🐪'),
(302, '🐬'),
(303, '🐭'),
(304, '🐯'),
(305, '🐰'),
(306, '🐲'),
(307, '🐳'),
(308, '🐴'),
(309, '🐵'),
(310, '🐸'),
(311, '🐹'),
(312, '🐺'),
(313, '🐽'),
(314, '🐾'),
(315, '👀'),
(316, '👄'),
(317, '👅'),
(318, '👋'),
(319, '👐'),
(320, '👑'),
(321, '👒'),
(322, '👓'),
(323, '👔'),
(324, '👕'),
(325, '👖'),
(326, '👗'),
(327, '👘'),
(328, '👙'),
(329, '👚'),
(330, '👛'),
(331, '👜'),
(332, '👝'),
(333, '👞'),
(334, '👟'),
(335, '👠'),
(336, '👡'),
(337, '👢'),
(338, '👣'),
(339, '👦'),
(340, '👧'),
(341, '👨'),
(342, '👩'),
(343, '👪'),
(344, '👫'),
(345, '👬'),
(346, '👭'),
(347, '👮'),
(348, '👯'),
(349, '👰'),
(350, '👱'),
(351, '👲'),
(352, '👳'),
(353, '👴'),
(354, '👵'),
(355, '👶'),
(356, '👷'),
(357, '👸'),
(358, '👻'),
(359, '👼'),
(360, '👾'),
(361, '💀'),
(362, '💁'),
(363, '💂'),
(364, '💃'),
(365, '💄'),
(366, '💅'),
(367, '💆'),
(368, '💇'),
(369, '💈'),
(370, '💉'),
(371, '💊'),
(372, '💌'),
(373, '💍'),
(374, '💎'),
(375, '💏'),
(376, '💐'),
(377, '💑'),
(378, '💒'),
(379, '💓'),
(380, '💕'),
(381, '💖'),
(382, '💗'),
(383, '💘'),
(384, '💙'),
(385, '💚'),
(386, '💛'),
(387, '💜'),
(388, '💝'),
(389, '💞'),
(390, '💟'),
(391, '💡'),
(392, '💣'),
(393, '💥'),
(394, '💧'),
(395, '💨'),
(396, '💬'),
(397, '💰'),
(398, '💳'),
(399, '💴'),
(400, '💵'),
(401, '💶'),
(402, '💷'),
(403, '💸'),
(404, '💺'),
(405, '💻'),
(406, '💼'),
(407, '💽'),
(408, '💾'),
(409, '💿'),
(410, '📄'),
(411, '📅'),
(412, '📇'),
(413, '📈'),
(414, '📉'),
(415, '📊'),
(416, '📋'),
(417, '📌'),
(418, '📍'),
(419, '📎'),
(420, '📐'),
(421, '📑'),
(422, '📒'),
(423, '📓'),
(424, '📔'),
(425, '📕'),
(426, '📖'),
(427, '📗'),
(428, '📘'),
(429, '📙'),
(430, '📚'),
(431, '📜'),
(432, '📝'),
(433, '📟'),
(434, '📠'),
(435, '📡'),
(436, '📢'),
(437, '📦'),
(438, '📭'),
(439, '📮'),
(440, '📯'),
(441, '📰'),
(442, '📱'),
(443, '📷'),
(444, '📹'),
(445, '📺'),
(446, '📻'),
(447, '📼'),
(448, '🔆'),
(449, '🔎'),
(450, '🔑'),
(451, '🔔'),
(452, '🔖'),
(453, '🔥'),
(454, '🔦'),
(455, '🔧'),
(456, '🔨'),
(457, '🔩'),
(458, '🔪'),
(459, '🔫'),
(460, '🔬'),
(461, '🔭'),
(462, '🔮'),
(463, '🔱'),
(464, '🗿'),
(465, '🙅'),
(466, '🙆'),
(467, '🙇'),
(468, '🙈'),
(469, '🙉'),
(470, '🙊'),
(471, '🙋'),
(472, '🙌'),
(473, '🙎'),
(474, '🚀'),
(475, '🚁'),
(476, '🚂'),
(477, '🚃'),
(478, '🚄'),
(479, '🚅'),
(480, '🚆'),
(481, '🚇'),
(482, '🚈'),
(483, '🚊'),
(484, '🚌'),
(485, '🚍'),
(486, '🚎'),
(487, '🚏'),
(488, '🚐'),
(489, '🚑'),
(490, '🚒'),
(491, '🚓'),
(492, '🚔'),
(493, '🚕'),
(494, '🚖'),
(495, '🚗'),
(496, '🚘'),
(497, '🚙'),
(498, '🚚'),
(499, '🚛'),
(500, '🚜'),
(501, '🚝'),
(502, '🚞'),
(503, '🚟'),
(504, '🚠'),
(505, '🚡'),
(506, '🚣'),
(507, '🚤'),
(508, '🚧'),
(509, '🚨'),
(510, '🚪'),
(511, '🚬'),
(512, '🚴'),
(513, '🚵'),
(514, '🚶'),
(515, '🚽'),
(516, '🚿'),
(517, '🛀'),
(518, '🇨🇳'),
(519, '🇩🇪'),
(520, '🇪🇸'),
(521, '🇫🇷'),
(522, '🇬🇧'),
(523, '🇮🇹'),
(524, '🇯🇵'),
(525, '🇰🇷'),
(526, '🇷🇺'),
(527, '🇺🇸'),
(528, '🇺🇦'),
(529, '🇦🇪'),
(530, '🇦🇹'),
(531, '🇦🇺'),
(532, '🇧🇪'),
(533, '🇧🇷'),
(534, '🇨🇦'),
(535, '🇨🇭'),
(536, '🇨🇱'),
(537, '🇨🇴'),
(538, '🇩🇰'),
(539, '🇫🇮'),
(540, '🇭🇰'),
(541, '🇮🇩'),
(542, '🇮🇪'),
(543, '🇮🇳'),
(544, '🇲🇴'),
(545, '🇲🇽'),
(546, '🇲🇾'),
(547, '🇳🇱'),
(548, '🇳🇴'),
(549, '🇳🇿'),
(550, '🇵🇭'),
(551, '🇵🇱'),
(552, '🇵🇷'),
(553, '🇵🇹'),
(554, '🇸🇦'),
(555, '🇸🇪'),
(556, '🇸🇬'),
(557, '🇻🇳'),
(558, '🇿🇦'),
(559, '🇰🇿'),
(560, '🇧🇾'),
(561, '🇮🇱'),
(562, '🇹🇷'),
(563, '‼'),
(564, '⁉'),
(565, 'ℹ'),
(566, '↔'),
(567, '↕'),
(568, '↖'),
(569, '↗'),
(570, '↘'),
(571, '↙'),
(572, '↩'),
(573, '↪'),
(574, '⌚'),
(575, '⌛'),
(576, '⏩'),
(577, '⏪'),
(578, '⏫'),
(579, '⏬'),
(580, 'Ⓜ'),
(581, '▪'),
(582, '▫'),
(583, '▶'),
(584, '◀'),
(585, '◻'),
(586, '◼'),
(587, '◽'),
(588, '◾'),
(589, '☑'),
(590, '☔'),
(591, '♈'),
(592, '♉'),
(593, '♊'),
(594, '♋'),
(595, '♌'),
(596, '♍'),
(597, '♎'),
(598, '♏'),
(599, '♐'),
(600, '♑'),
(601, '♒'),
(602, '♓'),
(603, '♠'),
(604, '♣'),
(605, '♥'),
(606, '♦'),
(607, '♨'),
(608, '♿'),
(609, '⚓'),
(610, '⚪'),
(611, '⚫'),
(612, '⛎'),
(613, '⛲'),
(614, '⛺'),
(615, '✅'),
(616, '✔'),
(617, '✖'),
(618, '✳'),
(619, '✴'),
(620, '❇'),
(621, '❌'),
(622, '❎'),
(623, '❓'),
(624, '❔'),
(625, '❕'),
(626, '❗'),
(627, '➕'),
(628, '➖'),
(629, '➗'),
(630, '➡'),
(631, '➰'),
(632, '➿'),
(633, '⤴'),
(634, '⤵'),
(635, '⬅'),
(636, '⬆'),
(637, '⬇'),
(638, '⬛'),
(639, '⬜'),
(640, '⭐'),
(641, '⭕'),
(642, '〰'),
(643, '〽'),
(644, '🅰'),
(645, '🅱'),
(646, '🅾'),
(647, '🅿'),
(648, '🆎'),
(649, '🆑'),
(650, '🆒'),
(651, '🆓'),
(652, '🆔'),
(653, '🆕'),
(654, '🆖'),
(655, '🆗'),
(656, '🆙'),
(657, '🆚'),
(658, '🈁'),
(659, '🌀'),
(660, '🌁'),
(661, '🌃'),
(662, '🌄'),
(663, '🌅'),
(664, '🌆'),
(665, '🌇'),
(666, '🌈'),
(667, '🌉'),
(668, '🌊'),
(669, '🌋'),
(670, '🌌'),
(671, '🌎'),
(672, '🌏'),
(673, '🌐'),
(674, '🌑'),
(675, '🌒'),
(676, '🌓'),
(677, '🌔'),
(678, '🌕'),
(679, '🌖'),
(680, '🌗'),
(681, '🌘'),
(682, '🌙'),
(683, '🌚'),
(684, '🌜'),
(685, '🌠'),
(686, '🍘'),
(687, '🍙'),
(688, '🎆'),
(689, '🎇'),
(690, '🎑'),
(691, '🎠'),
(692, '🎡'),
(693, '🎢'),
(694, '🎥'),
(695, '🎦'),
(696, '🎮'),
(697, '🎵'),
(698, '🎶'),
(699, '🎼'),
(700, '🏠'),
(701, '🏡'),
(702, '🏢'),
(703, '🏣'),
(704, '🏤'),
(705, '🏥'),
(706, '🏧'),
(707, '🏨'),
(708, '🏩'),
(709, '🏪'),
(710, '🏫'),
(711, '🏬'),
(712, '🏭'),
(713, '🏮'),
(714, '🏯'),
(715, '🏰'),
(716, '👉'),
(717, '👥'),
(718, '💠'),
(719, '💢'),
(720, '💤'),
(721, '💫'),
(722, '💮'),
(723, '💯'),
(724, '💱'),
(725, '💲'),
(726, '💹'),
(727, '📀'),
(728, '📁'),
(729, '📂'),
(730, '📃'),
(731, '📆'),
(732, '📏'),
(733, '📛'),
(734, '📞'),
(735, '📣'),
(736, '📤'),
(737, '📥'),
(738, '📧'),
(739, '📨'),
(740, '📩'),
(741, '📪'),
(742, '📫'),
(743, '📬'),
(744, '📲'),
(745, '📳'),
(746, '📴'),
(747, '📵'),
(748, '📶'),
(749, '🔀'),
(750, '🔁'),
(751, '🔂'),
(752, '🔃'),
(753, '🔄'),
(754, '🔅'),
(755, '🔇'),
(756, '🔈'),
(757, '🔉'),
(758, '🔊'),
(759, '🔋'),
(760, '🔌'),
(761, '🔍'),
(762, '🔏'),
(763, '🔐'),
(764, '🔒'),
(765, '🔓'),
(766, '🔕'),
(767, '🔗'),
(768, '🔘'),
(769, '🔙'),
(770, '🔚'),
(771, '🔛'),
(772, '🔜'),
(773, '🔝'),
(774, '🔟'),
(775, '🔠'),
(776, '🔡'),
(777, '🔢'),
(778, '🔣'),
(779, '🔤'),
(780, '🔯'),
(781, '🔲'),
(782, '🔳'),
(783, '🔴'),
(784, '🔵'),
(785, '🔶'),
(786, '🔷'),
(787, '🔸'),
(788, '🔹'),
(789, '🔺'),
(790, '🔻'),
(791, '🔼'),
(792, '🔽'),
(793, '🗻'),
(794, '🗼'),
(795, '🗽'),
(796, '🗾'),
(797, '😗'),
(798, '🙍'),
(799, '🚉'),
(800, '🚋'),
(801, '🚢'),
(802, '🚥'),
(803, '🚦'),
(804, '🚩'),
(805, '🚫'),
(806, '🚭'),
(807, '🚮'),
(808, '🚯'),
(809, '🚰'),
(810, '🚱'),
(811, '🚲'),
(812, '🚳'),
(813, '🚷'),
(814, '🚸'),
(815, '🚹'),
(816, '🚺'),
(817, '🚻'),
(818, '🚼'),
(819, '🚾'),
(820, '🛁'),
(821, '🛂'),
(822, '🛃'),
(823, '🛄'),
(824, '🛅'),
(825, '⌨'),
(826, '⏭'),
(827, '⏮'),
(828, '⏯'),
(829, '⏱'),
(830, '⏲'),
(831, '⏸'),
(832, '⏹'),
(833, '⏺'),
(834, '☂'),
(835, '☃'),
(836, '☄'),
(837, '☘'),
(838, '☠'),
(839, '☢'),
(840, '☣'),
(841, '☦'),
(842, '☪'),
(843, '☮'),
(844, '☯'),
(845, '☸'),
(846, '☹'),
(847, '⚒'),
(848, '⚔'),
(849, '⚖'),
(850, '⚗'),
(851, '⚙'),
(852, '⚛'),
(853, '⚜'),
(854, '⚰'),
(855, '⚱'),
(856, '⛈'),
(857, '⛏'),
(858, '⛑'),
(859, '⛓'),
(860, '⛩'),
(861, '⛰'),
(862, '⛱'),
(863, '⛴'),
(864, '⛷'),
(865, '⛸'),
(866, '⛹'),
(867, '✍'),
(868, '✝'),
(869, '✡'),
(870, '❣'),
(871, '🌡'),
(872, '🌤'),
(873, '🌥'),
(874, '🌦'),
(875, '🌧'),
(876, '🌨'),
(877, '🌩'),
(878, '🌪'),
(879, '🌫'),
(880, '🌬'),
(881, '🌭'),
(882, '🌮'),
(883, '🌯'),
(884, '🌶'),
(885, '🍽'),
(886, '🍾'),
(887, '🍿'),
(888, '🎖'),
(889, '🎗'),
(890, '🎙'),
(891, '🎚'),
(892, '🎛'),
(893, '🎞'),
(894, '🎟'),
(895, '🏅'),
(896, '🏋🏌'),
(897, '🏍'),
(898, '🏎'),
(899, '🏏'),
(900, '🏐'),
(901, '🏑'),
(902, '🏒'),
(903, '🏓'),
(904, '🏔'),
(905, '🏕'),
(906, '🏖'),
(907, '🏗'),
(908, '🏘'),
(909, '🏙'),
(910, '🏚'),
(911, '🏛'),
(912, '🏜'),
(913, '🏝'),
(914, '🏞'),
(915, '🏟'),
(916, '🏳'),
(917, '🏴'),
(918, '🏵'),
(919, '🏷'),
(920, '🏸'),
(921, '🏹'),
(922, '🏺'),
(923, '🐿'),
(924, '👁'),
(925, '📸'),
(926, '📽'),
(927, '📿'),
(928, '🕉'),
(929, '🕊'),
(930, '🕋'),
(931, '🕌'),
(932, '🕍'),
(933, '🕎'),
(934, '🕯'),
(935, '🕰'),
(936, '🕳'),
(937, '🕴'),
(938, '🕵'),
(939, '🕶'),
(940, '🕷'),
(941, '🕸'),
(942, '🕹'),
(943, '🖇'),
(944, '🖊'),
(945, '🖋'),
(946, '🖌'),
(947, '🖍'),
(948, '🖐'),
(949, '🖖'),
(950, '🖥'),
(951, '🖨'),
(952, '🖱'),
(953, '🖲'),
(954, '🖼'),
(955, '🗂'),
(956, '🗃'),
(957, '🗄'),
(958, '🗑'),
(959, '🗒'),
(960, '🗓'),
(961, '🗜'),
(962, '🗝'),
(963, '🗞'),
(964, '🗡'),
(965, '🗣'),
(966, '🗯'),
(967, '🗳'),
(968, '🗺'),
(969, '🙁'),
(970, '🙂'),
(971, '🙃'),
(972, '🙄'),
(973, '🛋'),
(974, '🛌'),
(975, '🛍'),
(976, '🛎'),
(977, '🛏'),
(978, '🛐'),
(979, '🛠'),
(980, '🛡'),
(981, '🛢'),
(982, '🛣'),
(983, '🛤'),
(984, '🛥'),
(985, '🛩'),
(986, '🛫'),
(987, '🛬'),
(988, '🛰'),
(989, '🛳'),
(990, '🤐'),
(991, '🤑'),
(992, '🤒'),
(993, '🤓'),
(994, '🤔'),
(995, '🤕'),
(996, '🤖'),
(997, '🤗'),
(998, '🤘'),
(999, '🦀'),
(1000, '🦁'),
(1001, '🦂'),
(1002, '🦃'),
(1003, '🦄'),
(1004, '🧀'),
(1005, '🗨'),
(1006, '👁‍🗨'),
(1007, '㊗'),
(1008, '㊙'),
(1009, '🈂'),
(1010, '🈚'),
(1011, '🈯'),
(1012, '🈲'),
(1013, '🈳'),
(1014, '🈴'),
(1015, '🈵'),
(1016, '🈶'),
(1017, '🈷'),
(1018, '🈸'),
(1019, '🈹'),
(1020, '🈺'),
(1021, '🉐'),
(1022, '🉑'),
(1023, '🕐'),
(1024, '🕑'),
(1025, '🕒'),
(1026, '🕓'),
(1027, '🕔'),
(1028, '🕕'),
(1029, '🕖'),
(1030, '🕗'),
(1031, '🕘'),
(1032, '🕙'),
(1033, '🕚'),
(1034, '🕛'),
(1035, '🕜'),
(1036, '🕝'),
(1037, '🕞'),
(1038, '🕟'),
(1039, '🕠'),
(1040, '🕡'),
(1041, '🕢'),
(1042, '🕣'),
(1043, '🕤'),
(1044, '🕥'),
(1045, '🕦'),
(1046, '🕧'),
(1047, '🔰');

-- --------------------------------------------------------

--
-- Структура таблицы `peers`
--

CREATE TABLE `peers` (
  `id` int UNSIGNED NOT NULL,
  `peer_id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `small_dick_names`
--

CREATE TABLE `small_dick_names` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `small_dick_names`
--

INSERT INTO `small_dick_names` (`id`, `name`) VALUES
(1, 'писюлек'),
(2, 'Пипин Короткий'),
(3, 'членик'),
(4, 'стручок'),
(5, 'отросток'),
(6, 'пупсик'),
(7, 'малыш'),
(8, 'петушок');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `dicks`
--
ALTER TABLE `dicks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vkid` (`vkid`),
  ADD KEY `peer_id` (`peer_id`),
  ADD KEY `icon` (`icon`);

--
-- Индексы таблицы `dicks_stats`
--
ALTER TABLE `dicks_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peer_id` (`peer_id`);

--
-- Индексы таблицы `dick_names`
--
ALTER TABLE `dick_names`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `globals`
--
ALTER TABLE `globals`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `icons`
--
ALTER TABLE `icons`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `peers`
--
ALTER TABLE `peers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peer_id` (`peer_id`);

--
-- Индексы таблицы `small_dick_names`
--
ALTER TABLE `small_dick_names`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `dicks`
--
ALTER TABLE `dicks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dicks_stats`
--
ALTER TABLE `dicks_stats`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dick_names`
--
ALTER TABLE `dick_names`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблицы `globals`
--
ALTER TABLE `globals`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT для таблицы `icons`
--
ALTER TABLE `icons`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1048;

--
-- AUTO_INCREMENT для таблицы `peers`
--
ALTER TABLE `peers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `small_dick_names`
--
ALTER TABLE `small_dick_names`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
