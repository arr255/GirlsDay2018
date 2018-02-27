<?php
// function myError($errno,$errstr,$errfile,$errline){
//     echo '第'.$errline.'行:'.$errstr;
//     die();
// }
// set_error_handler('myError');
    header("Content-Type: text/html;charset=utf-8");
    $servername="localhost";
    $username="root";
    $password='123456';
    $dbname='GirlsDay';
    //创建连接
    $conn=new mysqli($servername,$username,$password,$dbname);
    if($conn->connect_error){
        throw new Exception("连接失败：".$conn->connect_error);
    }
    //查询愿望领取者对应的id；
    $binfo=$_POST['trans_data'];
    $bname=$binfo[1];
    $bphonenumber=$binfo[0];
    $bqq=$binfo[2];
    $sql="select id from claim where name='$bname' and phonenumber='$bphonenumber' and qq='$bqq'";
    $gid=$conn->query($sql);
    if($gid=$gid->fetch_assoc()){
        $gid=$gid['id'];
        $gsql="select id,name,class,phonenumber,qq from wish where id='$gid'";
        $ginfo=$conn->query($gsql)->fetch_assoc();
        if($ginfo){
            echo json_encode($ginfo);
        }
        else{
            echo json_encode(404);
        }
        // echo json_encode($gid["id"]);
    }
    else{
        echo json_encode(502);
    }
    ?>