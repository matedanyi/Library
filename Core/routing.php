<?
session_start();

include_once('Utils/debug.php');
include_once('Utils/ErrorHandler.php');
$errorHandler = new ErrorHandler();

$getKey = array_keys($_GET);
$urlSegments = array();
$content = '';

if (isset($getKey[0])) {
  $urlSegments = explode('/', $getKey[0]);
}

$object = null;
$className = isset($urlSegments[0]) ? ucfirst($urlSegments[0]) : false;

if ($className) {
  $file = "Controller/$className.php";
  if (!file_exists($file)) {
    $errorHandler->errorAndDie("Can not find that file: " . $file);
  }

  include_once($file);

  if (!class_exists($className)) {
    $errorHandler->errorAndDie("Invalid URL! No such class name.");
  }

  $object = new $className();

  $method = 'index';

  if (isset($urlSegments[1])) {
    $method = $urlSegments[1];
  }

  if (method_exists($object, $method)) {
    if ($object->hasRole($method)) {
      $object->$method();
    } else {
      $errorHandler->errorAndDie("You do not have permission to view this page.");
    }
  } else {
    $errorHandler->errorAndDie("The method you were looking for could not be found $method");
  }
} else {
  $errorHandler->errorAndDie("Invalid URL! No such class name.");
}
