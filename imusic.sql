CREATE TABLE `music_users` (
`user_id` tinyint(10) NOT NULL AUTO_INCREMENT,
`user_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
`user_pwd` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
PRIMARY KEY (`user_id`) 
);

CREATE TABLE `music_songs` (
`song_id` tinyint(10) NOT NULL AUTO_INCREMENT,
`song_type` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '曲风类型',
`song_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '歌曲名字',
`song_album` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '专辑名称',
`song_publish` datetime NULL COMMENT '发行日期',
`song_lyics` varchar(50) NULL,
`song_comments` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '歌曲评论',
`singer_name` varchar(50) NOT NULL,
PRIMARY KEY (`song_id`) 
);

CREATE TABLE `music_singers` (
`singer_id` tinyint(10) NOT NULL AUTO_INCREMENT,
`singer_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '歌手名字',
`singer_type` char(4) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '歌手类别',
`singer_avtar` varchar(50) NULL DEFAULT NULL COMMENT '歌手图',
`singer_area` varchar(10) NULL DEFAULT NULL COMMENT '地区',
`singer_album` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '专辑名称',
`singer_birth` datetime NULL,
`singer_intro` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
PRIMARY KEY (`singer_id`) 
);

CREATE TABLE `music_lists` (
`list_id` tinyint(10) NOT NULL AUTO_INCREMENT,
`list_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`list_type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
`list_intro` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`list_thumb` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
`list_total` int(10) NULL DEFAULT NULL COMMENT '收听次数',
`list_author` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '歌单表作者',
`song_id` tinyint(10) NULL,
`list_publish` datetime NULL COMMENT '歌单发行日期',
PRIMARY KEY (`list_id`) 
);

CREATE TABLE `music_albums` (
`album_id` tinyint(10) NOT NULL AUTO_INCREMENT,
`album_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
`singer_name` varchar(50) NULL,
`song_name` varchar(50) NULL,
`album_avtar` varchar(50) NULL DEFAULT NULL COMMENT '专辑图路径',
`album_intro` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '专辑介绍',
PRIMARY KEY (`album_id`) 
);

CREATE TABLE `music_type` (
`type_id` tinyint(10) NOT NULL AUTO_INCREMENT,
`type_name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '曲风类型名',
PRIMARY KEY (`type_id`) 
);

CREATE TABLE `music_broadcast` (
`broadcast_id` tinyint(10) NOT NULL AUTO_INCREMENT,
`broadcast_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '电台名称',
`broadcast_author` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '作者',
`broadcast_list` varchar NULL,
`broadcast_thumb` varchar(100) NULL COMMENT '图片路径',
PRIMARY KEY (`broadcast_id`) 
);

CREATE TABLE `music_comment` (
`comment_id` tinyint(10) NOT NULL AUTO_INCREMENT,
`comment_content` varchar(255) NULL DEFAULT NULL,
`song_id` tinyint(10) NULL,
`from_uid` tinyint(10) NULL COMMENT '评论用户id',
`comment_time` datetime NULL,
PRIMARY KEY (`comment_id`) 
);

CREATE TABLE `music_reply` (
`id` int(10) NOT NULL AUTO_INCREMENT,
`comment_id` tinyint(10) NOT NULL,
`reply_content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`from_uid` tinyint(10) NOT NULL COMMENT '回复用户id',
`to_uid` tinyint(10) NOT NULL COMMENT '目标用户id',
`reply_time` datetime NULL,
PRIMARY KEY (`id`) 
);

CREATE TABLE `music_collect` (
`collect_id` tinyint(10) NOT NULL AUTO_INCREMENT,
`collect_time` datetime NULL,
`user_id` tinyint(10) NULL,
`song_id` tinyint(10) NULL,
PRIMARY KEY (`collect_id`) 
);

CREATE TABLE `music_user_playlist` (
`playlist_id` tinyint(10) NOT NULL AUTO_INCREMENT,
`playlislt_name` varchar(30) NULL,
`song_id` tinyint(10) NULL,
`user_id` tinyint(10) NULL,
PRIMARY KEY (`playlist_id`) 
);

