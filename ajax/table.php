<?php
    session_start();
    ob_start();

    include("../Connection.php");

    $HeadersArray = array();
    $stmt = null;

    if(isset($_POST['query'])){
        $stmt = $pdo->query("SELECT * FROM ".$_POST['selectedTable']." WHERE ".$_POST['selectedColumn']." LIKE '".$_POST['query']."'");
    }
    else{
        $stmt = $pdo->query("SELECT * FROM ".$_POST['selectedTable']);
    }?>
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
            if($(this).closest('tr').next('tr').find("#rowOptions"+$(this).find(":checkbox").val()).length !== 1){
                selectItem = $(this).find(":checkbox").val();
                var insert;
   
                if(selectedTable=="borrowed"){
                    insert = ` <tr id="Generated">
                        <td colspan=`+getColumns()+`>
                            <div class="rowOptions" id="rowOptions`+selectItem+`">
                                <label>Remarks : </label>
                                <div contenteditable="true" id="remarks`+selectItem+`" class="inputinbar" style="display:inline-block; min-width:5em;"></div>
                                <button id="Approve" class="row-button" value="`+selectItem+`">Approve</button>
                                <button id="Deny" class="row-button" value="`+selectItem+`">Deny</button>
                                <button id="Remove" class="row-button" value="`+selectItem+`">Remove</button>
                            </div>
                        </td>
                    </tr>`;
                }
                else if(selectedTable=="items"){
                    $(` <tr id="Generated">
                            <td colspan=`+getColumns()+`>
                                <div style="height:2.5em" id="rowOptions`+selectItem+`">
                                    <button id="Update" class="row-button value="`+selectItem+`"">Update</button>
                                    <button id="singleDelete" class="row-button" value="`+selectItem+`">Delete</button>
                                </div>
                            </td>
                        </tr>`).insertAfter($(this).closest('tr'));

                    for(var i = ColumnNames.length-1; i >= 0; i--) {
                        $('#rowOptions'+selectItem).prepend('<input class="editBar" id="'+ColumnNames[i]+'" placeholder="'+ColumnNames[i]+'" type="text">'); 
                    }
                }

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

    var tables = document.getElementsByTagName('table');
    for (var i=0; i<tables.length;i++){
        resizableGrid(tables[i]);
    }

    function resizableGrid(table) {
        var row = table.getElementsByTagName('tr')[0],
        cols = row ? row.children : undefined;
        if (!cols) return;
        
        table.style.overflow = 'hidden';
        
        var tableHeight = table.offsetHeight;
        
        for (var i=0;i<cols.length;i++){
            var div = createDiv(tableHeight);
            cols[i].appendChild(div);
            cols[i].style.position = 'relative';
            setListeners(div);
        }

        function setListeners(div){
            var pageX,curCol,nxtCol,curColWidth,nxtColWidth;

            div.addEventListener('mousedown', function (e) {
                curCol = e.target.parentElement;
                nxtCol = curCol.nextElementSibling;
                pageX = e.pageX; 
                
                var padding = paddingDiff(curCol);
                
                curColWidth = curCol.offsetWidth - padding;
                if (nxtCol)
                    nxtColWidth = nxtCol.offsetWidth - padding;
            });

            div.addEventListener('mouseover', function (e) {
                e.target.style.borderRight = '2px solid #0000ff';
            })

            div.addEventListener('mouseout', function (e) {
                e.target.style.borderRight = '';
            })

            document.addEventListener('mousemove', function (e) {
                if (curCol) {
                    var diffX = e.pageX - pageX;
                
                    if (nxtCol)
                    nxtCol.style.width = (nxtColWidth - (diffX))+'px';

                    curCol.style.width = (curColWidth + diffX)+'px';
                }
            });

            document.addEventListener('mouseup', function (e) { 
                curCol = undefined;
                nxtCol = undefined;
                pageX = undefined;
                nxtColWidth = undefined;
                curColWidth = undefined
            });
        }
        
        function createDiv(height){
            var div = document.createElement('div');
            div.style.top = 0;
            div.style.right = 0;
            div.style.width = '5px';
            div.style.position = 'absolute';
            div.style.cursor = 'col-resize';
            div.style.userSelect = 'none';
            div.style.height = height + 'px';
            return div;
        }
        
        function paddingDiff(col){
            if (getStyleVal(col,'box-sizing') == 'border-box'){
            return 0;
            }
            
            var padLeft = getStyleVal(col,'padding-left');
            var padRight = getStyleVal(col,'padding-right');
            return (parseInt(padLeft) + parseInt(padRight));
        }

        function getStyleVal(elm,css){
            return (window.getComputedStyle(elm, null).getPropertyValue(css))
        }
    };

</script>