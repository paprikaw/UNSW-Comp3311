-- students who have taken no courses

-- allStudents = first select
-- enrStudents = second select
-- result = (allStudents - enrStudents)

(select id from Students)
except
(select distinct student as id from course_enrolments)
;

-- or

select s.id
from   Students s
where  not exists (select *
                   from course_enrolments where student = s.id)
;

-- non-students who have taken courses

(select distinct student as id from course_enrolments)
except
(select id from Students)
;
