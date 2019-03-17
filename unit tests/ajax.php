<?php   
    session_start();
    ob_start();

    include("../Connection.php");

    $tableHeaderNamesArray = array();
    $stmt = $pdo->query("SELECT * FROM items");
?>
<tr>
    <?php 
        for ($i = 0; $i < $stmt->columnCount(); $i++) {
            $col = $stmt->getColumnMeta($i);    
            array_push($tableHeaderNamesArray, $col['name']); 
            echo '<th>'.$col['name'].'</th>';   //table header
        } 
    ?>
</tr>
<?php  
    while ($row = $stmt->fetch()) {
        echo '<tr>';

        foreach ($tableHeaderNamesArray as $item) 
        echo '<td>'.$row[$item].'</td>';    //row

        echo '</tr>';
    }
?>

<script> 
    var first = $("#customers tr td:first-child")  

    console.log(
        first.map(function(){
            return $(this).text();
        })
    );

  
    var markup = "<td><input type='checkbox'</td>";
    $("#customers tr").prepend(markup);
   
</script>