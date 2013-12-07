<?php

require_once('functions.php');


?>
<!doctype html>
<html>
<head>
   <title>Order</title>
</head>
<body>

<?php

if ($oids = placeOrder(
   $_POST['name'],
   $_POST['addr'],
   (int)$_POST['acct_no'],
   $_POST['email'],
   (int)$_POST['phone'],
   (int)$_POST['id']
)) {

?>
Order placed! <a href='trip.php?id=<?php echo (int)$_POST['id']; ?>'>Return to the trip page.</a>

<br><br>

Your reservation number: <?php echo $oids[0]; ?>
<p>
Your transaction number: <?php echo $oids[1]; ?>

<?php

} else {
   echo "Something went wrong...";
}

?>

</body>
</html>
