<?php
require "conn.php";
header("Content-Type:text/html;charset=utf-8");
$conn = mysqli_connect(DB_HOST,DB_USER,DB_PWD,DA_base);
if(!$conn){
    echo "数据库连接失败".mysqli_connect_error().mysqli_connect_errno();
}
$arr1=["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
    "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
    "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
    "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
    "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
    "3", "4", "5", "6", "7", "8", "9"];
session_start();
$code_re=@$_SESSION['code_re'];
$mobile_re=@$_SESSION['moblie_re'];
insert_user(@$_POST['username'],@$_POST['password'],@$_POST['moblie'],@$_POST['idcard'],$mobile_re,$code_re,@$_POST['Invite']);
function select_user($name=""){
    global $conn;
    $select=['user_name'];
    $select = is_array($select)?implode(",",$select):$select;
    $sql = "SELECT {$select} FROM user_table WHERE user_name='{$name}'";
    $sql = trim($sql);
    //获取结果集
    $res = mysqli_query($conn,$sql);
    $row  = mysqli_fetch_array($res);
    if ($row>0){
        return 11;
    }else{
        return false;
    }
    mysqli_close($conn);
}
function insert_user($username=null,$userpass=null,$userphone=null,$userid=null,$mobile_re=null,$code_re=null,$Invite=null){
    global $conn;
    global $arr1;
    if(select_user($username)==11){
        echo "<a href='login.html' style='position: absolute;width: 415px;height: 200px;text-align: center;top: 50%;left: 50%;margin-top: -20%;margin-left: -15%;'>   
                    用户已经存在，请登入！
                </a>";
    }elseif ($userphone !== $mobile_re){
        echo "<script>alert('手机号与验证手机号不匹配！');location='register.html'</script>";
    }else{
        if ($Invite != null){
            $list[]=null;
            $list=getinvite($Invite);
            $table='user_table';
            $integral_u=@$list[0]['user_integral']+5;
            $data=['user_integral'=>$integral_u];
            $tj['user_Invite']=$Invite;
            $ressss=up_Invite($table,$data,$tj,1);
        }
        $Invite_re=get_code($arr1);
        $integral=0;
        $userpass=strtolower(md5($userpass));
        $sql="INSERT INTO user_table(user_name,user_pass,user_phone,user_idcard,user_Invite,user_integral)values('{$username}','{$userpass}','{$userphone}','{$userid}','{$Invite_re}','{$integral}')";
        if(@mysqli_query($conn,$sql)==true){
            mysqli_close($conn);
            echo "注册成功，自动跳转登入页面中....";
            echo "<a href='login.html'>长时间未反应请点击此处</a>";
            header("Refresh:3,url=login.html");
        }else{
            mysqli_close($conn);
            echo "注册失败，正在跳转回注册页面...: ";
            echo "<a href='register.html'>长时间未反应请点击此处</a>";
            header("Refresh:3,url=register.html");
        }
    }
}
function get_code($arr1){
    $arrlens=count($arr1)-1;
    shuffle($arr1);
    $code_str= "";
    for ($i=0;$i<6;$i++){
        $code_str.=$arr1[mt_rand(0,$arrlens)];
    }
    return $code_str;
}
function up_Invite($table,$data,$tj="",$real_affected=false){
    global $conn;
    $updata_str = [];
    foreach($data as $col=>$value){
        $v =  is_numeric($value)?$value:"'".$value."'";
        $updata_arr[] = "`{$col}` = ".$v;
    }
    $updata_str = implode(",", $updata_arr);

    if(is_array($tj)){
        $tj_arr = [];
        foreach($tj as $col =>$value){
            $v =  is_numeric($value)?$value:"'".$value."'";
            $tj_arr[]="`{$col}` = ".$v;
        }
        $tj_str = implode(" AND ", $tj_arr);
    }else{
        $tj_str = $tj;
    }
    $sql  = "UPDATE {$table} SET {$updata_str} WHERE {$tj_str} ";
    $res = mysqli_query($conn,$sql);
    if(!$res){
        return false;
    }
    return $real_affected ? mysqli_affected_rows($conn):true;
}
function getinvite($user_Invite=null){
    global $conn;
    $select=['user_integral'];
    $select = is_array($select)?implode(",",$select):$select;
    $sql = "SELECT {$select} FROM user_table WHERE user_Invite='{$user_Invite}'";
    $sql = trim($sql);
    $res = mysqli_query($conn,$sql);
    $list = [];
    while($row  = mysqli_fetch_array($res,MYSQLI_ASSOC)){
        $list[] = $row;
    }
    return $list;
}
