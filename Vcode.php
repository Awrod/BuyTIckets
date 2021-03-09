<?php
session_start();
$yzm=$_SESSION['yzm'];
$yzm_t=$_POST['yzm'];
$vcode=new Vcode();
$status = $vcode->code($yzm, $yzm_t);
if (!$status) {
    echo $yzm;
}
class Vcode
{
    public function code($code,$code_yzm){
        if ($code==$code_yzm){
            return false;
        }else{
            return true;
        }
    }
}