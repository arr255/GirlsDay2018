<?php
function myError($errno,$errstr,$errfile,$errline){
    echo '第'.$errline.'行:'.$errstr;
    die();
}
function alert($s){
    echo "<script>alert('".(string)$s."');</script>";
}
set_error_handler('myError');
    header("Content-Type: text/html;charset=utf-8");
    $servername="localhost";
    $username="root";
    $password='';
    $dbname='GirlsDay';
    //创建连接
    $conn=new mysqli($servername,$username,$password,$dbname);
    if($conn->connect_error){
        throw new Exception("连接失败：".$conn->connect_error);
    }
    //从前端获取信息
    $bname=$_POST['name'];
    $bclass=$_POST["class"];
    $bphonenumber=$_POST['phonenumber'];
    $bqq=$_POST['qq'];
    $password=$_POST['password'];
    //查询男生信息
    $sql="select * from claim where name='$bname' and phonenumber='$bphonenumber' and qq='$bqq'";
    $binfo=$conn->query($sql);
    if(!$binfo=$binfo->fetch_assoc()){
        alert('未找到男生信息');
        echo '<script>window.location.href="html/draw.html";</script>';
    }
    else{
        $id=$binfo['id'];
        $ifclaim=$binfo['ifclaim'];
        if($ifclaim){
            alert('您已参与抽奖');
            echo '<script>window.location.href="index.html";</script>';
        }
        $gsql="select password from wish where id='$id'";
        $ginfo=$conn->query($gsql);
        if(!$ginfo=$ginfo->fetch_assoc()){
            alert('未找到愿望者信息');
        }
        else{
            $gpassword=$ginfo['password'];
            if($password!=$gpassword){
                alert('密码错误');
                echo '<script>window.location.href="html/draw.html";</script>';
            }
            else{
                alert('您已参与抽奖，抽奖结果将在微信公众号上公布');
                $upsql='update claim set ifclaim=1';
                $conn->query($upsql);
            }
        }
    }
