# Dump of table phpbb_blog_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS phpbb_blog_categories;

CREATE TABLE phpbb_blog_categories (
	id int(11) unsigned NOT NULL AUTO_INCREMENT,
	title varchar(255) NOT NULL DEFAULT '',
	description mediumtext NOT NULL,
	description_options int(11) unsigned NOT NULL DEFAULT '7',
	description_bitfield varchar(255) NOT NULL DEFAULT '',
	description_uid varchar(8) NOT NULL DEFAULT '',
	total_posts int(11) unsigned NOT NULL DEFAULT '0',
	last_post_id int(11) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table phpbb_blog_post_comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS phpbb_blog_post_comments;

CREATE TABLE phpbb_blog_post_comments (
	id int(11) unsigned NOT NULL AUTO_INCREMENT,
	post_id int(11) unsigned NOT NULL,
	comment mediumtext NOT NULL,
	commenter_id int(11) unsigned NOT NULL DEFAULT '0',
	comment_options int(11) unsigned NOT NULL DEFAULT '7',
	comment_bitfield varchar(255) NOT NULL DEFAULT '',
	comment_uid varchar(8) NOT NULL DEFAULT '',
	ctime int(11) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (id),
	KEY post_id (post_id),
	KEY commenter_id (commenter_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table phpbb_blog_posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS phpbb_blog_posts;

CREATE TABLE phpbb_blog_posts (
	id int(11) unsigned NOT NULL AUTO_INCREMENT,
	category int(11) NOT NULL,
	title varchar(255) NOT NULL DEFAULT '',
	post mediumtext NOT NULL,
	poster_id int(11) unsigned NOT NULL DEFAULT '0',
	bbcode_options int(11) unsigned NOT NULL DEFAULT '7',
	bbcode_bitfield varchar(255) NOT NULL DEFAULT '',
	bbcode_uid varchar(8) NOT NULL DEFAULT '',
	ptime int(11) unsigned NOT NULL DEFAULT '0',
	post_read_count int(11) unsigned NOT NULL DEFAULT '0',
	post_last_edit_time int(11) unsigned NOT NULL DEFAULT '0',
	post_edit_count mediumint(8) unsigned NOT NULL DEFAULT '0',
	post_comment_count int(11) unsigned NOT NULL DEFAULT '0',
	post_comment_lock tinyint(1) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (id),
	KEY category (category),
	KEY poster (poster_id),
	KEY time (time)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table phpbb_blog_tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS phpbb_blog_tags;

CREATE TABLE phpbb_blog_tags (
	id int(11) unsigned NOT NULL AUTO_INCREMENT,
	tag varchar(255) NOT NULL DEFAULT '',
	tag_count int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
