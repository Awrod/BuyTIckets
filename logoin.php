<?php
require "conn.php";
header("Content-Type:text/html;charset=utf-8");
session_start();
$conn = mysqli_connect(DB_HOST,DB_USER,DB_PWD,DA_base);
////$_POST用户名和密码
$username = $_POST['username'];
$password = $_POST['password'];
$password=strtolower(md5($password));
//判断用户名和密码是否为空
if ($username==""){
    echo "<script>alert('请输入用户名!');location='login.html'</script>";
    exit;
}
if ($password==""){
    echo "<script>alert('请输入密码!');location='login.html'</script>";
    exit;
}

//验证mysql连接是否成功
    if (!$conn) {
        echo "连接mysql失败：" . mysqli_error($conn);
        exit;
    }
//设置数据库字符集
mysqli_set_charset($conn, 'utf8');
//查看数据库emp
mysqli_select_db($conn, 'buytlckets_db');
//查看用户名与密码和传输值是否相等
$sql = "select user_id,user_name,user_pass from user_table where user_name='$username' and user_pass='$password'";
//验证码
$yzm=@$_SESSION['yzm'];
$h_yan=@$_POST['yzm'];
if($h_yan != $yzm){
    echo "<script>alert('验证码输入错误，请重新输入!');location='login.html'</script>";
}
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);// 函数返回结果集中行的数量
if ($num) {
    $_SESSION['user']=$username;
    $integral_list[]=getinvite($username);
    $_SESSION['integral']=$integral_list[0][0]["user_integral"];
    echo "<script>alert('登录成功!欢迎');location='index.html?name={$username}'</script>";
} else {
    echo "<script>alert('用户名或密码错误，请重新输入!');location='login.html'</script>";
}
function getinvite($user_name=null){
    global $conn;
    $select=['user_integral'];
    $select = is_array($select)?implode(",",$select):$select;
    $sql = "SELECT {$select} FROM user_table WHERE user_name='{$user_name}'";
    $sql = trim($sql);
    $res = mysqli_query($conn,$sql);
    $list = [];
    while($row  = mysqli_fetch_array($res,MYSQLI_ASSOC)){
        $list[] = $row;
    }
    return $list;
}
mysqli_close($conn);

