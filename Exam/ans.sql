-- COMP3311 21T1 Exam SQL Answer Template
--
-- * Don't change view/function names and view/function arguments;
-- * Only change the SQL code for view/function bodies as commented below;
-- * and do not remove the ending semicolon of course.
--
-- * You may create additional views, if you wish;
-- * but you are NOT allowed to create tables.
--


-- Q1. 

create or replace view Q1(name, total) as
select actor.name, count(m.id) as total from actor join acting a on actor.id = a.actor_id
                                                   join movie m on a.movie_id = m.id
group by actor.name
order by total DESC , actor.name ASC ;

-- Q2.

create or replace view Q2(year, name) as
    select a.year, name from
(select m.year, max(r.imdb_score) from movie m join director d on m.director_id = d.id
join rating r on m.id = r.movie_id
where m.year is not null and r.num_voted_users >= 100000
group by m.year)a
    join
    (select m.year, r2.imdb_score,d2.name, r2.num_voted_users from movie m join rating r2 on m.id = r2.movie_id
        join director d2 on m.director_id = d2.id) a2
        on a.year = a2.year and a.max = a2.imdb_score
order by a.year;

-- Q3. 

create or replace view Q3 (title, name) as
-- replace the SQL code below:
    select m.title, d.name from movie m
join director d on m.director_id = d.id and
                   exists(select * from actor join acting a on actor.id = a.actor_id
                   where actor.name = d.name and a.movie_id = m.id)
order by m.title ASC, d.name ASC;
select * from Q3
-- Q4.

create or replace view Q4 (name) as
-- replace the SQL code below:
select 'ABC'

;


-- Q5. 

create or replace view Q5(actor1, actor2) as
-- replace the SQL code below:
select 'ABC', 'DEF'

;


-- Q6. 


create or replace function
    experiencedActor(_m int, _n int) returns setof actor
as $$ 
declare
oldest int;
latest int;
duration int;
i record;
begin
    -- fill in the body
    for i in select * from actor
    loop

       select max(m.year) from acting ac
           join movie m on ac.movie_id = m.id
        where ac.actor_id = i.id
        into latest;

       select min(m.year) from acting ac
       join movie m on ac.movie_id = m.id
       where ac.actor_id = i.id
       into oldest;

       duration = latest - oldest + 1;
       if duration >= $1 and duration <= $2 then
           return next i;
           duration := -1;
            oldest := -1 ;
           latest := -1;
       end if;
    end loop;
end;
$$ language plpgsql;

-- Q7.
create or replace function genre_constraint() returns trigger
as
$$
declare
num_genre integer;
begin
    select count(*) from genre join movie m on genre.movie_id = m.id
    where m.id = old.movie_id into num_genre;
    if  num_genre < 6 then
        raise exception 'should not delete the genre';
    end if;
    return new;
end;
$$ language plpgsql;

create trigger rating_enforcement
    before delete
    on genre
    for each row
execute function genre_constraint();-- Define your trigger (or triggers) below


create or replace function keyword_constrant() returns trigger
as
$$
declare
    num_keyword integer;
begin
    select count(*) from keyword join movie m on keyword.movie_id = m.id
    where m.id = old.movie_id into num_keyword;
    if  num_keyword < 6 then
        raise exception 'should not delete the genre';
    end if;
    return new;
end;
$$ language plpgsql;

create trigger rating_enforcement
    before delete
    on genre
    for each row
execute function keyword_constrant();-- Define your trigger (or triggers) below
