-- schema
CREATE TABLE m (
    id integer NOT NULL,
    m_context text NOT NULL,
    FOREIGN KEY (id)
                  REFERENCES U(id),
    PRIMARY KEY (id, m_context)
)

-- Create a function
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

-- multiple cases
select CASE when b.name='Amber Ale' then 'Ale haha' else b.name end from beers b
where b.name <> 'Chestnut Lager';

-- A function of intersect
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


-- A trigger that will udpate groups
create trigger group_update
    before insert or update
    on groups
    for each row
execute function group_disamble();

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
