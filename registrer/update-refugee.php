<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Update Refugee</h1>
      <div class="form-section">
        <?php
        if(!isset($_GET['ref'])){ header('location:refugee.php'); exit; }
        $ref_id=(int)$_GET['ref'];
        $c_id=(int)$_SESSION['camp'];
        $registror=(int)$_SESSION['registrar'];
        $location=(int)$_SESSION['location'];

        $row=mysqli_fetch_array(mysqli_query($conn,"select * from refugee where ref_id='".$ref_id."' and c_id='".$c_id."'"));
        if(!$row){ header('location:refugee.php'); exit; }

        if(isset($_POST['submit'])){
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
          if($location < 1){ $location=(int)$row['l_id']; }

          $update=mysqli_query($conn,"update refugee set name='".$ref_name."', ref_number='".$ref_number."', n_id='".$nationality."', c_id='".$c_id."', l_id='".$location."', address='".$ref_adres."', reason='".$reason."', DOB='".$ref_DOB."', m_id='".$marital_status."', age_id='".$age_range."', t_id='".$refugee_type."', g_id='".$refugee_group."', r_id='".$registror."' where ref_id='".$ref_id."' and c_id='".$c_id."'");
          if($update){ echo "<div class='alert alert-success'>Refugee updated successfully.</div>"; }
          else{ echo "<div class='alert alert-error'>Failed to update refugee.</div>"; }
          $row=mysqli_fetch_array(mysqli_query($conn,"select * from refugee where ref_id='".$ref_id."'"));
        }
        ?>
        <form method="post">
            <input type="text" name="ref_name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
            <input type="text" name="ref_contact" value="<?php echo htmlspecialchars($row['ref_number']); ?>" required>
            <input type="text" name="ref_adres" value="<?php echo htmlspecialchars($row['address']); ?>" required>
            <textarea name="reason" required><?php echo htmlspecialchars($row['reason']); ?></textarea>
            <label>Date of Birth</label>
            <input type="date" name="ref_DOB" value="<?php echo htmlspecialchars($row['DOB']); ?>" required>
            <select name="nationality" required>
                <?php $select=mysqli_query($conn,"select * from nationality");
                while($opt=mysqli_fetch_assoc($select)){ $sel=$opt['n_id']==$row['n_id']?'selected':''; ?>
                <option value="<?php echo $opt['n_id']; ?>" <?php echo $sel; ?>><?php echo htmlspecialchars($opt['nationality']); ?></option>
                <?php } ?>
            </select>
            <select name="malital_status" required>
                <?php $select=mysqli_query($conn,"select * from marital_status");
                while($opt=mysqli_fetch_assoc($select)){ $sel=$opt['m_id']==$row['m_id']?'selected':''; ?>
                <option value="<?php echo $opt['m_id']; ?>" <?php echo $sel; ?>><?php echo htmlspecialchars($opt['status']); ?></option>
                <?php } ?>
            </select>
            <select name="age_range" required>
                <?php $select=mysqli_query($conn,"select * from age_range");
                while($opt=mysqli_fetch_assoc($select)){ $sel=$opt['age_id']==$row['age_id']?'selected':''; ?>
                <option value="<?php echo $opt['age_id']; ?>" <?php echo $sel; ?>><?php echo htmlspecialchars($opt['a_range']); ?></option>
                <?php } ?>
            </select>
            <select name="refugee_type" required>
                <?php $select=mysqli_query($conn,"select * from refugee_type");
                while($opt=mysqli_fetch_assoc($select)){ $sel=$opt['t_id']==$row['t_id']?'selected':''; ?>
                <option value="<?php echo $opt['t_id']; ?>" <?php echo $sel; ?>><?php echo htmlspecialchars($opt['type']); ?></option>
                <?php } ?>
            </select>
            <select name="refugee_group" required>
                <?php $select=mysqli_query($conn,"select * from refugee_group");
                while($opt=mysqli_fetch_assoc($select)){ $sel=$opt['g_id']==$row['g_id']?'selected':''; ?>
                <option value="<?php echo $opt['g_id']; ?>" <?php echo $sel; ?>><?php echo htmlspecialchars($opt['group_type']); ?></option>
                <?php } ?>
            </select>
            <input type="submit" name="submit" value="Update Refugee" class="btn">
        </form>
      </div>
      <p><a class="btn-link" href="refugee.php">Back</a></p>
    </div>
</div>
<?php include "includes/footer.php"; ?>
