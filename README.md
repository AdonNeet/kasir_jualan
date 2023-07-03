<h1 align= "center">
  <b>
    kasir_jualan
  </b>
</h1>

A database CRUD implementation from php to MySQL (known as My Squirrel as joke)  

[Member ID: 194, 228, 229]

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
```terminal
php [full dir path into...]/kasir_jualan/inserStaff.php
```
There is a staff account that was set-ed in insertStaff.php
| ID    | Name         | Job         | Pass         |
| :---  |    :----:    |    :----:   |         ---: |
| G01   | Bara         | Warehouse   | qwertyui     |
| G02   | Damar        | Warehouse   | asdfghjk     |
| K01   | Azza         | Cashier     | 12345678     |

+ Acces https://localhost/kasir_jualan to run the application



<br>

### Note   
+ Use xampp, because there was built-in PHP (Don't forget to set PHP in variabel environment on your computer) 
+ Don't forget to deploy the database (market.sql) in MySQL
+ Don't forget to turn on the Apache and MySQL server in xampp when you want to run the application


<br>


<h4 align= "left">
  AdonNeet (194)  -> Kelompok 10  <br>
    2023
</h4>
