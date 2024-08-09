<?php 
//import the class from 'NumberToletter/NumberToletter.php'
require './NumberToLetter.php';

//use the static method
// NumberToLetter::makeTest(9999,10, 'ENG');
$ntl = new NumberToLetter(999999999999, 'ENG');
echo $ntl->numberToLetter();