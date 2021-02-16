-- COMP3311 20T3 Assignment 1
-- Calendar schema
-- Written by INSERT YOUR NAME HERE

-- Types

create type AccessibilityType as enum ('read-write','read-only','none');
create type InviteStatus as enum ('invited','accepted','declined');

-- add more types/domains if you want

-- Tables

create table Users (
	id          serial,
	email       text not null unique,
	...
	primary key (id)
);

create table Groups (
	id          serial,
	name        text not null,
	...
	primary key (id)
);

-- etc. etc. etc.
