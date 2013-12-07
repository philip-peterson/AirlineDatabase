<?php

require_once('functions.php');

?>
<!doctype html>
<html>
<head>
   <title>Search Flights</title>
   <link href="css/ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
   <link href="css/airline.css" rel="stylesheet">
   <script src="js/jquery-1.9.1.js"></script>
   <script src="js/jquery-ui-1.10.3.custom.js"></script>
</head>
<body>

<h1>Trip Details</h1>

<?php

$id = (int)$_REQUEST['id'];

$legs = getFlightLegs($id);

var_dump($legs);


/*
            <td><?php echo $trip['TheDate']; ?></td>
            <td><?php echo $trip['ScheduleTime']; ?></td>
            <td><?php echo $trip['NumLegs']; ?></td>
            <td>$<?php echo $trip['Price']; ?></td>
            <td align="center"><a href="trip.php?id=<?php echo (int)$trip['TripNumber']; ?>">Details / Purchase</a></td>
*/



?>

</body>
</html>
