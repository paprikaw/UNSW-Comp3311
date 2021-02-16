
create table People (
	ssn  text primary key,
    name text not null
);

create table Patients (
    ssn     text references People(ssn),
    address text not null,
	d_o_b   date not null, -- e.g '1970-01-26'
	primary key (ssn)
);

create table Doctors (
	ssn     text references People(ssn),
	specialty text not null,
	y_o_exp integer not null check (y_o_exp >= 0),
	primary key (ssn)
);
    
