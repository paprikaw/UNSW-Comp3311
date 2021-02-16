create or replace view nbeers as
select brewer, count(*) as beers
from   Beers
group  by brewer;
