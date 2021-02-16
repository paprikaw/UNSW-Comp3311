create or replace view nlikes(beer,nl) as
select beer, count(*)
from likes
group by beer;

select beer from likes
group by beer
having count(*)=(select max(nl) from nlikes);
