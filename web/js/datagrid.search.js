function addSearchToolbar(selector) {
    var input = $("<input>").attr("id", selector + "_query").css({
        border: "1px solid #ccc",
        lineHeight: "20px",
        padding: "3px 10px",
        marginRight: "6px"
    }).keyup(function(e){
        if(e.keyCode == 13){
            var val = $(this).val();
            $('#'+selector).datagrid('load',{
                query: val
            });
            return false;
        }
    });
    var button = $("<a>").attr("href", "#").html("Search").addClass("easyui-linkbutton").click(function () {
        $('#'+selector).datagrid('load',{
            query: input.val()
        });
        return false;
    });
    var div = $("<div>").attr("id", selector + "_search").css({
        padding: "3px",
        textAlign: "right"
    });
    div.append(input);
    div.append(button);
    div.insertAfter($("#" + selector));

    return "#" + selector + "_search";
}