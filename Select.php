<?php
require "conn.php";
session_start();
$username=$_SESSION['user'];
if ($username==null || $username==""){
    $username='error';
}
header("Content-Type:text/html;charset=utf-8");
$conn = mysqli_connect(DB_HOST,DB_USER,DB_PWD,DA_base);
if(!$conn){
    echo "数据库连接失败".mysqli_connect_error().mysqli_connect_errno();
}
if (@$_POST['mo_h']=='1'){
    $date=@$_POST['m_date'];
    $movie_name=@$_POST['m_name'];
    $_SESSION['ticket']=$movie_name;
    $ticket_name=$_POST['m_name'];
    $re=select_ticket($ticket_name);
    if ($re==11){
        $list=getticket($ticket_name);
        echo "<script>location='show.html?name={$username}&date={$date}&mname={$movie_name}&jg={$list[0]['ticket_price']}&lx={$list[0]['tiket_type']}&jf={$_SESSION['integral']}'</script>";
    }else{
        echo "<script>alert('影片不存在!');location='movie.html?name={$username}'</script>";
    }
}elseif (@$_POST['t_h']=='1'){
    $date=@$_POST['t_date'];
    $ticket_name=@$_POST['t_name'].'-'.@$_POST['t_dname'];
    $_SESSION['ticket']=$ticket_name;
    $re=select_ticket($ticket_name);
    if ($re==11){
        $list=getticket($ticket_name);
        echo "<script>location='ta_show.html?name={$username}&date={$date}&addname={$_POST['t_name']}&mname={$ticket_name}&jg={$list[0]['ticket_price']}&lx={$list[0]['tiket_type']}&jf={$_SESSION['integral']}'</script>";
    }else{
        echo "<script>alert('车票不存在!');location='train.html?name={$username}'</script>";
    }
}else if(@$_POST['a_h']=='1'){
    $date=@$_POST['a_date'];
    $ticket_name=@$_POST['a_name'].'-'.@$_POST['a_dname'];
    $_SESSION['ticket']=$ticket_name;
    $re=select_ticket($ticket_name);
    if ($re==11){
        $list=getticket($ticket_name);
        echo "<script>location='ta_show.html?name={$username}&date={$date}&addname={$_POST['a_name']}&mname={$ticket_name}&jg={$list[0]['ticket_price']}&lx={$list[0]['tiket_type']}&jf={$_SESSION['integral']}'</script>";
    }else{
        echo "<script>alert('机票不存在!');location='airplane.html?name={$username}'</script>";
    }
}else if($username=='admin'){
    $list=getticket("",$username);
    echo " <head>";
    echo " <meta charset='UTF-8'>";
    echo " <title>详情</title>";
    echo " <script src=\"layui/layui.js\"></script>";
    echo " <link rel=\"stylesheet\" href=\"layui/css/layui.css\">";
    echo " <script>";
    //添加导航依赖element
    echo "layui.use('element', function(){
                 var element = layui.element;
                   //一些事件监听
                    element.on('tab(demo)', function(data){
                        console.log(data);
                    });
              });
             </script>
               </head>";
    echo "<body>";
    echo "<div style=\"width:100%;height: 90px;text-indent: 120px\">";
    echo "<img src=\"image/图标.jpg\">";
    echo " <a id=\"login_a\" href=\"index.html?name={$username}\"><input readonly=\"readonly\" id=\"login_xx\" type=\"text\" value=\"返回首页/\" style=\"border: 0;width:60px;margin-left: 65%;font-size: 15px\"></a>";
    echo "</div>";
    echo "<div style=\"background-color: #ffc900;font-size: 17px;word-spacing: 50px;height: 30px;line-height:35px; border:#fbff71 solid 1px;text-indent: 120px\">";
    echo " <span>";
    echo "    <a id=\"index_a\" href=\"index.html?name={$username}\">首页</a>";
    echo "    <a href=\"train.html?name={$username}\">火车票</a>";
    echo "    <a href=\"airplane.html?name={$username}\">飞机票</a>";
    echo "    <a id=\"movie_a\" href=\"movie.html?name={$username}\">电影票</a>";
    echo "  </span>";
    echo "</div>";
    echo "<div style=\"margin:0 auto;width: 85%;height: 1000px\">";
    echo "<a href='add_ticket.html?name={$username}'><button style='margin-top: 1%' class='layui-btn layui-bg-orange'>添加票</button></a>";
    echo " <table class=\"layui-table \">";
    echo "  <colgroup>";
    echo "    <col width=\"150\">";
    echo "    <col width=\"200\">";
    echo "    <col>";
    echo "</colgroup>";
    echo "<thead>";
    echo "<tr class=\"layui-bg-orange\">";
    echo "   <th>票名</th>";
    echo "  <th>价格</th>";
    echo " <th>类型</th>";
    echo " <th>删除</th>";
    echo " </tr>";
    echo " </thead>";
    echo " <tbody>";
    for ($i=0;$i<count($list);$i++){
        echo " <tr>";
        echo "  <td><input value='{$list[$i]['ticket_name']}' readonly=\"readonly\" style=\"background-color: white;border: 0;\"></td>";
        echo "  <td><input value='{$list[$i]['ticket_price']}' readonly=\"readonly\" style=\"background-color: white;border: 0;\"></td>";
        echo "  <td><input  value='{$list[$i]['tiket_type']}' readonly=\"readonly\" style=\"background-color: white;border: 0;\"></td>";
        echo "<td><form method='post' action='delete.php'><input type='hidden' name='delete' value='{$list[$i]['ticket_name']}'><button style='color: black;height: 35px' class=\"layui-btn layui-bg-orange\" lay-submit lay-filter=\"formDemo\">删除</button></form></td>";
        echo "</tr>";
    }
    echo " </tbody>";
    echo "</table>";
    echo "</div>";
    echo "</body>";
}else{
    $information_user_name=$username;
    $re=select_information($information_user_name);
    if ($re==11){
        $list=getinformation($information_user_name);
        echo " <head>";
            echo " <meta charset='UTF-8'>";
            echo " <title>详情</title>";
            echo " <script src=\"layui/layui.js\"></script>";
            echo " <link rel=\"stylesheet\" href=\"layui/css/layui.css\">";
            echo " <script>";
                //添加导航依赖element
             echo "layui.use('element', function(){
                 var element = layui.element;
                   //一些事件监听
                    element.on('tab(demo)', function(data){
                        console.log(data);
                    });
              });
             </script>
               </head>";
 echo "<body>";
 echo "<div style=\"width:100%;height: 90px;text-indent: 120px\">";
     echo "<img src=\"image/图标.jpg\">";
    echo " <a id=\"login_a\" href=\"index.html?name={$username}\"><input readonly=\"readonly\" id=\"login_xx\" type=\"text\" value=\"返回首页/\" style=\"border: 0;width:60px;margin-left: 65%;font-size: 15px\"></a>";
 echo "</div>";
 echo "<div style=\"background-color: #ffc900;font-size: 17px;word-spacing: 50px;height: 30px;line-height:35px; border:#fbff71 solid 1px;text-indent: 120px\">";
           echo " <span>";
           echo "    <a id=\"index_a\" href=\"index.html?name={$username}\">首页</a>";
           echo "    <a href=\"train.html?name={$username}\">火车票</a>";
           echo "    <a href=\"airplane.html?name={$username}\">飞机票</a>";
           echo "    <a id=\"movie_a\" href=\"movie.html?name={$username}\">电影票</a>";
           echo "  </span>";
 echo "</div>";
 echo "<div style=\"margin:0 auto;width: 85%;height: 1000px\">";
    echo " <table class=\"layui-table \">";
       echo "  <colgroup>";
         echo "    <col width=\"150\">";
         echo "    <col width=\"200\">";
         echo "    <col>";
         echo "</colgroup>";
         echo "<thead>";
         echo "<tr class=\"layui-bg-orange\">";
          echo "   <th>用户名</th>";
          echo "   <th>票名</th>";
          echo "  <th>价格</th>";
          echo " <th>时间</th>";
        echo " <th>类型</th>";
        echo " </tr>";
        echo " </thead>";
        echo " <tbody>";
        for ($i=0;$i<count($list);$i++){
           echo " <tr>";
           echo "  <td><input value='{$username}' readonly=\"readonly\" style=\"background-color: white;border: 0;\"></td>";
           echo "  <td><input value='{$list[$i]['information_ticket_name']}' readonly=\"readonly\" style=\"background-color: white;border: 0;\"></td>";
           echo "  <td><input value='{$list[$i]['information_ticket_price']}' readonly=\"readonly\" style=\"background-color: white;border: 0;\"></td>";
           echo "  <td><input  value='{$list[$i]['information_ticket_date']}' readonly=\"readonly\" style=\"background-color: white;border: 0;\"></td>";
            echo "  <td><input  value='{$list[$i]['ticket_type']}' readonly=\"readonly\" style=\"background-color: white;border: 0;\"></td>";
           echo "</tr>";
         }
        echo " </tbody>";
     echo "</table>";
 echo "</div>";
 echo "</body>";

    }else{
        echo "<script>alert('无购买记录!');location='index.html?name={$username}'</script>";
    }
}
function getticket($ticket_name='',$username=''){
    global $conn;
    if ($username =='admin'){
        $select=['*'];
        $select = is_array($select)?implode(",",$select):$select;
        $sql = "SELECT {$select} FROM ticket_table";
    }else{
        $select=['ticket_price','tiket_type'];
        $select = is_array($select)?implode(",",$select):$select;
        $sql = "SELECT {$select} FROM ticket_table WHERE ticket_name='{$ticket_name}'";
    }
    $sql = trim($sql);
    $res = mysqli_query($conn,$sql);
    $list = [];
    while($row  = mysqli_fetch_array($res,MYSQLI_ASSOC)){
        $list[] = $row;
    }
    return $list;
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

function getinformation($information_user_name=''){
    global $conn;
    $select=['*'];
    $select = is_array($select)?implode(",",$select):$select;
    $sql = "SELECT {$select} FROM information_table WHERE information_user_name='{$information_user_name}'";
    $sql = trim($sql);
    $res = mysqli_query($conn,$sql);
    $list = [];
    while($row  = mysqli_fetch_array($res,MYSQLI_ASSOC)){
        $list[] = $row;
    }
    return $list;
}
function select_information($information_user_name=""){
    global $conn;
    $select=['information_user_name'];
    $select = is_array($select)?implode(",",$select):$select;
    $sql = "SELECT {$select} FROM information_table WHERE information_user_name='{$information_user_name}'";
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
