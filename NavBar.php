<?php
function DisplayNavBar() {
  $UserName = $_SESSION["FirstName"];
?>

  <nav id="myHeader">
    <ul>
      <li>
        <a href="settings.php">
          <img src="../img\user-icon.png"style="margin-left:0;padding-left:.35em;" class="navicons"><?php echo $UserName; ?></a>
      </li>
      
      <?php 
        if($_SESSION['Privilege'] == "admin"){
          echo '
          <li>
            <a href="InventoryAdministrator.php">
              <img src="../img\inventory-icon.png" class="navicons">inventory</a>
          </li>
          <li>
            <a href="UserAccessControl.php">
              <img src="../img\inventory-icon.png" class="navicons">registered users</a>
          </li>
          <li>
          <a href="RequestedItems.php">
            <img src="../img\inventory-icon.png" class="navicons">requested items</a>
          </li>';
        }
        else{
          echo '
            <li>
              <a href="NonAdministrator.php">
                <img src="img\inventory-icon.png" class="navicons">items</a>
            </li>
            <li>
              <a href="requests.php">
                <img src="img\inventory-icon.png" class="navicons">pending approval</a>
            </li>
            <li>
            <a href="returnItem.php">
              <img src="img\inventory-icon.png" class="navicons">return item</a>
            </li>';
        }
      ?>
      <li style="float: right;">
        <a href="index.php">
          log out<img src="../img\signout-icon.png" style="margin-left:.5em;" class="navicons"></a>
      </li>
    </ul>
</nav>
<?php
}
?>