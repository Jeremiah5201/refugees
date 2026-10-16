<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Add Registror</h1>
      <div class="form-section">
        <?php
        if(isset($_POST['submit'])){
          $r_name=mysqli_real_escape_string($conn,$_POST['r_name']);
          $r_contact=mysqli_real_escape_string($conn,$_POST['r_contact']);
          $r_email=mysqli_real_escape_string($conn,$_POST['r_email']);
          $nationality=(int)$_POST['nationality'];
          $location=(int)$_POST['location'];
          $camp=(int)$_POST['camp'];
          $password=md5($_POST['password']);

          $select=mysqli_query($conn,"select * from registrar where r_email='".$r_email."'");
          if($row=mysqli_fetch_array($select)){
            echo "<div class='alert alert-error'>Email already exists.</div>";
          }else{
            $insert=mysqli_query($conn,"insert into registrar(r_id,r_name,r_contact,r_email,n_id,l_id,c_id,password)
            values(null,'".$r_name."','".$r_contact."','".$r_email."','".$nationality."','".$location."','".$camp."','".$password."')");
            if($insert){
              $newId=mysqli_insert_id($conn);
              mysqli_query($conn,"update camp set r_id='".$newId."' where c_id='".$camp."'");
              echo "<div class='alert alert-success'>Registror created successfully.</div>";
            }else{
              echo "<div class='alert alert-error'>Failed to create registror: ".mysqli_error($conn)."</div>";
            }
          }
        }
        ?>
        <form action="" method="post">
            <input type="text" name="r_name" placeholder="Enter Registror Name" required>
            <input type="text" name="r_contact" placeholder="070000000" required>
            <input type="email" name="r_email" placeholder="example@gmail.com" required>
            <select name="nationality" required>
                <option value="">Select Nationality</option>
                <?php
                $select=mysqli_query($conn,"select * from nationality order by nationality");
                while($row=mysqli_fetch_assoc($select)){
                ?>
                <option value="<?php echo $row['n_id']; ?>"><?php echo htmlspecialchars($row['nationality']); ?></option>
                <?php } ?>
            </select>
            <select name="location" required>
                <option value="">Select Location</option>
                <?php
                $select=mysqli_query($conn,"select * from location order by l_name");
                while($row=mysqli_fetch_assoc($select)){
                ?>
                <option value="<?php echo $row['l_id']; ?>"><?php echo htmlspecialchars($row['l_name']); ?></option>
                <?php } ?>
            </select>
            <select name="camp" required>
                <option value="">Select Camp</option>
                <?php
                $select=mysqli_query($conn,"select * from camp order by c_name");
                while($row=mysqli_fetch_assoc($select)){
                ?>
                <option value="<?php echo $row['c_id']; ?>"><?php echo htmlspecialchars($row['c_name']); ?></option>
                <?php } ?>
            </select>
            <input type="password" name="password" value="reg@pass" required readonly>
            <input type="submit" name="submit" value="Add Registror" class="btn">
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
          <th>Location</th>
          <th>Camp</th>
          <th>Action</th>
        </tr>
        <?php
        $select=mysqli_query($conn,"select registrar.*, nationality.nationality, location.l_name, camp.c_name
        from registrar
        left join nationality on registrar.n_id=nationality.n_id
        left join location on registrar.l_id=location.l_id
        left join camp on registrar.c_id=camp.c_id
        order by registrar.r_id desc");
        $count=0;
        while($row=mysqli_fetch_array($select)){
          $count++;
          ?>
<tr>
          <td><?php echo $count; ?></td>
          <td><?php echo htmlspecialchars($row['r_name']); ?></td>
          <td><?php echo htmlspecialchars($row['r_contact']); ?></td>
          <td><?php echo htmlspecialchars($row['r_email']); ?></td>
          <td><?php echo htmlspecialchars($row['nationality']); ?></td>
          <td><?php echo htmlspecialchars($row['l_name']); ?></td>
          <td><?php echo htmlspecialchars($row['c_name']); ?></td>
          <td><div class="actions">
           <a href="update-registror.php?r=<?php echo $row['r_id']; ?>"><div class="edit">Update</div></a>
           <a href="delete-registror.php?r=<?php echo $row['r_id']; ?>" onclick="return confirm('Are you sure you want to delete');"><div class="delete">Delete</div></a>
          </div></td>
        </tr>
          <?php
        }
        if($count==0){
          echo "<tr><td colspan='8' class='empty-state'>No registrors found.</td></tr>";
        }
        ?>
      </table>
</div>
    </div>
</div>
<?php include "includes/footer.php"; ?>
