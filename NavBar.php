<?php
function DisplayNavBar() {
?>

  <nav>
    <div class="button-container">
      <a href="Settings.php">
        <div class="container-item user-button">
            <div class="button-icon-container">
                <img src="../img\inventory-icon-test.png" class="navicons">
            </div>
            <p><?php echo $_SESSION["FirstName"]; ?></p>
        </div>
      </a>
      <?php 

        if($_SESSION['Privilege'] == "admin"){
          echo '
            <a href="InventoryAdministrator.php">
              <div class="container-item">
                  <div class="button-icon-container">
                      <img src="../img\inventory-icon-test.png" class="navicons">
                  </div>
                  <p>inventory</p>
              </div>
            </a>

            <a href="UserAccessControl.php">
              <div class="container-item">
                <div class="button-icon-container">
                    <img src="../img\inventory-icon-test.png" class="navicons">
                </div>
                <p>manage users</p>
              </div>
            </a>

            <a href="RequestedItems.php">
              <div class="container-item">
                <div class="button-icon-container">
                    <img src="../img\inventory-icon-test.png" class="navicons">
                </div>
                <p>requested items</p>
              </div>
            </a>';
        }
        else{
          echo '
              <a href="NonAdministrator.php">
                <div class="container-item">
                  <div class="button-icon-container">
                      <img src="../img\inventory-icon-test.png" class="navicons">
                  </div>
                  <p>items</p>
                </div>
              </a>

              <a href="requests.php">
                <div class="container-item">
                  <div class="button-icon-container">
                      <img src="../img\inventory-icon-test.png" class="navicons">
                  </div>
                  <p>pending approval</p>
                </div>
              </a>';
        }
      ?>
      <a href="index.php">
          <div class="logout-button">
              <div class="button-icon-container" style="background: #c80000">
                  <img src="../img\logout.svg" class="navicons">
              </div>
              <p>log out</p>
          </div>
      </a>
    </div>
  </nav>
<?php
}
?>
