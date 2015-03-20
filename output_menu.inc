<?php

$pages = Array(
	'name' => "MatrixConfig",
	'type' => "output",
	'page' => "plugin_setup.php");

?>

<li><a href="<?php echo preg_replace('/.*\/plugins\/(.*)/', 'plugin.php?plugin='.$pages["name"].'&page=plugin_setup.php', dirname(__FILE__)); ?>">Matrix Config</a></li
>
