-- Bars that sell no beers made by Carlton
-- for each bar B {
--    SoldAtB = set of beers sold at B
--    CarltonBeers = set of beers made by Carlton
--    if (sets are disjoint) return B as a result
-- }

create or replace view q22
as
select b.name
from   Bars b
where  not exists (
         (select beer from Sells where bar = b.name)
           intersect
         (select name as beer from Beers where brewer='Carlton')
       )
;
