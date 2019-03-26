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

    var selectItem = '';
    var itemcodes = $("#customers tr td:first-child").map(function(){
        return $(this).text();
    })
  
    $("#customers tr").slice(1).prepend("<td><input type='checkbox'></td>");
    $("#customers tr:first-child").prepend("<th><input type='checkbox'></th>");
    
    $("#customers tr td:first-child input[type='checkbox']").each(function(i){  
        $(this).val(itemcodes[i]);
    })

    $("#customers tr td:first-child input[type='checkbox']").click(function(e) { e.stopPropagation(); });
      
    $("#customers tr").on("click",(function(){        
        if($(this).closest('tr').next('tr').find("#rowOptions").length !== 1){
            selectItem = $(this).find(":checkbox").val();
            
            console.log('#rowOptions'+' [value="'+selectItem+'"]');


            html = $('<tr id="Generated"><td colspan=6><div id="rowOptions'+selectItem+'"></div></td></tr>')
            html.insertAfter($(this).closest('tr'));

            for(var i = 0; i < ColumnNames.length; i++) {
                $('#rowOptions'+selectItem).append('<input class="editTest" id="'+ColumnNames[i]+'" name="'+ColumnNames[i]+'" placeholder="'+ColumnNames[i]+'" type="text">'); 
            }
            
            $('#rowOptions'+selectItem).append('<button id="Update" class="NewButton">Update</button><button id="Close" class="NewButton">Close</button>');  
        }   
    }));
    

    $(document).on('click', '#Close',function(){
        $(this).parent().parent().parent().remove();   
    });

    $(document).on('click', '#Update',function(){
        var updateArray = [];

        for(var i = 0;i<ColumnNames.length;i++) {
            if($("#"+ColumnNames[i]+".editTest").val() != ''){
                updateArray.push(ColumnNames[i]+"= '"+$("#"+ColumnNames[i]+".editTest").val()+"' ");
            }
        }

        $.ajax({
            url:'updateItem.php',
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

</script>

/*
    todo adding edit options and binding them to one row
    maybe use item code to identify belonging row
*/