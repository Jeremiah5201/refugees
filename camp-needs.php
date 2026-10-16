<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Camp Needs</h1>
      <p style="margin-bottom:16px;color:#5b6785">Needs posted by camp registrors and shown on the public homepage.</p>
      <div class="table-section">
        <table>
          <tr>
            <th>#</th>
            <th>Camp</th>
            <th>Registror</th>
            <th>Resource</th>
            <th>Quantity</th>
            <th>Description</th>
            <th>Status</th>
            <th>Posted</th>
          </tr>
          <?php
          $select=mysqli_query($conn,"select camp_need.*, camp.c_name, registrar.r_name, resources.resource
          from camp_need
          left join camp on camp_need.c_id=camp.c_id
          left join registrar on camp_need.r_id=registrar.r_id
          left join resources on camp_need.res_id=resources.res_id
          order by camp_need.need_id desc");
          $count=0;
          while($row=mysqli_fetch_array($select)){
            $count++;
          ?>
          <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo htmlspecialchars($row['c_name']); ?></td>
            <td><?php echo htmlspecialchars($row['r_name']); ?></td>
            <td><?php echo htmlspecialchars($row['resource']); ?></td>
            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
            <td><?php echo htmlspecialchars($row['description']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
            <td><?php echo htmlspecialchars($row['posted_date']); ?></td>
          </tr>
          <?php }
          if($count==0){ echo "<tr><td colspan='8' class='empty-state'>No camp needs posted yet.</td></tr>"; }
          ?>
        </table>
      </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>
