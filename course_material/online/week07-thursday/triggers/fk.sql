create table R (id integer, val text);
create table S (r integer references R(id), value text);

create trigger S_fk_check 
before insert or update on S
for each row execute
procedure check_S_fk();

create or replace function
   check_S_fk() returns trigger
as $$
begin
	select * from R where id = new.r;
	if (not found) then
		if (TG_OP = 'INSERT') then
			return null;
		else if (TG_OP = 'UPDATE') then
			return old;
        end if;
	else
		return new;
	end if;
end;
$$ language plpgsql;
