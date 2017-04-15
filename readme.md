Fake Customer Gateway
=====================

damian@troyweb.com

[Challenge Problem](./challenge-problem.md)

## Install

You will need to have [Composer](https://getcomposer.org/doc/00-intro.md) and PHP v7.0 or greater installed.

Create a file called package.json in your project root and paste in the following:

```json
{
    "name": "albany-can-code/php-challenge-problem",
    "require": {}
}
```

Run the following command to add this package to the dependency list of your project.

`composer require damiantw/fake-customer-gateway`

Require the Composer autoload file and import the namespace in your PHP script.

```php
<?php

require_once __DIR__.'/vendor/autoload.php';

use \DamianTW\FakeCustomerGateway\CustomerGateway;


```

## Usage

Create an instance of `CustomerGateway`

```php
<?php

require_once __DIR__.'/vendor/autoload.php';

use \DamianTW\FakeCustomerGateway\CustomerGateway;

$customerGateway = new CustomerGateway();
```

Use the following methods to interact with the customer data:

```php
<?php 

require_once __DIR__.'/vendor/autoload.php';

use \DamianTW\FakeCustomerGateway\CustomerGateway;

$customerGateway = new CustomerGateway();

/*
 * Data Retrieval
 */

//Returns an array of all of the customers.
$customerGateway->all();

//Returns a paginated array of customers.
$customerGateway->paginate($pageNumber, $perPage);

//Returns an array of all customer sorted on the selected field in ascending order.
//$field can be any of the following strings: 'id', 'name', 'company', 'email', 'phone_number'
$customerGateway->sortByAsc($field);

//Returns an array of all customer sorted on the selected field in descending order.
//$field can be any of the following strings: 'id', 'name', 'company', 'email', 'phone_number'
$customerGateway->sortByDesc($field);

//Returns a paginated array of all customer sorted on the selected field in ascending order.
//$field can be any of the following strings: 'id', 'name', 'company', 'email', 'phone_number'
$customerGateway->sortByPaginatedAsc($field, $pageNumber, $perPage);

//Returns a paginated array of all customer sorted on the selected field in descending order.
//$field can be any of the following strings: 'id', 'name', 'company', 'email', 'phone_number'
$customerGateway->sortByPaginatedDesc($field, $pageNumber, $perPage);

//Returns the number of customer records
$customerGateway->count();

//Returns the customer with the given id. Throws an exception if no user with that id is found.
$customerGateway->get($id);

/*
 * Data Manipulation
 */

//Add a customer record.
//Requires a value for at least the $name field or an exception will be thrown.
//Returns the automatically generated id of the new customer.
$customerGateway->add($name, $company, $email, $phone_number);

//Update a customer record.
//Throws an exception if there is no user with the given id.
$customerGateway->update($id, $name, $company, $email, $phone_number);

//Delete a customer record.
//Throws an exception if there is no user with the given id.
$customerGateway->delete($id);
```

### Usage Example

Suppose you wanted to print out an HTML unordered list containing all of the customers ids and names.

```php
<?php 

require_once __DIR__.'/vendor/autoload.php';

use \DamianTW\FakeCustomerGateway\CustomerGateway;

$customerGateway = new CustomerGateway();

echo '<ul>';

foreach ($customerGateway->all() as $customer) {
    echo "<li>$customer->id - $customer->name</li>";   
}

echo '</ul>';

```

### Persisting Data Changes

The `CustomerGateway` instance will build an in memory data structure to hold the customer data when it is created.
 
By default, any changes that are made to the customer data will not persist between requests.

Functions are provided that allow for saving the current state of customer data to a file on disk and 
the ability for the CustomerGateway instance to restore customer data state by loading one of these files.

```php
<?php 

require_once __DIR__.'/vendor/autoload.php';

use \DamianTW\FakeCustomerGateway\CustomerGateway;

$customerGateway = new CustomerGateway();

/*
 * Saves the current state of customer data to disk.
 * Returns false if the file write was not successful.
 * Make sure PHP has permission to write to the directory you choose!
 * Include this at the bottom of any PHP script that changes data.
 * $pathToFile example: './customers.db'.
 */
$customerGateway->saveDataFile($pathToFile);

/*
 * Overwrites the default customer data given a file generated using the saveDataFile function.
 * No changes will be made to the CustomerGateways data if the file does not exist.
 * Returns false if the given file does not exist.
 * Loading the data file should be one of the first tasks of your PHP script if persisting data.
 * $pathToFile example: './customers.db'.
 */
$customerGateway->loadDataFileIfExists($pathToFile);
```

### Sample Data

Default output of `var_dump($customerGateway->all());`

```
array (size=50)
  0 => 
    object(DamianTW\FakeCustomerGateway\Customer)[55]
      public 'id' => int 1
      public 'name' => string 'Aimee Weissnat' (length=14)
      public 'company' => string 'Wisozk, Nikolaus and Watsica' (length=28)
      public 'email' => string 'alba.daniel@example.org' (length=23)
      public 'phone_number' => string '1-874-459-9351 x043' (length=19)
  1 => 
    object(DamianTW\FakeCustomerGateway\Customer)[56]
      public 'id' => int 2
      public 'name' => string 'Linda Runolfsdottir Sr.' (length=23)
      public 'company' => string 'Jaskolski-Schuster' (length=18)
      public 'email' => string 'krajcik.conner@example.org' (length=26)
      public 'phone_number' => string '393-268-1544' (length=12)
  2 => 
    object(DamianTW\FakeCustomerGateway\Customer)[57]
      public 'id' => int 3
      public 'name' => string 'Kelvin Greenholt' (length=16)
      public 'company' => string 'Schulist, Tromp and Haag' (length=24)
      public 'email' => string 'rita34@example.net' (length=18)
      public 'phone_number' => string '1-574-618-9692 x2919' (length=20)
  3 => 
    object(DamianTW\FakeCustomerGateway\Customer)[58]
      public 'id' => int 4
      public 'name' => string 'Ned Kulas' (length=9)
      public 'company' => string 'Rau-Daniel' (length=10)
      public 'email' => string 'pouros.lizzie@example.org' (length=25)
      public 'phone_number' => string '234-835-2578' (length=12)
  4 => 
    object(DamianTW\FakeCustomerGateway\Customer)[59]
      public 'id' => int 5
      public 'name' => string 'Herminia Jakubowski DDS' (length=23)
      public 'company' => string 'Grady-Johnson' (length=13)
      public 'email' => string 'jarred.haley@example.com' (length=24)
      public 'phone_number' => string '(323) 815-8407 x08442' (length=21)
  5 => 
    object(DamianTW\FakeCustomerGateway\Customer)[60]
      public 'id' => int 6
      public 'name' => string 'Dr. Jedediah Jacobi' (length=19)
      public 'company' => string 'Littel, Altenwerth and Watsica' (length=30)
      public 'email' => string 'miguel.nolan@example.com' (length=24)
      public 'phone_number' => string '(412) 673-4191 x3666' (length=20)
  6 => 
    object(DamianTW\FakeCustomerGateway\Customer)[61]
      public 'id' => int 7
      public 'name' => string 'Jean Hane PhD' (length=13)
      public 'company' => string 'Kovacek, Rath and Gorczany' (length=26)
      public 'email' => string 'leonel.kuhic@example.net' (length=24)
      public 'phone_number' => string '743-583-6179' (length=12)
  7 => 
    object(DamianTW\FakeCustomerGateway\Customer)[62]
      public 'id' => int 8
      public 'name' => string 'Treva Boehm' (length=11)
      public 'company' => string 'Schamberger-Koss' (length=16)
      public 'email' => string 'haley30@example.net' (length=19)
      public 'phone_number' => string '+1-952-668-8764' (length=15)
  8 => 
    object(DamianTW\FakeCustomerGateway\Customer)[63]
      public 'id' => int 9
      public 'name' => string 'Stanford Rempel' (length=15)
      public 'company' => string 'Klein, Kassulke and Carter' (length=26)
      public 'email' => string 'nitzsche.tod@example.com' (length=24)
      public 'phone_number' => string '(913) 983-0041 x22471' (length=21)
  9 => 
    object(DamianTW\FakeCustomerGateway\Customer)[64]
      public 'id' => int 10
      public 'name' => string 'Dr. Willard Haag' (length=16)
      public 'company' => string 'Mills-Heidenreich' (length=17)
      public 'email' => string 'lindgren.janick@example.org' (length=27)
      public 'phone_number' => string '634-265-2601' (length=12)
  10 => 
    object(DamianTW\FakeCustomerGateway\Customer)[65]
      public 'id' => int 11
      public 'name' => string 'Karina King' (length=11)
      public 'company' => string 'Larkin Group' (length=12)
      public 'email' => string 'uorn@example.net' (length=16)
      public 'phone_number' => string '1-505-264-5229' (length=14)
  11 => 
    object(DamianTW\FakeCustomerGateway\Customer)[66]
      public 'id' => int 12
      public 'name' => string 'Margarette Mertz' (length=16)
      public 'company' => string 'Mayert-Collier' (length=14)
      public 'email' => string 'ahmad30@example.com' (length=19)
      public 'phone_number' => string '962-316-6876' (length=12)
  12 => 
    object(DamianTW\FakeCustomerGateway\Customer)[67]
      public 'id' => int 13
      public 'name' => string 'Jerome Howe' (length=11)
      public 'company' => string 'Champlin Group' (length=14)
      public 'email' => string 'avery.bosco@example.org' (length=23)
      public 'phone_number' => string '790-923-7396 x449' (length=17)
  13 => 
    object(DamianTW\FakeCustomerGateway\Customer)[68]
      public 'id' => int 14
      public 'name' => string 'Dr. Lillie Legros' (length=17)
      public 'company' => string 'Leffler-Klein' (length=13)
      public 'email' => string 'oconnell.joelle@example.org' (length=27)
      public 'phone_number' => string '(412) 510-1100 x71640' (length=21)
  14 => 
    object(DamianTW\FakeCustomerGateway\Customer)[69]
      public 'id' => int 15
      public 'name' => string 'Harry Cole' (length=10)
      public 'company' => string 'Gutmann-Bechtelar' (length=17)
      public 'email' => string 'coby67@example.org' (length=18)
      public 'phone_number' => string '1-231-933-1118' (length=14)
  15 => 
    object(DamianTW\FakeCustomerGateway\Customer)[70]
      public 'id' => int 16
      public 'name' => string 'Lila Keeling' (length=12)
      public 'company' => string 'Hammes Inc' (length=10)
      public 'email' => string 'will.sigmund@example.org' (length=24)
      public 'phone_number' => string '249-446-6752 x50657' (length=19)
  16 => 
    object(DamianTW\FakeCustomerGateway\Customer)[71]
      public 'id' => int 17
      public 'name' => string 'Addie McGlynn' (length=13)
      public 'company' => string 'Zulauf Group' (length=12)
      public 'email' => string 'nolan30@example.org' (length=19)
      public 'phone_number' => string '229-236-0013' (length=12)
  17 => 
    object(DamianTW\FakeCustomerGateway\Customer)[72]
      public 'id' => int 18
      public 'name' => string 'Louvenia Huels' (length=14)
      public 'company' => string 'Von and Sons' (length=12)
      public 'email' => string 'hettinger.elwyn@example.com' (length=27)
      public 'phone_number' => string '(802) 794-3920' (length=14)
  18 => 
    object(DamianTW\FakeCustomerGateway\Customer)[73]
      public 'id' => int 19
      public 'name' => string 'Jodie Reilly Sr.' (length=16)
      public 'company' => string 'Collier and Sons' (length=16)
      public 'email' => string 'considine.cyril@example.net' (length=27)
      public 'phone_number' => string '216-673-3795' (length=12)
  19 => 
    object(DamianTW\FakeCustomerGateway\Customer)[74]
      public 'id' => int 20
      public 'name' => string 'Dr. Bernard Mohr II' (length=19)
      public 'company' => string 'Hand Inc' (length=8)
      public 'email' => string 'zoila82@example.com' (length=19)
      public 'phone_number' => string '(535) 362-1292' (length=14)
  20 => 
    object(DamianTW\FakeCustomerGateway\Customer)[75]
      public 'id' => int 21
      public 'name' => string 'Mr. Torey Bahringer IV' (length=22)
      public 'company' => string 'Brekke, D'Amore and Kozey' (length=25)
      public 'email' => string 'geovany.purdy@example.com' (length=25)
      public 'phone_number' => string '1-728-653-2980 x445' (length=19)
  21 => 
    object(DamianTW\FakeCustomerGateway\Customer)[76]
      public 'id' => int 22
      public 'name' => string 'Dr. Milan Schulist' (length=18)
      public 'company' => string 'Keebler and Sons' (length=16)
      public 'email' => string 'matt09@example.com' (length=18)
      public 'phone_number' => string '(947) 223-2012' (length=14)
  22 => 
    object(DamianTW\FakeCustomerGateway\Customer)[77]
      public 'id' => int 23
      public 'name' => string 'Trinity Zboncak I' (length=17)
      public 'company' => string 'Christiansen Ltd' (length=16)
      public 'email' => string 'istroman@example.net' (length=20)
      public 'phone_number' => string '571.246.7085 x169' (length=17)
  23 => 
    object(DamianTW\FakeCustomerGateway\Customer)[78]
      public 'id' => int 24
      public 'name' => string 'Mr. Gaylord Herzog' (length=18)
      public 'company' => string 'Zulauf, West and Bode' (length=21)
      public 'email' => string 'aiden.grady@example.net' (length=23)
      public 'phone_number' => string '+12415834185' (length=12)
  24 => 
    object(DamianTW\FakeCustomerGateway\Customer)[79]
      public 'id' => int 25
      public 'name' => string 'Mrs. Adrienne Jacobi' (length=20)
      public 'company' => string 'Casper LLC' (length=10)
      public 'email' => string 'hmccullough@example.org' (length=23)
      public 'phone_number' => string '(257) 746-8737 x01549' (length=21)
  25 => 
    object(DamianTW\FakeCustomerGateway\Customer)[80]
      public 'id' => int 26
      public 'name' => string 'Kristy Trantow' (length=14)
      public 'company' => string 'Upton-Kunde' (length=11)
      public 'email' => string 'stanford91@example.org' (length=22)
      public 'phone_number' => string '1-562-201-1590' (length=14)
  26 => 
    object(DamianTW\FakeCustomerGateway\Customer)[81]
      public 'id' => int 27
      public 'name' => string 'Milton Bins' (length=11)
      public 'company' => string 'Langworth, Feest and Erdman' (length=27)
      public 'email' => string 'larry.conn@example.com' (length=22)
      public 'phone_number' => string '+1-650-922-8502' (length=15)
  27 => 
    object(DamianTW\FakeCustomerGateway\Customer)[82]
      public 'id' => int 28
      public 'name' => string 'Delores Erdman' (length=14)
      public 'company' => string 'Bailey-Keeling' (length=14)
      public 'email' => string 'barton.brooklyn@example.org' (length=27)
      public 'phone_number' => string '+1.689.710.6289' (length=15)
  28 => 
    object(DamianTW\FakeCustomerGateway\Customer)[83]
      public 'id' => int 29
      public 'name' => string 'Vanessa Beahan V' (length=16)
      public 'company' => string 'Waters-Gleichner' (length=16)
      public 'email' => string 'fleta.erdman@example.net' (length=24)
      public 'phone_number' => string '532-324-2347 x03800' (length=19)
  29 => 
    object(DamianTW\FakeCustomerGateway\Customer)[84]
      public 'id' => int 30
      public 'name' => string 'Therese Boehm' (length=13)
      public 'company' => string 'Quitzon, Harvey and Schmeler' (length=28)
      public 'email' => string 'rolfson.emmet@example.com' (length=25)
      public 'phone_number' => string '1-332-486-6999' (length=14)
  30 => 
    object(DamianTW\FakeCustomerGateway\Customer)[85]
      public 'id' => int 31
      public 'name' => string 'Mrs. Eldora Rippin I' (length=20)
      public 'company' => string 'Hirthe, Bartoletti and Wolff' (length=28)
      public 'email' => string 'lavinia55@example.net' (length=21)
      public 'phone_number' => string '449-586-6653' (length=12)
  31 => 
    object(DamianTW\FakeCustomerGateway\Customer)[86]
      public 'id' => int 32
      public 'name' => string 'Candida Mertz' (length=13)
      public 'company' => string 'O'Hara and Sons' (length=15)
      public 'email' => string 'miller.megane@example.com' (length=25)
      public 'phone_number' => string '(763) 716-4168' (length=14)
  32 => 
    object(DamianTW\FakeCustomerGateway\Customer)[87]
      public 'id' => int 33
      public 'name' => string 'Dr. Jocelyn Stroman Sr.' (length=23)
      public 'company' => string 'Herman, Leffler and Kautzer' (length=27)
      public 'email' => string 'lexi.fritsch@example.net' (length=24)
      public 'phone_number' => string '+1 (515) 539-9891' (length=17)
  33 => 
    object(DamianTW\FakeCustomerGateway\Customer)[88]
      public 'id' => int 34
      public 'name' => string 'Myah Farrell Sr.' (length=16)
      public 'company' => string 'Simonis-Ernser' (length=14)
      public 'email' => string 'wolff.maryjane@example.com' (length=26)
      public 'phone_number' => string '701.879.3640 x26029' (length=19)
  34 => 
    object(DamianTW\FakeCustomerGateway\Customer)[89]
      public 'id' => int 35
      public 'name' => string 'Jordy Zulauf' (length=12)
      public 'company' => string 'Schaefer Inc' (length=12)
      public 'email' => string 'eugenia.ryan@example.com' (length=24)
      public 'phone_number' => string '273.913.6122' (length=12)
  35 => 
    object(DamianTW\FakeCustomerGateway\Customer)[90]
      public 'id' => int 36
      public 'name' => string 'Nathen Champlin PhD' (length=19)
      public 'company' => string 'Waelchi-Price' (length=13)
      public 'email' => string 'bertrand.prohaska@example.com' (length=29)
      public 'phone_number' => string '798-488-1104' (length=12)
  36 => 
    object(DamianTW\FakeCustomerGateway\Customer)[91]
      public 'id' => int 37
      public 'name' => string 'Euna Nolan Jr.' (length=14)
      public 'company' => string 'Sauer and Sons' (length=14)
      public 'email' => string 'qdare@example.com' (length=17)
      public 'phone_number' => string '746.866.9099 x9193' (length=18)
  37 => 
    object(DamianTW\FakeCustomerGateway\Customer)[92]
      public 'id' => int 38
      public 'name' => string 'Dawson O'Hara' (length=13)
      public 'company' => string 'Schroeder-Nader' (length=15)
      public 'email' => string 'hokeefe@example.net' (length=19)
      public 'phone_number' => string '+1-863-732-2936' (length=15)
  38 => 
    object(DamianTW\FakeCustomerGateway\Customer)[93]
      public 'id' => int 39
      public 'name' => string 'Sarai Murphy' (length=12)
      public 'company' => string 'Kassulke-Kessler' (length=16)
      public 'email' => string 'eryn.leuschke@example.com' (length=25)
      public 'phone_number' => string '(821) 838-5359' (length=14)
  39 => 
    object(DamianTW\FakeCustomerGateway\Customer)[94]
      public 'id' => int 40
      public 'name' => string 'Melba Bechtelar' (length=15)
      public 'company' => string 'Bode-Ledner' (length=11)
      public 'email' => string 'glueilwitz@example.net' (length=22)
      public 'phone_number' => string '+1-568-546-1768' (length=15)
  40 => 
    object(DamianTW\FakeCustomerGateway\Customer)[95]
      public 'id' => int 41
      public 'name' => string 'Miss Alanis Reichert' (length=20)
      public 'company' => string 'Russel PLC' (length=10)
      public 'email' => string 'erica52@example.org' (length=19)
      public 'phone_number' => string '493-607-2040 x67005' (length=19)
  41 => 
    object(DamianTW\FakeCustomerGateway\Customer)[96]
      public 'id' => int 42
      public 'name' => string 'Aryanna Lesch III' (length=17)
      public 'company' => string 'Weimann-Herman' (length=14)
      public 'email' => string 'sierra77@example.com' (length=20)
      public 'phone_number' => string '1-549-667-7265 x42737' (length=21)
  42 => 
    object(DamianTW\FakeCustomerGateway\Customer)[97]
      public 'id' => int 43
      public 'name' => string 'Georgiana Aufderhar' (length=19)
      public 'company' => string 'Kassulke-Gerlach' (length=16)
      public 'email' => string 'dovie13@example.net' (length=19)
      public 'phone_number' => string '743.789.8000 x761' (length=17)
  43 => 
    object(DamianTW\FakeCustomerGateway\Customer)[98]
      public 'id' => int 44
      public 'name' => string 'Naomi Rowe' (length=10)
      public 'company' => string 'Kiehn-Howe' (length=10)
      public 'email' => string 'bernier.lorenza@example.com' (length=27)
      public 'phone_number' => string '730-287-9052' (length=12)
  44 => 
    object(DamianTW\FakeCustomerGateway\Customer)[99]
      public 'id' => int 45
      public 'name' => string 'Dr. Ellis Lehner' (length=16)
      public 'company' => string 'Rempel-Parker' (length=13)
      public 'email' => string 'nyah24@example.org' (length=18)
      public 'phone_number' => string '+1-920-552-6746' (length=15)
  45 => 
    object(DamianTW\FakeCustomerGateway\Customer)[100]
      public 'id' => int 46
      public 'name' => string 'Sonya Champlin' (length=14)
      public 'company' => string 'Langworth-Kshlerin' (length=18)
      public 'email' => string 'wreynolds@example.com' (length=21)
      public 'phone_number' => string '1-968-592-3705 x1689' (length=20)
  46 => 
    object(DamianTW\FakeCustomerGateway\Customer)[101]
      public 'id' => int 47
      public 'name' => string 'Destiney Green' (length=14)
      public 'company' => string 'Howell, Boehm and Gaylord' (length=25)
      public 'email' => string 'umacejkovic@example.org' (length=23)
      public 'phone_number' => string '947.756.8528 x86248' (length=19)
  47 => 
    object(DamianTW\FakeCustomerGateway\Customer)[102]
      public 'id' => int 48
      public 'name' => string 'Mona Mertz' (length=10)
      public 'company' => string 'Zboncak-O'Connell' (length=17)
      public 'email' => string 'demetris.kassulke@example.com' (length=29)
      public 'phone_number' => string '705.976.9662 x355' (length=17)
  48 => 
    object(DamianTW\FakeCustomerGateway\Customer)[103]
      public 'id' => int 49
      public 'name' => string 'Jana Rosenbaum PhD' (length=18)
      public 'company' => string 'Toy PLC' (length=7)
      public 'email' => string 'nora04@example.com' (length=18)
      public 'phone_number' => string '1-364-732-1352 x51040' (length=21)
  49 => 
    object(DamianTW\FakeCustomerGateway\Customer)[104]
      public 'id' => int 50
      public 'name' => string 'Dorris Rempel II' (length=16)
      public 'company' => string 'Roberts-Hirthe' (length=14)
      public 'email' => string 'langworth.christian@example.com' (length=31)
      public 'phone_number' => string '761-975-3522 x7498' (length=18)
```