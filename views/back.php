<!DOCTYPE html>
<head>
    <meta charset="UTF-8" />
    <link rel='stylesheet' href="<?php echo Lii::app()->baseUrl; ?>/css/back.css">
    <title>玉龙轩后台管理</title>
</head>
<body>
	<div id="header">
		<span>玉龙轩后台管理</span>
		<div class="header_right">
			<a href="index">返回网站</a>
			<a href="logout">退出</a>
		</div>
	</div>
	<div id="context">
		<table border="1">
            <tr>
              <th>id</th>
              <th>姓名</th>
              <th>电话</th>
              <th>型号</th>
              <th>颜色</th>
              <th>地址</th>
              <th>时间</th>
            </tr>
            <?php foreach ($result as $model){
                $tmp = '';
                $tmp .= "<tr>";
                $tmp .= "<td>$model->id</td>";
                $tmp .= "<td>$model->name</td>";
                $tmp .= "<td>$model->phone</td>";
                $tmp .= "<td>$model->type</td>";
                $tmp .= "<td>$model->color</td>";
                $tmp .= "<td>$model->province-$model->city-$model->area-$model->detail</td>";
                $tmp .= "<td>$model->date</td>";
                $tmp .= "</tr>";
                echo $tmp;
            }?>
    </table>
	</div>
  <div id="change">

      <?php $pages->displayCode(); ?>
      
      <div class="export">
        <a href="<?php echo Lii::app()->baseUrl.'/index.php/exportData/'.$pages->currentPage;?>">导出当前页</a>
        <a href="<?php echo Lii::app()->baseUrl;?>/index.php/exportData">导出全部</a>
      </div>
    </div>
	<div id="footer">
	</div>
</body>
