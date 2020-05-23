Project created with stack: php7.4, symfony 5, PostgreSQL 12.2

Steps for building application:
1. Create postgre database <i>'account_transactions'</i> (or another name) and set connection string in your .env file 
connection to db. For example, <i>DATABASE_URL=postgresql://user:password@localhost:5432/account_transactions</i><br>
2. Run <i>composer update</i> and <i>composer install</i> for dependency injection in project.<br>
3. Execute migrations in src/Migrations:<br>
   <i>bin/console doctrine:migrations:execute 20200522105829</i><br>
   <i>bin/console doctrine:migrations:execute 20200522112730</i><br>
   <i>bin/console doctrine:migrations:execute 20200522125452</i><br>
   <b>Don't forget to install pgsql extention in php (sudo apt install php7.4-pgslq).</b>
4. Run server - execute <i>symfony server:start</i>.<br>
5. Run command <i>bin/console app:import-accounts import/accounts.csv</i> or use your file with this kind
   of file structure.<br>
6. Perform testing, link to api method - <i>your_host:port/transaction</i>   

