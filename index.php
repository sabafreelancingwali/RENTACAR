<?php
// index.php – RentACar Clone Homepage
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>RentACar Clone</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f7f8fa;
      color: #333;
    }
    header {
      background: #0077b6;
      color: #fff;
      padding: 20px;
      text-align: center;
      font-size: 24px;
      font-weight: bold;
      letter-spacing: 1px;
    }
    .search-bar {
      background: #fff;
      max-width: 900px;
      margin: 30px auto;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      display: flex;
      gap: 15px;
      align-items: center;
      justify-content: center;
      flex-wrap: wrap;
    }
    .search-bar input, .search-bar button {
      padding: 12px;
      font-size: 16px;
      border-radius: 8px;
      border: 1px solid #ddd;
      outline: none;
    }
    .search-bar input:focus {
      border-color: #0077b6;
    }
    .search-bar button {
      background: #0077b6;
      color: #fff;
      border: none;
      cursor: pointer;
      transition: 0.3s;
    }
    .search-bar button:hover {
      background: #023e8a;
    }
    .section-title {
      text-align: center;
      font-size: 22px;
      margin-top: 50px;
      margin-bottom: 20px;
      color: #222;
    }
    .cars {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
      max-width: 1200px;
      margin: auto;
      padding: 0 20px 50px;
    }
    .car-card {
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      transition: transform 0.2s;
    }
    .car-card:hover {
      transform: translateY(-5px);
    }
    .car-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }
    .car-info {
      padding: 15px;
    }
    .car-info h3 {
      margin: 0 0 10px;
      font-size: 18px;
      color: #0077b6;
    }
    .car-info p {
      margin: 0 0 10px;
      font-size: 14px;
      color: #555;
    }
    .car-info .price {
      font-size: 16px;
      font-weight: bold;
      color: #000;
    }
  </style>
</head>
<body>
 
  <header>🚗 RentACar Clone</header>
 
  <form class="search-bar" onsubmit="return goToListings()">
    <input type="text" id="location" placeholder="Pickup Location" required>
    <input type="date" id="startDate" required>
    <input type="date" id="endDate" required>
    <button type="submit">Search Cars</button>
  </form>
 
  <h2 class="section-title">Featured Rental Cars</h2>
 
  <div class="cars">
    <div class="car-card">
      <img src="https://i.ibb.co/jHchvQd/car1.jpg" alt="Toyota Corolla">
      <div class="car-info">
        <h3>Toyota Corolla</h3>
        <p>Comfortable and fuel efficient – perfect for city trips.</p>
        <p class="price">$40/day</p>
      </div>
    </div>
    <div class="car-card">
      <img src="https://i.ibb.co/ygKz5jq/car2.jpg" alt="Honda Civic">
      <div class="car-info">
        <h3>Honda Civic</h3>
        <p>Stylish and powerful, great for long drives.</p>
        <p class="price">$55/day</p>
      </div>
    </div>
    <div class="car-card">
      <img src="https://i.ibb.co/5hKbtYn/car3.jpg" alt="SUV Jeep">
      <div class="car-info">
        <h3>Jeep Wrangler</h3>
        <p>Rugged SUV – best for off-road and adventures.</p>
        <p class="price">$80/day</p>
      </div>
    </div>
  </div>
 
  <script>
    function goToListings() {
      const location = document.getElementById("location").value;
      const startDate = document.getElementById("startDate").value;
      const endDate = document.getElementById("endDate").value;
      // Redirect to listings.php with search params
      window.location.href = `listings.php?location=${encodeURIComponent(location)}&start=${startDate}&end=${endDate}`;
      return false;
    }
  </script>
 
</body>
</html>
