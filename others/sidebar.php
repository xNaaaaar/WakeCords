<ul class="sidebar " data-sidebar>
  <li class="sidebar-list">
    <a class="sidebar-link <?php echo ($this_page == 'profile')?'active':''; ?>" href="profile.php" title="Profile">
      <i class="fa-solid fa-user"></i>
      <div>Profile</div>
    </a>
  </li>
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
      <a class="sidebar-link <?php echo ($this_page == 'services')?'active':''; ?>" href="get_started.php" title="Services">
        <i class="fa-solid fa-clipboard-check"></i>
        <div>Services</div>
      </a>
    <?php
      } else {
    ?>
      <a class="sidebar-link <?php echo ($this_page == 'services')?'active':''; ?>" href="get_started.php" title="Services">
        <i class="fa-solid fa-clipboard-check"></i>
        <div>Users</div>
      </a>
    <?php
      }
    ?>
  </li>
  <li class="sidebar-list">
    <a class="sidebar-link <?php echo ($this_page == 'feedback')?'active':''; ?>" href="feedback.php" title="Feedback">
      <i class="fas fa-box"></i>
      <div>Feedback</div>
    </a>
  </li>
  <li class="sidebar-list">
    <a class="sidebar-link <?php echo ($this_page == 'transact')?'active':''; ?>" href="cart.php" title="Transactions">
      <i class="fas fa-hands-helping"></i>
      <div>Transactions</div>
    </a>
  </li>
  <li class="sidebar-list">
    <?php
      if(user_type() != "admin"){
    ?>
      <a class="sidebar-link <?php echo ($this_page == 'contact')?'active':''; ?>" href="contact.php" title="Contact Us">
        <i class="fas fa-phone-square"></i>
        <div>Contact Us</div>
      </a>
    <?php
      }
    ?>
  </li>
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
