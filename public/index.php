<?php
session_start();
require_once 'init.php';
spl_autoload_register('coreAutoloader');
$router = new Router();
