# MongoPHP

A slightly easier way to use MongoDB with PHP. This library aims to simplify CRUD operations on MongoDB with PHP.

_Note : If you need a more comprehensive library, you can use the official [mongodb/mongodb](https://packagist.org/packages/mongodb/mongodb) library._

## Requirements

- PHP 7.4 or higher
- [PHP MongoDB Extension](https://www.php.net/manual/tr/mongodb.installation.php)

## Installation

```
composer require muhammetsafak/mongophp
```

## Usage

### Connection

```php
require_once "vendor/autoload.php";
use MuhammetSafak\MongoPHP\MongoPHP;

$db = new MongoPHP('mongodb://127.0.0.1:27017', 'databaseName');
```

### Create (Insert)

**Single Insert :**

```php
/** @var $db \MuhammetSafak\MongoPHP\MongoPHP */
$res = $db->insert(['user' => 'muhammet', 'mail' => 'info@muhammetsafak.com.tr'])
            ->save('userCollection');
            
if($res){
    echo 'Ok!';
}else{
    foreach ($db->getErrors() as $err) {
        echo 'Error: ' . $err . \PHP_EOL;
    }
}
```

**Multi Insert :**

```php
/** @var $db \MuhammetSafak\MongoPHP\MongoPHP */
$res = $db->insert(['user' => 'muhammet', 'mail' => 'info@muhammetsafak.com.tr'])
            ->insert(['user' => 'ahmet', 'mail' => 'example@example.com'])
            ->save('userCollection');
            
if($res){
    echo 'Ok!';
}else{
    foreach ($db->getErrors() as $err) {
        echo 'Error: ' . $err . \PHP_EOL;
    }
}
```

### Read

```php
/** @var $db \MuhammetSafak\MongoPHP\MongoPHP */
$res = $db->read('userCollection', ['mail' => 'info@muhammetsafak.com.tr']);
foreach ($res as $row) {
    echo '#' . $row->_id . ': ' . $row->user . ' &lt;' . $row->mail . '&gt;' . \PHP_EOL;
}
```

### Update

**Note :** This will replace the entire row with the new data, not just the specified column.

```php
/** @var $db \MuhammetSafak\MongoPHP\MongoPHP */
$res = $db->update(['user' => 'old_user_name'], ['user' => 'new_username'])
            ->save('userCollection');
            
if($res){
    echo 'Ok!';
}else{
    foreach ($db->getErrors() as $err) {
        echo 'Error: ' . $err . \PHP_EOL;
    }
}
```

### Delete

```php
/** @var $db \MuhammetSafak\MongoPHP\MongoPHP */
$res = $db->delete(['user' => 'muhammet'])
            ->save('userCollection');
            
if($res){
    echo 'Ok!';
}else{
    foreach ($db->getErrors() as $err) {
        echo 'Error: ' . $err . \PHP_EOL;
    }
}
```

## Getting Help

If you have questions, concerns, bug reports, etc, please file an issue in this repository's Issue Tracker.

## Contributing

> All contributions to this project will be published under the MIT License. By submitting a pull request or filing a bug, issue, or feature request, you are agreeing to comply with this waiver of copyright interest.

- Fork it ( https://github.com/muhammetsafak/mongophp/fork )
- Create your feature branch (git checkout -b my-new-feature)
- Commit your changes (git commit -am "Add some feature")
- Push to the branch (git push origin my-new-feature)
- Create a new Pull Request

## Credits

- [Muhammet ŞAFAK](https://www.muhammetsafak.com.tr) <<info@muhammetsafak.com.tr>>

## License

Copyright &copy; 2022 [MIT License](./LICENSE)