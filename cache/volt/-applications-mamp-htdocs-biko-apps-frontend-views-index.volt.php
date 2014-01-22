<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Biko - <?php echo $this->tag->getTitle(false); ?></title><?php echo $this->assets->outputCss(); ?><?php echo $this->assets->outputJs(); ?></head>
	<body><?php echo $this->getContent(); ?></body>
</html>
