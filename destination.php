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
      padding: 40px;
      overflow-y: auto;
    }

    .content > p {
      font-size: 1.1rem;
      margin-bottom: 30px;
      color: #f5f5f5;
    }

    .adventure-section {
      margin-bottom: 60px;
      padding: 30px;
      border-radius: 10px;
      background-color: #1a1f2b;
      display: flex;
      flex-wrap: wrap;
      align-items: flex-start;
      justify-content: space-between;
      transition: background-color 0.3s ease;
    }

    .adventure-section:hover {
      background-color: #222c3d;
    }

    .adventure-text {
      flex: 1 1 60%;
      padding-right: 20px;
    }

    .adventure-text h3 {
      font-size: 1.6rem;
      margin-bottom: 12px;
      color: #ffcc66;
    }

    .adventure-text p {
      font-size: 1rem;
      line-height: 1.6;
      color: #ffffffd9;
    }

    .adventure-details {
      margin-top: 10px;
      font-style: italic;
      font-size: 0.95rem;
      color: #f0e68c;
    }

    .adventure-image {
      flex: 1 1 35%;
      text-align: center;
    }

    .adventure-image img {
      width: 100%;
      height: auto;
      max-height: 240px;
      border-radius: 10px;
      object-fit: cover;
    }

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

      .adventure-section {
        flex-direction: column;
      }

      .adventure-text,
      .adventure-image {
        flex: 1 1 100%;
        padding: 0;
      }

      .adventure-image img {
        max-height: none;
      }
    }

      .intro-paragraph {
    background-color: #1a1f2b;
    padding: 25px 30px;
    margin-bottom: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    font-size: 1.15rem;
    line-height: 1.8;
    color: #fdf6e3;
    border-left: 5px solid #ffcc66;
    transition: background-color 0.3s ease;
  }

  .intro-paragraph:hover {
    background-color: #222c3d;
  }

.adventure-details {
  font-style: italic;
  font-size: 1.3rem;
  color: #fff; /* white text for contrast */
  background:rgb(179, 66, 9); /* solid color */
  padding: 8px 16px;
  border-radius: 5px;
  display: inline-block;
  box-shadow: 0 2px 6px rgba(153, 51, 0, 0.3);
  cursor: default;
  user-select: none;
}


.adventure-details:hover {
  color: #fff;
  background: #993300;
  box-shadow: 0 4px 10px rgba(153, 51, 0, 0.5);
}

.adventure-text p {
  margin-top: 20px;
  margin-bottom: 20px;
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
      <a href="destination.php" class="active">Destinations</a>
      <a href="travel-log.php">Travel Log</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
    </nav>
    <a href="logout.php" class="logout-link">Logout</a>
  </aside>

  <main class="content">
  <p class="intro-paragraph">
    Compass works hard to bring you the best possible trips for your rugged lifestyle.
    Here you'll find our latest travel packages suited for the adventure spirit.
  </p>

    <section class="adventure-section" id="hero">
      <div class="adventure-text">
        <h3>Surfing Adventure</h3>
        <p>Be ready to go on a moment's notice. We will call you when the surf is pumping and fly you out for five mornings of hurricane-inspired summertime swells.</p>
        <p class="adventure-details">$960 including lodging, food, and airfare</p>
      </div>
      
      <div class="adventure-image">
         <a href=detail-surfing.php>
        <img src="https://lapoint.b-cdn.net/image/4qxBb6Nw4NARuV8AUDXZn6/1c594f817ac1aa69e81d8c07bfa90c0e/massive_waves.jpg?fm=jpg&fl=progressive&w=1920&q=75" alt="Surfer">
        </a>
      </div>
    </section>

    <section class="adventure-section" id="trip-planner">
      <div class="adventure-text">
        <h3>Mountain Biking Expedition</h3>
        <p>Get ready for thrilling trails and scenic routes designed for biking enthusiasts. Our mountain biking package takes you through breathtaking terrain and unforgettable views.</p>
        <p class="adventure-details">$870 including guide, meals, and transport</p>
      </div>
          <div class="adventure-image">
            <a href="#detail-biker">
            <img src="https://cdn.whistler.com/s3/images/og/whistler-recreational-biking.jpg" alt="Mountain Biker">
            </a>
          </div>
    </section>

    <section class="adventure-section" id="travel-log">
      <div class="adventure-text">
        <h3>Rock Climbing Experience</h3>
        <p>Challenge yourself with our rock climbing adventures. Whether you're a beginner or seasoned climber, we've got the cliffs and gear ready for an adrenaline-packed journey.</p>
        <p class="adventure-details">$920 including gear rental, safety training, and meals</p>
      </div>
        <a href="#detail-climber">
          <div class="adventure-image">
            <a href="#detail-climber">
            <img src="https://assets.canarymedia.com/content/uploads/Alex-honnold-lead-resized.jpg" alt="Climber">
            </a>
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
