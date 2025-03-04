<?php

function url_for($script_path) {
  // add the leading '/' if not present
  if($script_path[0] != '/') {
    $script_path = "/" . $script_path;
  }
  return WWW_ROOT . $script_path;
}

function u($string="") {
  return urlencode($string);
}

function raw_u($string="") {
  return rawurlencode($string);
}

function h($string="") {
  return htmlspecialchars($string);
}

function error_404() {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
  exit();
}

function error_500() {
  header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
  exit();
}

function redirect_to($location) {
  header("Location: " . $location);
  exit;
}

function is_post_request() {
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request() {
  return $_SERVER['REQUEST_METHOD'] == 'GET';
}

if(!function_exists('money_format')) {
  function money_format($format, $number) {
    return '$' . number_format($number, 2);
  }
}

function timeToSeconds($hours, $minutes){
  return ($hours * 3600) + ($minutes * 60);
}

function convertSeconds($seconds) {
  $hours = floor($seconds / 3600); // Calculate hours
  $minutes = floor(($seconds % 3600) / 60); // Calculate minutes

  return "{$hours} hours and {$minutes} minutes";
}

function formatDate($timestamp) {
  return date("d/m/Y", strtotime($timestamp));
}

function fractionToDecimal($fraction) {
  // Check if the input is a valid fraction (e.g. 1/2, 3/4)
  if (preg_match('/^(\d+)\/(\d+)$/', $fraction, $matches)) {
      // $matches[1] is the numerator, $matches[2] is the denominator
      $numerator = (int) $matches[1];
      $denominator = (int) $matches[2];
      return $numerator / $denominator;  // Convert to decimal
  }
  return $fraction;  // If not a fraction, return the input as is
}
?>