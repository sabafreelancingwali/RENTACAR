<?php
// book.php
require 'db.php';
if($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }
 
$car_id = intval($_POST['car_id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$pickup_location = trim($_POST['pickup_location'] ?? '');
$start = $_POST['start_date'] ?? null;
$end = $_POST['end_date'] ?? null;
$total_days = intval($_POST['total_days'] ?? 0);
$total_price = floatval($_POST['total_price'] ?? 0);
 
if(!$car_id || !$name || !$email || !$phone || !$start || !$end || $total_days<=0){
    echo "<p>Missing data. <a href='javascript:history.back()'>Go back</a></p>";
    exit;
}
 
$stmt = $mysqli->prepare("INSERT INTO bookings (car_id,name,email,phone,pickup_location,start_date,end_date,total_days,total_price) VALUES (?,?,?,?,?,?,?,?,?)");
$stmt->bind_param('isssssiid',$car_id,$name,$email,$phone,$pickup_location,$start,$end,$total_days,$total_price);
$ok = $stmt->execute();
$booking_id = $mysqli->insert_id;
?>
<!doctype html><html><head><meta charset="utf-8"><title>Processing booking</title></head><body>
<script>
<?php if($ok): ?>
  // Redirect to confirmation page using JS with booking id
  window.location = 'confirm.php?id=<?=intval($booking_id)?>';
<?php else: ?>
  alert('Could not save booking. Please try again.');
  window.location = 'car.php?id=<?=intval($car_id)?>';
<?php endif; ?>
</script>
</body></html>
