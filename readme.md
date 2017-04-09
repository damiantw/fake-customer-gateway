Fake Customer Gateway
=====================

damian@troyweb.com

[Challenge Problem](./challenge-problem.md)

## Install

You will need to have [Composer](https://getcomposer.org/doc/00-intro.md) installed.

Run the following command in the root directory of your project to initialize Composer.

`composer init`

Complete all of the prompts then run the following command to add this package to the dependency list of your project.

`composer require damiantw/fake-customer-gateway`

Update your local composer dependencies.

`composer update`

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