<?php

require_once('config.php');

function getConn() {
   static $pdo;
   if (!$pdo) {
      $pdo = new PDO(AIRLINE_DSN, AIRLINE_USER, AIRLINE_PASS);
   }
   return $pdo;
}

function runQuery($sql, $args) {
   $stmt = getConn()->prepare($sql, array());
   $stmt->execute($args);
   return $stmt->fetchAll();
}

function getBool($x) {
   if (isset($_REQUEST[$x])) {
      return filter_var($_REQUEST[$x], FILTER_VALIDATE_BOOLEAN);
   }
   return false;
}

function getFlightsFrom($airportCode, $date, $fuzzyDate) {
   $params = array($airportCode, $date);
   
   if ($fuzzyDate) {
      array_push($params, $date);
      $dateShebang = "BETWEEN SUBDATE(DATE(?), INTERVAL 2 DAY) AND ADDDATE(DATE(?), INTERVAL 2 DAY)";
   }
   else {
      $dateShebang = "= ?";
   }

   $q = <<<SQL
SELECT
   ScheduleTime,
   LegNumberRef,
   TripNumberRef
FROM
   Departure
WHERE
   AirportCode = ?
   AND DATE(ScheduleTime) $dateShebang
SQL;

   return runQuery($q, $params);
}

function getFlightsFromTo($airportCode, $departDate, $fuzzyDate) {
   $res = getFlightsFrom($airportCode, $departDate, $fuzzyDate);
   return $res;
}
