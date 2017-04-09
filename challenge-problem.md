#### Challenge Problem

Many modern applications include some sort of functionality to display and manage tabular data. The source for this data can come from a variery of places including a relational database like MySQL, a NoSQL database like MongoDB, or via an external service like Twitter that exposes an API for developers.

For the sake of setup simplicity, for this activity we will use Composer to pull in a fake customer gateway package that will provide a way for us to interact with dummy customer data from a simple in-memory data store. 

Your task is to create a PHP application that provide a logical display of the customer data that the fake gateway provides. A basic HTML table would be a good fit but feel free to get creative.

Documentation for how to setup and use the fake customer gateway package can be found on [GitHub](https://www.github.com/damiantw/fake-customer-gateway):

**Bonus Points:**

1.

It's a good idea to provide users functionality to sort tabular data. 

Use the `sortBy($field)` and `sortByDesc($field)` methods provided by the fake customer gateway package to add
sorting to your table.

2.

Often you'll need to provide functionality to not only display tabular data but to create, update, and remove it.

Create a form that allows the user to add another customer by taking advantage of the`add($name, $company, $email, $phone_number)`method provided by the fake customer gateway package. Feel free to give update and delete a try too! 

**Note:** You will need to take advantage of the `saveDataFile($filePath)` and `loadDataFileIfExists($filePath)` functions provided by the customer gateway package or any changes made to the data will not persist between requests.

3.

Imagine that your application has thousands of customer records. It would be impractical to present the user with all of the customer records at once. 

To prepare for situations like this we can use a technique called pagination. You can read more about pagination [here](http://codular.com/implementing-pagination)

Use the `pagination($page, $perPage)` function provided by the customer gateway package to display the data in paged chunks. Create a next/previous page button for your tabular data display. 