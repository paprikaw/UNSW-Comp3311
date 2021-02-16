create table Flights (
	fromCity    text,
	toCity      text,
	primary key (fromCity,toCity)
);

insert into Flights values ('SF','DAL');
insert into Flights values ('SF','DEN');
insert into Flights values ('DEN','CHI');
insert into Flights values ('DEN','DAL');
insert into Flights values ('DAL','CHI');
insert into Flights values ('DAL','NY');
insert into Flights values ('CHI','NY');
