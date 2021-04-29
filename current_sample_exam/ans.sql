-- COMP3311 21T1 Exam SQL Answer Template
--
-- * Don't change view names and view arguments;
-- * Only change the SQL code for view as commented below;
-- * and do not remove the ending semicolon of course.
--
-- * You may create additional views, if you wish;
-- * but you are not allowed to create tables.
--


-- Q1. Find the brewers whose beers John likes.

create or replace view Q1(brewer) as
select b2.name from drinkers d
                        join likes l on d.id = l.drinker
                        join beers b on l.beer = b.id
                        join brewers b2 on b.brewer = b2.id
where d.name = 'John' ;
select 'ABC'

;


-- Q2. How many beers does each brewer make?

create or replace view Q2(brewer, nbeers) as
select brewers.name, count(b.name) from brewers
join beers b on brewers.id = b.brewer
group by brewers.name;


-- Q3. Beers sold at bars where John drinks.
create or replace view Q3(beer) as
(select distinct b2.name as beer from
    bars b join sells s on b.id = s.bar
           join beers b2 on s.beer = b2.id)
INTERSECT
(select b.name from drinkers d
                        join likes l on d.id = l.drinker
                        join beers b on l.beer = b.id
                        join brewers b2 on b.brewer = b2.id
 where d.name = 'John');


-- Q4. What is the most expensive beer?

create or replace view Q4(beer) as
select beers.name, price from
beers join sells s on beers.id = s.beer
where price = (
    select max(s.price)
    from sells s
)
order by beers.name ASC;


-- Q5. Find the average price of common beers
create or replace view Q5(beer, "AvgPrice") as
select beers.name, avg(s.price)::numeric(4,1), count(beers.name) from
    beers join sells s on beers.id = s.beer
          join bars b on s.bar = b.id
group by beers.name
having count(beers.name) > 2
order by name ASC ;

create or replace view Bar_min_price as
select b.id, b.name as bar, min(s.price)::numeric(5,2) as min_price
from   Bars b
         join Sells s on (b.id=s.bar)
group  by b.id, b.name
;

-- Q6. Name of cheapest beer at each bar?

create or replace view Q6(bar, beer) as
    select a.name, a.min, b2.name from (
                                    select bars.name, min(s.price)
                                    from bars
                                             join sells s on bars.id = s.bar
                                             join beers b on s.beer = b.id
                                    group by bars.name
                                ) a
join sells s on s.price = a.min
join beers b2 on s.beer = b2.id;

