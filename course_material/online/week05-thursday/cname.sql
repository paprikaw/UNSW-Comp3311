create or replace function
	courseName(_cid integer) returns text
as $$
declare
	_code text;
	_name text;
    _term integer;
begin
	select s.code,s.name,c.semester into _code,_name,_term
	from   Courses c join Subjects s on (s.id = c.subject)
	where  c.id = _cid;
	if (not found) then
		return 'No such course';
	end if;
	return _code||' '||termName(_term)||' '||_name;
end;
$$ language plpgsql;
