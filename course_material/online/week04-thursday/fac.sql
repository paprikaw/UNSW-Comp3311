create or replace function
   factorial(n integer) returns integer
as $fac$
declare
   i integer;
   fac integer := 1;
begin
   if (n < 1) then
      raise exception 'Invalid %!',n;
   end if;
   for i in 1..n loop
      fac := fac * i;
   end loop;
   return fac;
end;
$fac$ language plpgsql;


-- int factorial(int n) {...}
