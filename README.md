RedAnt Console
==============

Menu select helper for Symfony Console
-------------------------------

This menu helper is a bridge for PHPSchool's
[CliMenu](https://github.com/php-school/cli-menu) library,
so that it can easily be used inside the Symfony Console.

It provides an interactive menu that you can navigate using
the arrow and enter keys.

Only compatible with UNIX tty-style terminals.

Installation
------------
Install through `composer require redant/console`.

Setup
-----
Register the helper in your HelperSet:

```php
use RedAnt\Console\Helper\SelectHelper;

// Further on in your code ...
$this->getHelperSet()->set(new SelectHelper(), 'select'));
```

Then you can start using the helper like this:

```php
$helper = $this->getHelper('select');
$value = $helper->select(
    $input,
    'What is your favorite food?',
    [
        'hamburger' => 'Hamburger',
        'pizza'     => 'Pizza',
        'sushi'     => 'Sushi',
        'poke'      => 'Poké bowl'
    ]
);

// $value = 'poke' when the fourth option was chosen
// $value = null when the user canceled
```

About
-----
Lovingly crafted by RedAnt in Utrecht, NL.

This project is licensed under the terms of the MIT license.