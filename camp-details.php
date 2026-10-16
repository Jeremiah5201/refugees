<?php include "includes/header.php" ?>
<?php
if(!isset($_GET['c']) || $_GET['c']==""){
  header('location:dashboard.php');
  exit;
}
$c_id=(int)$_GET['c'];
$select=mysqli_query($conn,"select camp.*, location.l_name, registrar.r_name, registrar.r_contact, registrar.r_email
 from camp
 left join location on camp.l_id=location.l_id
 left join registrar on camp.r_id=registrar.r_id
 where camp.c_id='".$c_id."'");
$camp=mysqli_fetch_array($select);
if(!$camp){
  header('location:dashboard.php');
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
        <img src="<?php echo htmlspecialchars($camp['campIMG']); ?>" alt="<?php echo htmlspecialchars($camp['c_name']); ?>">
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
          <h3>Camp Registror</h3>
          <p><strong>Name:</strong> <?php echo htmlspecialchars($camp['r_name'] ? $camp['r_name'] : 'Unassigned'); ?></p>
          <p><strong>Contact:</strong> <?php echo htmlspecialchars($camp['r_contact'] ? $camp['r_contact'] : '-'); ?></p>
          <p><strong>Email:</strong> <?php echo htmlspecialchars($camp['r_email'] ? $camp['r_email'] : '-'); ?></p>
        </div>
      </div>

      <div class="table-section">
        <table>
          <tr>
            <th>#</th>
            <th>Refugee</th>
            <th>Number</th>
            <th>Nationality</th>
            <th>Type</th>
            <th>Group</th>
          </tr>
          <?php
          $select=mysqli_query($conn,"select refugee.*, nationality.nationality, refugee_type.type, refugee_group.group_type
          from refugee
          left join nationality on refugee.n_id=nationality.n_id
          left join refugee_type on refugee.t_id=refugee_type.t_id
          left join refugee_group on refugee.g_id=refugee_group.g_id
          where refugee.c_id='".$c_id."'
          order by refugee.ref_id desc");
          $count=0;
          while($row=mysqli_fetch_array($select)){
            $count++;
          ?>
          <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['ref_number']); ?></td>
            <td><?php echo htmlspecialchars($row['nationality']); ?></td>
            <td><?php echo htmlspecialchars($row['type']); ?></td>
            <td><?php echo htmlspecialchars($row['group_type']); ?></td>
          </tr>
          <?php }
          if($count==0){
            echo "<tr><td colspan='6' class='empty-state'>No refugees in this camp yet.</td></tr>";
          }
          ?>
        </table>
      </div>

      <div class="table-section" style="margin-top:18px">
        <table>
          <tr>
            <th>#</th>
            <th>Donor</th>
            <th>Resource</th>
            <th>Quantity</th>
            <th>Date</th>
            <th>Status</th>
          </tr>
          <?php
          $select=mysqli_query($conn,"select donation.*, donnor.d_name, resources.resource
          from donation
          left join donnor on donation.d_id=donnor.d_id
          left join resources on donation.res_id=resources.res_id
          where donation.c_id='".$c_id."'
          order by donation.don_id desc");
          $count=0;
          while($row=mysqli_fetch_array($select)){
            $count++;
          ?>
          <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo htmlspecialchars($row['d_name']); ?></td>
            <td><?php echo htmlspecialchars($row['resource']); ?></td>
            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
            <td><?php echo htmlspecialchars($row['donation_date']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
          </tr>
          <?php }
          if($count==0){
            echo "<tr><td colspan='6' class='empty-state'>No donations for this camp yet.</td></tr>";
          }
          ?>
        </table>
      </div>
      <p style="margin-top:18px"><a class="btn-link" href="dashboard.php">Back to Camps</a></p>
    </div>
</div>
<?php include "includes/footer.php"; ?>
