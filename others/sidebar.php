<ul class="sidebar " data-sidebar>
  <li class="sidebar-list">
    <a class="sidebar-link <?php echo ($this_page == 'profile')?'active':''; ?>" href="profile.php" title="Profile">
      <i class="fa-solid fa-user"></i>
      <div>Profile</div>
    </a>
  </li>
  <?php
    ## FOR ADMIN
    if(user_type() == "admin"){
  ?>
  <li class="sidebar-list">
    <a class="sidebar-link <?php echo ($this_page == 'users')?'active':''; ?>" href="admin_users.php" title="Feedback">
      <i class="fa-solid fa-users"></i>
      <div>Users</div>
    </a>
  </li>
  <?php
    }
  ?>
  <li class="sidebar-list">
    <?php
      if(user_type() == "seeker"){
    ?>
      <a class="sidebar-link <?php echo ($this_page == 'services')?'active':''; ?>" href="get_started.php" title="Services">
        <i class="fa-solid fa-clipboard-check"></i>
        <div>Get Started</div>
      </a>
    <?php
      } elseif(user_type() == "provider"){
    ?>
      <a class="sidebar-link <?php echo ($this_page == 'services')?'active':''; ?>" <?php echo (is_subscribed()) ? "href='services.php'":"style='cursor:no-drop;'"; ?> title="Services">
        <i class="fa-solid fa-clipboard-check"></i>
        <div>Services</div>
      </a>
    <?php
      } elseif(user_type() == "admin") {
    ?>
      <a class="sidebar-link <?php echo ($this_page == 'services')?'active':''; ?>" href="funeral.php" title="Services">
        <i class="fa-solid fa-clipboard-check"></i>
        <div>Services</div>
      </a>
    <?php
      }
    ?>
  </li>
  <!-- <li class="sidebar-list">
    <a class="sidebar-link <?php echo ($this_page == 'feedback')?'active':''; ?>" href="feedback.php" title="Feedback">
      <i class="fas fa-box"></i>
      <div>Feedback</div>
    </a>
  </li> -->
  <li class="sidebar-list">
    <?php
    if(user_type() == 'admin'){
      $link = "<a class='sidebar-link ";
      $link .= ($this_page == 'transact')?'active':'';
      $link .= "' href='admin_transact.php' title='Transactions'>";
    } else {
      $link = "<a class='sidebar-link ";
      $link .= ($this_page == 'transact')?'active':'';
      $link .= "' href='cart.php' title='Transactions'>";
    }
    echo $link;
    ?>
      <i class="fas fa-hands-helping"></i>
      <div>Transactions</div>
    </a>
  </li>
  <?php
    ## FOR NON-ADMIN
    if(user_type() != "admin"){
  ?>
  <li class="sidebar-list">
    <a class="sidebar-link <?php echo ($this_page == 'contact')?'active':''; ?>" href="contact.php" title="Contact Us">
      <i class="fas fa-phone-square"></i>
      <div>Contact Us</div>
    </a>
  </li>
  <?php
    }
  ?>
  <li class="sidebar-list">
    <a class="sidebar-link" href="logout.php" title="Logout" onclick='return confirm("Are you sure you want to logout?");'>
      <i class="fa-solid fa-right-from-bracket"></i>
      <div>Logout</div>
    </a>
  </li>
  <li class="sidebar-list">
    <a class="sidebar-link">
      <i class="fa-solid fa-copyright"></i>
      <div>All right reserved. <span>Wakecords <?php echo date("Y"); ?></span></div>
    </a>
  </li>
</ul>
