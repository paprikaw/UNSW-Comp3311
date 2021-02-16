-- Q12.sql and Q13.sql

-- Bars where either Gernot or John drink.
-- SetOfGernotBars union SetOfJohnBars

(select bar from frequents where drinker='Gernot')
union
(select bar from frequents where drinker='John');

-- Bars where both Gernot and John drink.
-- SetOfGernotBars intersect SetOfJohnBars

(select bar from frequents where drinker='Gernot')
intersect
(select bar from frequents where drinker='John');
