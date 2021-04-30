
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



-- important
select CASE when b.name='Amber Ale' then 'Ale haha' else b.name end from beers b
where b.name <> 'Chestnut Lager';


-- pgpsql for loop

create type cheap_number as ( "group" text, nshort integer, nlong integer );
create or replace function q5() returns setof cheap_number as
$$
declare
    temp1 integer;
    temp2 integer;
    i record;
    j record;
    res cheap_number;
begin
    temp1 := 0;
    temp2 := 0;
    FOR i IN select name from bars
    loop
        for j in select s.price from bars b join sells s on b.id = s.bar
            where b.name = i.name
            loop
            if j.price > 5
            then
                temp1 := temp1 + 1;
            else
                temp2 := temp2 + 1;
            end if;
            end loop;
         res := (i.name, temp1, temp2);
        return next res;
        temp1 = 0;
        temp2 = 0;
    end loop;
end;
$$
    language plpgsql;


create or replace function group_disamble() returns trigger
as
$$
declare
    now_date date;
begin
    -- If there is no group member in the group
    if not exists(select m.performer from new join memberof m on new.id = m.in_group)
    then
        select getdate()::date into now_date;
        update new
        set disbanded = now_date;
    end if;
    return new;
end;
$$ language plpgsql;

create trigger underwriting_enforcement
    after update
    on groups
    for each row
execute function group_disamble();


-- A trigger of udpates the row
create or replace function group_disamble() returns trigger
as
$$
declare
    now_date date;
begin
    -- If there is no group member in the group
    select m.performer from memberof m where m.in_group = new.id;
    if not found
    then
        select current_date::date into now_date;
        new.disbanded = now_date;
    end if;
    return new;
end;
$$ language plpgsql;