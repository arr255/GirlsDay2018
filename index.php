<?php
function myError($errno,$errstr,$errfile,$errline){
    echo '第'.$errline.'行:'.$errstr;
    die();
}
set_error_handler('myError');
header("Content-Type: text/html;charset=utf-8");
$servername="localhost";
$username="root";
$password='123456';
$dbname='GirlsDay';
//创建连接
$conn=new mysqli($servername,$username,$password,$dbname);

$sql='select id,wishes,status from wish';
$result=$conn->query($sql);
$i=0;
$info=array();
while($row=$result->fetch_assoc()){
    $info['id'][$i]=$row['id'];
    $info['wishes'][$i]=$row['wishes'];
    $info['status'][$i]=$row['status'];
    $i+=1;
}
$json_string=json_encode($info);
echo "var info=".$json_string;
?>