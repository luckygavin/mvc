<h1>Hello World!</h1>
<h3>Readme</h3>
<?php
	$readme=file(Lii::app()->basePath.'/Readme');
	foreach ($readme as $value) {
		echo $value."<br>";
	}
?>