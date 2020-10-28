$(document).ready(function() {
    $('#text').keydown(function() {
        if(event.keyCode == 13) {
            $('#chatForm').submit();
        }
    });
});


$(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };
    
    var blankCont = "null";

    $('#tmpImageinput').on('change', function() {
        imagesPreview(this, 'div.postImageShow');
    });
    
    $(function(){
    $("#postImage").click(function(){
        var $fileUpload = $("#tmpImageinput");
        if (parseInt($fileUpload.get(0).files.length)<=9){
            $('#postImageForm').submit();
        } else if (parseInt($fileUpload.get(0).files.length)===0) {
            $('.postImageShow').empty();
            return false;
        } else {
            alert("You can only upload a maximum of 9 images");
            $('.postImageShow').empty();
            document.getElementById('tmpImageinput').value="";
            return false;
        }
    });    
});
});

$(function(){
    $("#uploadImagebtn").click(function(){
        $('.postImageShow').empty();
    });    
});