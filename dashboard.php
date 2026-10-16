<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Registered Camps</h1>
      <?php
        $campCount = mysqli_fetch_array(mysqli_query($conn,"select count(*) as total from camp"));
        $refugeeCount = mysqli_fetch_array(mysqli_query($conn,"select count(*) as total from refugee"));
        $registrarCount = mysqli_fetch_array(mysqli_query($conn,"select count(*) as total from registrar"));
        $donorCount = mysqli_fetch_array(mysqli_query($conn,"select count(*) as total from donnor"));
      ?>
      <div class="stats-row">
        <div class="stat-card"><span>Camps</span><strong><?php echo (int)$campCount['total']; ?></strong></div>
        <div class="stat-card"><span>Refugees</span><strong><?php echo (int)$refugeeCount['total']; ?></strong></div>
        <div class="stat-card"><span>Registrors</span><strong><?php echo (int)$registrarCount['total']; ?></strong></div>
        <div class="stat-card"><span>Donors</span><strong><?php echo (int)$donorCount['total']; ?></strong></div>
      </div>
      <div class="camps">
         <?php
        $select=mysqli_query($conn,"select camp.*, location.l_name, registrar.r_name,
         (select count(*) from refugee where refugee.c_id=camp.c_id) as total_refugees
         from camp
         left join location on camp.l_id=location.l_id
         left join registrar on camp.r_id=registrar.r_id
         order by camp.c_id desc");
        $found=false;
        while($row=mysqli_fetch_array($select)){
          $found=true;
          ?>
        <div class="camp">
            <img src="<?php echo  htmlspecialchars($row['campIMG']); ?>" alt="<?php echo htmlspecialchars($row['c_name']); ?>">
            <div class="camp_name">
                <h2><?php echo  htmlspecialchars($row['c_name']); ?></h2>
            </div>
            <div class="details">
                <table>
                    <tr>
                        <th>Total:</th>
                        <td><?php echo (int)$row['total_refugees']; ?> Refugees</td>
                    </tr>
                    <tr>
                        <th>Location:</th>
                        <td><?php echo  htmlspecialchars($row['l_name'] ? $row['l_name'] : 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Camp Registror:</th>
                        <td><?php echo  htmlspecialchars($row['r_name'] ? $row['r_name'] : 'Unassigned'); ?></td>
                    </tr>
                </table>
                <hr>
                <a href="camp-details.php?c=<?php echo (int)$row['c_id']; ?>"><div class="btn">View Camp Details</div></a>
            </div>
        </div>
         <?php }
         if(!$found){
           echo "<div class='empty-state'>No camps registered yet. <a href='add-camp.php'>Add a camp</a>.</div>";
         }
         ?>
      </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>
