CREATE DATABASE twitter_clone;

USE twitter_clone;

CREATE TABLE users(
	id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name varchar(100) NOT NULL,
    email varchar(150) NOT NULL,
    password varchar(32) NOT NULL
);