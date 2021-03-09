<?php
session_start();
$_SESSION['user']='error';
session_destroy();
echo "<script>alert('注销成功!');location='index.html'</script>";