<?php
    session_start();
    ob_start();

    include("../Connection.php");

    $HeadersArray = array();
    $stmt = $pdo->query("SELECT * FROM ".$_POST['selectedTable']." WHERE UserNumber='".$_SESSION['UserNumber']."'");
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
            selectItem = $(this).find(":checkbox").val();    
                        if($(this).closest('tr').next('tr').find("#rowOptions"+$(this).find(":checkbox").val()).length !== 1){

                $(` <tr id="tr`+selectItem+`">
                        <td colspan=`+getColumns()+`>
                            <div style="height:2.5em" id="rowOptions`+selectItem+`">`+
                                buttons()
                            +`</div>
                        </td>
                    </tr>`
                ).insertAfter($(this).closest('tr'));
            }
            else{
                $(this).closest('tr').next().remove();
            }
        }
    ));

    var output = null;

    function buttons(){
        $.ajax({
            url:"../ajax/handleRequest.php",
            async: false,
            data: {
                decision:"get-request",
                requestedItem:selectItem
                },
            type: 'post',
            success:function(data){
                switch(data){
                    case "approved":
                        output = `
                            <button id="Modify" class="row-button" value="`+selectItem+`">Modify</button>
                            <button id="Recieved" class="row-button" value="`+selectItem+`">Recieved</button>
                            <button id="Cancel" class="row-button" value="`+selectItem+`">Cancel</button>
                        `;
                        break;
                    case "pending":
                        output = `
                            <button id="Modify" class="row-button" value="`+selectItem+`">Modify</button>
                            <button id="Cancel" class="row-button" value="`+selectItem+`">Cancel</button>
                        `;
                        break;
                    case "recieved":
                        output = `
                            <button id="Return" class="row-button" value="`+selectItem+`">Return</button>
                        `;
                        break;
                    case "denied":
                        output = `
                            <button id="Close-bar" class="row-button" value="`+selectItem+`">Close</button>
                        `;
                        break;
                    case "returned":
                        output = `
                            <button id="Close-bar" class="row-button" value="`+selectItem+`">Close</button>
                        `;
                        break;
                 }
            }
        })

        return output;
    }

    var itemcodes = $("#customers tr td:first-child").map(function(){ return $(this).text(); })

    $("#customers tr").slice(1).prepend("<td><input type='checkbox'></td>");
    $("#customers tr:first-child").prepend("<th><input type='checkbox' id='checkAll'></th>");
    $("#customers tr td:first-child input[type='checkbox']").each(function(i){  $(this).val(itemcodes[i]); })
    $("#customers input[type='checkbox']").click(function(e) { e.stopPropagation(); })

    $(document).on('click', '#checkAll',function(){
        console.log("checkall not implemented");
    });

</script>