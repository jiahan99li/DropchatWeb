$(function(){
    $(document).on('submit','#chatForm', function(){
        var text = $.trim($("#text").val());
        var sender = $("#sending").val();
        var receiver = $("#receiving").val();
        var time = $("#time").val();
        var read = $("#read").val();
        
        if(text != "" && sender != "" && receiver != "" && time != "" && read != ""){
            $.post('../includes/sendMsg.inc.php',{text: text, sending: sender, receiving: receiver, time: time, read: read}, function(data){
            $(".chatContentMid").append(data);
            document.getElementById('text').value="";
        });
        } else {
            
        }
    });
    
    function getMessages(){
        $.get('../includes/getMsg.inc.php', function(data){
            $(".chatContentMid").html(data);
        });
    }
            setInterval(function(){
            getMessages();
        },500);
});