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

    .hero {
      position: relative;
      background: url('https://2minutetabletop.com/wp-content/uploads/2020/02/Arvyre-Fantasy-Map-Banner.jpg') center center/cover no-repeat;
      height: 280px;
      border-radius: 16px;
      margin-bottom: 40px;
      box-shadow: 0 10px 40px #993300;
    }

    .hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: rgba(153, 51, 0, 0.6);
      border-radius: 16px;
    }

    .hero-text {
      position: absolute;
      bottom: 30px;
      left: 40px;
      z-index: 2;
      color: #ffffffcc;
    }

    .hero-text h1 {
      font-weight: 800;
      font-size: 2.8rem;
      letter-spacing: 3px;
      text-shadow: 0 0 12px rgba(0,0,0,0.7);
    }

    .hero-text p {
      margin-top: 10px;
      font-weight: 500;
      font-size: 1.2rem;
      opacity: 0.9;
    }

    h3 {
      color: #ffcc66;
      font-size: 2rem;
      margin-bottom: 20px;
      border-bottom: 3px solid #993300;
      padding-bottom: 5px;
      max-width: fit-content;
      letter-spacing: 1.5px;
    }

    .grid-section {
      display: flex;
      flex-wrap: wrap;
      gap: 40px;
      margin-bottom: 40px;
    }

    .featured-box,
    .highlight-box {
      flex: 1;
      min-width: 300px;
      background-color: #1a1f2b;
      padding: 20px;
      border-radius: 12px;
    }

    .featured-box img {
      width: 100%;
      border-radius: 8px;
    }

    .learn-more-section {
      margin-bottom: 40px;
    }

    .learn-more-cards {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }

    .learn-card {
      flex: 1;
      min-width: 250px;
      background-color: #1a1f2b;
      padding: 20px;
      border-radius: 10px;
      color: #fff;
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .learn-card:hover {
    background-color: #993300;  /* subtle solid color on hover */
    cursor: pointer;            /* pointer cursor to show it's clickable */
    color: #fff;                /* keep text readable */
    box-shadow: none;           /* no glow */
    transition: background-color 0.3s ease;  /* smooth transition */
    }

    .learn-card h4 {
    margin-bottom: 18px;
    }

    .featured-box:hover img,
    .highlight-box:hover img {
    filter: brightness(0.9);
    transform: scale(1.03);
    transition: transform 0.3s ease, filter 0.3s ease;
    }


  </style>
</head>
<body>

<div class="layout">
  <aside class="sidebar" role="navigation" aria-label="Main Navigation">
    <h2>COMPASS</h2>
    <nav>
      <a href="dashboard.php" class="active">Home</a>
      <a href="trip-planner.php">Trip Planner</a>
      <a href="destination.php">Destinations</a>
      <a href="travel-log.php">Travel Log</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
    </nav>
    <a href="logout.php" class="logout-link">Logout</a>
  </aside>

  <main class="content" role="main">
    <section class="hero" id="hero">
      <div class="hero-text">
        <h1>Wander often, wonder always.</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
      </div>
    </section>

   <div class="grid-section">
  <div class="featured-box">
    <h3>Featured Destination</h3>
    <img src="https://i.pinimg.com/736x/42/1b/bd/421bbdfc87fa55c0921f2c9c5c19fe90.jpg" alt="Featured Destination">
    <h4 style="margin-top: 15px; margin-bottom: 15px; color: #fff; font-size: 20px;">Hogwarts School of Witchcraft and Wizardry.</h4>
    <p style="font-size: 0.95rem; color: #fff;">Hogwarts School of Witchcraft and Wizardry is a magical boarding school in Scotland where young witches and wizards are trained in the magical arts. It is divided into four houses: Gryffindor, Hufflepuff, Ravenclaw, and Slytherin, each with its own unique values and traditions.</p>
  </div>

  <div class="highlight-box">
    <h3>Highlights</h3>
    <img src="https://platform.polygon.com/wp-content/uploads/sites/2/chorus/uploads/chorus_asset/file/23110040/3532507.jpeg?quality=90&strip=all&crop=12.359198998748,0,75.281602002503,100" alt="Highlights Image" style="width: 100%; border-radius: 8px; margin-bottom: 15px;">
    <p style="font-size: 0.95rem; color: #fff;">Quidditch is a high-speed, magical sport played on broomsticks in the Harry Potter series. It involves four balls, seven players per team, and a mix of scoring goals and catching the Golden Snitch.</p>
  </div>
</div>


    <section class="learn-more-section">
      <h3>Learn More About</h3>
      <div class="learn-more-cards">
        <div class="learn-card">
          <h4>Fly Fishing in the Rocky Mountains</h4>
          <p>Discover how to stretch your budget and explore the best of Europe without breaking the bank.</p>
        </div>
        <div class="learn-card">
          <h4>Level 5 Rapids! </h4>
          <p>Put your helmet on and grab your wetsuit. It's time to conquer Siberia.</p>
        </div>
        <div class="learn-card">
          <h4>Puget Sound Kayaking </h4>
          <p>One week of ocean kayaking in the Puget Sound.</p>
        </div>
      </div>
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
