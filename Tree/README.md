## Tree builders
SimpleTreeBuilder converts flat format with parent_id into tree.

+----+-----------+
| id | parent_id |
+----+-----------+
|  1 |         0 |
|  2 |         1 |
|  3 |         1 |
+----+-----------+

NestedSetTreeBuilder converts flat format with left and right ids into tree.

+----+-----+-----+-------+
| id | lft | rgt | depth |
+----+-----+-----+-------+
|  1 |  10 |  11 |     1 |
|  2 |  10 |  11 |     1 |
|  3 |  12 |  13 |     1 |
+----+-----+-----+-------+