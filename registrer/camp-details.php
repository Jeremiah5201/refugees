<?php include "includes/header.php" ?>
<?php
$c_id=(int)$_SESSION['camp'];
$camp=mysqli_fetch_array(mysqli_query($conn,"select camp.*, location.l_name, registrar.r_name, registrar.r_contact, registrar.r_email
 from camp
 left join location on camp.l_id=location.l_id
 left join registrar on camp.r_id=registrar.r_id
 where camp.c_id='".$c_id."'"));
if(!$camp){
  echo "<div class='container'><div class='main'><div class='empty-state'>No camp assigned.</div></div></div>";
  include "includes/footer.php";
  exit;
}
$refugeeCount=mysqli_fetch_array(mysqli_query($conn,"select count(*) as total from refugee where c_id='".$c_id."'"));
$donationCount=mysqli_fetch_array(mysqli_query($conn,"select count(*) as total from donation where c_id='".$c_id."'"));
?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1><?php echo htmlspecialchars($camp['c_name']); ?></h1>
      <div class="hero-camp">
        <img src="../<?php echo htmlspecialchars($camp['campIMG']); ?>" alt="">
      </div>
      <div class="stats-row">
        <div class="stat-card"><span>Refugees</span><strong><?php echo (int)$refugeeCount['total']; ?></strong></div>
        <div class="stat-card"><span>Donations</span><strong><?php echo (int)$donationCount['total']; ?></strong></div>
        <div class="stat-card"><span>Location</span><strong style="font-size:1.1rem"><?php echo htmlspecialchars($camp['l_name'] ? $camp['l_name'] : 'N/A'); ?></strong></div>
      </div>
      <div class="detail-grid">
        <div class="detail-card">
          <h3>Camp Info</h3>
          <p><strong>Name:</strong> <?php echo htmlspecialchars($camp['c_name']); ?></p>
          <p><strong>Location:</strong> <?php echo htmlspecialchars($camp['l_name'] ? $camp['l_name'] : 'N/A'); ?></p>
        </div>
        <div class="detail-card">
          <h3>Assigned Registror</h3>
          <p><strong>Name:</strong> <?php echo htmlspecialchars($camp['r_name'] ? $camp['r_name'] : $_SESSION['name']); ?></p>
          <p><strong>Contact:</strong> <?php echo htmlspecialchars($camp['r_contact'] ? $camp['r_contact'] : '-'); ?></p>
          <p><strong>Email:</strong> <?php echo htmlspecialchars($camp['r_email'] ? $camp['r_email'] : '-'); ?></p>
        </div>
      </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>
