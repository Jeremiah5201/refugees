<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Register Refugee</h1>
      <div class="form-section">
        <?php
        // Auto-map logged-in registror and their assigned camp
        $registror=(int)$_SESSION['registrar'];
        $camp=(int)$_SESSION['camp'];
        $location=(int)$_SESSION['location'];

        $campInfo=mysqli_fetch_array(mysqli_query($conn,"select camp.c_name, location.l_name from camp left join location on camp.l_id=location.l_id where camp.c_id='".$camp."'"));
        if($campInfo){
          echo "<div class='alert alert-success'>Registering under camp <strong>".htmlspecialchars($campInfo['c_name'])."</strong> (".htmlspecialchars($campInfo['l_name'])."). Camp &amp; registror are set automatically.</div>";
        }

        if(isset($_POST['submit'])){
          if($camp < 1 || $registror < 1){
            echo "<div class='alert alert-error'>Your account has no assigned camp. Contact an admin.</div>";
          }else{
            $ref_name=mysqli_real_escape_string($conn,$_POST['ref_name']);
            $ref_number=mysqli_real_escape_string($conn,$_POST['ref_contact']);
            $ref_adres=mysqli_real_escape_string($conn,$_POST['ref_adres']);
            $reason=mysqli_real_escape_string($conn,$_POST['reason']);
            $ref_DOB=mysqli_real_escape_string($conn,$_POST['ref_DOB']);
            $nationality=(int)$_POST['nationality'];
            $marital_status=(int)$_POST['malital_status'];
            $age_range=(int)$_POST['age_range'];
            $refugee_type=(int)$_POST['refugee_type'];
            $refugee_group=(int)$_POST['refugee_group'];

            // Use camp location if registrar location is missing
            if($location < 1){
              $campRow=mysqli_fetch_array(mysqli_query($conn,"select l_id from camp where c_id='".$camp."'"));
              $location = $campRow ? (int)$campRow['l_id'] : 0;
            }

            $insert=mysqli_query($conn,"insert into refugee(ref_id,name,ref_number,n_id,c_id,l_id,address,reason,DOB,m_id,age_id,t_id,g_id,r_id)
            values(null,'".$ref_name."','".$ref_number."','".$nationality."','".$camp."','".$location."','".$ref_adres."','".$reason."','".$ref_DOB."','".$marital_status."','".$age_range."','".$refugee_type."','".$refugee_group."','".$registror."')");
            if($insert){
              echo "<div class='alert alert-success'>Refugee registered successfully.</div>";
            }else{
              echo "<div class='alert alert-error'>Failed to register refugee: ".mysqli_error($conn)."</div>";
            }
          }
        }
        ?>
        <form method="post">
            <input type="text" name="ref_name" placeholder="Enter Refugee Name" required>
            <input type="text" name="ref_contact" placeholder="Refugee Number / Contact" required>
            <input type="text" name="ref_adres" placeholder="Enter Refugee Address" required>
            <textarea name="reason" placeholder="Reason why you are a refugee..." required></textarea>
            <label>Date of Birth</label>
            <input type="date" name="ref_DOB" required>
            <select name="nationality" required>
                <option value="">Select Nationality</option>
                <?php
                $select=mysqli_query($conn,"select * from nationality order by nationality");
                while($row=mysqli_fetch_assoc($select)){
                ?>
                <option value="<?php echo $row['n_id']; ?>"><?php echo htmlspecialchars($row['nationality']); ?></option>
                <?php } ?>
            </select>
            <select name="malital_status" required>
                <option value="">Select Marital Status</option>
                <?php
                $select=mysqli_query($conn,"select * from marital_status");
                while($row=mysqli_fetch_assoc($select)){
                ?>
                <option value="<?php echo $row['m_id']; ?>"><?php echo htmlspecialchars($row['status']); ?></option>
                <?php } ?>
            </select>
            <select name="age_range" required>
                <option value="">Select Age Range</option>
                <?php
                $select=mysqli_query($conn,"select * from age_range");
                while($row=mysqli_fetch_assoc($select)){
                ?>
                <option value="<?php echo $row['age_id']; ?>"><?php echo htmlspecialchars($row['a_range'].' - '.$row['description']); ?></option>
                <?php } ?>
            </select>
            <select name="refugee_type" required>
                <option value="">Select Refugee Type</option>
                <?php
                $select=mysqli_query($conn,"select * from refugee_type");
                while($row=mysqli_fetch_assoc($select)){
                ?>
                <option value="<?php echo $row['t_id']; ?>"><?php echo htmlspecialchars($row['type']); ?></option>
                <?php } ?>
            </select>
            <select name="refugee_group" required>
                <option value="">Select Refugee Group</option>
                <?php
                $select=mysqli_query($conn,"select * from refugee_group");
                while($row=mysqli_fetch_assoc($select)){
                ?>
                <option value="<?php echo $row['g_id']; ?>"><?php echo htmlspecialchars($row['group_type']); ?></option>
                <?php } ?>
            </select>
            <input type="submit" name="submit" value="Register Refugee" class="btn">
        </form>
      </div>

      <div class="table-section" id="list">
   <table>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Number</th>
          <th>Nationality</th>
          <th>Type</th>
          <th>Action</th>
        </tr>
        <?php
        $c_id=(int)$_SESSION['camp'];
        $select=mysqli_query($conn,"select refugee.*, nationality.nationality, refugee_type.type
        from refugee
        left join nationality on refugee.n_id=nationality.n_id
        left join refugee_type on refugee.t_id=refugee_type.t_id
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
          <td><div class="actions">
           <a href="update-refugee.php?ref=<?php echo $row['ref_id']; ?>"><div class="edit">Update</div></a>
           <a href="delete-refugee.php?ref=<?php echo $row['ref_id']; ?>" onclick="return confirm('Are you sure you want to delete');"><div class="delete">Delete</div></a>
          </div></td>
        </tr>
          <?php
        }
        if($count==0){
          echo "<tr><td colspan='6' class='empty-state'>No refugees in your camp yet.</td></tr>";
        }
        ?>
      </table>
</div>
    </div>
</div>
<?php include "includes/footer.php"; ?>
