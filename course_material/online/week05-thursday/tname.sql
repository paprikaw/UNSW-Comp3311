create or replace function
	termName(_id integer) returns text
as $$
declare
	_year integer;
	_sess char(2);
begin
	select year,session into _year,_sess
	from   Terms
	where  id = _id;
	if (not found) then
		return 'No such term';
	end if;
	-- e.g. 2002 S1 -> 02s1
	return substr(_year::text,3,2)||lower(_sess);
end;
$$ language plpgsql;
