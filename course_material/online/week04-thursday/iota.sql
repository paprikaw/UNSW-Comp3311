create or replace function
	iota(lo integer, hi integer, step integer)
	returns setof integer
as $fac$
declare
	i integer;
begin
	raise warning $$Hello$$;
	i := lo;
	while (i <= hi)
	loop
		return next i;
		i := i + step;
	end loop;
end;
$fac$ language plpgsql;

create or replace function
	iota(integer,integer) returns setof integer
as $$
select * from iota($1,$2,1);
$$ language sql;


create or replace function
	iota(integer) returns setof integer
as $$
select * from iota(1,$1,1);
$$ language sql;
