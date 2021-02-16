create or replace view nstyles(style,nbeers) as
select style, count(*)
from   Beers
group by style;

select style
from nstyles
where nbeers = (select max(nbeers) from nstyles);
