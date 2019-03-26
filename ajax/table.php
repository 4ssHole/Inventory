<?php
    session_start();
    ob_start();

    include("../Connection.php");

    $HeadersArray = array();

    echo $_POST['selectedTable'];

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
    
    $("#customers tr").slice(1).on("click",(
        function(){  
            if($(this).closest('tr').next('tr').find("#rowOptions"+$(this).find(":checkbox").val()).length !== 1){
                selectItem = $(this).find(":checkbox").val();

                $('<tr id="Generated"><td colspan=7><div id="rowOptions'+selectItem+'"></div></td></tr>').insertAfter($(this).closest('tr'));

                for(var i = 0; i < ColumnNames.length; i++) {
                    $('#rowOptions'+selectItem).append('<input class="editBar" id="'+ColumnNames[i]+'" name="'+ColumnNames[i]+'" placeholder="'+ColumnNames[i]+'" type="text">'); 
                }
                
                $('#rowOptions'+selectItem).append(
                    '<button id="Update" class="NewButton">Update</button>'+
                    '<button id="RequestItem" class="NewButton" value="'+selectItem+'">Request Item</button>'+
                    '<button id="singleDelete" class="NewButton" value="'+selectItem+'">Delete</button>'
                )
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
      

    $(document).on('click', "#singleDelete", function(){
        var deleteArray = ["'"+$(this).val()+"'"];

        $.ajax({
            url:'../ajax/removeItem.php',
            data: {deleteItems:deleteArray},
            type: 'post',
            success:function(data){
            reloadTable();
            $('#test').html(data);
            }  
        });
    });

    $(document).on('click', '#Update',function(){
        var updateArray = [];

        for(var i = 0;i<ColumnNames.length;i++) {
            if($("#"+ColumnNames[i]+".editBar").val() != ''){
                updateArray.push(ColumnNames[i]+"= '"+$("#"+ColumnNames[i]+".editBar").val()+"' ");
            }
        }

        $.ajax({
            url:'../ajax/updateItem.php',
            data: 
            {
                updateItems:updateArray,
                selectedItem:selectItem,
            },
            type: 'post',
            success:function(data){
                reloadTable();
                $('#test').html(data);
            }  
        });
    });

    $(document).on('click', '#RequestItem',function(){
        var requestedValue = $(this).val();

        $.ajax({
            url:'../ajax/requestItem.php',
            data: {requestedItem:requestedValue},
            type: 'post',
            success:function(data){
                $('#test').html(data);
            }  
        });
    });

    $(document).on('click', '#checkAll',function(){
        console.log("checkall not implemented");
    });

</script>