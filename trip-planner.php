<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: index.html");
  exit();
}

$username = $_SESSION['username'];

// DB connection
$conn = new mysqli("localhost", "root", "", "auth_system");

$city = $region = '';
$activities = $info = [];

if ($conn->connect_error === false) {
  $stmt = $conn->prepare("SELECT city, region, activities, info FROM trip_plans WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->bind_result($city, $region, $activitiesStr, $infoStr);

  if ($stmt->fetch()) {
    $activities = explode(", ", $activitiesStr);
    $info = explode(", ", $infoStr);
  }

  $stmt->close();
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Nomad Trails - Trip Planner Signup</title>
  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
    }

    body, html {
      height: 100%;
      font-family: 'Poppins', sans-serif;
      background-color: #0d1117;
      color: #ffcc66;
    }

    a {
      color: #ffcc66;
      text-decoration: none;
    }

    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 260px;
      height: 100vh;
      background: #121821;
      display: flex;
      flex-direction: column;
      padding: 30px 20px;
      z-index: 10;
    }

    .sidebar h2 {
      font-weight: 700;
      font-size: 1.8rem;
      margin-bottom: 30px;
      color: #ffcc66;
      letter-spacing: 2px;
      text-align: center;
    }

    nav {
      flex-grow: 1;
    }

    nav a {
      display: block;
      padding: 15px 10px;
      font-weight: 600;
      font-size: 1.1rem;
      margin: 10px 0;
      border-radius: 8px;
      color: #ffffffcc;
      transition: background-color 0.3s, color 0.3s;
    }

    nav a.active,
    nav a:hover {
      background-color: #993300;
    }

    .logout-link {
      margin-top: auto;
      padding: 15px 10px;
      font-weight: 600;
      font-size: 1.1rem;
      border-radius: 8px;
      color: #ffffffcc;
      transition: background-color 0.3s, color 0.3s;
    }

    .logout-link:hover {
      background-color: #993300;
    }

    .content {
      margin-left: 260px;
      min-height: 100vh;
      padding: 40px 50px;
      background: linear-gradient(160deg, #121821 0%, #0d1117 100%);
      color: #ffcc66;
    }

    h1 {
      font-weight: 800;
      font-size: 2.8rem;
      letter-spacing: 3px;
      margin-bottom: 10px;
      text-align: center;
      color: #ffcc66;
      text-shadow: 0 0 12px rgba(153, 51, 0, 0.7);
    }

    p.welcome {
      font-weight: 500;
      font-size: 1.2rem;
      margin-bottom: 30px;
      text-align: center;
      color:rgb(255, 255, 255);
    }

    #chartdiv {
      width: 100%;
      height: 500px;
      margin-bottom: 40px;
    }

  form {
    max-width: 800px;
    width: 100%;
    background: #121821;
    padding: 30px;
    border-radius: 10px;
    color:rgb(255, 255, 255);
    box-shadow: 0 0 10px rgba(0,0,0,0.5);
    margin-left: 130px;
    margin-top: 100px;
  }

  form h2 {
    margin-top: 20px;
    font-size: 1.5rem;
    color: #ffcc66;
  }

  form label {
    display: block;
    margin: 10px 0 5px;
    font-weight: 500;
  }

  form input[type="text"] {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: none;
    margin-bottom: 20px;
    background: #1e2a38;
    color: #fff;
  }

  .checkbox-group {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px 20px;
    margin-bottom: 20px;
  }

  .checkbox-group label {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #1e2a38;
    padding: 10px;
    border-radius: 6px;
    cursor: pointer;
    user-select: none;
    font-weight: 400;
    transition: background-color 0.3s ease;
  }

  .checkbox-group label:hover {
    background: #bb4a12;
  }

  form input[type="checkbox"] {
    accent-color:#bb4a12;
    transform: scale(1.2);
  }

  form input[type="submit"] {
    margin-top: 20px;
    padding: 12px 20px;
    background: #993300;
    border: none;
    color: #ffffff;
    font-weight: bold;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  form input[type="submit"]:hover {
    background:rgb(199, 85, 28);
  }
  </style>
  <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
</head>
<body>

<div>
  <aside class="sidebar" role="navigation" aria-label="Main Navigation">
    <h2>COMPASS</h2>
    <nav>
      <a href="dashboard.php">Home</a>
      <a href="trip-planner.php" class="active">Trip Planner</a>
      <a href="destination.php">Destinations</a>
      <a href="#travel-log">Travel Log</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
    </nav>
    <a href="logout.php" class="logout-link">Logout</a>
  </aside>

  <main class="content" role="main">
    <h1>Plan Your Next Adventure</h1>
    <p class="welcome">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! Either click a region on the map or use the form below to plan your trip.</p>

    <div id="chartdiv"></div>

<form action="submit-trip.php" method="post">
  <h2>1. Either select a region on the map or type it into the fields below:</h2>
  <label for="city">City or closest major city:</label>
  <input type="text" name="city" id="city">

  <label for="region">Country or region:</label>
  <input type="text" name="region" id="region">

  <h2>2. What kind of things will you be doing there?</h2>
  <div class="checkbox-group">
    <label><input type="checkbox" name="activities[]" value="Hiking"> Hiking</label>
    <label><input type="checkbox" name="activities[]" value="Mountain Biking"> Mountain Biking</label>
    <label><input type="checkbox" name="activities[]" value="Kayaking"> Kayaking</label>
    <label><input type="checkbox" name="activities[]" value="Skiing"> Skiing</label>
    <label><input type="checkbox" name="activities[]" value="Fishing"> Fishing</label>
    <label><input type="checkbox" name="activities[]" value="Surfing"> Surfing</label>
  </div>

  <h2>3. What kind of information do you want about this trip?</h2>
  <div class="checkbox-group">
    <label><input type="checkbox" name="info[]" value="Transportation"> Transportation</label>
    <label><input type="checkbox" name="info[]" value="Health"> Health</label>
    <label><input type="checkbox" name="info[]" value="Weather"> Weather</label>
    <label><input type="checkbox" name="info[]" value="Gear"> Gear</label>
    <label><input type="checkbox" name="info[]" value="Political Info"> Political Info</label>
    <label><input type="checkbox" name="info[]" value="Activity Specific"> Activity Specific</label>
  </div>

  <input type="submit" value="Submit Plan">
</form>
  </main>
</div>

<script>
  am5.ready(function() {
    var root = am5.Root.new("chartdiv");
    root.setThemes([am5themes_Animated.new(root)]);

    var chart = root.container.children.push(
      am5map.MapChart.new(root, {
        panX: "rotateX",
        panY: "none",
        projection: am5map.geoMercator()
      })
    );

    var polygonSeries = chart.series.push(
      am5map.MapPolygonSeries.new(root, {
        geoJSON: am5geodata_worldLow,
        exclude: ["AQ"]
      })
    );

    polygonSeries.mapPolygons.template.setAll({
  tooltipText: "{name}",
  interactive: true,
  fill: am5.color(0x1e2a38), // default color (dark gray)
  stroke: am5.color(0x666666)
});

polygonSeries.mapPolygons.template.states.create("hover", {
  fill: am5.color(0xffcc66) // bright yellow on hover
});


    polygonSeries.mapPolygons.template.events.on("click", function(ev) {
      var name = ev.target.dataItem.dataContext.name;
      document.getElementById("region").value = name;
    });
  });

  const navLinks = document.querySelectorAll('.sidebar nav a');
  navLinks.forEach(link => {
    link.addEventListener('click', e => {
      navLinks.forEach(l => l.classList.remove('active'));
      e.target.classList.add('active');
    });
  });
</script>

</body>
</html>
