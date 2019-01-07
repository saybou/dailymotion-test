CREATE TABLE `playlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

CREATE TABLE `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `thumbnail` varchar(2083) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

CREATE TABLE `playlist_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playlist_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`,`playlist_id`,`video_id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

ALTER TABLE `dailymotion-test`.`playlist_video`
ADD INDEX `playlist_id_idx` (`playlist_id` ASC),
ADD INDEX `video_id_idx` (`video_id` ASC);
;
ALTER TABLE `dailymotion-test`.`playlist_video`
ADD CONSTRAINT `playlist_id`
  FOREIGN KEY (`playlist_id`)
  REFERENCES `dailymotion-test`.`playlist` (`id`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION,
ADD CONSTRAINT `video_id`
  FOREIGN KEY (`video_id`)
  REFERENCES `dailymotion-test`.`video` (`id`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION;

INSERT INTO `playlist` (`id`,`title`) VALUES (1,'Ma première playlist');
INSERT INTO `playlist` (`id`,`title`) VALUES (2,'Une deuxième playlist');

INSERT INTO `video` (`id`,`name`,`thumbnail`) VALUES (1,'Ma première vidéo :)','http://www.dailymotion.fr');
INSERT INTO `video` (`id`,`name`,`thumbnail`) VALUES (2,'Ma deuxième vidéo trop cool','http://www.dailymotion.fr');
INSERT INTO `video` (`id`,`name`,`thumbnail`) VALUES (3,'Une vidéo avec des chats','http://www.dailymotion.fr');
INSERT INTO `video` (`id`,`name`,`thumbnail`) VALUES (4,'La super info à ne pas rater !','http://www.dailymotion.fr');
INSERT INTO `video` (`id`,`name`,`thumbnail`) VALUES (5,'Dernière vidéo','http://www.dailymotion.fr');

INSERT INTO `playlist_video` (`id`,`playlist_id`,`video_id`,`order`) VALUES (1,1,1,2);
INSERT INTO `playlist_video` (`id`,`playlist_id`,`video_id`,`order`) VALUES (2,1,2,1);
INSERT INTO `playlist_video` (`id`,`playlist_id`,`video_id`,`order`) VALUES (3,2,3,1);
INSERT INTO `playlist_video` (`id`,`playlist_id`,`video_id`,`order`) VALUES (4,2,4,2);
INSERT INTO `playlist_video` (`id`,`playlist_id`,`video_id`,`order`) VALUES (5,2,5,3);