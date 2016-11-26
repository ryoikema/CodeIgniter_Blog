CREATE DATABASE code_blog;

CREATE TABLE user(
  user_id int(6) not null auto_increment,
  user_name varchar(20) not null,
  user_pass varchar(60) not null,
  user_email varchar(120) not null unique,
  user_date datetime not null DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(user_id)
);

CREATE TABLE post(
  post_id int(6) not null auto_increment,
  post_title varchar(200),
  post_slug varchar(200) not null,
  post_content text,
  post_date datetime not null DEFAULT CURRENT_TIMESTAMP,
  post_date_up datetime,
  post_delete datetime,
  cat_id int(6) not null DEFAULT 0,
  user_id int(6),
  PRIMARY KEY(post_id)
);

CREATE TABLE category(
  cat_id int(6) not null auto_increment,
  cat_name varchar(100) not null,
  cat_slug varchar(100) not null unique,
  cat_date datetime not null DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(cat_id)
);

create table post_category(
  post_category_id int(6) auto_increment,
  post_id int(6),
  cat_id int(6) DEFAULT 0,
  primary key(post_category_id)
);


/*---user---*/
INSERT INTO user(user_name,user_pass,user_email,user_date) VALUES("zaku","zakudesu","zaku@gmail.comm",now());
/*---post---*/
INSERT INTO post(post_title,post_content) VALUES("タイトル１","本文２");
INSERT INTO post(post_title,post_content) VALUES("タイトル2","本文2");
INSERT INTO post(post_title,post_content) VALUES("タイトル3","本文3");
INSERT INTO post(post_title,post_content) VALUES("タイトル4","本文4");
/*---category---*/
INSERT INTO category(cat_name) VALUES("blog");
/*---post_category---*/
INSERT INTO post_category(post_id,cat_id) VALUES(30,1);
INSERT INTO post_category(post_id,cat_id) VALUES(30,2);

