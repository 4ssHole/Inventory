<?php
    session_start();
    ob_start();

    include("../Connection.php");

    $HeadersArray = array();   
    $stmt = $pdo->query("SELECT * FROM ".$_POST['selectedTable']);
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
    var selectItem = '';

    var accessLevel = <?php echo "'".$_SESSION['Privilege']."';";?>
    var selectedTable = <?php echo "'".$_POST['selectedTable']."';";?>

    $("#customers tr").slice(1).on("click",(
        function(){  
            if($(this).closest('tr').next('tr').find("#rowOptions"+$(this).find(":checkbox").val()).length !== 1){
                selectItem = $(this).find(":checkbox").val();

                $(` <tr id="tr`+selectItem+`">
                        <td colspan=9>
                            <div style="height:2.5em" id="rowOptions`+selectItem+`">
                                <button id="Return" value="`+selectItem+`">Return</button>
                            </div>
                        </td>
                    </tr>`
                ).insertAfter($(this).closest('tr'));
                
            }   
            else{
                $(this).closest('tr').next().remove();
            }
        }
    ));

    var itemcodes = $("#customers tr td:first-child").map(function(){ return $(this).text(); })
  
    $("#customers tr").slice(1).prepend("<td><input type='checkbox'></td>");
    $("#customers tr:first-child").prepend("<th><input type='checkbox' id='checkAll'></th>");
    $("#customers tr td:first-child input[type='checkbox']").each(function(i){  $(this).val(itemcodes[i]); })
    $("#customers input[type='checkbox']").click(function(e) { e.stopPropagation(); })

    $(document).on('click', '#checkAll',function(){
        console.log("checkall not implemented");
    });

</script>