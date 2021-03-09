<?php
require "conn.php";
session_start();
$conn = mysqli_connect(DB_HOST,DB_USER,DB_PWD,DA_base);
$username=$_SESSION['user'];
getP_Data($username);
function getP_Data($username){
    $table='user_table';
    $zd='*';
    $tj['user_name']=$username;
    $list[]='';
    $list=getuser($table,$zd,$tj);
    echo "<script> location='PersonalData.html?name={$list[0]['user_name']}&pw={$list[0]['user_pass']}&phone={$list[0]['user_phone']}&id={$list[0]['user_idcard']}&invite={$list[0]['user_Invite']}&integral={$list[0]['user_integral']}'</script>";
}
function getuser($table,$zd="*",$tj){
    global $conn;
    if(empty($table) || empty($zd) || empty($tj)){
        return false;
    }
    $zd = is_array($zd)?implode(",",$zd):$zd;
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
    $sql = "SELECT {$zd} FROM {$table} WHERE {$tj_str}";
    $sql = trim($sql);
    $res = mysqli_query($conn,$sql);
    $list = [];
    while($row  = mysqli_fetch_array($res,MYSQLI_ASSOC)){
        $list[] = $row;
    }
    return $list;
}

