-- Relies on you knowing that the grid refs used in the unsw map
-- use A-L for north to south, and 1-27 for west to east
-- example: K17 ... roughly mid east-west, close to southern boundary

-- There seems to be a rogue entry with gridref BS38

-- A possible solution ...

drop view if exists Building_locations;

create view Building_locations
as
select id, name, gridref,
       substr(gridref,1,1) as north_south,
       substr(gridref,2,2)::integer as east_west
from   Buildings
where  campus = 'K';  -- only want Kensington campus

select name, gridref, north_south, east_west
from   Building_locations
order  by east_west;

select name, gridref
from   Building_locations
where  east_west = (select max(east_west) from Building_locations);

-- I give up ... too many buildings have gridrefs like C8A
-- I suspect that if they're removed, the ::integer will work
