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
         rets.css('visibility', 'hidden');
         $("#round-trip").change(function(e){ rets.css('visibility', $(e.target).prop('checked') ? 'visible' : 'hidden'); });
      });
   </script>
</head>
<body>

<?php

function toBool($x) {
   return filter_var($x, FILTER_VALIDATE_BOOLEAN);
}

switch (isset($_REQUEST['act'])) {
   'search':
      var_dump(getFlights(
         $_REQUEST['source'],
         $_REQUEST['depart-date'],
         toBool($_REQUEST['depart-flex']
      )));

   default:
?>

<form method="GET">
   <input type="hidden" name="act" value="search">
   <div class="depart">
      <h2>From</h2>
      <input type="text" name="source" id="source" placeholder="Departing Airport">
      <input type="text" name="depart-date"    id="depart-date"    placeholder="Departure Date">
      <input type="checkbox" name="depart-flex" id="depart-flex"> <label id="depart-flex-label" for="depart-flex">This date is flexible</label> 
   </div>
   <div class="arrive">
      <h2>To</h2>
      <input type="text" name="dest" id="dest" placeholder="Destination Airport">
      <label for="round-trip">Round trip?</label> <input type="checkbox" name="round-trip" id="round-trip">
      <fieldset id="return-fields">
         <legend>Return Trip</legend>
         <input type="text" name="return-date"    id="return-date"    placeholder="Return Date">
         <input type="checkbox" name="return-flex" id="return-flex"> <label id="return-flex-label" for="return-flex">This date is flexible</label> 
      </fieldset>
   </div>
   <input type="submit" value="Go!">
</form>

<?php

}

?>

</body>
</html>
