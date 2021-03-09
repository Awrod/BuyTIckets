<?php
require "conn.php";
$conn = mysqli_connect(DB_HOST,DB_USER,DB_PWD,DA_base);
if($_POST['ps_data']=='T'){
    $table='user_table';
    $data=['user_pass'=>md5(@$_POST['password'])];
    $tj['user_name']=$_POST['username'];
    $rea=up_pass($table,$data,$tj,1);
    if ($rea==1){
        echo "<script>alert('修改成功，请重新登入！');location='login.html'</script>";
    }else{
        echo "<script>alert('修改失败!');location='PersonalData.php'</script>";
    }
}
function up_pass($table,$data,$tj="",$real_affected=false){
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