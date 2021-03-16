# Week04 notes

# How to select a unit where there is no redandency of that praperty?
 My thoughts is to recognize same unit with their primary key. If there is two primary keys with same property, we can say there is redandency.
  If we have a database like this:

      id | brand  |    model     | year |   reg
    ----+--------+--------------+------+---------
      0 | Nissan | Micra K11 LX | 2005 | NTQ-254
      1 | Nissan | Micra K11 LX | 2009 | VCN-214
      3 | Nissan | Micra K11 LX | 2017 | LKH-886
      4 | Toyota | Camry Altise | 2014 | ATB-252
      7 | Honda  | Civic        | 2016 | TCL-222

  We can use
  ``` sql
  select * from insured_item v1 where not exists (select * from insured_item v2 where v1.reg <> v2.reg and v1.brand = v2.brand);
  ```


# 如何玩转Join？



# 如何玩转最值？
    
    当我们需要选择一个具有最值property的tuple时，我们可以考虑使用`ANY`或者`ALL`
    
    还是上面那个relation，如果我们需要选择年份最新的一辆车，我们可以使用：
    ``` sql
    select * from insured_item where year >= ALL (select year from insured_item);
    ```
    这里的逻辑是，如果这辆车的年份大于等于所有的车包括它自己，那么他就是最新的。

    同样的，如果我们需要选一辆最久的车，那么逻辑就是选一辆年份小于所有的车除了它自己。另一方面，如果我们需要选择除了最旧车的其他车之外，我们就可以想到只要有一部车比这辆车旧，那么它就不是最旧的：
    ``` sql
    select * from insured_item where year > ANY (select year from insured_item );
    ```



各种Union, intersect, except的操作

Distinct key word
    
思考下面这个query：
    
    select count(distinct brand) from insured)item:


# 如何玩转group, partition？

如果我们想要对某一个property aggregate, 那么我们就得考虑使用group

思考一下两个query的区别：
``` sql
select pno, id, agreedvalue, min(agreedvalue) over (partition by id), max(agreedvalue) over (partition by id) from policy where status='E' order by pno;
```
这个会produce以下这个table：
```
 pno | id | agreedvalue |  min  |  max
-----+----+-------------+-------+-------
   2 |  0 |       46500 | 46500 | 46500
   4 |  3 |       56500 | 56500 | 56500
   5 |  4 |       16500 | 16500 | 16500
   6 |  7 |       32500 | 20800 | 32500
   7 |  7 |       20800 | 20800 | 32500
```

如果是group的话：
``` sql
select id, min(agreedvalue), max(agreedvalue) from policy where status='E' group by id order by id;
```
produce:
```
 id |  min  |  max
----+-------+-------
  0 | 46500 | 46500
  3 | 56500 | 56500
  4 | 16500 | 16500
  7 | 20800 | 32500
(4 rows)
```

思考为什么下列的sql query是错误的？
``` sql
select pno, id, min(agreedvalue) from policy group by id
```

# Functions? 


