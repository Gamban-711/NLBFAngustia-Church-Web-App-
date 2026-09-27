<?= view('Template/Header') ?>
<?= view('Template/SideNav') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
  * {
    box-sizing: border-box;
  }

  .dashboard {
    padding: 32px 36px 60px;
    margin-left: 300px; /* To avoid overlap with the fixed sidebar */
    margin-top: 50px;   /* To avoid overlap with the fixed top header */
    min-height: calc(100vh - 90px); /* Full height minus header */
    background:
      radial-gradient(circle at 8% 10%, rgba(120, 170, 255, 0.35) 0%, rgba(120, 170, 255, 0) 45%),
      radial-gradient(circle at 92% 15%, rgba(160, 130, 255, 0.28) 0%, rgba(160, 130, 255, 0) 45%),
      radial-gradient(circle at 50% 100%, rgba(90, 200, 220, 0.25) 0%, rgba(90, 200, 220, 0) 50%),
      linear-gradient(160deg, #eaf2fd 0%, #dfeaf9 50%, #e7effc 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  /* ---------- Page heading ---------- */
  .dashboard-heading {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 4px;
  }

  .dashboard-heading .heading-icon {
    width: 46px;
    height: 46px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #6a8dff, #8f6bff);
    color: #fff;
    font-size: 18px;
    box-shadow: 0 6px 16px rgba(106, 141, 255, 0.4);
    flex-shrink: 0;
  }

  .dashboard-heading h3 {
    margin: 0;
    font-weight: 700;
    font-size: 24px;
    color: #1f2937;
    letter-spacing: 0.2px;
  }

  .dashboard-heading .subtitle {
    margin: 2px 0 0 0;
    font-size: 13.5px;
    color: #64748b;
  }

  .dashboard hr {
    border: none;
    height: 1px;
    background: linear-gradient(90deg, rgba(100, 130, 200, 0.35), rgba(100, 130, 200, 0));
    margin: 22px 0 28px 0;
  }

  /* ---------- Stat cards (glassmorphism) ---------- */
  .card-container {
    display: flex;
    flex-wrap: wrap;
    gap: 22px;
  }

  .dashboard-card {
    position: relative;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.55);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    border: 1px solid rgba(255, 255, 255, 0.6);
    border-radius: 20px;
    box-shadow:
      0 8px 24px rgba(31, 45, 90, 0.1),
      inset 0 1px 0 rgba(255, 255, 255, 0.7);
    flex: 1;
    min-width: 250px;
    padding: 24px;
    color: #333;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    text-align: left;
    gap: 18px;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
  }

  /* colored top accent bar, unique per card position */
  .dashboard-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--accent, linear-gradient(90deg, #6a8dff, #8f6bff));
  }

  .dashboard-card:nth-child(1) { --accent: linear-gradient(90deg, #22c55e, #16a34a); }
  .dashboard-card:nth-child(2) { --accent: linear-gradient(90deg, #f97316, #ea580c); }
  .dashboard-card:nth-child(3) { --accent: linear-gradient(90deg, #a855f7, #7c3aed); }
  .dashboard-card:nth-child(4) { --accent: linear-gradient(90deg, #3b82f6, #2563eb); }

  .dashboard-card:hover {
    transform: translateY(-4px) scale(1.015);
    box-shadow:
      0 16px 34px rgba(31, 45, 90, 0.18),
      inset 0 1px 0 rgba(255, 255, 255, 0.7);
  }

  .card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
  }

  .card-icon {
    width: 44px;
    height: 44px;
    border-radius: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    color: #fff;
    background: var(--accent);
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.12);
    flex-shrink: 0;
  }

  .dashboard-card h4 {
    margin: 0;
    font-weight: 600;
    font-size: 14px;
    letter-spacing: 0.3px;
    text-transform: uppercase;
    color: #64748b;
  }

  .dashboard-card p {
    margin: 0;
    font-size: 26px;
    font-weight: 800;
    color: #1e293b;
    letter-spacing: 0.2px;
  }

  .view-all-link {
    font-size: 13.5px;
    font-weight: 600;
    color: #334155;
    text-decoration: none;
    align-self: flex-end;
    margin-top: auto;
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.6);
    transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
  }

  .view-all-link span {
    font-size: 12px;
    margin-left: 6px;
    transition: transform 0.2s ease;
  }

  .view-all-link:hover {
    color: #fff;
    background: linear-gradient(135deg, #6a8dff, #8f6bff);
    transform: translateX(2px);
  }

  .view-all-link:hover span {
    transform: translateX(2px);
  }

  /* ---------- Upcoming events ---------- */
  .upcoming-events {
    margin-top: 34px;
    background: rgba(255, 255, 255, 0.45);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    border: 1px solid rgba(255, 255, 255, 0.6);
    padding: 26px;
    border-radius: 20px;
    box-shadow: 0 8px 24px rgba(31, 45, 90, 0.08);
  }

  .upcoming-events-heading {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 18px;
  }

  .upcoming-events-heading .events-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #fff;
    font-size: 14px;
  }

  .upcoming-events h5 {
    font-weight: 700;
    font-size: 16px;
    margin: 0;
    color: #1e293b;
  }

  .event-item {
    background: rgba(255, 255, 255, 0.8);
    border-radius: 14px;
    padding: 14px 16px;
    margin-bottom: 12px;
    box-shadow: 0 3px 10px rgba(31, 45, 90, 0.06);
    display: flex;
    align-items: center;
    gap: 14px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .event-item:last-child {
    margin-bottom: 0;
  }

  .event-item:hover {
    transform: translateX(3px);
    box-shadow: 0 6px 16px rgba(31, 45, 90, 0.12);
  }

  .event-item .event-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #8f6bff);
    flex-shrink: 0;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
  }

  .event-item .event-text strong {
    display: block;
    font-size: 14.5px;
    color: #1e293b;
    margin-bottom: 2px;
  }

  .event-item .event-text small {
    color: #64748b;
    font-size: 12.5px;
  }

  .no-events {
    text-align: center;
    color: #64748b;
    padding: 18px 0;
    font-size: 14px;
  }

  @media (max-width: 900px) {
    .dashboard {
      margin-left: 0;
      padding: 24px;
    }
  }
</style>


<div class="dashboard">

  <div class="dashboard-heading">
    <div class="heading-icon"><i class="fas fa-church"></i></div>
    <div>
      <h3>Welcome to NLBFii Admin Dashboard</h3>
      <p class="subtitle">Here's a quick overview of your church's finances and upcoming activities.</p>
    </div>
  </div>
  <hr>

  <div class="card-container">
    <div class="dashboard-card">
    <div class="card-top">
      <div>
        <h4>Total Donations</h4>
        <p>₱<?= number_format($totalDonations, 2) ?></p>
      </div>
      <div class="card-icon"><i class="fas fa-hand-holding-heart"></i></div>
    </div>
    <a href="<?= site_url('Manager/churchfund') ?>" class="view-all-link">
        View all
        <span><i class="fas fa-chevron-right"></i></span>
    </a>
    </div>


    <div class="dashboard-card">
      <div class="card-top">
        <div>
          <h4>Total Expenses</h4>
          <p>₱<?= number_format($totalExpenses, 2) ?></p>
        </div>
        <div class="card-icon"><i class="fas fa-receipt"></i></div>
      </div>
      <a href="<?= site_url('Expenses') ?>" class="view-all-link">
        View All
        <span><i class="fas fa-chevron-right"></i></span>
      </a>
    </div>

    <div class="dashboard-card">
      <div class="card-top">
        <div>
          <h4>Anniv Contributions</h4>
          <p>₱<?= number_format($totalAnnivContributions, 2) ?></p>
        </div>
        <div class="card-icon"><i class="fas fa-gift"></i></div>
      </div>
      <a href="<?= site_url('AnnivCon') ?>" class="view-all-link">
         View All
         <span><i class="fas fa-chevron-right"></i></span>
      </a>
    </div>

    <div class="dashboard-card">
      <div class="card-top">
        <div>
          <h4>Upcoming Events</h4>
          <p><?= count($upcomingEvents) ?> event(s)</p>
        </div>
        <div class="card-icon"><i class="fas fa-calendar-days"></i></div>
      </div>
      <a href="<?= site_url('Events') ?>" class="view-all-link">
         View All
         <span><i class="fas fa-chevron-right"></i></span>
      </a>
    </div>
  </div>

  <div class="upcoming-events">
    <div class="upcoming-events-heading">
      <div class="events-icon"><i class="fas fa-calendar-check"></i></div>
      <h5>Upcoming Events</h5>
    </div>
    <?php if (!empty($upcomingEvents)): ?>
        <?php foreach ($upcomingEvents as $event): ?>
        <div class="event-item">
            <div class="event-dot"></div>
            <div class="event-text">
              <strong><?= esc($event['event_name']) ?></strong>
              <small><?= esc($event['date']) ?> &nbsp;&middot;&nbsp; <?= esc($event['description']) ?></small>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-events">No upcoming events.</p>
    <?php endif; ?>
  </div>

</div>

<?= view('Template/Footer') ?>