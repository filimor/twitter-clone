CREATE DATABASE twitter_clone;

USE twitter_clone;

CREATE TABLE users(
	id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name varchar(100) NOT NULL,
    email varchar(150) NOT NULL,
    password varchar(32) NOT NULL
);

CREATE TABLE tweets(
	id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_user int NOT NULL,
	tweet varchar(140) NOT NULL,
	date datetime DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE followers(
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_user int NOT NULL,
    id_user_following int NOT NULL
);