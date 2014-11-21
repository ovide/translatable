- there are 2 main databases with a few tables, some tables are managed with different backend adapters:htop

1. translatable
  - table1    Model (same database)
  - table2    Model (same database)
  - table3    Collection (MongoDB)
2. translatable2
  - table1    Model (same database)
  - table2    Redis

- each table has at least a translatable field.
- translatable.table1 and translatable.table3 are n:m related through table2.
- translatable2.table1 has many translatable2.table2

