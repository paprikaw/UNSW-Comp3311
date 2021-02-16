
create or replace view imports1(beer,brewer,country)
as
select b.name::text as beer,
	   r.name::text as brewer,
	   r.country::text
from   Beers b join Brewers r on (b.brewer = r.id)
where  r.country <> 'Australia'
;

-- since there is no (beer,brewer,country) tuple type
create type BeerInfo as (beer text, brewer text, country text);

create or replace function
	imports() returns setof BeerInfo
as $$
declare
	beer BeerInfo;
begin
	for beer in
		select b.name::text as beer,
		       r.name::text as brewer,
		       r.country::text
		from   Beers b join Brewers r on (b.brewer = r.id)
		where  r.country <> 'Australia'
	loop
		return next beer;
	end loop;
end;
$$ language plpgsql;
