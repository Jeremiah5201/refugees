<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Add Donor</h1>
      <div class="form-section">
        <?php
        if(isset($_POST['submit'])){
          $d_name=mysqli_real_escape_string($conn,$_POST['d_name']);
          $d_contact=mysqli_real_escape_string($conn,$_POST['d_contact']);
          $d_email=mysqli_real_escape_string($conn,$_POST['d_email']);
          $nationality=(int)$_POST['nationality'];
          $password=md5($_POST['password']);

          $select=mysqli_query($conn,"select * from donnor where d_email='".$d_email."'");
          if($row=mysqli_fetch_array($select)){
            echo "<div class='alert alert-error'>Email already exists.</div>";
          }else{
            $insert=mysqli_query($conn,"insert into donnor(d_id,d_name,d_contact,d_email,n_id,password)
            values(null,'".$d_name."','".$d_contact."','".$d_email."','".$nationality."','".$password."')");
            if($insert){
              echo "<div class='alert alert-success'>Donor created successfully.</div>";
            }else{
              echo "<div class='alert alert-error'>Failed to create donor: ".mysqli_error($conn)."</div>";
            }
          }
        }
        ?>
        <form method="post">
            <input type="text" name="d_name" placeholder="Enter Donor Name" required>
            <input type="text" name="d_contact" placeholder="070000000" required>
            <input type="email" name="d_email" placeholder="example@gmail.com" required>
            <select name="nationality" required>
                <option value="">Select Nationality</option>
                <?php
                $select=mysqli_query($conn,"select * from nationality order by nationality");
                while($row=mysqli_fetch_assoc($select)){
                ?>
                <option value="<?php echo $row['n_id']; ?>"><?php echo htmlspecialchars($row['nationality']); ?></option>
                <?php } ?>
            </select>
            <input type="password" name="password" value="don@pass" required readonly>
            <input type="submit" name="submit" value="Add Donor" class="btn">
        </form>
      </div>

      <div class="table-section" id="list">
   <table>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Contact</th>
          <th>Email</th>
          <th>Nationality</th>
          <th>Action</th>
        </tr>
        <?php
        $select=mysqli_query($conn,"select donnor.*, nationality.nationality
        from donnor
        left join nationality on donnor.n_id=nationality.n_id
        order by donnor.d_id desc");
        $count=0;
        while($row=mysqli_fetch_array($select)){
          $count++;
          ?>
<tr>
          <td><?php echo $count; ?></td>
          <td><?php echo htmlspecialchars($row['d_name']); ?></td>
          <td><?php echo htmlspecialchars($row['d_contact']); ?></td>
          <td><?php echo htmlspecialchars($row['d_email']); ?></td>
          <td><?php echo htmlspecialchars($row['nationality']); ?></td>
          <td><div class="actions">
           <a href="update-donor.php?d=<?php echo $row['d_id']; ?>"><div class="edit">Update</div></a>
           <a href="delete-donor.php?d=<?php echo $row['d_id']; ?>" onclick="return confirm('Are you sure you want to delete');"><div class="delete">Delete</div></a>
          </div></td>
        </tr>
          <?php
        }
        if($count==0){
          echo "<tr><td colspan='6' class='empty-state'>No donors found.</td></tr>";
        }
        ?>
      </table>
</div>
    </div>
</div>
<?php include "includes/footer.php"; ?>
