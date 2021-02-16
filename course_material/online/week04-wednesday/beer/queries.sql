-- Q.1 What is the price of the cheapest beer at each bar?

select bar,min(price) from Sells group by bar;


-- Q.2 What is the name of the cheapest beer at each bar?

-- easier if we create a view for cheapest prices

create view Bargains(bar,cheapest) as
   select bar,min(price) from Sells group by bar;


-- find all beers such that they're sold at a price
-- equal to the cheapest price in the bar where they're sold

select s.bar,s.beer
from   Sells s
where  s.price = (select cheapest from Bargains where bar=s.bar)
order by bar;

-- alternatively

select s.bar,s.beer,s.price
from   Sells s, Bargains p
where  s.bar=p.bar and s.price=p.cheapest;


-- Q3. Beers that are sold in all Bars.

-- foreach Beer b {
--    AllBars = names of all Bars
--    OurBars = names of Bars where b is sold
--    if (AllBars == OurBars) { we have a result }
-- }
--
-- Since PostgreSQL does not have a set equality test,
-- we are forced to use a test like:  isEmpty(AllBars-OurBars)
--
-- This gives an implementation of relational algebra Division

create or replace view q18
as
select b.name
from   Beers b
where  not exists (
	(select name as bar from Bars)
	except
	(select bar from Sells where beer = b.name)
	)
;


-- Q4. How many bars are there in suburbs where drinkers live?

-- Need to ensure that all subrurbs where drinkers live are included
-- Outer Join gives this, plus property of count(NULL) == 0

select d.addr, count(b.name)
from   Drinkers d left outer join Bars b using (addr)
group  by d.addr;

