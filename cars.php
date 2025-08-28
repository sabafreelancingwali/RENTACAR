<?php
// cars.php
require 'db.php';
$pickup = $_GET['pickup'] ?? '';
$start = $_GET['start'] ?? '';
$end = $_GET['end'] ?? '';
$type = $_GET['type'] ?? '';
$sort = $_GET['sort'] ?? 'price_asc';
 
$where = [];
$params = [];
 
if($type !== '') { $where[] = "type = ?"; $params[] = $type; }
 
$sql = "SELECT * FROM cars";
if(count($where)) $sql .= " WHERE " . implode(" AND ", $where);
 
if($sort === 'price_asc') $sql .= " ORDER BY price_per_day ASC";
elseif($sort === 'price_desc') $sql .= " ORDER BY price_per_day DESC";
elseif($sort === 'rating') $sql .= " ORDER BY rating DESC";
 
$stmt = $mysqli->prepare($sql);
if($params){
  $types = str_repeat('s', count($params));
  $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$res = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html><html lang="en"><head>
<meta charset="utf-8"><title>Car results</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
/* internal CSS similar style to index */
body{font-family:Inter,Arial;background:#f4f6fb;margin:0;color:#111}
.container{max-width:1100px;margin:18px auto;padding:0 18px}
.controls{display:flex;gap:12px;align-items:center;flex-wrap:wrap;margin-bottom:14px}
.select, .btn {padding:10px;border-radius:8px;border:1px solid #e8eefb;background:white}
.cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:18px}
.card{background:white;padding:14px;border-radius:12px;box-shadow:0 8px 24px rgba(11,118,255,0.06);display:flex;flex-direction:column}
.card img{height:150px;object-fit:cover;border-radius:8px}
.price{margin-top:auto;display:flex;justify-content:space-between;align-items:center;font-weight:700}
.small{color:#6b7280}
</style>
</head><body>
<div class="container">
  <div style="display:flex;justify-content:space-between;align-items:center">
    <h2>Available cars</h2>
    <button class="select" onclick="window.location='index.php'">← New search</button>
  </div>
 
  <div class="controls">
    <div class="small">Pickup: <strong><?=htmlspecialchars($pickup ?: 'Any')?></strong></div>
    <div class="small">From: <strong><?=htmlspecialchars($start ?: '—')?></strong></div>
    <div class="small">To: <strong><?=htmlspecialchars($end ?: '—')?></strong></div>
 
    <div style="margin-left:auto">
      <label class="small">Sort</label>
      <select id="sort" onchange="applySort()" class="select">
        <option value="price_asc" <?= $sort==='price_asc'?'selected':'' ?>>Price: Low → High</option>
        <option value="price_desc" <?= $sort==='price_desc'?'selected':'' ?>>Price: High → Low</option>
        <option value="rating" <?= $sort==='rating'?'selected':'' ?>>Top rated</option>
      </select>
    </div>
  </div>
 
  <div class="cards">
    <?php if(empty($res)): ?>
      <div style="grid-column:1/-1;padding:26px;background:white;border-radius:12px;text-align:center">No cars found. Try broadening filters.</div>
    <?php endif; ?>
 
    <?php foreach($res as $c): ?>
      <div class="card">
        <img src="<?=htmlspecialchars($c['image'])?>" alt="">
        <h3><?=htmlspecialchars($c['brand'].' '.$c['model'])?></h3>
        <div class="small"><?=htmlspecialchars($c['type'])?> • <?= $c['seats'] ?> seats • <?=$c['fuel']?></div>
        <p class="small" style="margin-top:8px"><?=htmlspecialchars(mb_strimwidth($c['description'],0,120,'...'))?></p>
        <div class="price">
          <div>Rs <?=number_format($c['price_per_day'],2)?> / day</div>
          <div>
            <button class="select" onclick="viewCar(<?=$c['id']?>)">View</button>
            <button class="select" onclick="bookNow(<?=$c['id']?>)">Book</button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
 
</div>
 
<script>
function applySort(){
  const url = new URL(window.location);
  url.searchParams.set('sort', document.getElementById('sort').value);
  window.location = url.toString();
}
function viewCar(id){ window.location = 'car.php?id=' + id; }
function bookNow(id){
  // forward along existing query params (dates + pickup)
  const url = new URL(window.location);
  const pickup = url.searchParams.get('pickup') || '';
  const start = url.searchParams.get('start') || '';
  const end = url.searchParams.get('end') || '';
  // redirect to car page with prefilled query
  window.location = `car.php?id=${id}&pickup=${encodeURIComponent(pickup)}&start=${encodeURIComponent(start)}&end=${encodeURIComponent(end)}`;
}
</script>
</body></html>
 
