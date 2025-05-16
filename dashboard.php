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
    background-color: #0d1117; /* base dark */
    color: #ffcc66; /* warm yellow text */
  }

  a {
    color: #ffcc66; /* warm yellow links */
    text-decoration: none;
  }

  .layout {
    display: flex;
    height: 100vh;
    overflow: hidden;
  }

  .sidebar {
    width: 260px;
    background: #121821; /* a little lighter than base for contrast */
    display: flex;
    flex-direction: column;
    padding: 30px 20px;
  }

  .sidebar h2 {
    font-weight: 700;
    font-size: 1.8rem;
    margin-bottom: 30px;
    color: #ffcc66; /* warm yellow */
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
    color: #ffffffcc; /* white with some transparency */
    transition: background-color 0.3s, color 0.3s;
  }

  nav a.active,
  nav a:hover {
    background-color: #993300; /* dark orange */
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
    background: rgba(153, 51, 0, 0.6); /* dark orange overlay */
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
    color: #ffcc66; /* warm yellow */
    font-size: 2rem;
    margin-bottom: 20px;
    border-bottom: 3px solid #993300; /* dark orange */
    padding-bottom: 5px;
    max-width: fit-content;
    letter-spacing: 1.5px;
  }
</style>


</head>
<body>

<div class="layout">
  <aside class="sidebar" role="navigation" aria-label="Main Navigation">
    <h2>COMPASS</h2>
    <nav>
      <a href="#hero" class="active">Home</a>
      <a href="#travel-log">Trip Planner</a>
      <a href="#destinations">Destinations</a>
      <a href="#travel-log">Travel Log</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
    </nav>
    <a href="logout.php" class="logout-link">Logout</a>
  </aside>

  <main class="content" role="main">
    <section class="hero" id="hero" aria-label="Hero section with travel theme">
      <div class="hero-text" tabindex="0">
        <h1>Wander often, wonder always.</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
      </div>
    </section>

  </main>
</div>

</body>
</html>


<script>
  // Navigation active link highlighting
  const navLinks = document.querySelectorAll('.sidebar nav a');
  navLinks.forEach(link => {
    link.addEventListener('click', e => {
      navLinks.forEach(l => l.classList.remove('active'));
      e.target.classList.add('active');
    });
  });

  // Travel log functionality
  const form = document.getElementById('travelLogForm');
  const logEntriesContainer = document.getElementById('logEntries');

  // Load entries from localStorage and render
  function loadEntries() {
    const entries = JSON.parse(localStorage.getItem('nomadTravelLog')) || [];
    logEntriesContainer.innerHTML = '';

    if (entries.length === 0) {
      logEntriesContainer.innerHTML = '<p style="color:#aaa; font-style:italic;">No travel log entries yet. Start by adding one above!</p>';
      return;
    }

    entries.forEach(entry => {
      const entryEl = document.createElement('article');
      entryEl.className = 'log-entry';
      entryEl.tabIndex = 0;
      const dateObj = new Date(entry.date);
      const formattedDate = dateObj.toLocaleDateString(undefined, { year:'numeric', month:'short', day:'numeric' });

        entryEl.innerHTML = `
        <h4>${entry.title}</h4>
        <div class="meta">${formattedDate} | ${entry.location}</div>
        <p>${entry.description}</p>
        `;


      logEntriesContainer.appendChild(entryEl);
    });
  }

  // Save new entry to localStorage
  function saveEntry(entry) {
    const entries = JSON.parse(localStorage.getItem('nomadTravelLog')) || [];
    entries.unshift(entry); // Newest first
    localStorage.setItem('nomadTravelLog', JSON.stringify(entries));
  }

  form.addEventListener('submit', e => {
    e.preventDefault();

    const newEntry = {
      title: form.title.value.trim(),
      location: form.location.value.trim(),
      date: form.date.value,
      description: form.description.value.trim()
    };

    if (!newEntry.title || !newEntry.location || !newEntry.date || !newEntry.description) {
      alert('Please fill in all fields.');
      return;
    }

    saveEntry(newEntry);
    form.reset();
    loadEntries();
    form.title.focus();
  });

  loadEntries();
</script>

</body>
</html>

