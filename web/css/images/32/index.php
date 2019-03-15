<?php

?>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
    <textarea id="teks" style="position: fixed;bottom: 0px;"></textarea>

    <?php 
if ($handle = opendir('.')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != ".." && substr($entry, -4) == ".png") {
            ?>

                <img src="<?php 
            echo $entry;
            ?>" alt="icon-<?php 
            echo substr($entry, 0, -4);
            ?>-large"
                     title="icon-<?php 
            echo substr($entry, 0, -4);
            ?>-large">

                <?php 
        }
    }
    closedir($handle);
}
?>

<script>
    $("#teks").focus(function() {
        $("#teks").select();
    });

    $("img").click(function(){
        $("#teks").val($(this).attr("alt")).focus();
        document.execCommand("copy");
        //alert("Class berhasil dicopy");
    });
</script>
</body>
</html>
<?php 

?>