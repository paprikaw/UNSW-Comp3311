
-----------------------PRAC EXAM 1
--q1:
select t.country, count(i.match)
from teams t join involves i on t.id = i.team
group by t.country;

--q2:Write an SQL view that gives the names of all players who have scored more than one goal that is rated as "amazing".ss
create or replace function common_beer(drinker1 text, drinker2 text) returns integer as
$$
declare
        count integer;
begin
    if not exists(select * from drinkers d where d.name = $1)
    then
        return null;
    end if;

    if not exists(select * from drinkers d where d.name = $2)
    then
        return null;
    end if;

    count := 0;
    select count(name) into count
    from
    ((select b.name from
                drinkers d join likes l on d.id = l.drinker
    join beers b on l.beer = b.id
    where d.name = $1)
    intersect
    (select b.name from
                drinkers d join likes l on d.id = l.drinker
    join beers b on l.beer = b.id
    where d.name = $2)) a;
    RETURN count;
end
$$ language plpgsql;

select
--q3:

--q10:

select t.country, m.city, count(m.city)
from   Matches m join Involves i on (m.id = i.match)
join teams t on i.team = t.id
group by t.country, m.city;



------------ PRAC EXAM 2
--Q2
select g.name from
groups g join albums a on g.id = a.made_by
where not exists(select * from
    groups g2 join albums a on g.id = a.made_by
    where g.name = g2.name);
