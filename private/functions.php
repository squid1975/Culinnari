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
  $fraction = trim($fraction);

  // Return NULL if input is empty
  if ($fraction === '') {
      return null;
  }

  // Check if the input is already a valid number
  if (is_numeric($fraction)) {
      return round((float) $fraction, 2);  // Round to two decimal places
  }

  // Check if the input is a fraction (e.g., "1/2", "3/4")
  if (preg_match('/^(\d+)\s*(\/)\s*(\d+)$/', $fraction, $matches)) {
      $numerator = (int) $matches[1];
      $denominator = (int) $matches[3];

      if ($denominator == 0) {
          return null; // Avoid division by zero
      }
      return round($numerator / $denominator, 2);  // Round to two decimal places
  }

  return null; // Invalid input, return NULL
}

function decimal_to_fraction($decimal) {
  // Ensure the decimal is a numeric value
  if (!is_numeric($decimal)) {
      return $decimal;  // Return as-is if not a number
  }

  $whole = floor($decimal); // Get the whole number part
  $fraction = $decimal - $whole; // Get the fractional part

  if ($fraction == 0) {
      return (string) $whole; // Return as a whole number if no fraction
  }

  // Let's work with a reasonable denominator, such as 100 for two decimal places
  $denominator = 100;
  $numerator = round($fraction * $denominator);

  // Simplify the fraction
  $gcd = gcd($numerator, $denominator);
  $numerator /= $gcd;
  $denominator /= $gcd;

  // Combine whole number and fraction
  if ($whole == 0) {
      return "$numerator/$denominator"; // Just the fraction if no whole part
  } else {
      return "$whole $numerator/$denominator"; // Whole part with fraction
  }
}

// Helper function for finding the greatest common divisor
function gcd($a, $b) {
  while ($b != 0) {
      $temp = $b;
      $b = $a % $b;
      $a = $temp;
  }
  return $a;
}

