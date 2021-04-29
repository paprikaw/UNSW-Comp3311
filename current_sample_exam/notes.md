

# Join
当我们使用join的时候需要思考join的两个relationship 是total还是partial的 

# RA 例题
select a,c from R join S on (b=d) where c < 0
Proj [a,c](select[c < 0](R Join[b=d] S))

select a, b from R join S on R.s = S.s
Proj[a, b] (Join R [s = ss] (Rename[S(a,b,ss)](S)))

# BCNF
Example:

# #NF
