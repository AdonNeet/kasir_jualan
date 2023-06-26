<h1 align= "center">
  <b>
    kasir_jualan
  </b>
</h1>

A database CRUD implementation from php to MySQL (known as My Squirrel as joke) 

<br><br>

### Todo's Before Using It

+ Clone this repo inside the htdocs of xampp

```terminal
git clone https://github.com/AdonNeet/kasir_jualan.git
```

+ Deploy the market.sql into your MySQL

```terminal
mysql -u database_username -p database_name < [full dir path into...]/kasir_jualan/market.sql
```

+ Don't forget to edit the connDB.php

```php
$servername = "your-servername";
$username = "your-username";
$password = "your-pass";
$dbname = "your-deployed-DB";

```

+ Run insertStaff.php to insert the staff data
+ Acces https://localhost/kasir_jualan to run the application



<br>

### Note :  
+ Use xampp, because there was built-in PHP (jangan lupa set PHP di variabel environment pada komputer) 
+ Jangan lupa untuk mendeploy database (market.sql) pada MySQL


<br>


<h4 align= "left">
  AdonNeet (194)  -> Kelompok 10  <br>
    2023
</h4>
