-- COMP3311 Prac 03 Exercise
-- Schema for simple company database

create table Employees (
	tfn         char(11) check(tfn ~ '[0-9]{3}-[0-9]{3}-[0-9]{3}'),
	givenName   varchar(30) NOT NULL,
	familyName  varchar(30),
	hoursPweek  float check  (hourspweek <= 168 and hourspweek >= 0),
	primary key (tfn)
);

create table Departments (
	id          char(3) UNIQUE,
	name        varchar(100) UNIQUE,
	manager     char(11),
	primary key (id)
);

create table DeptMissions (
	department  char(3),
	keyword     varchar(20),
	primary key (department, keyword),
	foreign key (department) REFERENCES departments(id)
);

create table WorksFor (
	employee    char(11),
	department  char(3),
	percentage  float check (percentage > 0 and percentage <= 1),
	primary key (employee,department),
	foreign key (employee) REFERENCES employees(tfn),
	foreign key (department) REFERENCES departments(id)
);
