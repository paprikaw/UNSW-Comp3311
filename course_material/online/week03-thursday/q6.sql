select name, brewer
from beers
where brewer in (select brewer from nbeers where beers=1);
