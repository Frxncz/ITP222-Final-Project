<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: index.html");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>About - Nomad Trails</title>
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

    .layout {
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    .sidebar {
      width: 260px;
      background: #121821;
      display: flex;
      flex-direction: column;
      padding: 30px 20px;
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
      flex-grow: 1;
      overflow-y: auto;
      padding: 40px 50px;
      background: linear-gradient(160deg, #121821 0%, #0d1117 100%);
      color: #ffcc66;
    }

    .section {
      margin-bottom: 40px;
    }

    h1 {
      font-size: 2.5rem;
      margin-bottom: 20px;
      border-bottom: 3px solid #993300;
      padding-bottom: 10px;
      max-width: fit-content;
    }

    p {
      font-size: 1.1rem;
      line-height: 1.7;
      color: #ffffffcc;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

<div class="layout">
  <aside class="sidebar" role="navigation" aria-label="Main Navigation">
<h2>
  <img src="./logo/logo-comp.png" alt="Compass Logo" style="height: 60px; vertical-align: middle; margin-right: 10px;">
  COMPASS
</h2>
    <nav>
      <a href="dashboard.php">Home</a>
      <a href="trip-planner.php">Trip Planner</a>
      <a href="destination.php">Destinations</a>
      <a href="travel-log.php">Travel Log</a>
      <a href="about.php" class="active">About</a>
    </nav>
    <a href="logout.php" class="logout-link">Logout</a>
  </aside>

  <main class="content" role="main">
    <section class="section">
      <h1>About COMPASS</h1>
      <p>
        COMPASS is your digital compass for discovering the world. Whether you're planning your first trip or your hundredth, we help you explore new destinations, log unforgettable adventures, and uncover hidden gems across the globe.
      </p>
      <p>
        This platform is built with passion by travelers, for travelers — ensuring every journey you take is well-planned, well-remembered, and full of wonder. From planning tools to logging your memories, COMPASS is here to support your wanderlust.
      </p>
      <p>
        Logged in as <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>. Thank you for being part of our community.
      </p>
    </section>

    <section class="section">
      <h1>Contact Us</h1>
      <p>We'd love to hear from you! Reach out to us through any of the following channels:</p>
      <p><strong>Email:</strong> support@compass-travel.com</p>
      <p><strong>Phone:</strong> +1 (234) 567-890</p>
      <p><strong>Address:</strong> 123 Explorer Lane, Wanderlust City, 45678</p>
    </section>
  </main>
</div>

<script>
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
