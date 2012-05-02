<?php
include ('sqlMarkup.php');
$demoStatement = <<<'EOT'
SELECT toppingStyle, COUNT(*)  FROM foods INNER JOIN toppings ON foods foods.toppingStyle = foods.toppingStyle     WHERE food foods.type LIKE 'pizza' AND toppings.topping_id = 5
EOT;

$sqlMarkerUpper = new sqlMarkup();
$sqlMarkerUpper->setStatement($demoStatement);

?>

<html>
	<head>
		<style type="text/css">
			.sqlFunction{
			    color: #990033;
			}
			.sqlRWord{
			    color: #006666;
			}
			.sqlData{
			    color: #660066;
			}
			.sqlWrap{
			    font-family: calibri,monospace;
			}
		</style>
	</head>
	<body>
		Here's the ugly, poorly formatted (possibly not even real SQL) statement <br /> <br />
		<span><?php echo($demoStatement); ?></span><br /> <br />
		Here's the formatted statement: <br /> <br />
		<span><?php echo($sqlMarkerUpper->getMarkedStatement()); ?></span><br /><br />
		Here's the statement with blanksClean turned off. Notice the extra line break at the top of the span: <br /><br />
		<span><?php $sqlMarkerUpper->setBlanksClean(FALSE); echo($sqlMarkerUpper->getMarkedStatement()); ?></span>
	</body>
<html>
