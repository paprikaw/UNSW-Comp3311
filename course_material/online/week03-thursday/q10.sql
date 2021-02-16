-- find "drinkers" who are not in the set of people who like beers
select name
from drinkers
where name not in (select distinct(drinker) from likes);


-- SetOfPotentialDrinkers - SetOfActualDrinkers
(select name as drinker from drinkers)
except
(select distinct(drinker) from likes);
