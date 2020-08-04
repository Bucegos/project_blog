<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../app/core/constants.php';
require_once '../app/core/autoload.php';
require_once '../app/core/App.php';

$app = new App;
