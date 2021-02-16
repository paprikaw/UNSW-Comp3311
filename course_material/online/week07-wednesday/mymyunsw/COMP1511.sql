-- offerings of COMP1511

select termname(c.term)
from   Courses c join Subjects s on (c.subject = s.id)
where  s.code = 'COMP1511';


-- result in mymy1
 termname 
----------
(0 rows)

-- result in mymy2
 termname 
----------
 17s1
 17s2
 18s1
 18s2
 19T1
 19T2
 19T3
(7 rows)

