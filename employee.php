<?php
// 防止亂碼
header("Content-Type:text/html; charset=big5");
// CROS
header("Access-Control-Allow-Origin: *");


//取得記錄傳回
$arr = get_rows();



$keys = ["name"];
// 有資料時才轉 json
if (count($arr) > 0) {
    $json = arr_to_json($arr, $keys);
    echo $json . "\n";
}


/* FUNCTION */

//打卡記錄
function get_rows()
{
    $db = new PDO("odbc:salary"); 

 
$sql = "SELECT 姓名 FROM 員工基本資料";  
 
    $sql = mb_convert_encoding($sql, "BIG5", "UTF-8");


    try {
        $rs = $db->query($sql);
    } catch (PDOException $err) {
        print_r($err->getMessage());
    }

    // 取得資料陣列
    $arr = $rs->fetchAll(PDO::FETCH_ASSOC);

    $rows = [];

    if (empty($arr)) {
        return $rows;
    }

    return $arr;
}




function arr_to_json($arr, $keys = [])
{
    $json = "";

    for ($i = 0; $i < count($arr); $i++) {
        $j = 0;
        foreach ($arr[$i] as $key => $value) {            
            // 字串後面有空白導致無法正確輸出 json 格式, 加上 trim            
            $newarr[urlencode($keys[$j])] = urlencode(trim($value));    
                         
            $j++;
        }
       
        $rows[$i] = $newarr;
    }
    // array to json
    $json = json_encode($rows);
   
    // 再用urldecode把資料轉回成中文格式
    $json = urldecode($json);
    return $json;
}
