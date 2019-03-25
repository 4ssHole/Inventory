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
    var rowOptionsNumber = 0;
    var itemcodes = $("#customers tr td:first-child").map(function(){
        return $(this).text();
    })
  
    $("#customers tr").slice(1).prepend("<td><input type='checkbox'></td>");
    $("#customers tr:first-child").prepend("<th><input type='checkbox'></th>");
    
    $("#customers tr td:first-child input[type='checkbox']").each(function(i){  
        $(this).val(itemcodes[i]);
    })

    $("#customers tr td:first-child input[type='checkbox']").click(function(e) { e.stopPropagation(); });
      
    $("#customers tr").click(function(){
        $(this).unbind("click");

        rowOptionsNumber++;
        $('<tr><td colspan = '+6+'><div id="rowOptions'+rowOptionsNumber+'"></div></td></tr>').insertAfter($(this).closest('tr'));
        
        console.log("test : "+$(this).find(":checkbox").val());
        loadOptions();        

        // $( "#foo" ).bind( "click", function() {
        //   alert( "The quick brown fox jumps over the lazy dog." );
        // });
    })

    function makeOptions(data,target) {
        $(target).append('<input class="editTest" id="'+data+'" name="'+data+'" placeholder="'+data+'" type="text">');
    }

    function loadOptions() {
        for(var i = 0; i < ColumnNames.length; i++) makeOptions(ColumnNames[i],'#rowOptions'+rowOptionsNumber);     
    }
</script>