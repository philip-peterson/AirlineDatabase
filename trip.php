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

list($trip) = getTripDetails($_GET['id']);

?>

<table border="1">
   <tr>
      <tr><th colspan="2" align="center">Trip Details</th></tr>
   </tr>
   <tr>
      <th>Trip Number</td>
      <td><?php echo $trip['TripNumber']; ?></td>
   </tr>
   <tr>
      <th>Price</th>
      <td>$<?php echo $trip['Price'];      ?></td>
   </tr>
   <tr>
      <th>Departing from</th>
      <td><?php echo $trip['Departure'];      ?></td>
   </tr>
   <tr>
      <th>Arriving at</th>
      <td><?php echo $trip['Destination'];      ?></td>
   </tr>
   <tr>
      <th>Number of Legs</th>
      <td><?php echo $trip['NumLegs'];      ?></td>
   </tr>
</table>

<h2>Flight Legs</h2>

<table border="1">
   <tr>
      <th>Leg Number</th>
      <th>Seats Available</th>
      <th>Departing from</th>
      <th>Departure date</th>
      <th>Departure time</th>
      <th>Arriving at</th>
      <th>Arrival date</th>
      <th>Arrival time</th>
   </tr>

   <tr>
<?php

$id = (int)$_REQUEST['id'];

$legs = getFlightLegs($id);

foreach ($legs as $leg) {
?>

   <tr>
      <td><?php echo $leg['LegNumber'];  ?></td>
      <td><?php echo $leg['NumSeatsAvailable'];  ?></td>
      <td><?php echo $leg['departure']['AirportCode'];  ?></td>
      <td><?php echo $leg['departure']['TheDate'];  ?></td>
      <td><?php echo $leg['departure']['TheTime'];  ?></td>
      <td><?php echo $leg['arrival']['AirportCode'];  ?></td>
      <td><?php echo $leg['arrival']['TheDate'];  ?></td>
      <td><?php echo $leg['arrival']['TheTime'];  ?></td>
   </tr>

<?php
}



?>

   </tr>
</table>

<h2>Ticket Purchase</h2>


<form action="buy.php" method="POST">
   <input type="hidden" name="id" value="<?php prtField('id'); ?>">
   <input type="hidden" name="act" value="buyticket">

      <input type="text" name="name" id="name" placeholder="name on account">
      <input type="text" name="acct_no" id="acct_no" placeholder="account number">
      <input type="text" name="email" id="email" placeholder="email address">
      <input type="text" name="addr" id="addr" placeholder="physical address">
      <input type="text" name="phone" id="phone" placeholder="phone number">

   <input type="submit" value="Book Ticket">
</form>

</body>
</html>
