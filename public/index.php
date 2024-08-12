<?php
include_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/src/Models/Database.php';
header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
use MaterialDesignForum\Routes\Api;
use MaterialDesignForum\Routes\Route;
if (Api::IsApi()) {
  echo Api::HandleAPI();
} else {
  echo Route::HandleRoute();
}
?>