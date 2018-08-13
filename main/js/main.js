$(document).ready(function(){
    //随机设置背景图片
    $("body").removeClass();
    var x = 6;
    var y = 1;
    var rand = parseInt(Math.random() * (x - y + 1) + y);
    $("body").addClass("body__background-"+rand);
});
