<?php
include 'includes/config.php';
session_start();
$donorLogged = isset($_SESSION['donor']) && $_SESSION['donor'] != "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refugee Management System</title>
    <link rel="shortcut icon" href="images/favicone.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/home.css">
</head>
<body>
    <nav class="site-nav">
        <a class="brand" href="index.php">Refugee Management System</a>
        <button type="button" class="nav-toggle" id="navToggle" aria-label="Toggle navigation" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
        <div class="nav-links" id="navLinks">
            <a href="#needs">Camp Needs</a>
            <a href="#camps">Camps</a>
            <?php if($donorLogged){ ?>
                <a href="donor-dashboard.php">My Donations</a>
                <a class="btn-solid" href="donate.php">Donate</a>
            <?php } else { ?>
                <a href="donor-login.php">Donor Login</a>
                <a class="btn-solid" href="donor-register.php">Donor</a>
            <?php } ?>
            <a href="staff-login.php">Staff Login</a>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-content">
            <h1 class="brand-mark">Refugee Management System</h1>
            <p>Support camps directly. See what each camp needs right now, create a donor account, and send help where it matters.</p>
            <div class="cta-row">
                <a class="btn btn-primary" href="<?php echo $donorLogged ? 'donate.php' : 'donor-register.php'; ?>">Donate Now</a>
                <a class="btn btn-ghost" href="#needs">View Camp Needs</a>
            </div>
        </div>
    </header>

    <section class="section" id="needs">
        <div class="section-head">
            <h2>Open Camp Needs</h2>
            <p>Posted by camp registrors. Choose a need to donate the exact resource a camp is asking for.</p>
        </div>
        <div class="needs-grid">
            <?php
            $needs=mysqli_query($conn,"select camp_need.*, camp.c_name, camp.campIMG, location.l_name, resources.resource, registrar.r_name
            from camp_need
            left join camp on camp_need.c_id=camp.c_id
            left join location on camp.l_id=location.l_id
            left join resources on camp_need.res_id=resources.res_id
            left join registrar on camp_need.r_id=registrar.r_id
            where camp_need.status='Open'
            order by camp_need.need_id desc");
            $found=false;
            while($row=mysqli_fetch_array($needs)){
              $found=true;
              $donateLink = $donorLogged
                ? 'donate.php?need='.(int)$row['need_id']
                : 'donor-login.php?redirect=donate.php?need='.(int)$row['need_id'];
            ?>
            <article class="need-card">
                <span class="tag"><?php echo htmlspecialchars($row['resource']); ?></span>
                <h3><?php echo htmlspecialchars($row['c_name']); ?></h3>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <div class="need-meta">
                    <span><?php echo htmlspecialchars($row['quantity']); ?></span>
                    <span><?php echo htmlspecialchars($row['l_name'] ? $row['l_name'] : 'N/A'); ?></span>
                </div>
                <p>Posted by <?php echo htmlspecialchars($row['r_name']); ?> · <?php echo htmlspecialchars($row['posted_date']); ?></p>
                <a class="btn btn-primary" href="<?php echo $donateLink; ?>">Donate to this need</a>
            </article>
            <?php }
            if(!$found){
              echo "<p>No open camp needs at the moment. Check back soon.</p>";
            }
            ?>
        </div>
    </section>

    <section class="section donate-band" id="donate">
        <div class="section-head">
            <h2>Ready to help?</h2>
            <p>Create a donor account once, then support any camp and track your contributions from your dashboard.</p>
        </div>
        <div class="cta-row">
            <?php if($donorLogged){ ?>
                <a class="btn btn-primary" href="donate.php">Make a Donation</a>
                <a class="btn btn-ghost" href="donor-dashboard.php">Go to Dashboard</a>
            <?php } else { ?>
                <a class="btn btn-primary" href="donor-register.php">Create Donor Account</a>
                <a class="btn btn-ghost" href="donor-login.php">Donor Login</a>
            <?php } ?>
        </div>
    </section>

    <section class="section" id="camps">
        <div class="section-head">
            <h2>Registered Camps</h2>
            <p>Every camp is supported by a registror who updates needs and welcomes refugees.</p>
        </div>
        <div class="camps-grid">
            <?php
            $camps=mysqli_query($conn,"select camp.*, location.l_name,
            (select count(*) from refugee where refugee.c_id=camp.c_id) as total_refugees
            from camp
            left join location on camp.l_id=location.l_id
            order by camp.c_id desc");
            while($camp=mysqli_fetch_array($camps)){
            ?>
            <article class="camp-card">
                <img src="<?php echo htmlspecialchars($camp['campIMG']); ?>" alt="<?php echo htmlspecialchars($camp['c_name']); ?>">
                <div class="body">
                    <h3><?php echo htmlspecialchars($camp['c_name']); ?></h3>
                    <p><?php echo htmlspecialchars($camp['l_name'] ? $camp['l_name'] : 'N/A'); ?> · <?php echo (int)$camp['total_refugees']; ?> refugees</p>
                </div>
            </article>
            <?php } ?>
        </div>
    </section>

    <footer class="site-footer">
        <div><strong>Refugee Management System</strong><br>Connecting camps, registrors, and donors.</div>
        <div>
            <a href="staff-login.php">Admin Login</a> ·
            <a href="registrer/index.php">Registror Login</a>
        </div>
    </footer>
    <script src="assets/js/home.js"></script>
</body>
</html>
