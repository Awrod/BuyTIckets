<?php
require "conn.php";
session_start();
$username=@$_SESSION['user'];
if ($username==null || $username==""){
    $username='error';
}
header("Content-Type:text/html;charset=utf-8");
$conn = mysqli_connect(DB_HOST,DB_USER,DB_PWD,DA_base);
if(!$conn){
    echo "数据库连接失败".mysqli_connect_error().mysqli_connect_errno();
}
if (@$_POST['delete'] !=null){
    $table='ticket_table';
    $tj['ticket_name']=$_POST['delete'];
    $rea=sc_comment($table,$tj,1);
    if ($rea==1){
        echo "<script>alert('删除成功!');location='Select.php'</script>";
    }else{
        echo "<script>alert('删除失败!');location='Select.php'</script>";
    }
}else{
    $table='comment_table';
    $tj['user_name']=$username;
    $tj['comment_main']=$_POST['main'];
    $rea=sc_comment($table,$tj,1);
    if ($rea==1){
        echo "<script>alert('删除成功!');location='comment.php'</script>";
    }else{
        echo "<script>alert('删除失败!');location='comment.php'</script>";
    }
}
function sc_comment($table,$tj,$real_affected=false){
    global $conn;
    if(is_array($tj)){
        $where_arr = [];
        foreach($tj as $col =>$value){
            $v =  is_numeric($value)?$value:"'".$value."'";
            $where_arr[]="`{$col}` = "."{$v}";
        }
        $tj_str = implode(" AND ", $where_arr);
    }else{
        $tj_str = $tj;
    }
    $sql  = "DELETE FROM  {$table}   WHERE {$tj_str} ";
    $res = mysqli_query($conn,$sql);
    if(!$res){
        return false;
    }
    return $real_affected ? mysqli_affected_rows($conn):true;
}