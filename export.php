<?php
function export($fileName, $title, $data)
{
  set_time_limit(0);
  ini_set('memory_limit', '256M');
  //下载csv的文件名、将数据编码转换成GBK格式
  mb_convert_variables('GBK', 'UTF-8', $fileName);
  //设置header头
  header('Content-Description: File Transfer');
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment; filename="' . $fileName . '"');
  header('Expires: 0');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
  //打开php数据输入缓冲区
  $fp = fopen('php://output', 'a');
  //将数据编码转换成GBK格式
  mb_convert_variables('GBK', 'UTF-8', $title);
  //将数据格式化为CSV格式并写入到output流中
  fputcsv($fp, $title);

  //如果在csv中输出一个空行，向句柄中写入一个空数组即可实现
  foreach ($data as $row) {
    //将数据编码转换成GBK格式
    mb_convert_variables('GBK', 'UTF-8', $row);
    fputcsv($fp, $row);
    //将已经存储到csv中的变量数据销毁，释放内存
    unset($row);
  }
  //关闭句柄
  fclose($fp);
  die;
}

//调用
$fileName = '示例.csv';
$title = ['姓名', '性别', '手机号'];
for ($i = 0; $i < 100000; $i++) {
  $data[$i]['name'] = '小明';
  $data[$i]['sex'] = '男';
  $data[$i]['num'] = $i;
}
$info = export($fileName, $title, $data);
