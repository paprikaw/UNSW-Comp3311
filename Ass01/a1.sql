create or replace view policy_rating_record(
        pno,
        sid,
        rid,
        status,
        rate,
        rdate
    ) as
select p.pno,
    rb.sid,
    rr.rid,
    rr.status,
    rr.rate,
    rb.rdate
from policy p,
    coverage c,
    rating_record rr,
    rated_by rb
where p.pno = c.pno
    and c.coid = rr.coid
    and rr.rid = rb.rid;
create or replace view policy_underwriting_record(
        pno,
        sid,
        urid,
        status,
        wdate
    ) as
select p.pno,
    ub.sid,
    ub.urid,
    ur.status,
    ub.wdate
from policy p,
    underwriting_record ur,
    underwritten_by ub
where p.pno = ur.pno
    and ur.urid = ub.urid;
create or replace view premium(pno, premium_rate) as
select po.pno,
    sum(r.rate) as premium_rate
from policy po,
    coverage c,
    rating_record r
where po.pno = c.pno
    and c.coid = r.coid
    and po.status = 'E'
    and r.status = 'A'
group by po.pno;
create or replace view brand_premium(brand, vid, pno, premium) as
select ii.brand,
    ii.id as vid,
    p.pno,
    p.premium_rate as premium
from premium p,
    insured_item ii,
    policy pp
where p.pno = pp.pno
    and pp.id = ii.id;
create or replace view spending_time (pno, duration) as
select foo1.pno,
    (end_time - start_time) as duration
from (
        select pno,
            min(rdate) as start_time
        from policy_rating_record
        group by pno
    ) foo1
    join (
        select pno,
            max(wdate) as end_time
        from policy_underwriting_record
        group by pno
    ) foo2 on foo1.pno = foo2.pno
    join policy p on foo1.pno = p.pno
where p.status = 'E';
create or replace view Q1(pid, firstname, lastname) as
select p.pid,
    p.firstname,
    p.lastname
from person p
where p.pid not in (
        (
            select c.pid
            from client c
        )
        UNION
        (
            select s.pid
            from staff s
        )
    )
order by p.pid;
create or replace view Q2(pid, firstname, lastname) as
select p.pid,
    p.firstname,
    p.lastname
from person p
where pid not in (
        select c.pid
        from policy p,
            insured_by ib,
            client c
        where p.pno = ib.pno
            and ib.cid = c.cid
            and p.status = 'E'
    );
create or replace view Q3(brand, vid, pno, premium) as
select *
from brand_premium bp
where bp.premium in (
        select max(bp.premium)
        from brand_premium bp
        group by brand
    )
order by brand,
    vid,
    pno desc;
create or replace view Q4(pid, firstname, lastname) as
select sid,
    firstname,
    lastname
from staff s,
    person p
where s.pid = p.pid
    and s.sid not in (
        select sid
        from (
                select distinct ub.sid
                from policy p,
                    underwriting_record ur,
                    underwritten_by ub
                where p.pno = ur.pno
                    and ur.urid = ub.urid
            ) FOO
        union
        (
            select p.sid
            from policy p,
                coverage c,
                rating_record rc,
                rated_by rb
            where p.status = 'E'
                and p.pno = c.pno
                and c.coid = rc.coid
                and rc.rid = rb.rid
            group by p.sid
        )
        union
        (
            select distinct p.sid
            from policy p
            where p.status = 'E'
        )
    );
create or replace view Q5(suburb, npolicies) as
select upper(suburb) as suburb,
    count(suburb) as npolicies
from (
        select p.suburb,
            pp.pno
        from policy pp,
            client c,
            person p,
            insured_by ib
        where ib.pno = pp.pno
            and ib.cid = c.cid
            and c.pid = p.pid
            and pp.status = 'E'
        group by p.suburb,
            pp.pno
    ) a
group by suburb
order by npolicies,
    suburb asc;
create or replace view staff_participation(
        pno,
        rate_staff,
        underwritting_staff,
        selling_staff
    ) as
select underw.pno,
    rate.sid as rate_staff,
    underw.sid as underwritting_staff,
    selling.sid as selling_staff
from (
        select p.pno,
            ub.sid
        from policy p,
            underwriting_record ur,
            underwritten_by ub
        where p.pno = ur.pno
            and ur.urid = ub.urid
        group by ub.sid,
            p.pno
    ) underw
    join (
        select p.pno,
            rb.sid
        from policy p,
            coverage c,
            rating_record rc,
            rated_by rb
        where p.status = 'E'
            and p.pno = c.pno
            and c.coid = rc.coid
            and rc.rid = rb.rid
        group by p.pno,
            rb.sid
    ) rate on underw.pno = rate.pno
    join (
        select pno,
            sid
        from policy
        where policy.status = 'E'
    ) selling on underw.pno = selling.pno;
create or replace view policy_staff_num(pno, policy_staff_number) as
select pno,
    count(pno)
from staff_participation
group by pno;
create or replace view Q6(pno, ptype, pid, firstname, lastname) as
select p.pno,
    p.ptype,
    pp.pid,
    pp.firstname,
    pp.lastname
from policy p,
    person pp
where p.id = pp.pid
    and p.pno in (
        select pno
        from policy_staff_num
        where policy_staff_number = 1
        intersect
        select pno
        from staff_participation
        where rate_staff = selling_staff
            and selling_staff = underwritting_staff
    );
create or replace view Q7(
        pno,
        ptype,
        effectivedate,
        expirydate,
        agreedvalue
    ) as
select p.pno,
    p.ptype,
    p.effectivedate,
    p.expirydate,
    agreedvalue
from spending_time st
    join policy p on st.pno = p.pno
where st.duration >= ALL(
        select duration
        from spending_time
    );

create or replace view Q8(pid, name, brand) as
select p.pid,
    concat(p.firstname, ' ', p.lastname) as name,
    foo3.brand
from (
        select foo1.sid,
            foo2.brand
        from (
                select sid
                from(
                        select p.sid,
                            ii.brand
                        from policy p,
                            insured_item ii
                        where p.id = ii.id
                            and p.status = 'E'
                        group by p.sid,
                            ii.brand
                    ) a
                group by sid
                having count(sid) = 1
            ) foo1
            join (
                select p.sid,
                    ii.brand
                from policy p,
                    insured_item ii
                where p.id = ii.id
                    and p.status = 'E'
                group by p.sid,
                    ii.brand
            ) foo2 on foo1.sid = foo2.sid
    ) foo3,
    staff s,
    person p
where foo3.sid = s.sid
    and s.pid = p.pid;

create or replace view Q9(pid, name) as
select pid, concat( firstname, ' ', lastname) as name from
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
    language sql
as
$$
select count(foo.pno) from
(
select prr.pno,sid from policy_rating_record prr group by prr.pno, sid having prr.pno=$1
UNION
select p.pno, sid from policy p where p.pno =$1
UNION
select pur.pno, sid from policy_underwriting_record pur group by pur.pno, sid having pur.pno=$1
    ) foo;
$$;


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

/* Below functions and triggers are for Q12 */

/* Select all the staffs involving in one policy */
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

