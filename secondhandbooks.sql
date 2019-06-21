-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2019-05-28 10:08:52
-- 服务器版本： 10.1.35-MariaDB
-- PHP 版本： 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `secondhandbooks`
--
/*CREATE DATABASE secondhandbooks;*/
-- --------------------------------------------------------


--
-- 表的结构 `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `ma_name` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `sell_price` varchar(128) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `type` varchar(128) NOT NULL,
  `remark` text,
  `sold` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `materials`( `id`,`ma_name`,`image`,`sell_price`,
  `seller_id`,`type`,`remark`,`sold`) VALUES
(1,'2019考研英语拆分与组合翻译法','资料图1.png','￥15,00',1,'英语','全新无笔记，可小刀',1),
(2,'2010考研中医综合240分之路','资料图2.png','￥27.00',2,'医学','时间较早，但是很新',1),
(3,'肖秀荣考研政治强化三件套2018','资料图3.png','￥30.00',1,'政治','2018年政治、未写',1),
(4,'思想政治理论基础强化2000题','资料图4.png','￥17.60',1,'政治','全新',1),
(5,'考研政治考点全解真题精讲','资料图5.png','￥22.60',1,'政治','有少量笔记',1),
(6,'新编考研英语阅读理解150篇','资料图6.png','￥22.00',3,'英语','全新',1),
(7,'考研英语阅读150篇','资料图7.png','￥5.00',3,'英语','全新',1),
(8,'新东方考研英语写作宝典','资料图8.png','￥5.00',3,'英语','有笔记',1);
-- --------------------------------------------------------

--
-- 表的结构 `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `buyer_name` varchar(128) NOT NULL,
  `ma_id` int(11) NOT NULL,
  `content` text,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `message`( `id`,`buyer_id`,`buyer_name`,`ma_id`,`content`,`date`) VALUES
(1,2,'Box',3,'书比较新，买家也很好','2019-06-20'),
(2,2,'Box',7,'','2019-06-20'),
(3,2,'Box',8,'总体不错','2019-06-20');
-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `ma_id` int(11) NOT NULL,
  `ma_name` varchar(128) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `seller_name` varchar(128) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `image` varchar(128) NOT NULL,
  `sell_price` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `orders`( `id`,`ma_id`,`ma_name`,`seller_id`,
  `seller_name`,`buyer_id`,`image`,`sell_price`) VALUES
(1,3,'肖秀荣考研政治强化三件套2018',1,'Hyuk',2,'资料图3.png','￥30.00'),
(2,7,'考研英语阅读150篇',3,'www',2,'资料图7.png','￥5.00'),
(3,8,'新东方考研英语写作宝典',3,'www',2,'资料图8.png','￥5.00');
-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_name` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `user_email` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user`( `id`,`user_name`,`password`,`user_email`) VALUES
(1,'Hyuk','$2y$10$s5O30tmFCqd9ouGd25K6lOtFBbJIAdyhfzBXtiVu/vfw0YLhrBPpy','952858008@qq.com'),
(2,'Box','$2y$10$s5O30tmFCqd9ouGd25K6lOtFBbJIAdyhfzBXtiVu/vfw0YLhrBPpy','123452345@163.com'),
(3,'www','$2y$10$s5O30tmFCqd9ouGd25K6lOtFBbJIAdyhfzBXtiVu/vfw0YLhrBPpy','543214321@qq.com');
--
-- 转储表的索引
--

--
-- 表的索引 `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- 表的索引 `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `ma_id` (`ma_id`);

--
-- 表的索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ma_id` (`ma_id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 限制导出的表
--

--
-- 限制表 `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `user` (`id`);

--
-- 限制表 `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`ma_id`) REFERENCES `materials` (`id`);

--
-- 限制表 `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`ma_id`) REFERENCES `materials` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`buyer_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
