-- Q11.sql
-- Where could I go to drink 'Old'?

select bars.name, bars.addr
from   bars join sells on (bars.name = sells.bar)
where  sells.beer = 'Old';
