-- Function to print a report on branches

create or replace function
	branchInfo(_locn text) returns text
as $$
declare
	a   record;
	b   record;
	tot integer;
	qry text;
	out text := E'\n';
begin
	for b in select * from Branches where location like '%'||_locn||'%'
	loop
		out := out || 'Branch: ' || b.location || ', ';
		out := out || b.address || E'\n' || 'Customers: ';
		tot := 0;
		for a in select * from Accounts where branch=b.location
		loop
			out := out || ' ' || a.holder;
			tot := tot + a.balance;
		end loop;
		out := out || E'\nTotal deposits: ';
		out := out || to_char(tot,'$999999.99');
		out := out || E'\n---\n';
	end loop;
	return out;
end;
$$ language plpgsql;
