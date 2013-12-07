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

function prtChecked($field) {
   echo getBool($field) ? ' checked' : '';
}

function prtField($field) {
   if (isset($_REQUEST[$field])) {
      echo htmlentities($_REQUEST[$field]);
   }
   else {
      echo '';
   }
}

function getTripsFromTo($from, $to, $date, $fuzzyDate) {
   $params = array($from, $to, $to, $date);
   
   if ($fuzzyDate) {
      array_push($params, $date);
      $dateShebang = "BETWEEN SUBDATE(DATE(?), INTERVAL 2 DAY) AND ADDDATE(DATE(?), INTERVAL 2 DAY)";
   }
   else {
      $dateShebang = "= ?";
   }

   $q = <<<SQL
      SELECT
         TripNumber,
         TheDate,
         DATE_FORMAT(ScheduleTime, '%l:%i %p') AS ScheduleTime,
         Departure,
         Destination,
         Price,
         NumLegs,
         LegNumber,
         NumSeatsAvailable
      FROM
         Trip
         JOIN FlightLeg USING (TripNumber)
         JOIN Departure ON (TripNumber = TripNumberRef AND LegNumber = LegNumberRef)
      WHERE
         Airline='Errfoil'
         AND Departure = UPPER(?)
         AND (
            Destination = UPPER(?)
            OR ? = ''
         )
         AND LegNumber = 1
         AND TheDate $dateShebang
SQL;

   return runQuery($q, $params);
}

function getTripDetails($tripID) {
   $q = <<<SQL
      SELECT
         TripNumber,
         Price,
         Departure,
         Destination,
         NumLegs
      FROM
         Trip
      WHERE
         TripNumber = ?
         AND Airline = 'Errfoil'
SQL;

   return runQuery($q, array($tripID));
}

function getArrivalOrDeparture($arrivalOrDeparture, $tripID, $legNumber) {
   $table = (($arrivalOrDeparture === 'arrival') ? 'Arrival' : 'Departure');
   $q = <<<SQL
      SELECT
         AirportCode,
         DATE_FORMAT(ScheduleTime, "%l:%i %p") AS TheTime,
         DATE_FORMAT(ScheduleTime, "%M %e, %Y") AS TheDate
      FROM
         $table
      WHERE
         TripNumberRef = ?
         AND LegNumberRef = ?
SQL;
   $res = runQuery($q, array($tripID, $legNumber));
   return $res[0];
}

function getFlightLegs($tripID) {
   
   $q = <<<SQL
      SELECT
         LegNumber,
         Airplane.Type AS AirplaneName,
         NumSeatsAvailable
      FROM
         Trip
         JOIN FlightLeg USING (TripNumber)
         JOIN Airplane ON (FlightLeg.AirplaneId = Airplane.Id)
      WHERE
         Airline='Errfoil'
         AND TripNumber = ?
SQL;

   $legs = runQuery($q, array($tripID));
   $newlegs = array();

   foreach ($legs as $leg) {
      $newleg = $leg;
      $newleg['arrival']   = getArrivalOrDeparture('arrival',   $tripID, $leg['LegNumber']);
      $newleg['departure'] = getArrivalOrDeparture('departure', $tripID, $leg['LegNumber']);
      $newlegs[] = $newleg;
   }

   return $newlegs;

}
