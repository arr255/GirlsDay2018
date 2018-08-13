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
    $id=$_POST['id'];
    $time=time();
    //表单验证
    $regname='/.{2,4}/';
    $regclass='/.{4,20}/';
    $regphonenumber='/[0-9]{11}/';
    $regqq='/[0-9]{5,10}/';
    if(!preg_match($regname,$name)){
        alert('请输入正确名称');
        echo '<script>window.location.href="html/claim.html"</script>';
		exit();
    }
    if(!preg_match($regclass,$class)){
        alert('请输入正确班级');
        echo '<script>window.location.href="html/claim.html"</script>';
		exit();
    }
    if(!preg_match($regphonenumber,$phonenumber)){
        alert('请输入正确手机号码');
        echo '<script>window.location.href="html/claim.html"</script>';
		exit();
    }
    if(!preg_match($regqq,$qq)){
        alert('请输入正确qq');
        echo '<script>window.location.href="html/claim.html"</script>';
		exit();
    }
    //查询编号是否被认领
    $sqlq="select * from wish where id='$id' and status=0";
    $test=$conn->query($sqlq);
    if(!$test->fetch_assoc()){
        echo "<script>alert('认领的编号不存在或已被认领');</script>";
    }
    else{
        //判断是否重复
        $sqlr="select * from claim where phonenumber='$phonenumber'";
        $re=$conn->query($sqlr);
        if($re->fetch_assoc()){
            $sqlupdate="update claim set name='$name',class='$class',phonenumber='$phonenumber',qq='$qq' where phonenumber='$phonenumber'";
            if ($conn->query($sqlupdate) === TRUE) {
                echo "<script>alert('信息更新成功');</script>";
            } else {
                echo "<script>alert('更新失败');</script>";
                echo "Error: " . $sqlupdate . "<br>" . $conn->error;
            }      
        }
        else{
            //插入数据
            $sql="insert into claim (id,name,class,phonenumber,qq,createTime)
                    values ('$id','$name','$class','$phonenumber','$qq','$time')";
            if ($conn->query($sql) === TRUE) {
                $gsql="select id,name,class,phonenumber,qq from wish where id='$id'";
                $ginfo=$conn->query($gsql)->fetch_assoc();
                $alertginfo='提交成功\n愿望者信息\n编号:'.(string)$ginfo['id'].'\n姓名:'.(string)$ginfo['name'].'\n班级:'
                .(string)$ginfo['class'].'\n电话:'.(string)$ginfo['phonenumber'].'\nqq:'.(string)$ginfo['qq'];
                alert($alertginfo);
            } else {
                echo "<script>alert('提交失败');</script>";
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            //更新愿望状态
            $sqlupdate="update wish set status=1 where id='$id'";
            $conn->query($sqlupdate);
        }
    }
        echo '<script>window.location.href="main/index.html"</script>';
    ?>
