-- Database Schema for Health Scenario

create table Pharmacies (
	id integer primary key,
	name    text unique not null,
	address text not null,
	phone   text,
);

create table Drugs (
	formula text not null,
    tradename text primary key
);

create table Sells (
	pharmacy integer,
	drug     text references Drugs(tradename),
    price    money,
    foreign key (pharmacy) references Pharmacies(id),
	primary key (pharmacy,drug)
);


/*
char(4)     'abcde'::char(4) -> 'abcd'
            'abc' -. 'abc '
varchar(4)  'abcde' -> 'abcd'
            'abc' -> 'abc'


attr like '%the%'

attr ~ '.*the.*'

code ~ '[A-Z]{4}[0-9]{4}'
*/
