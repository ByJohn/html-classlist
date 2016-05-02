# HTML Class Attribute Manager for PHP

Helps to manage a list of CSS class names when dynamically adding them to an HTML tag.

I created this project to explore unit testing with [PHPUnit](https://phpunit.de/), but I probably also use this class every now and then.

## Usage

### Instantiating
```php
//Require the PHP class
require 'HTMLClasslist.php';

//Create an instance
$classes = new HTML_Classlist();

//Create an instance with some initial classes
$classes = new HTML_Classlist('my-class');

//Multiple class names can be provided as a space-separated string or an array
$classes = new HTML_Classlist('box left'); //String
$classes = new HTML_Classlist(array('box', 'left')); //Array
```

### Adding and Removing Classes
```php
//Add classes
$classes->add('new-class');
$classes->add('example example-two');
$classes->add(array('class-one','class-two'));

//Remove classes
$classes->remove('new-class');
$classes->remove('example example-two');
$classes->remove(array('class-one','class-two'));


//Add classes if...
$classes->addIf(1 == 1, 'new-class');

//Remove classes if...
$classes->removeIf(1 == 1, 'new-class');
```

### Checking Class existence
```php
//Check if a classes exist
$classes->has('my-class'); //True

//When multiple classes are checked, they all have to exist to return true
$classes->has('my-class my-class-two'); //False
```

### Output your Classes
```php
//Get your classes (return)
$classes->getOutput(); //Returns 'box left'
$classes->getHTML(); //Returns 'class="box left"'

//Output your classes (echo)
$classes->output(); //Echos 'box left'
$classes->html(); //Echos 'class="box left"'
```

### Chaining
```php
//You can chain appropriate methods
$classes->add('new-class')->remove('my-class');
```

## Features
* Prevents duplicate class names from being added
* Triggers a warning if an invalid CSS class name is provided
* All methods that accept class names will accept a space-separated string or an array
* All appropriate methods return themselves (their PHP class instance), so calls can be chained

## To Do
* Add more comments and DocBlocks
