select pid, concat( firstname, ' ', lastname)  from
(select distinct p.pid, p.firstname, p.lastname, ii.brand  from person p, client c, insured_by ib, policy pp, insured_item ii
where
p.pid=c.pid and
      c.cid=ib.cid and
      ib.pno=pp.pno and
      pp.id=ii.id
order by p.pid) foo
group by pid, firstname, lastname
having count(brand) = (select count (distinct brand) from insured_item)
order by pid asc;

create or replace function staffcount(pno integer) returns integer
as $$
select count(foo.pno) from
(
select prr.pno,sid from policy_rating_record prr group by prr.pno, sid having prr.pno=pno
UNION
select p.pno, sid from policy p where p.pno =pno
UNION
select pur.pno, sid from policy_underwriting_record pur group by pur.pno, sid having pur.pno=pno
    ) foo;
$$ language sql



 select staffcount(1);


create or replace procedure renew(pno integer)
as $$
declare
    duration integer;
    policy_tuple record;
    coverage_tuple record;
    current_date date;
    new_pno integer;
    new_coid integer;
begin
    if $1 in (select p.pno from policy p)
        then
        new_coid := (select max(c.coid)  from coverage c) + 1;
        new_pno := (select max(p.pno)  from policy p) + 1;
        select * into policy_tuple from policy p where p.pno=$1;
        select * into coverage_tuple from coverage c where c.pno=$1;
        duration:=policy_tuple.expirydate-policy_tuple.effectivedate;

        insert into policy(pno, ptype, status, effectivedate, expirydate, agreedvalue, comments, sid, id)
        values (new_pno, policy_tuple.ptype, 'D', current_date, current_date + duration, policy_tuple.agreedvalue, policy_tuple.comments, policy_tuple.sid, policy_tuple.id);

        if exists(select * from coverage c where c.pno = $1)
        then
        insert into coverage(coid, cname, maxamount, comments, pno)
        values (new_coid, coverage_tuple.cname, coverage_tuple.maxamount, coverage_tuple.comments, new_pno);
        end if;

        if current_date <=policy_tuple.expirydate
               and current_date >= policy_tuple.effectivedate
            and policy_tuple.status='E'
        then
            update policy p
            set expirydate=current_date
            where p.pno=$1;
        end if;
    end if;
end
$$ language plpgsql;

call renew(3);

select current_date;

create or replace function involving_staff(pno integer) returns TABLE(sid integer) as
    $$
        select sid from (
            select distinct sid from policy_rating_record
            UNION
            select distinct sid from policy_underwriting_record
            UNION
             select distinct sid from policy
        ) foo
    $$ language sql;


create or replace function policy_constraint() returns trigger
as
    $$
    declare
        _pid integer;
        _sid integer;
    begin
        select pid from client c where c.cid = new.cid into _pid;
        select sid from staff s where s.pid = _pid into _sid;
        if found
        then
            select * from involving_staff(new.pno) as ivs where ivs.sid=_sid into _sid;
            if found
            then
                raise exception 'Only staff who is not invovling in this policy is allowed';
            end if;
        end if;
        return new;
    end;
    $$ language plpgsql;

create trigger policy_enforement
    before insert or update
    on insured_by
    for each row
    execute function policy_constraint();

insert into insured_by values (3, 3)
insert into client values (4, 5)
insert into insured_by values (5, 5);

create or replace function underwriting_constraint() returns trigger
as
$$
declare
_pno integer;
_sid integer;
begin
    select ur.pno from underwriting_record ur where ur.urid = new.urid into _pno;
    select sid from involving_staff(_pno) ivs where new.sid=ivs.sid into _sid;
    if found then
        raise exception 'Can not alter underwriting record since this staff have this policy';
    end if;
    return new;
end;
$$ language plpgsql;

create trigger underwriting_enforcement
    before insert or update
    on underwritten_by
    for each row
execute function underwriting_constraint();

update  underwritten_by set sid=8 where  urid = 4;


create or replace function rating_constraint() returns trigger
as
$$
declare
_pno integer;
_sid integer;
begin
    select c.pno from coverage c, rating_record rr where c.coid=rr.coid and rr.rid= new.rid into _pno;
    select sid from involving_staff(_pno) ivs where new.sid=ivs.sid into _sid;
    if found then
        raise exception 'Can not alter underwriting record since this staff have this policy';
    end if;
    return new;
end;
$$ language plpgsql;

create trigger rating_enforcement
    before insert or update
    on rated_by
    for each row
execute function rating_constraint();

update rated_by set sid=8 where rid=8;
drop trigger rating_enforcement on rating_record
select c.pno from coverage c, rating_record rr where c.coid=rr.coid and rr.rid=8
select sid from involving_staff(5) ivs where 8=ivs.sid
