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
   <script type="text/javascript">
      $(function() {
         $("[id $= '-date']").datepicker({dateFormat: "yy-mm-dd"});
         var rets = $("[id ^= 'return-']");
         function doHideShow(element) {
            rets.css('visibility', element.prop('checked') ? 'visible' : 'hidden');
         }

         var cbox = $('#round-trip');

         doHideShow(cbox);
         cbox.change(function(e){ doHideShow($(e.target)); });
      });
   </script>
</head>
<body>

<h1>Search for Trips</h1>

<?php

function displayResults($trips) {

?>


<table border="1">
   <tr>
      <th>From</th>
      <th>To</th>
      <th>Date of Departure</th>
      <th>Time of Departure</th>
      <th>Stops</th>
      <th>Price</th>
      <th>Action</th>
   </tr>

<?php


      foreach ($trips as $trip) {
         ?> <tr>

            <td><?php echo $trip['Departure']; ?></td>
            <td><?php echo $trip['Destination']; ?></td>

            <td><?php echo $trip['TheDate']; ?></td>
            <td><?php echo $trip['ScheduleTime']; ?></td>
            <td><?php echo $trip['NumLegs']; ?></td>
            <td>$<?php echo $trip['Price']; ?></td>
            <td align="center"><a href="trip.php?id=<?php echo (int)$trip['TripNumber']; ?>">Details / Purchase</a></td>
         
         </tr> <?php
      }

?>

</table>

<?php

}

switch (isset($_REQUEST['act'])) {
   case 'search':


      echo "<h2>Departing Flights</h2>";

      $departures = getTripsFromTo(
         $_REQUEST['source'],
         $_REQUEST['dest'],
         $_REQUEST['depart-date'],
         getBool('depart-flex')
      );

      displayResults($departures);

      if (getBool('round-trip')) {

         echo "<h2>Return Flights</h2>";

         $returns = getTripsFromTo(
            $_REQUEST['dest'],
            $_REQUEST['source'],
            $_REQUEST['return-date'],
            getBool('return-flex')
         );

         displayResults($returns);
   
      }

   default:
?>

<form method="GET">
   <input type="hidden" name="act" value="search">
   <div class="depart">
      <h2>From</h2>
      <input type="text" name="source" maxlength="3" id="source" placeholder="Departing Airport" value="<?php prtField('source'); ?>">
      <input type="text" name="depart-date"    id="depart-date" placeholder="Departure Date" value="<?php prtField('depart-date'); ?>">
      <input type="checkbox" name="depart-flex" id="depart-flex" <? prtChecked('depart-flex'); ?>> <label id="depart-flex-label" for="depart-flex">This date is flexible</label> 
   </div>
   <div class="arrive">
      <h2>To</h2>
      <input type="text" name="dest" maxlength="3" id="dest" placeholder="Destination Airport" value="<?php prtField('dest'); ?>">
      <label for="round-trip">Round trip?</label> <input type="checkbox" name="round-trip" id="round-trip" <?php prtChecked('round-trip'); ?>>
      <fieldset id="return-fields">
         <legend>Return Trip</legend>
         <input type="text" name="return-date"    id="return-date" placeholder="Return Date" value="<?php prtField('return-date'); ?>">
         <input type="checkbox" name="return-flex" id="return-flex" <?php prtChecked('return-flex'); ?>> <label id="return-flex-label" for="return-flex">This date is flexible</label> 
      </fieldset>
   </div>
   <input type="submit" value="Go!">
</form>

<?php

}

?>

</body>
</html>
