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
  <title>Nomad Trails - Travel Website with Log</title>
  <style>
    /* Reset and basics */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      scroll-behavior: smooth;
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

    /* Layout */
    .layout {
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    /* Sidebar */
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

    /* Main content */
    .content {
      flex-grow: 1;
      padding: 40px;
      overflow-y: auto;
    }

    /* Images row */
    .images-row {
      display: flex;
      justify-content: space-between;
      gap: 20px;
      margin-bottom: 30px;
    }

    .images-row img {
      width: 32%;
      height: auto;
      border-radius: 10px;
      object-fit: cover;
      max-height: 240px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.4);
      transition: transform 0.3s ease;
      cursor: pointer;
    }

    .images-row img:hover {
      transform: scale(1.05);
    }

    /* Info section */
    .info-section {
      color: #fdf6e3;
      font-size: 1.15rem;
      line-height: 1.8;
    }

    /* Each adventure container */
    .adventure-container {
      background-color: #1a1f2b;
      padding: 25px 30px;
      margin-bottom: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
      border-left: 5px solid #ffcc66;
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }

    .adventure-container:hover {
      background-color: #222c3d;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.6);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .layout {
        flex-direction: column;
      }

      .sidebar {
        width: 100%;
        flex-direction: row;
        overflow-x: auto;
        white-space: nowrap;
      }

      .content {
        padding: 20px;
      }

      .images-row {
        flex-direction: column;
        gap: 15px;
      }

      .images-row img {
        width: 100%;
        max-height: none;
      }
    }
  </style>
</head>
<body>

<div class="layout">
  <aside class="sidebar" role="navigation" aria-label="Main Navigation">
    <h2>COMPASS</h2>
    <nav>
      <a href="dashboard.php">Home</a>
      <a href="trip-planner.php">Trip Planner</a>
      <a href="destination.php">Destinations</a>
      <a href="travel-log.php" class="active">Travel Log</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
    </nav>
    <a href="logout.php" class="logout-link">Logout</a>
  </aside>

  <main class="content">

    <div class="images-row">
      <img src="https://lapoint.b-cdn.net/image/4qxBb6Nw4NARuV8AUDXZn6/1c594f817ac1aa69e81d8c07bfa90c0e/massive_waves.jpg?fm=jpg&fl=progressive&w=1920&q=75" alt="Surfer" />
      <img src="https://cdn.whistler.com/s3/images/og/whistler-recreational-biking.jpg" alt="Scaling mountains in Manurai" />
      <img src="https://assets.canarymedia.com/content/uploads/Alex-honnold-lead-resized.jpg" alt="Cycling the Irma coastline" />
    </div>

    <div class="info-section">
      <h3>Featured Adventures</h3>

      <div class="adventure-container">
        <p><strong>Conquering the rapids of the Rutan Islands:</strong> Definitely our craziest journey ever! A beautiful collage of nature. Rapids reaching nearly 50 mph, more than a dozen waterfalls of various sizes, and some killer rocks gave us the biggest rush. Nothing beats the feeling of complete loss of control! The Rutan Islands also has a lighter, more relaxing side – check out the local villages.</p>
      </div>

      <div class="adventure-container">
        <p><strong>Scaling mountains in Manurai:</strong> Some of the steepest cliffs around! My buddy and I began our 3-day scale above the majestic raging waters of Nanna.</p>
      </div>

      <div class="adventure-container">
        <p><strong>Cycling the Irma coastline:</strong> Beautiful scenery combined with steep inclines and fast roads allowed for some great cycling. Don't forget the helmet!!</p>
      </div>
    </div>

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
