<?php
require "conn.php";
header("Content-Type:text/html;charset=utf-8");
session_start();
$conn = mysqli_connect(DB_HOST,DB_USER,DB_PWD,DA_base);
if(!$conn){
    echo "数据库连接失败".mysqli_connect_error().mysqli_connect_errno();
}
$username=$_SESSION['user'];
if (@$_POST['fb_comment'] == '1'){
    $ticket_name=$_SESSION['ticket'];
    insert_comment($username,$ticket_name,@$_POST['comment_main']);
}else if (@$_POST['add_ticket'] == 'T'){
    $res=select_ticket(@$_POST['ticket_name']);
    if ($res==11){
        echo "<script>alert('票已存在!');location='add_ticket?name={$username}'</script>";
    }else{
        insert_ticket(@$_POST['ticket_name'],@$_POST['ticket_price'],'',@$_POST['ticket_type']);
    }
}else{
    insert_ticket($username,@$_POST['mo_name'],@$_POST['l_date'],@$_POST['price'],@$_POST['lx']);
}
function insert_ticket($username=null,$moviename=null,$moviedate=null,$movieprice=null,$lx=null,$code=null){
    global $conn;
    $str='';
    $str2='';
    $html='';
    if (@$_POST['add_ticket'] == 'T'){
        $sql="INSERT INTO ticket_table(ticket_name,ticket_price,tiket_type)values('{$username}','{$moviename}','{$movieprice}')";
        $str='添加票成功！';
        $str2='添加票失败！';
        $html='Select.php';
    }else{
        $sql="INSERT INTO information_table(information_user_name,information_ticket_name,information_ticket_price,information_ticket_date,ticket_type)values('{$username}','{$moviename}','{$lx}','{$moviedate}','{$movieprice}')";
        $str='购买成功！';
        $table='user_table';
        $integral_u=0;
        $data=['user_integral'=>$integral_u];
        $tj['user_name']=$username;
        up_Invite($table,$data,$tj,1);
        $str2='购买失败！';
        $html='index.html';
    }
    if(@mysqli_query($conn,$sql)==true){
        mysqli_close($conn);
        echo "<script>alert('{$str}');location='{$html}?name={$username}'</script>";
    }else{
        mysqli_close($conn);
        echo "<script>alert('{$str2}');location='{$html}?name={$username}'</script>";
    }
}
function insert_comment($username=null,$ticket_name=null,$comment_main=null,$code=null){
    global $conn;
    $date=date('Y-m-d h:i:s', time()+288000/10);
    $sql="INSERT INTO comment_table(ticket_name,user_name,comment_main,comment_date)values('{$ticket_name}','{$username}','{$comment_main}','{$date}')";
    if(@mysqli_query($conn,$sql)==true){
        mysqli_close($conn);
        echo "<script>alert('发布成功!');location='comment.php'</script>";
    }else{
        mysqli_close($conn);
        echo "<script>alert('发布失败!');location='comment.php'</script>";
    }
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
function select_ticket($ticket_name=""){
    global $conn;
    $select=['ticket_name'];
    $select = is_array($select)?implode(",",$select):$select;
    $sql = "SELECT {$select} FROM ticket_table WHERE ticket_name='{$ticket_name}'";
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