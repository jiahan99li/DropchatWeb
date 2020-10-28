document.getElementById('homeLikeButton').addEventListener('click', liking());
document.getElementById('homeDislikeButton').addEventListener('click', disliking());

var div = document.getElementById('postLikeContainer');

function liking() {
    var disliking = document.getElementById('homeDislikeButton');
    let button = $(this);
    let post_id = $(button).data('postid');
    let user = $(button).data('user');
    let dislike = 1;
    $.post("../test.php",
       {
           'dislike' : dislike,
           'post_id' : post_id,
           'user' : user
       },
       function(data, status){
           div.removeChild(document.getElementById('homeLikeButton'));
           div.appendChild(disliking);
       });
}


function test1() {
var firstbtn = document.getElementById("btn1");
var secondbtn = document.getElementById("btn2");
firstbtn.parentNode.replaceChild(secondbtn, firstbtn);
}

function test2() {
var firstbtn = document.getElementById("btn1");
var secondbtn = document.getElementById("btn2");
secondbtn.parentNode.replaceChild(firstbtn, secondbtn);
}
