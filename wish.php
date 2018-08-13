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
    $name=$_POST['name'];
    $class=$_POST["class"];
    $phonenumber=$_POST['phonenumber'];
    $qq=$_POST['qq'];
    $wish=$_POST['wish'];
    $password=$_POST['password'];
    //表单验证
    $regname='/^[\x{4e00}-\x{9fa5}]{1,5}$/u';
    $regclass='/^[\x{4e00}-\x{9fa5}0-9]{1,10}$/u';
    $regphonenumber='/^[0-9]{5,12}$/';
    $regqq='/^[0-9]{5,12}$/';
    $regwish='/^[\x{4e00}-\x{9fa5}0-9a-z\p{P}]{2,50}$/u';
    $regpassword='/[0-9a-z]{0,10}/';
    if(!preg_match($regname,$name)){
        alert('请输入正确名称');
        echo '<script>window.location.href="html/wish.html"</script>';
		exit();
    }
    if(!preg_match($regclass,$class)){
        alert('请输入正确班级');
        echo '<script>window.location.href="html/wish.html"</script>';
		exit();
    }
    if(!preg_match($regphonenumber,$phonenumber)){
        alert('请输入正确手机号码');
        echo '<script>window.location.href="html/wish.html"</script>';
		exit();
    }
    if(!preg_match($regqq,$qq)){
        alert('请输入正确qq');
        echo '<script>window.location.href="html/wish.html"</script>';
		exit();
    }
    if(!preg_match($regwish,$wish)){
        alert('愿望不要过长或过短');
        echo '<script>window.location.href="html/wish.html"</script>';
		exit();
    }
    if(!preg_match($regpassword,$password)){
        alert('密码不要过长');
        echo '<script>window.location.href="html/wish.html"</script>';
		exit();
    }
    //查询当前编号
    $sqlq="select id from wish order by id DESC limit 1";      
    $idlast=$conn->query($sqlq)->fetch_assoc()['id'];
    if(!isset($idlast)){
        $idlast=0;
    }
    //设置当前编号
    $id=$idlast+1;
    $time=time();
    $status=0;
    //判断是否重复
    $sqlr="select * from wish where phonenumber='$phonenumber'";
    $re=$conn->query($sqlr);
    if($re->fetch_assoc()){
        $sqlupdate="update wish set name='$name',class='$class',phonenumber='$phonenumber',qq='$qq',createTime='$time',password='$password' where phonenumber='$phonenumber'";
        if ($conn->query($sqlupdate) === TRUE) {
            echo "<script>alert('信息更新成功');</script>";
        } else {
            echo "<script>alert('更新失败');</script>";
            echo "Error: " . $sqlupdate . "<br>" . $conn->error;
        }      
    }
    else{
        //插入数据
        $sql="insert into wish (id,name,password,class,phonenumber,qq,wishes,createTime,status)
                values ('$id','$name','$password','$class','$phonenumber','$qq','$wish','$time','$status')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('提交成功');</script>";
        } else {
            echo "<script>alert('提交失败');</script>";
            echo "Error: " . $sql . "<br>" . $conn->error;
        }      
    }
    echo '<script>window.location.href="main/index.html"</script>';
?>
