<?php
// bookings.php
require 'db.php';
$res = $mysqli->query("SELECT b.*, c.brand, c.model FROM bookings b LEFT JOIN cars c ON b.car_id = c.id ORDER BY b.created_at DESC");
$rows = $res->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html><html lang="en"><head>
<meta charset="utf-8"><title>All bookings</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
body{font-family:Inter,Arial;background:#f4f6fb;margin:0;color:#111}
.container{max-width:1100px;margin:18px auto;padding:0 18px}
.table{background:white;border-radius:12px;padding:12px;box-shadow:0 8px 30px rgba(11,118,255,0.06)}
.row{display:grid;grid-template-columns:1fr 120px 140px 120px 140px;gap:12px;padding:10px;border-bottom:1px solid #f1f5fb;align-items:center}
.row.header{font-weight:700;color:#374151}
.small{color:#6b7280}
@media(max-width:760px){.row{grid-template-columns:1fr 1fr;}}
</style>
</head><body>
<div class="container">
  <h2>Bookings</h2>
  <div class="table">
    <div class="row header"><div>Booking</div><div>Date</div><div>Customer</div><div>Days</div><div>Total</div></div>
    <?php foreach($rows as $r): ?>
      <div class="row">
        <div>
          <div style="font-weight:700"><?=htmlspecialchars($r['brand'].' '.$r['model'])?></div>
          <div class="small"><?=htmlspecialchars($r['pickup_location'])?> — <?=htmlspecialchars($r['start_date'])?> → <?=htmlspecialchars($r['end_date'])?></div>
        </div>
        <div><?=htmlspecialchars(date('Y-m-d',strtotime($r['created_at'])))?></div>
        <div><?=htmlspecialchars($r['name'])?><div class="small"><?=htmlspecialchars($r['email'])?></div></div>
        <div><?=intval($r['total_days'])?></div>
        <div>Rs <?=number_format($r['total_price'],2)?></div>
      </div>
    <?php endforeach; ?>
    <?php if(empty($rows)) echo '<div style="padding:20px;text-align:center;color:#6b7280">No bookings yet.</div>'; ?>
  </div>
  <div style="margin-top:12px"><button onclick="window.location='index.php'">Back to Home</button></div>
</div>
</body></html>
