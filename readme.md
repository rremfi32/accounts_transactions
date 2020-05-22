Project created with stack: php7.2, symfony 5, PostgreSQL 12.2
Steps for building application:
1. Create postgre database 'account_transactions' with  and set in your .env file 
connection to db. 
For example, 
DATABASE_URL=postgresql://user:password@localhost:5432/account_transactions
2. Run $composer update and $composer install for dependency injection in project
3. Execute migrations in src/Migrations
4. Run server - execute $symfony server:start.
4. Run command app:import-accounts import/accounts.csv or use your file with this kind
   of file structure
5. Perform testing, link to api method - your_host:port/transaction   

