<?php
/* 尝试MySQL服务器连接。 假设您正在运行MySQL
具有默认设置的服务器（用户“ root”，密码） */
$link = mysqli_connect("10.0.0.110", "smg", "bt6f7m3XIEXL)XyIWZ", "smg_xlsx");
 
//检查连接
if($link === false){
    die("错误：无法连接。 " . mysqli_connect_error());
}
 
if(isset($_REQUEST["term"])){
    //预处理select语句
	$sql = "SELECT * FROM `smg_xlsx`.`03` WHERE (CONVERT(`port` USING utf8) LIKE ?) ";
    
    if($stmt = mysqli_prepare($link, $sql)){
        //将变量作为参数绑定到预处理语句
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        
        //设置参数
        $param_term = $_REQUEST["term"] . '%';
        
        // Attempt to执行预处理语句
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            //检查结果集中的行数
            if(mysqli_num_rows($result) > 0){
                //获取结果行作为关联数组
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<div>" . $row["col"] . "<div  class='result_div'>" . 
					"端口:" . $row["port"] . "&nbsp/&nbsp模块:" . $row["type"] ."</div>" .
					"</div>" ;
                }
            } else{
                echo "<p>没有找到匹配的记录</p>";
            }
        } else{
            echo "错误：无法执行 $sql. " . mysqli_error($link);
        }
    }
     
    //结束语句
    mysqli_stmt_close($stmt);
}
 
//关闭连接
mysqli_close($link);
?>