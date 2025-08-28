<?php
// confirm.php
require 'db.php';
$id = intval($_GET['id'] ?? 0);
$stmt = $mysqli->prepare("SELECT b.*, c.brand, c.model, c.price_per_day FROM bookings b LEFT JOIN cars c ON b.car_id = c.id WHERE b.id = ?");
$stmt->bind_param('i',$id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();
if(!$booking){ echo "Booking not found"; exit; }
?>
<!doctype html><html lang="en"><head>
<meta charset="utf-8"><title>Booking confirmed</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
body{font-family:Inter,Arial;background:#f4f6fb;margin:0;color:#111}
.container{max-width:800px;margin:28px auto;padding:18px}
.card{background:white;border-radius:12px;padding:18px;box-shadow:0 8px 30px rgba(11,118,255,0.06)}
.small{color:#6b7280}
.ok{display:flex;gap:12px;align-items:center}
.ok .dot{width:48px;height:48px;border-radius:50%;background:#e6fbf6;display:flex;align-items:center;justify-content:center;color:#0bb078;font-weight:800}
</style>
</head><body>
<div class="container">
  <div class="card">
    <div class="ok">
      <div class="dot">✓</div>
      <div>
        <h2>Booking confirmed</h2>
        <div class="small">Booking ID: <?=htmlspecialchars($booking['id'])?></div>
      </div>
    </div>
 
    <hr style="margin:14px 0">
 
    <h3><?=htmlspecialchars($booking['brand'].' '.$booking['model'])?></h3>
    <div class="small">Pickup location: <?=htmlspecialchars($booking['pickup_location'])?></div>
    <div class="small">From: <?=htmlspecialchars($booking['start_date'])?> — To: <?=htmlspecialchars($booking['end_date'])?></div>
    <div style="margin-top:10px;font-weight:700">Total days: <?=$booking['total_days']?> • Total: Rs <?=number_format($booking['total_price'],2)?></div>
 
    <hr style="margin:14px 0">
 
    <div class="small">Booked by: <?=htmlspecialchars($booking['name'])?> • <?=htmlspecialchars($booking['email'])?> • <?=htmlspecialchars($booking['phone'])?></div>
 
    <div style="margin-top:18px">
      <button onclick="window.location='index.php'">Back to Home</button>
      <button onclick="window.location='bookings.php'">View all bookings (admin)</button>
    </div>
  </div>
</div>
</body></html>
