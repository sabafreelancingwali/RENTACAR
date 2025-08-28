<?php
// car.php
require 'db.php';
$id = intval($_GET['id'] ?? 0);
$pickup = $_GET['pickup'] ?? '';
$start = $_GET['start'] ?? '';
$end = $_GET['end'] ?? '';
 
$stmt = $mysqli->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->bind_param('i',$id);
$stmt->execute();
$car = $stmt->get_result()->fetch_assoc();
if(!$car){ echo "Car not found"; exit; }
?>
<!doctype html><html lang="en"><head>
<meta charset="utf-8"><title><?=htmlspecialchars($car['brand'].' '.$car['model'])?></title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
body{font-family:Inter,Arial;background:#f4f6fb;margin:0;color:#111}
.container{max-width:900px;margin:18px auto;padding:0 18px}
.card{background:white;padding:18px;border-radius:12px;box-shadow:0 10px 30px rgba(11,118,255,0.06);display:grid;grid-template-columns:1fr 360px;gap:18px}
.card img{width:100%;height:320px;object-fit:cover;border-radius:10px}
.info h1{margin:0 0 8px}
.small{color:#6b7280}
.form input, .form textarea, .form select{width:100%;padding:10px;margin-top:8px;border-radius:8px;border:1px solid #e6edf7}
.book-btn{background:linear-gradient(90deg,#0b76ff,#5ec0ff);color:white;border:none;padding:12px;border-radius:10px;font-weight:700;cursor:pointer;margin-top:12px}
@media(max-width:880px){.card{grid-template-columns:1fr;}.card img{height:220px}}
</style>
</head><body>
<div class="container">
  <div style="margin-bottom:12px"><button onclick="history.back()">← Back</button></div>
  <div class="card">
    <div>
      <img src="<?=htmlspecialchars($car['image'])?>" alt="">
      <div style="padding-top:10px">
        <h1><?=htmlspecialchars($car['brand'].' '.$car['model'])?></h1>
        <div class="small"><?=htmlspecialchars($car['type'])?> • <?=$car['seats']?> seats • <?=$car['fuel']?> • Rating <?=$car['rating']?></div>
        <p style="margin-top:10px" class="small"><?=htmlspecialchars($car['description'])?></p>
      </div>
    </div>
 
    <div>
      <div style="background:#f7fbff;padding:14px;border-radius:10px">
        <div style="font-weight:800;font-size:20px">Rs <?=number_format($car['price_per_day'],2)?> <span class="small" style="font-weight:400">/ day</span></div>
        <div class="small" style="margin-top:6px">Select dates & fill details to book.</div>
 
        <form class="form" id="bookingForm" method="POST" action="book.php">
          <input type="hidden" name="car_id" value="<?=$car['id']?>">
          <label class="small">Pickup location</label>
          <input name="pickup_location" id="pickup_location" value="<?=htmlspecialchars($pickup)?>">
 
          <div style="display:flex;gap:8px;margin-top:8px">
            <div style="flex:1">
              <label class="small">Start date</label>
              <input type="date" name="start_date" id="start_date" value="<?=htmlspecialchars($start)?>">
            </div>
            <div style="flex:1">
              <label class="small">End date</label>
              <input type="date" name="end_date" id="end_date" value="<?=htmlspecialchars($end)?>">
            </div>
          </div>
 
          <label class="small">Your name</label>
          <input name="name" required>
 
          <label class="small">Email</label>
          <input name="email" type="email" required>
 
          <label class="small">Phone</label>
          <input name="phone" required>
 
          <div style="margin-top:6px" class="small">Total days: <span id="days">—</span></div>
 
          <button type="button" class="book-btn" onclick="submitBooking()">Book now</button>
        </form>
      </div>
    </div>
  </div>
</div>
 
<script>
const price = <?=json_encode((float)$car['price_per_day'])?>;
function calculateDays(){
  const s = document.getElementById('start_date').value;
  const e = document.getElementById('end_date').value;
  if(!s || !e) return 0;
  const sd = new Date(s);
  const ed = new Date(e);
  const diff = Math.ceil((ed - sd) / (1000*60*60*24));
  return diff > 0 ? diff : 0;
}
function updateTotal(){
  const d = calculateDays();
  document.getElementById('days').textContent = d || '—';
}
document.getElementById('start_date').addEventListener('change', updateTotal);
document.getElementById('end_date').addEventListener('change', updateTotal);
updateTotal();
 
function submitBooking(){
  const form = document.getElementById('bookingForm');
  const d = calculateDays();
  if(!d){ alert('Select valid start and end dates.'); return; }
  // calculate total and attach hidden input
  const total = (d * price).toFixed(2);
  const input = document.createElement('input');
  input.type = 'hidden'; input.name = 'total_price'; input.value = total;
  const daysInput = document.createElement('input');
  daysInput.type='hidden'; daysInput.name='total_days'; daysInput.value = d;
  form.appendChild(input);
  form.appendChild(daysInput);
 
  // Use JS to POST by submitting the form. After server processes, server will redirect using JS.
  form.submit();
}
</script>
</body></html>
