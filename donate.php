<?php
include 'includes/config.php';
session_start();
if(!isset($_SESSION['donor']) || $_SESSION['donor']==""){
  $need = isset($_GET['need']) ? (int)$_GET['need'] : 0;
  $redir = $need ? 'donate.php?need='.$need : 'donate.php';
  header('location:donor-login.php?redirect='.urlencode($redir));
  exit;
}
$donor_id=(int)$_SESSION['donor'];
$prefill=null;
if(isset($_GET['need']) && $_GET['need']!=""){
  $need_id=(int)$_GET['need'];
  $prefill=mysqli_fetch_array(mysqli_query($conn,"select camp_need.*, resources.resource, camp.c_name
  from camp_need
  left join resources on camp_need.res_id=resources.res_id
  left join camp on camp_need.c_id=camp.c_id
  where camp_need.need_id='".$need_id."' and camp_need.status='Open'"));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate | Refugee Management System</title>
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
        <h1>Make a Donation</h1>
        <div class="panel">
            <?php
            if(isset($_POST['submit'])){
              $camp=(int)$_POST['camp'];
              $resource=(int)$_POST['resource'];
              $quantity=mysqli_real_escape_string($conn,$_POST['quantity']);
              $donation_date=mysqli_real_escape_string($conn,$_POST['donation_date']);
              $need_id = isset($_POST['need_id']) && $_POST['need_id']!="" ? (int)$_POST['need_id'] : "NULL";
              $status='Pending';

              $insert=mysqli_query($conn,"insert into donation(don_id,d_id,res_id,quantity,donation_date,c_id,status,need_id)
              values(null,'".$donor_id."','".$resource."','".$quantity."','".$donation_date."','".$camp."','".$status."',".($need_id==="NULL"?"NULL":"'".$need_id."'").")");
              if($insert){
                if($need_id!=="NULL"){
                  // keep need open unless registrar closes it; optional note only
                }
                echo "<div class='alert alert-success'>Donation submitted successfully. Thank you!</div>";
              }else{
                echo "<div class='alert alert-error'>Failed to submit donation: ".mysqli_error($conn)."</div>";
              }
            }
            if($prefill){
              echo "<div class='alert alert-success'>Donating toward: ".htmlspecialchars($prefill['resource'])." for ".htmlspecialchars($prefill['c_name'])." (".$prefill['quantity'].")</div>";
            }
            ?>
            <form method="post">
                <?php if($prefill){ ?>
                <input type="hidden" name="need_id" value="<?php echo (int)$prefill['need_id']; ?>">
                <?php } ?>
                <label>Camp</label>
                <select name="camp" required>
                    <option value="">Select Camp</option>
                    <?php
                    $select=mysqli_query($conn,"select * from camp order by c_name");
                    while($row=mysqli_fetch_assoc($select)){
                      $selected = ($prefill && $prefill['c_id']==$row['c_id']) ? 'selected' : '';
                      echo "<option value='".$row['c_id']."' $selected>".htmlspecialchars($row['c_name'])."</option>";
                    }
                    ?>
                </select>
                <label>Resource</label>
                <select name="resource" required>
                    <option value="">Select Resource</option>
                    <?php
                    $select=mysqli_query($conn,"select * from resources order by resource");
                    while($row=mysqli_fetch_assoc($select)){
                      $selected = ($prefill && $prefill['res_id']==$row['res_id']) ? 'selected' : '';
                      echo "<option value='".$row['res_id']."' $selected>".htmlspecialchars($row['resource'])."</option>";
                    }
                    ?>
                </select>
                <label>Quantity</label>
                <input type="text" name="quantity" value="<?php echo $prefill ? htmlspecialchars($prefill['quantity']) : ''; ?>" required>
                <label>Donation Date</label>
                <input type="date" name="donation_date" value="<?php echo date('Y-m-d'); ?>" required>
                <button type="submit" name="submit" class="btn btn-primary" style="margin-top:12px">Submit Donation</button>
            </form>
        </div>
    </div>
</body>
</html>
