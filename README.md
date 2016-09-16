# google-chart-php-library
## A PHP library for generating Google Charts (a Javascript library)

#### Author: Jordan McQueen

Status: still in development. Used to be fully functional, but I began refactoring to adhere to better design priciples/patterns. May or may not be working at this given moment.

I began writing this library to create a simple, clean interface for PHP to generate the javascript code to create google 
charts, without manually creating any javascript code. As the project grew in scope, it was clear that OO design patterns were
needed to manage its growing complexity, and it has since become an excellent project to hone and develop my skills.

Here's an example of what the PHP syntax looks like to create a simple line graph, using this library:

(Note: you must load Google's javascript Google Charts API in the head of your HTML file.)
```php
// create example data with which to graph
// the data input is flexible; an associative array is not required.
$data = [
  ['date' => '2016-05-01', 'sales' => 512350],
  ['date' => '2016-05-02', 'sales' => 479203],
  ['date' => '2016-05-03', 'sales' => 475231],
  ['date' => '2016-05-04', 'sales' => 513051],
  ['date' => '2016-05-05', 'sales' => 587314],
  ];

$chart = GoogleChart::factory($data, 'line'); // 'line' indicates type of chart
// there are many types available. e.g. line, bar, column, pie, gauge, scatter, ...
```
[List of Google Charts in the Javascript API](https://developers.google.com/chart/interactive/docs/gallery)
```php
$chart
  ->set_title('First five days of May sales'); // setting a title isn't necessary
  ->build();
  
echo $chart->display(); // display() returns all of the javascript to make this go.
```
