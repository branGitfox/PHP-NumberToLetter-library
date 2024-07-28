<?php 
//import the class from 'NumberToletter/NumberToletter.php'
require './NumberToLetter.php';

//Instance of NumberToLetter
$ntl = new NumberToLetter(500033, 'ENG');

//use the method numberToLetter
echo $ntl->numberToLetter();
