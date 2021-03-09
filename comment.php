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
$ticket_name=@$_SESSION['ticket'];
$list=getcomment($ticket_name);
echo " <head>";
echo " <meta charset='UTF-8'>";
echo " <title>详情</title>";
echo " <script src=\"layui/layui.js\"></script>";
echo " <link rel=\"stylesheet\" href=\"layui/css/layui.css\">";
echo " <script>";
//添加导航依赖element
echo "    layui.use('element', function(){
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
    echo "<div style=\"margin:0 auto;width: 85%;height: 1000px;background-color: white\">";
        echo "<h2 style='border: 1px;border: orange;margin-top: 2%'>{$ticket_name}评论</h2>";
        if (count($list)==0){
            echo "暂无评论!";
        }
            for ($i=0;$i<count($list);$i++) {
                echo "<div class=\"layui-card\" style='margin-top: 2%'>";
                    echo "<div class=\"layui-card-header\">用户名：{$list[$i]['user_name']}<h5 style='float: right'>发布时间：{$list[$i]['comment_date']}</h5></div>";
                    echo "<div class=\"layui-card-body\">";
                        echo "{$list[$i]['comment_main']}<h5 style='float: right'>";
                        if($list[$i]['user_name'] == $username){
                            echo "<form method='post' action='delete.php'><input type='hidden' name='main' value='{$list[$i]['comment_main']}'><button style='color: black;background-color: white' class=\"layui-btn \" lay-submit lay-filter=\"formDemo\">删除</button></form>";
                        }
                        echo "</h5>";
                    echo "</div>";
                    echo "</div>";
            }
        require 'comment.html';
        echo "<div>";
echo "</body>";
function getcomment($ticket_name=''){
    global $conn;
    $select=['*'];
    $select = is_array($select)?implode(",",$select):$select;
    $sql = "SELECT {$select} FROM comment_table WHERE ticket_name='{$ticket_name}'";
    $sql = trim($sql);
    $res = mysqli_query($conn,$sql);
    $list = [];
    while($row  = mysqli_fetch_array($res,MYSQLI_ASSOC)){
        $list[] = $row;
    }
    return $list;
}