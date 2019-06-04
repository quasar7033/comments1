-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 30 2019 г., 14:20
-- Версия сервера: 5.6.38
-- Версия PHP: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `comments1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `all_comments`
--

CREATE TABLE `all_comments` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `path` text NOT NULL,
  `name` varchar(50) NOT NULL,
  `e_mail` varchar(50) NOT NULL,
  `home_page` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `ip` text NOT NULL,
  `brouser` text NOT NULL,
  `img_type` varchar(8) NOT NULL,
  `c_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `all_comments`
--

INSERT INTO `all_comments` (`id`, `parent_id`, `path`, `name`, `e_mail`, `home_page`, `text`, `ip`, `brouser`, `img_type`, `c_date`) VALUES
(43, 0, '0', 'name1', 'qwerty1@mail.ru', '', '<i>Comment1</i>', '127.0.0.1', 'Google Chrome', 'png', '2019-05-29 14:03:58'),
(44, 43, '1', 'name2', 'qwerty2@mail.ru', 'https://ru.stackoverflow.com/questions/183063/%D0%', '<i>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci aliquid architecto assumenda, blanditiis consequatur, delectus ducimus esse, fugiat labore officiis optio repudiandae saepe similique velit vitae voluptate voluptatem voluptates.</i>', '127.0.0.1', 'Google Chrome', 'txt', '2019-05-29 14:04:47'),
(45, 43, '1.1', 'name1', 'qwerty1@mail.ru', '', '<code>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci aliquid architecto assumenda, blanditiis consequatur, delectus ducimus esse, fugiat labore officiis optio repudiandae saepe similique velit vitae voluptate voluptatem voluptates.</code>', '127.0.0.1', 'Google Chrome', '', '2019-05-29 14:06:28'),
(46, 0, '0', 'name45', 'qwerty@mail.ru', 'https://www.google.com', '<strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci aliquid architecto assumenda, blanditiis consequatur, delectus ducimus esse, fugiat labore officiis optio repudiandae saepe similique velit vitae voluptate voluptatem voluptates.</strong>\r<br><a href=\"#\" title=\"google\">google</a> ', '127.0.0.1', 'Google Chrome', '', '2019-05-29 14:07:51'),
(47, 43, '1.1.1', 'name8', 'qwerty8@mail.ru', '', '<code>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci aliquid architecto assumenda, blanditiis consequatur, delectus ducimus esse, fugiat labore officiis optio repudiandae saepe similique velit vitae voluptate voluptatem voluptates.</code>', '127.0.0.1', 'Google Chrome', 'txt', '2019-05-29 14:09:46'),
(48, 43, '1.2', 'name3', 'qwerty3@mail.ru', '', '<strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci aliquid architecto assumenda, blanditiis consequatur, delectus ducimus esse, fugiat labore officiis optio repudiandae saepe similique velit vitae voluptate voluptatem voluptates. </strong>', '127.0.0.1', 'Google Chrome', '', '2019-05-29 14:10:34');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `all_comments`
--
ALTER TABLE `all_comments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `all_comments`
--
ALTER TABLE `all_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
