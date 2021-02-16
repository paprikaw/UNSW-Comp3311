create or replace function
	append(soFar text, newStr anyelement) returns text
as $$
begin
	return soFar||','||newStr::text;
end;
$$ language plpgsql;

create or replace function
	chop(result text) returns text
as $$
begin
	return substr(result,2,length(result)-1);
end;
$$ language plpgsql;

drop aggregate if exists concat(anyelement);

create aggregate concat(anyelement) (
	initcond  = '',
	stype     = text,
	sfunc     = append,
	finalfunc = chop
);
