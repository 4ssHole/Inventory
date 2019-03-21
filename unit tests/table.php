<?php
    session_start();
    ob_start();

    include("../Connection.php");

    $HeadersArray = array();
    $stmt = $pdo->query("SELECT * FROM items");
?>
<tr>
    <?php 
        for ($i = 0; $i < $stmt->columnCount(); $i++) {
            $col = $stmt->getColumnMeta($i);    
            array_push($HeadersArray, $col['name']); 
            echo '<th>'.$col['name'].'</th>';   //table header
        } 
    ?>
</tr>
<?php  
    while ($row = $stmt->fetch()) {
        echo '<tr>';

        foreach ($HeadersArray as $item) 
        echo '<td>'.$row[$item].'</td>';    //row

        echo '</tr>';
    }
?>

<script> 

    var itemcodes = $("#customers tr td:first-child").map(function(){
        return $(this).text();
    })
  
    $("#customers tr").slice(1).prepend("<td><input type='checkbox'></td>");
    $("#customers tr:first-child").prepend("<th><input type='checkbox'></th>");
    
    $("#customers tr td:first-child input[type='checkbox']").each(function(i){  
        $(this).val(itemcodes[i]);
    })


</script>