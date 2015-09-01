
$(".Vakje").on('click',function(){
     $.get("server.php", function(data, status){
        console.log("Data: " + data + "\nStatus: " + status);
     });
     
});

//var id=$(this).attr('id').val();
