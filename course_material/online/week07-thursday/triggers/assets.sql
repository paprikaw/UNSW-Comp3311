--
--  Triggers to maintain Branch assets as
--    sum of Account balances at that branch
--
--  (select assets from Branch where id = b)
--  ==
--  (select sum(balance) from Accounts where branch = b)
--

--
-- function to fix Branch assets when new account added
--
-- triggered by insert into Accounts(id,branch,balance) values (...)

create or replace function
   include_new_customer_assets() returns trigger
as $$
begin
   update Branches
   set    assets = assets + new.balance
   where  location = new.branch;
   return new;
end;
$$ language plpgsql;

--
-- set trigger to invoke function when new Account tuple inserted
--
create trigger new_assets
after insert on Accounts
for each row execute
procedure include_new_customer_assets();


-- function to adjust Branch assets for cases:
-- * customer deposits funds into account
-- * customer withdraws funds from account
-- * customer moves account to a different branch

-- update from Accounts set balance = 0 where id = X
-- old (X,branch,balance) ... new (X,branch,0)
-- update Accounts set branch = Y where id = X
-- old (X,branch,balance) ... new (X,Y,balance)

create or replace function
   update_customer_assets() returns trigger
as $$
begin
   update Branches
   set    assets = assets - old.balance
   where  location = old.branch;
   update Branches
   set    assets = assets + new.balance
   where  location = new.branch;
   return new;
end;
$$ language plpgsql;

--
-- set trigger to invoke function when Account tuple updated
--
create trigger changed_assets
after update on Accounts
for each row execute
procedure update_customer_assets();
