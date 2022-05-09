<?php
declare(strict_types=1);
require_once "../vendor/autoload.php";
use \MuhammetSafak\MongoPHP\MongoPHP;

// Connection
#$db = new MongoPHP('mongodb://127.0.0.1:27017', 'test');


// Insert

/*
$res = $db->insert(['user' => 'muhammet', 'mail' => 'info@muhammetsafak.com.tr'])
    ->insert(['user' => 'ahmet', 'mail' => 'example@example.com'])
    ->save('userCollection');

if($res === FALSE){
    foreach ($db->getErrors() as $err) {
        echo $err . \PHP_EOL;
    }
}
*/


// Read

/*
$res = $db->read('userCollection', ['mail' => 'info@muhammetsafak.com.tr']);
foreach ($res as $row) {
    echo '#' . $row->_id . ': ' . $row->user . ' &lt;' . $row->mail . '&gt;' . \PHP_EOL;
}
*/


// Update

/*
$res = $db->update(['user' => 'muhammet'], ['user' => 'admin'])
    ->save('userCollection');

if($res === FALSE){
    foreach ($db->getErrors() as $err) {
        echo $err . \PHP_EOL;
    }
}else{
    echo 'Ok!';
}
*/


// DELETE

/*
$res = $db->delete(['user' => 'ahmet'])
    ->save('userCollection');

if($res === FALSE){
    foreach ($db->getErrors() as $err) {
        echo $err . \PHP_EOL;
    }
}else{
    echo 'Deleted!';
}
*/
