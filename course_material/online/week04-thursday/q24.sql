-- Which bars sell all beers?
-- for each bar B 
--    SoldAtB = set of beers sold at B
--    AllBeers = set of all beers
--    if (SoldAtB == AllBeers) add B to results
-- }
--
-- relational division operator

create or replace view q24
as
select b.name
from   Bars b
where  not exists (
         (select name as beer from Beers)            -- all beers
           except
         (select beer from Sells where bar = b.name) -- sold at b
       )
;
