<?php

namespace App\Helpers;

class EmployeeHelper
{
  public static function employeeRoundDown($number) {
    if ($number <= 250) {
        return floor($number / 50) * 50;
    } else {
        return floor($number / 250) * 250;
    }
  }
  
  public static function employeeRangeRoundDown($range) {
    if ($range == "50 - 99") {
        return 50;
    } else {
        return 250;
    }
  }
}