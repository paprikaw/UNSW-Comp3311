select drinker, concat(beer)
from likes
group by drinker;
