create table users (
	id serial primary key,
	username varchar(20) not null unique,
	password varchar(32) not null,
	name varchar(30) not null,
	role varchar(20) not null
);
