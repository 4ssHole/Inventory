//#0

echo '<td>
        <label class="button">'.$row[$item].'</label>';
    <div id="popup1" class="overlay"><div class="popup"><br><a class="close" href="">&times;</a>';
        
    $selectedItemData = mysqli_query($connection, 
    "SELECT * FROM `! list of all items` WHERE `Item Number` = \"".$_GET['id1']."\"");

    $int = 0;
    while ($row23 = mysqli_fetch_array($selectedItemData)){
echo '<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'>';
    foreach ($tableHeaderNamesArray as $item23){
        if($tableHeaderNamesArray[$int]=="Date Updated"||$tableHeaderNamesArray[$int]=="Date Added"){}
        else if($tableHeaderNamesArray[$int]=="Category"){
        echo 'Category <select class="inputbox" name="ModifyAttribute'.$int.'">';

        foreach($categoryNameArray as $s){
            if($s==$_SESSION["FilterValue"]) echo '<option value="'.$s.'" selected>' .$s. '</option>';
            else echo '<option value="'.$s.'">' .$s. '</option>';
        }
        echo '</select><br>';
        }
        else echo $tableHeaderNamesArray[$int].' <input class="inputbox" type="text" name="ModifyAttribute'.$int.'" placeholder="'.$row23[$item23].'"><br>'; 
        $int++;
    }
    echo '<br>type, in the fields that need to be modified
    <input type="submit" name="ChangeRow" class="LargeSubmitButton" value="Confirm"></div></form>';
    }
    echo '</div>';