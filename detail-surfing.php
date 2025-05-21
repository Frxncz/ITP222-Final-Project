<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Destinations</title>
  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Poppins', sans-serif;
      background-color: #0d1117;
      color: #ffcc66;
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
      text-decoration: none;
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

    .content h3 {
      margin-bottom: 10px;
      color: #ffcc66;
    }

    .info-box {
      background-color: #1a1f2b;
      padding: 25px 30px;
      margin-bottom: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
      border-left: 5px solid #ffcc66;
      color: #fdf6e3;
      line-height: 1.7;
    }

    .two-column-Info {
      display: flex;
      gap: 20px;
    }

    .two-column-Info .info-box {
      flex: 1;
    }

    .camera-icon {
      width: 28px;
      height: 28px;
      fill: #ffcc66;
      margin-left: 10px;
      transition: transform 0.3s ease, fill 0.3s ease, filter 0.3s ease;
      vertical-align: middle;
      cursor: pointer;
    }

    .camera-icon:hover {
      transform: scale(1.3);
      fill: #fff2b3;
      filter: drop-shadow(0 0 5px #fff2b3);
    }

    .icon-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .icon-list li {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
      color: #fdf6e3;
    }

    .icon-list svg {
      width: 22px;
      height: 22px;
      fill: #ffcc66;
      margin-right: 10px;
      transition: transform 0.3s ease, fill 0.3s ease, filter 0.3s ease;
    }

    .icon-list li:hover svg {
      transform: scale(1.2);
      fill: #fff2b3;
      filter: drop-shadow(0 0 5px #fff2b3);
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

      .two-column {
        flex-direction: column;
      }
    }

    .package-line {
  display: flex;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
  padding-top: 10px;
}

.package-item {
  display: flex;
  align-items: center;
  gap: 8px;
  font-weight: 500;
  color: #fdf6e3;
}

.package-item svg {
  width: 22px;
  height: 22px;
  fill: #ffcc66;
  transition: transform 0.3s ease, fill 0.3s ease;
}

.package-item:hover svg {
  transform: scale(1.2);
  fill: #fff2b3;
}

.separator {
  height: 30px;
  width: 2px;
  background-color: #ffcc66;
  opacity: 0.5;
}

  </style>
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
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
        <!-- Package Includes Section -->
        <div class="info-box">
        <h3>Package Includes:</h3>
        <div class="package-line">
            <div class="package-item">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
            </svg>
            Airfare
            </div>
            <div class="separator"></div>
            <div class="package-item">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M4 6h16v2H4zm0 6h16v2H4zm0 6h16v2H4z" />
            </svg>
            Food
            </div>
            <div class="separator"></div>
            <div class="package-item">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M4 10v10h16V10l-8-6z" />
            </svg>
            Lodging
            </div>
            <div class="separator"></div>
            <div class="package-item">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
            </svg>
            Local guide
            </div>
        </div>
        </div>


      <!-- Other Things To Do Section -->
      <div class="info-box">
        <h3>
          Other Things To Do:
          <svg class="camera-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M20 5h-3.586l-1.707-1.707A.996.996 0 0014 3H10a.996.996 0 00-.707.293L7.586 5H4c-1.103 0-2 .897-2 2v10c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V7c0-1.103-.897-2-2-2zm-8 11a4 4 0 110-8 4 4 0 010 8zm0-6a2 2 0 100 4 2 2 0 000-4z"/>
          </svg>
        </h3>
        <p>Take a look at our slide show. We've got several snap shots of the area around your hotel, including some great places to eat, drink, or just hang out.</p>
      </div>

      <!-- Two-Column Info Section -->
      <div class="two-column-Info">
        <div class="info-box">
          <p>Summertime in southern California, what could be better? Let us know what you're looking for and we'll find it and take you there. Do you want big, fast waves or gentle rollers? Do you prefer a slamming beach break or a long, peeling point break? California's got it all so sign up now before summer's gone.</p>
        </div>
        <div class="info-box">
          <p>You'll stay at the centrally located Newport Bonita in Newport Beach. From there you can strike out to Trestles, Malibu, Salt Creek, The Wedge, San Onofre, and a dozen secret spots. Or, you can just walk out to the local beach breaks.</p>
        </div>
      </div>

            <a href="destination.php" style="
        display: inline-block;
        padding: 10px 20px;
        background-color: #993300;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        margin-bottom: 20px;
        transition: background-color 0.3s ease;
        ">Back</a>

    </main>
  </div>
</body>
</html>
