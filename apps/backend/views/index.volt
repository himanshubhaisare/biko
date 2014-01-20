<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Biko - {{ get_title(false) }}</title>
		{{- assets.outputCss() -}}
		{{- assets.outputJs() -}}
	</head>
	<body>
		{{- content() -}}
	</body>
</html>
