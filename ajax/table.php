<?php
    session_start();
    ob_start();

    include("../Connection.php");

    $HeadersArray = array();

    
    if($_POST['selectedTable'] == "return"){
        $stmt = $pdo->query("SELECT * FROM borrowed WHERE UserNumber = ".$_SESSION['UserNumber']." AND request = 'approved'");
    }
    else{    
        $stmt = $pdo->query("SELECT * FROM ".$_POST['selectedTable']);
    }
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
    var accessLevel = <?php echo "'".$_SESSION['Privilege']."';";?>
    var selectedTable = <?php echo "'".$_POST['selectedTable']."';";?>
    var page = <?php echo "'".$_POST['page']."';";?>
    
    var selectItem = '';
    
    $("#customers tr").slice(1).on("click",(
        function(){  
            if($(this).closest('tr').next('tr').find("#rowOptions"+$(this).find(":checkbox").val()).length !== 1){
                selectItem = $(this).find(":checkbox").val();

                if(accessLevel=="admin"){
                    if(selectedTable=="borrowed"){
                        $(` <tr id="Generated">
                            <td colspan=9>
                                <div id="rowOptions`+selectItem+`">
                                    <button id="Approve" class="NewButton" value="`+selectItem+`">Approve</button>
                                    <button id="Deny" class="NewButton" value="`+selectItem+`">Deny</button>
                                    <button id="Remove" class="NewButton" value="`+selectItem+`">Remove</button>
                                </div>
                            </td>
                        </tr>`).insertAfter($(this).closest('tr'));
                    }
                    else if(selectedTable=="items"){
                        $(` <tr id="Generated">
                            <td colspan=7>
                                <div id="rowOptions`+selectItem+`">
                                    <button id="Update" class="NewButton">Update</button>
                                    <button id="RequestItem" class="NewButton" value="`+selectItem+`">Request Item</button>
                                    <button id="singleDelete" class="NewButton" value="`+selectItem+`">Delete</button>
                                </div>
                            </td>
                        </tr>`).insertAfter($(this).closest('tr'));

                        for(var i = ColumnNames.length-1; i >= 0; i--) {
                            $('#rowOptions'+selectItem).prepend('<input class="editBar" id="'+ColumnNames[i]+'" placeholder="'+ColumnNames[i]+'" type="text">'); 
                        }
                    }
                }
                else{
                    if(page=="requests-user"){
                        $(` <tr id="tr`+selectItem+`">
                                <td colspan=9>
                                    <div id="rowOptions`+selectItem+`">
                                        <button id="Return" value="`+selectItem+`">Return</button>
                                    </div>
                                </td>
                            </tr>`
                        ).insertAfter($(this).closest('tr'));
                    }
                    else{
                        $(` <tr id="tr`+selectItem+`">
                                <td colspan=7>
                                    <div id="rowOptions`+selectItem+`">
                                        <label for="Quantity-request">Quantity</label>
                                        <input id="Quantity-request`+selectItem+`" class="" type="number"/>`+`
                                        <button id="RequestItem" class="NewButton" value="`+selectItem+`">Request Item</button>`+`
                                    </div>
                                </td>
                            </tr>`
                        ).insertAfter($(this).closest('tr'));
                    }
                }
            }   
            else{
                $(this).closest('tr').next().remove();
            }
        }
    ));

    var itemcodes = $("#customers tr td:first-child").map(function(){
        return $(this).text();
    })
  
    $("#customers tr").slice(1).prepend("<td><input type='checkbox'></td>");
    $("#customers tr:first-child").prepend("<th><input type='checkbox' id='checkAll'></th>");
    $("#customers tr td:first-child input[type='checkbox']").each(function(i){  $(this).val(itemcodes[i]); })
    $("#customers input[type='checkbox']").click(function(e) { e.stopPropagation(); })




    $(document).on('click', '#checkAll',function(){
        console.log("checkall not implemented");
    });

</script>