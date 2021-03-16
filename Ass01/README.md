# Assignment notes


1. List all persons that are neither clients nor staff members. Order the result by pid in ascending order. 
``` sql
create or replace view Q1(pid, firstname, lastname) as
select p.pid, p.firstname, p.lastname from person p
where p.pid not in
((select c.pid from client c) UNION (select s.pid from staff s))
order by p.pid;
```
这道题主要考察对`UNION`和`IN`语句的掌握

