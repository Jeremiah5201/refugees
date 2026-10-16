<?php
include 'includes/config.php';
session_start();
if(!isset($_SESSION['donor']) || $_SESSION['donor']==""){
  header('location:donor-login.php');
  exit;
}
$donor_id=(int)$_SESSION['donor'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard | Refugee Management System</title>
    <link rel="shortcut icon" href="images/favicone.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/home.css">
</head>
<body class="donor-shell">
    <div class="donor-nav">
        <strong>Hello, <?php echo htmlspecialchars($_SESSION['donor_name']); ?></strong>
        <div class="links">
            <a href="index.php">Home</a>
            <a href="donor-dashboard.php">My Donations</a>
            <a href="donate.php">Donate</a>
            <a href="donor-logout.php">Logout</a>
        </div>
    </div>
    <div class="donor-main">
        <h1>My Donations</h1>
        <div class="panel">
            <div class="cta-row" style="margin-bottom:16px">
                <a class="btn btn-primary" href="donate.php">Make another donation</a>
                <a class="btn btn-ghost" href="index.php#needs" style="background:#e8eefc;color:#0b1f4d">Browse camp needs</a>
            </div>
            <div class="table-wrap">
                <table>
                    <tr>
                        <th>#</th>
                        <th>Camp</th>
                        <th>Resource</th>
                        <th>Quantity</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Linked Need</th>
                    </tr>
                    <?php
                    $select=mysqli_query($conn,"select donation.*, camp.c_name, resources.resource, camp_need.description
                    from donation
                    left join camp on donation.c_id=camp.c_id
                    left join resources on donation.res_id=resources.res_id
                    left join camp_need on donation.need_id=camp_need.need_id
                    where donation.d_id='".$donor_id."'
                    order by donation.don_id desc");
                    $count=0;
                    while($row=mysqli_fetch_array($select)){
                      $count++;
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo htmlspecialchars($row['c_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['resource']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($row['donation_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo $row['description'] ? htmlspecialchars($row['description']) : '-'; ?></td>
                    </tr>
                    <?php }
                    if($count==0){
                      echo "<tr><td colspan='7'>No donations yet. <a href='donate.php'>Donate now</a>.</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
