-- Valentina Studio --
-- MySQL dump --
-- ---------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
-- ---------------------------------------------------------


-- CREATE TABLE "article" ----------------------------------
CREATE TABLE `article` ( 
	`id_article` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`title` VarChar( 128 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`content` Text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`img` VarChar( 255 ) NULL,
	PRIMARY KEY ( `id_article` ) )
ENGINE = InnoDB
AUTO_INCREMENT = 17;
-- ---------------------------------------------------------


-- CREATE TABLE "comment" ----------------------------------
CREATE TABLE `comment` ( 
	`id_comment` Int( 32 ) AUTO_INCREMENT NOT NULL,
	`article_id` Int( 32 ) NOT NULL,
	`user` VarChar( 128 ) NOT NULL,
	`text` Text NOT NULL,
	`date` VarChar( 32 ) NOT NULL,
	PRIMARY KEY ( `id_comment` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 33;
-- ---------------------------------------------------------


-- CREATE TABLE "page" -------------------------------------
CREATE TABLE `page` ( 
	`id_page` Int( 10 ) AUTO_INCREMENT NOT NULL,
	`page_title` VarChar( 50 ) NOT NULL,
	`id_page_template` Int( 11 ) NULL,
	PRIMARY KEY ( `id_page` ) )
CHARACTER SET = utf8
COLLATE = utf8_general_ci
ENGINE = InnoDB
AUTO_INCREMENT = 2;
-- ---------------------------------------------------------


-- CREATE TABLE "page_template" ----------------------------
CREATE TABLE `page_template` ( 
	`id_page_template` Int( 10 ) AUTO_INCREMENT NOT NULL,
	`page_template_name` VarChar( 50 ) NOT NULL DEFAULT '0',
	PRIMARY KEY ( `id_page_template` ) )
CHARACTER SET = utf8
COLLATE = utf8_general_ci
ENGINE = InnoDB
AUTO_INCREMENT = 2;
-- ---------------------------------------------------------


-- CREATE TABLE "role" -------------------------------------
CREATE TABLE `role` ( 
	`id_role` Int( 5 ) AUTO_INCREMENT NOT NULL,
	`name` VarChar( 256 ) NOT NULL,
	PRIMARY KEY ( `id_role` ),
	CONSTRAINT `name` UNIQUE( `name` ) )
CHARACTER SET = cp1251
COLLATE = cp1251_general_ci
ENGINE = InnoDB
AUTO_INCREMENT = 3;
-- ---------------------------------------------------------


-- CREATE TABLE "user" -------------------------------------
CREATE TABLE `user` ( 
	`id_user` Int( 10 ) AUTO_INCREMENT NOT NULL,
	`user_login` VarChar( 50 ) NOT NULL,
	`user_name` VarChar( 50 ) NULL,
	`user_pass_hash` VarChar( 50 ) NULL,
	`user_session` VarChar( 50 ) NULL,
	`user_action_hash` VarChar( 32 ) NULL,
	`is_active` TinyInt( 4 ) NOT NULL,
	`user_last_action` Int( 255 ) NULL,
	`email` VarChar( 32 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	PRIMARY KEY ( `id_user` ) )
CHARACTER SET = utf8
COLLATE = utf8_general_ci
ENGINE = InnoDB
AUTO_INCREMENT = 7;
-- ---------------------------------------------------------


-- CREATE TABLE "user_role" --------------------------------
CREATE TABLE `user_role` ( 
	`id_user_role` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`id_user` Int( 11 ) NOT NULL,
	`id_role` Int( 11 ) NOT NULL,
	PRIMARY KEY ( `id_user_role` ) )
ENGINE = InnoDB
AUTO_INCREMENT = 9;
-- ---------------------------------------------------------


-- Dump data of "article" ----------------------------------
INSERT INTO `article`(`id_article`,`title`,`content`,`img`) VALUES ( '18', 'Роснано вернется к проекту гибких дисплеев Plastic Logic', 'Plastic Logic известна своими разработками в области элекронной бумаги, в том числе на гибкой пластиковой подложке. На CES 2013 компания показала концептуальный планшет PaperTab с гибким тачскрином на базе “электронной бумаги”. А в 2011 году было объявлено о начале совместного проекта с Роснано по строительству завода в Зеленограде, на котором будут производиться продукты пластиковой электроники, а также центра исследований и разработок.
26 июля совет директоров Роснано рассмотрит вопрос об инвестиционном проекте по производству «пластиковых» дисплеев Plastic Logic. Подробности пока неизвестны, но неофициально сообщается о переговорах по привлечению стратегического инвестора для возрождения производства гибких дисплеев.', 'art1.jpg' );
INSERT INTO `article`(`id_article`,`title`,`content`,`img`) VALUES ( '19', 'Windows 10: что вы на самом деле хотели увидеть в новой системе', 'Разработка крупного юбилейного обновления, которое выйдет спустя чуть более года после финальной версии Windows 10 практически завершена. Однако мы сегодня хотим заглянуть чуть в прошлое: в те времена, когда открытое тестирование «десятки» ещё только начиналось. Осенью 2014 Microsoft предоставила всем желающим возможность оставить свои предложения о том, что они хотели бы увидеть в будущей версии Windows на специальном веб-сайте Windows Feature Suggestion Box. Давайте взглянем, чем закончилась эта история.
Начнём с того, что данного ресурса к настоящему моменту уже нет: его закрыли ещё под конец прошлого года. Разумеется, Microsoft не перестала интересоваться мнением пользователей, но делает теперь это исключительно в Windows 10 и только при наличии MS-аккаунта. Выходит, если вы по какой-то причине решили остаться на предыдущей версии Windows, то ваше мнение корпорацию особо уже не интересует.Впрочем, вернёмся к Suggestion Box. Запуская его осенью, Microsoft логично предупредила, что начнёт учитывать тамошние пожелания не сразу, а только с приходом 2015 года, так как быстро воплотить идеи юзеров у неё не получится. Сегодня на дворе уже вторая половина 2016: успела выйти сама Windows 10, первое крупное обновление для неё и вот теперь совсем близок выход уже второго апдейта. Не пора ли подвести как минимум промежуточный итог?
Пользователи тогда к заманчивой инициативе со стороны корпорации отнеслись с солидным энтузиазмом. Они оставили на Suggestion Box тысячи предложений. Чтобы не плодить число заявок юзерам было позволено не только писать собственные пожелания, но и голосовать за наиболее понравившиеся чужие. Благодаря этому определённые идеи получили поддержку в десятки тысяч голосов.Этот перевод всего интересного, что было предложено людьми на Suggestion Box, готовился нами ещё более года назад, однако тогда так и не был опубликован, зато сейчас взглянуть на него будет вдвойне интересно, потому что теперь можно оценить не только идеи юзеров, но и реакцию на них со стороны корпорации.
Далее мы отобрали идеи, которые тогда уверенно лидировали в том голосовании. Полужирным начертанием выделена сама идея, а далее идёт уже наше небольшое пояснение, если оно требуется.
Ну и последнее, что заметим: пользователи – простые люди, поэтому среди предложений можно найти немало тех, а, вернее, даже преобладают те, которые не несут особой практической пользы, но весьма любопытны в эстетическом плане.', 'art2.png' );
INSERT INTO `article`(`id_article`,`title`,`content`,`img`) VALUES ( '20', 'Opera 39: что нового?', 'Норвежская компания Opera готовится представить следующее крупное обновление для своего одноимённого браузера, которое принесёт как одну давно ожидаемую, так и развитие нескольких уже имеющихся в веб-обозревателе функций. О том, что нового появится в Opera 39 мы подробно расскажем в этой заметке.
Безусловно, самая ожидаемая пользователями новинка Opera 39 – это встроенный бесплатный и безлимитный VPN. Opera первые, кто реализует нечто подобное в популярном браузере, что называется, прямо из коробки. VPN – это анонимность, безопасность и возможность обходить запреты самого разного уровня. За всё это, впрочем, придётся расплатиться некоторым понижением производительности на время VPN-сёрфинга.
Включить VPN нужно в настройках браузера, в разделе «безопасность». 
Далее отключать и снова включать функцию можно будет с помощью специального нового значка в адресной строке веб-обозревателя. Клик по нему открывает всплывающий интерфейс, где также можно оценить, какой объём трафика был пропущен через виртуальную сеть, а заодно убедиться, что ваш IP изменён.
Эти и прочие новые функции разработчики покажут уже в другой версии, которая появится после Opera 39.', 'art3.png' );
-- ---------------------------------------------------------


-- Dump data of "comment" ----------------------------------
INSERT INTO `comment`(`id_comment`,`article_id`,`user`,`text`,`date`) VALUES ( '33', '20', 'Даша', 'Интересно надо попробовать', '25.07.2016' );
INSERT INTO `comment`(`id_comment`,`article_id`,`user`,`text`,`date`) VALUES ( '34', '19', 'Даша', 'КОму нужна эта Винда, когда есть тру Линукс', '25.07.2016' );
INSERT INTO `comment`(`id_comment`,`article_id`,`user`,`text`,`date`) VALUES ( '35', '18', 'Даша', 'Прикольнинько', '25.07.2016' );
INSERT INTO `comment`(`id_comment`,`article_id`,`user`,`text`,`date`) VALUES ( '36', '20', 'Оля', 'Очень круто!!!', '25.07.2016' );
INSERT INTO `comment`(`id_comment`,`article_id`,`user`,`text`,`date`) VALUES ( '37', '18', 'Григорий', 'Нормально, скоро свернул планшет и пошел', '25.07.2016' );
-- ---------------------------------------------------------


-- Dump data of "page" -------------------------------------
INSERT INTO `page`(`id_page`,`page_title`,`id_page_template`) VALUES ( '1', 'Main page', '1' );
-- ---------------------------------------------------------


-- Dump data of "page_template" ----------------------------
INSERT INTO `page_template`(`id_page_template`,`page_template_name`) VALUES ( '1', 'main_template' );
-- ---------------------------------------------------------


-- Dump data of "role" -------------------------------------
INSERT INTO `role`(`id_role`,`name`) VALUES ( '1', 'admin' );
INSERT INTO `role`(`id_role`,`name`) VALUES ( '2', 'user' );
-- ---------------------------------------------------------


-- Dump data of "user" -------------------------------------
INSERT INTO `user`(`id_user`,`user_login`,`user_name`,`user_pass_hash`,`user_session`,`user_action_hash`,`is_active`,`user_last_action`,`email`) VALUES ( '1', 'test', 'test', '202cb962ac59075b964b07152d234b70', 'jah308quolc7s8c8ea0c6621c4', '118edb70694d08df25c19ed23dfd0524', '1', '1469444158', '' );
INSERT INTO `user`(`id_user`,`user_login`,`user_name`,`user_pass_hash`,`user_session`,`user_action_hash`,`is_active`,`user_last_action`,`email`) VALUES ( '2', 'new', 'new', '202cb962ac59075b964b07152d234b70', 'jah308quolc7s8c8ea0c6621c4', '118edb70694d08df25c19ed23dfd0524', '0', '1469369245', '' );
INSERT INTO `user`(`id_user`,`user_login`,`user_name`,`user_pass_hash`,`user_session`,`user_action_hash`,`is_active`,`user_last_action`,`email`) VALUES ( '5', 'user', 'user', '202cb962ac59075b964b07152d234b70', 'm3v654aipukhv55lqaeqqnde54', '16c5104259e3cc1ae87d308d7ab7366b', '0', '1469294935', 'sakov74@ya.ru' );
INSERT INTO `user`(`id_user`,`user_login`,`user_name`,`user_pass_hash`,`user_session`,`user_action_hash`,`is_active`,`user_last_action`,`email`) VALUES ( '6', 'dasha', 'Даша', '202cb962ac59075b964b07152d234b70', 'jah308quolc7s8c8ea0c6621c4', '118edb70694d08df25c19ed23dfd0524', '0', '1469443320', 'ex@ry.com' );
INSERT INTO `user`(`id_user`,`user_login`,`user_name`,`user_pass_hash`,`user_session`,`user_action_hash`,`is_active`,`user_last_action`,`email`) VALUES ( '7', 'Оля', 'Оля', '202cb962ac59075b964b07152d234b70', 'jah308quolc7s8c8ea0c6621c4', '118edb70694d08df25c19ed23dfd0524', '0', '1469443716', 't@t.ru' );
INSERT INTO `user`(`id_user`,`user_login`,`user_name`,`user_pass_hash`,`user_session`,`user_action_hash`,`is_active`,`user_last_action`,`email`) VALUES ( '8', 'Григорий', 'Григорий', 'c4ca4238a0b923820dcc509a6f75849b', 'jah308quolc7s8c8ea0c6621c4', '118edb70694d08df25c19ed23dfd0524', '0', '1469444562', 'ex@ex.ru' );
-- ---------------------------------------------------------


-- Dump data of "user_role" --------------------------------
INSERT INTO `user_role`(`id_user_role`,`id_user`,`id_role`) VALUES ( '1', '1', '1' );
INSERT INTO `user_role`(`id_user_role`,`id_user`,`id_role`) VALUES ( '7', '5', '2' );
INSERT INTO `user_role`(`id_user_role`,`id_user`,`id_role`) VALUES ( '8', '6', '2' );
INSERT INTO `user_role`(`id_user_role`,`id_user`,`id_role`) VALUES ( '9', '7', '2' );
INSERT INTO `user_role`(`id_user_role`,`id_user`,`id_role`) VALUES ( '10', '8', '2' );
-- ---------------------------------------------------------


-- CREATE INDEX "article_id" -------------------------------
CREATE INDEX `article_id` USING BTREE ON `comment`( `article_id` );
-- ---------------------------------------------------------


-- CREATE FUNCTION "AddGeometryColumn" ---------------------

delimiter $$$ 
CREATE DEFINER=`` PROCEDURE `AddGeometryColumn`(catalog varchar(64), t_schema varchar(64),
   t_name varchar(64), geometry_column varchar(64), t_srid int)
begin
  set @qwe= concat('ALTER TABLE ', t_schema, '.', t_name, ' ADD ', geometry_column,' GEOMETRY REF_SYSTEM_ID=', t_srid); PREPARE ls from @qwe; execute ls; deallocate prepare ls; end;

$$$ delimiter ;
-- ---------------------------------------------------------


-- CREATE FUNCTION "DropGeometryColumn" --------------------

delimiter $$$ 
CREATE DEFINER=`` PROCEDURE `DropGeometryColumn`(catalog varchar(64), t_schema varchar(64),
   t_name varchar(64), geometry_column varchar(64))
begin
  set @qwe= concat('ALTER TABLE ', t_schema, '.', t_name, ' DROP ', geometry_column); PREPARE ls from @qwe; execute ls; deallocate prepare ls; end;

$$$ delimiter ;
-- ---------------------------------------------------------


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- ---------------------------------------------------------


