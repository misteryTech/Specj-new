<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="index.html" class="logo d-flex align-items-center">
    <img src="assets/img/logo.png" alt="">
    <span class="d-none d-lg-block">SPECJ WEBSITE</span>
  </a>
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->



<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

    <li class="nav-item d-block d-lg-none">
      <a class="nav-link nav-icon search-bar-toggle " href="#">
        <i class="bi bi-search"></i>
      </a>
    </li><!-- End Search Icon-->



    <li class="nav-item dropdown pe-3">

    
    <?php
       // Fetch user details from the database
       $stmt = $conn->prepare("SELECT firstname, lastname, email, username, password FROM users WHERE id = ?");
       $stmt->bind_param("i", $user_id);
       $stmt->execute();
       $result_customer = $stmt->get_result();
       $customer_result = $result_customer->fetch_assoc();

       
       $customer_fullname = $customer_result['firstname']. ' ' . $customer_result['lastname'];
       $customer_username = $customer_result['username'];
      ?>


      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
      
        <span class="d-none d-md-block dropdown-toggle ps-2"><?= $customer_username; ?></span>
      </a><!-- End Profile Iamge Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

        <li class="dropdown-header">
          <h6><?= $customer_fullname; ?></h6>
          <span><?= $role;  ?> </span>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="profile.php">
            <i class="bi bi-person"></i>
            <span>My Profile</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

     
      
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="../layout/logout.php">
            <i class="bi bi-box-arrow-right"></i>
            <span>Sign Out</span>
          </a>
        </li>

      </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->

</header><!-- End Header -->