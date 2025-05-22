<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Nomad Trails - Trip Planner</title>
  <style>
 /* Reset and base */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

html, body {
  height: 100%;
  font-family: 'Poppins', sans-serif;
  background-color: #0d1117;
  color: #ffcc66;
  line-height: 1.5;
}

/* Links */
a {
  color: #ffcc66;
  text-decoration: none;
  transition: color 0.3s ease;
}
a:hover,
nav a.active {
  color: #ffffffcc;
  background-color: #993300;
  border-radius: 8px;
}

/* Sidebar */
.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  width: 260px;
  height: 100vh;
  background: #121821;
  padding: 30px 20px;
  display: flex;
  flex-direction: column;
  z-index: 10;
}

.sidebar h2 {
  font-weight: 700;
  font-size: 1.8rem;
  color: #ffcc66;
  letter-spacing: 2px;
  text-align: center;
  margin-bottom: 30px;
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
  color: #ffffffcc;
  border-radius: 8px;
  cursor: pointer;
  user-select: none;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.logout-link {
  margin-top: auto;
  padding: 15px 10px;
  font-weight: 600;
  font-size: 1.1rem;
  color: #ffffffcc;
  border-radius: 8px;
  cursor: pointer;
  user-select: none;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.logout-link:hover {
  background-color: #993300;
  color: #fff;
}

/* Main content */
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
  color: #ffffffcc;
}

/* Form styling */
form {
  max-width: 800px;
  margin: 100px auto 0 auto;
  background: #121821;
  padding: 30px;
  border-radius: 10px;
  color: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}

form h2 {
  margin-top: 20px;
  margin-bottom: 15px;
  font-size: 1.5rem;
  color: #ffcc66;
  font-weight: 600;
}

form label {
  display: block;
  margin-bottom: 6px;
  font-weight: 500;
  cursor: pointer;
}

form input[type="text"] {
  width: 100%;
  padding: 10px;
  border-radius: 6px;
  border: none;
  background: #1e2a38;
  color: #fff;
  font-size: 1rem;
  margin-bottom: 20px;
  transition: background-color 0.3s ease;
}

form input[type="text"]:focus {
  outline: none;
  background-color: #2b3a50;
}

/* Checkbox groups */
.checkbox-group {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
  gap: 12px 20px;
  margin-bottom: 20px;
}

.checkbox-group label {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px;
  background: #1e2a38;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 400;
  transition: background-color 0.3s ease;
  user-select: none;
}

.checkbox-group label:hover {
  background: #bb4a12;
}

form input[type="checkbox"] {
  accent-color: #bb4a12;
  transform: scale(1.2);
  cursor: pointer;
}

/* Submit button */
form input[type="submit"] {
  display: inline-block;
  margin-top: 20px;
  padding: 12px 20px;
  background: #993300;
  border: none;
  border-radius: 6px;
  color: #fff;
  font-weight: 700;
  font-size: 1.1rem;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

form input[type="submit"]:hover {
  background: #c7551c;
}

/* Trip items */
.trip-item {
  max-width: 800px;
  margin: 20px auto;
  background: #1e2a38;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 8px rgba(255, 204, 102, 0.2);
  color: #fff;
  line-height: 1.4;
}

.trip-item strong {
  color: #ffcc66;
}

.trip-item form {
  margin-top: 15px;
}

.trip-item input[type="submit"] {
  background: #bb4a12;
  border: none;
  padding: 10px 15px;
  border-radius: 6px;
  color: #fff;
  font-weight: 700;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.trip-item input[type="submit"]:hover {
  background: #d94a0b;
}

/* Submitted Trips Container */
.submitted-trips {
  max-width: 800px;
  margin: 40px auto 80px auto;
  padding: 0 20px;
}

/* No trips message */
.no-trips-message {
  background: #1e2a38;
  padding: 20px;
  border-radius: 10px;
  color: #ffcc66;
  font-size: 1.3rem;
  text-align: center;
  /* box-shadow removed */
  margin-top: 20px;
}

/* Trip items container */
.trip-items-list {
  display: flex;
  flex-direction: column;
  gap: 20px;
  margin-top: 20px;
}

/* Trip item */
.trip-item {
  background: #1e2a38;
  padding: 20px 25px;
  border-radius: 10px;
  /* box-shadow removed */
  color: #fff;
  line-height: 1.5;
  position: relative;
}

/* Strong text */
.trip-item strong {
  color: #ffcc66;
}

/* Cancel button */
.trip-item form {
  margin-top: 15px;
  text-align: right;
}

.trip-item input[type="submit"] {
  background: #bb4a12;
  border: none;
  padding: 10px 18px;
  border-radius: 6px;
  color: #fff;
  font-weight: 700;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.trip-item input[type="submit"]:hover {
  background: #d94a0b;
}




  </style>
</head>
<body>

<div>
  <aside class="sidebar" role="navigation" aria-label="Main Navigation">
<h2>
  <img src="./logo/logo-comp.png" alt="Compass Logo" style="height: 60px; vertical-align: middle; margin-right: 10px;">
  COMPASS
</h2>
    <nav>
      <a href="dashboard.php">Home</a>
      <a href="trip-planner.php" class="active">Trip Planner</a>
      <a href="destination.php">Destinations</a>
      <a href="travel-log.php">Travel Log</a>
      <a href="about.php">About</a>
    </nav>
    <a href="logout.php" class="logout-link">Logout</a>
  </aside>

  <main class="content" role="main">
    <h1>Plan Your Next Adventure</h1>
    <p class="welcome">Welcome, <?php echo htmlspecialchars($username); ?>! Either click a region on the map or use the form below to plan your trip.</p>

    <!-- Your map div or other interactive region can be here -->
    <div id="chartdiv" style="width: 100%; height: 500px; margin-bottom: 40px;"></div>

    <!-- Trip Submission Form -->
    <form action="submit-trip.php" method="post" aria-label="Submit a new trip plan">
      <h2>1. Either select a region on the map or type it into the fields below:</h2>
      <label for="city">City or closest major city:</label>
      <input type="text" name="city" id="city" required>

      <label for="region">Country or region:</label>
      <input type="text" name="region" id="region" required>

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

<h2 style="
  margin-top: 60px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  font-size: 2.4rem;
  color: #ffcc66;
  text-align: center;
  letter-spacing: 1.5px;
  border-bottom: 3px solid #ffcc66;
  padding-bottom: 10px;
  /* max-width: 400px;  <-- remove this */
  margin-left: auto;
  margin-right: auto;
  white-space: nowrap; /* optional: prevents wrapping */
">
  Your Submitted Trip Plans
</h2>



    <?php
    // Connect to DB and fetch trips for the user
    $conn = new mysqli("localhost", "root", "", "auth_system");
    if ($conn->connect_error) {
        echo "<p style='color: red;'>Error connecting to database.</p>";
    } else {
        $stmt = $conn->prepare("SELECT id, city, region, activities, info FROM trip_plans WHERE username = ? ORDER BY id DESC");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<div class="submitted-trips">';
if ($result->num_rows > 0) {
    echo '<div class="trip-items-list">';
    while ($row = $result->fetch_assoc()) {
        echo '<div class="trip-item">';
        echo '<strong>City:</strong> ' . htmlspecialchars($row['city']) . '<br>';
        echo '<strong>Region:</strong> ' . htmlspecialchars($row['region']) . '<br>';
        echo '<strong>Activities:</strong> ' . htmlspecialchars($row['activities']) . '<br>';
        echo '<strong>Info Requested:</strong> ' . htmlspecialchars($row['info']) . '<br>';

        // Cancel form
        echo '<form method="POST" action="delete-trip.php" onsubmit="return confirm(\'Are you sure you want to cancel this trip plan?\');">';
        echo '<input type="hidden" name="trip_id" value="' . intval($row['id']) . '">';
        echo '<input type="submit" value="Cancel Trip">';
        echo '</form>';

        echo '</div>';
    }
    echo '</div>';
} else {
    echo '<p class="no-trips-message">You haven\'t submitted any trip plans yet.</p>';
}
echo '</div>';

        $stmt->close();
        $conn->close();
    }
    ?>

  </main>
</div>

<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

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
      cursorOverStyle: "pointer",
      fill: am5.color(0x993300),
      stroke: am5.color(0x662200)
    });

    polygonSeries.mapPolygons.template.states.create("hover", {
      fill: am5.color(0xffd27f )
    });

    polygonSeries.mapPolygons.template.events.on("click", function(ev) {
      var city = prompt("Enter a city or closest major city:");
      var region = ev.target.dataItem.dataContext.name;
      if(city && region) {
        document.getElementById("city").value = city;
        document.getElementById("region").value = region;
        window.scrollTo({top: document.getElementById("city").offsetTop - 100, behavior: 'smooth'});
      }
    });
  });
</script>

</body>
</html>
