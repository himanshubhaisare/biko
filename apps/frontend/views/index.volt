<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Biko - {{ get_title(false) }}</title>
		{{- assets.outputCss() -}}
		{{- assets.outputJs() -}}
	</head>
	<body>
		{{- content() -}}
	</body>
</html>
