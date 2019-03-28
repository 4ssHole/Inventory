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

    function getColumns(){
        var tableColumns = 0;
        $('#customers tr:nth-child(1) th').each(function () {
            tableColumns++;
        });
        return tableColumns
    }
    
    $("#customers tr").slice(1).on("click",(
        function(){  

            if($(this).closest('tr').find("#rowOptions"+$(this).find(":checkbox").val()).length !== 1){
            
            }
            if($(this).closest('tr').next('tr').find("#rowOptions"+$(this).find(":checkbox").val()).length !== 1){
                selectItem = $(this).find(":checkbox").val();
                var  insert = 
                `<tr id="tr`+selectItem+`">
                    <td colspan=`+getColumns()+`>
                        <div style="height:2.5em" id="rowOptions`+selectItem+`">
                            <label>Date From : </label>
                            <input id="date-from`+selectItem+`" class="inputinbar" type="datetime-local"/>`+`
                            <label> Till : </label>
                            <input id="date-till`+selectItem+`" class="inputinbar" type="datetime-local"/>`+`
                            <label>Quantity : </label>
                            <input id="Quantity-request`+selectItem+`" class="inputinbar" type="number"/>`+`
                            <button id="RequestItem" class="row-button" value="`+selectItem+`">Request Item</button>`+`
                        </div>
                    </td>
                </tr>`;
                
                $(insert).insertAfter($(this).closest('tr'));
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