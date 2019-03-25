<?php
require "classes.php";
 
$h = new User( "Calvin", 15 );
echo "Hello, " . $h->getName(). "! You are ". $h->isAdult();
?>
<br/>
<?php
$h = new User( "Chris", 39 );
echo "Hello, " . $h->getName(). "! You are ". $h->isAdult();
?>