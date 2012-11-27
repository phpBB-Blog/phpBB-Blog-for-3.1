/*
 * DO NOT EDIT THIS FILE, IT IS GENERATED
 *
 * To change the contents of this file, edit
 * phpBB/develop/create_schema_files.php and
 * run it.
 */

BEGIN;

/*
	Domain definition
*/
CREATE DOMAIN varchar_ci AS varchar(255) NOT NULL DEFAULT ''::character varying;

/*
	Operation Functions
*/
CREATE FUNCTION _varchar_ci_equal(varchar_ci, varchar_ci) RETURNS boolean AS 'SELECT LOWER($1) = LOWER($2)' LANGUAGE SQL STRICT;
CREATE FUNCTION _varchar_ci_not_equal(varchar_ci, varchar_ci) RETURNS boolean AS 'SELECT LOWER($1) != LOWER($2)' LANGUAGE SQL STRICT;
CREATE FUNCTION _varchar_ci_less_than(varchar_ci, varchar_ci) RETURNS boolean AS 'SELECT LOWER($1) < LOWER($2)' LANGUAGE SQL STRICT;
CREATE FUNCTION _varchar_ci_less_equal(varchar_ci, varchar_ci) RETURNS boolean AS 'SELECT LOWER($1) <= LOWER($2)' LANGUAGE SQL STRICT;
CREATE FUNCTION _varchar_ci_greater_than(varchar_ci, varchar_ci) RETURNS boolean AS 'SELECT LOWER($1) > LOWER($2)' LANGUAGE SQL STRICT;
CREATE FUNCTION _varchar_ci_greater_equals(varchar_ci, varchar_ci) RETURNS boolean AS 'SELECT LOWER($1) >= LOWER($2)' LANGUAGE SQL STRICT;

/*
	Operators
*/
CREATE OPERATOR <(
  PROCEDURE = _varchar_ci_less_than,
  LEFTARG = varchar_ci,
  RIGHTARG = varchar_ci,
  COMMUTATOR = >,
  NEGATOR = >=,
  RESTRICT = scalarltsel,
  JOIN = scalarltjoinsel);

CREATE OPERATOR <=(
  PROCEDURE = _varchar_ci_less_equal,
  LEFTARG = varchar_ci,
  RIGHTARG = varchar_ci,
  COMMUTATOR = >=,
  NEGATOR = >,
  RESTRICT = scalarltsel,
  JOIN = scalarltjoinsel);

CREATE OPERATOR >(
  PROCEDURE = _varchar_ci_greater_than,
  LEFTARG = varchar_ci,
  RIGHTARG = varchar_ci,
  COMMUTATOR = <,
  NEGATOR = <=,
  RESTRICT = scalargtsel,
  JOIN = scalargtjoinsel);

CREATE OPERATOR >=(
  PROCEDURE = _varchar_ci_greater_equals,
  LEFTARG = varchar_ci,
  RIGHTARG = varchar_ci,
  COMMUTATOR = <=,
  NEGATOR = <,
  RESTRICT = scalargtsel,
  JOIN = scalargtjoinsel);

CREATE OPERATOR <>(
  PROCEDURE = _varchar_ci_not_equal,
  LEFTARG = varchar_ci,
  RIGHTARG = varchar_ci,
  COMMUTATOR = <>,
  NEGATOR = =,
  RESTRICT = neqsel,
  JOIN = neqjoinsel);

CREATE OPERATOR =(
  PROCEDURE = _varchar_ci_equal,
  LEFTARG = varchar_ci,
  RIGHTARG = varchar_ci,
  COMMUTATOR = =,
  NEGATOR = <>,
  RESTRICT = eqsel,
  JOIN = eqjoinsel,
  HASHES,
  MERGES,
  SORT1= <);

/*
	Table: 'phpbb_blog_categories'
*/
CREATE SEQUENCE phpbb_blog_categories_seq;

CREATE TABLE phpbb_blog_categories (
	id INT4 DEFAULT nextval('phpbb_blog_categories_seq'),
	name varchar(255) DEFAULT '' NOT NULL,
	description varchar(4000) DEFAULT '' NOT NULL,
	options INT4 DEFAULT '7' NOT NULL CHECK (options >= 0),
	bitfield varchar(255) DEFAULT '' NOT NULL,
	uid varchar(8) DEFAULT '' NOT NULL,
	total_posts INT4 DEFAULT '0' NOT NULL CHECK (total_posts >= 0),
	last_post_id INT4 DEFAULT '0' NOT NULL CHECK (last_post_id >= 0),
	PRIMARY KEY (id)
);


/*
	Table: 'phpbb_blog_posts'
*/
CREATE SEQUENCE phpbb_blog_posts_seq;

CREATE TABLE phpbb_blog_posts (
	id INT4 DEFAULT nextval('phpbb_blog_posts_seq'),
	category INT4 DEFAULT '0' NOT NULL CHECK (category >= 0),
	title varchar(255) DEFAULT '' NOT NULL,
	poster_id INT4 DEFAULT '0' NOT NULL CHECK (poster_id >= 0),
	post varchar(4000) DEFAULT '' NOT NULL,
	options INT4 DEFAULT '7' NOT NULL CHECK (options >= 0),
	bitfield varchar(255) DEFAULT '' NOT NULL,
	uid varchar(8) DEFAULT '' NOT NULL,
	post_time INT4 DEFAULT '0' NOT NULL CHECK (post_time >= 0),
	PRIMARY KEY (id)
);

CREATE INDEX phpbb_blog_posts_category ON phpbb_blog_posts (category);


COMMIT;