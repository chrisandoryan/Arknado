<?php
function asset($path)
{
	$dir = "";
	switch (pathinfo($path, PATHINFO_EXTENSION)) {
		case 'js':
			$dir = "js";
			break;
		case 'css':
			$dir = "css";
			break;
		case 'png':
			$dir = "asset";
			break;
	}
	$resource = sprintf("http://localhost:8000/public/%s/%s", $dir, $path);
	return $resource;
}
?>

<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Swagger UI</title>
	<link rel="stylesheet" type="text/css" href="<?= asset('swagger-ui.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?= asset('style.css'); ?>">
	<link rel="icon" type="image/png" href="<?= asset('favicon-32x32.png'); ?>" sizes="32x32" />
	<link rel="icon" type="image/png" href="<?= asset('favicon-16x16.png')?>" sizes="16x16" />
	<style>
		html {
			box-sizing: border-box;
			overflow: -moz-scrollbars-vertical;
			overflow-y: scroll;
		}

		*,
		*:before,
		*:after {
			box-sizing: inherit;
		}

		body {
			margin: 0;
			background: #fafafa;
		}
	</style>
</head>

<body>
	<div id="swagger-ui"></div>

	<script src="<?= asset('swagger-ui-bundle.js')?>"></script>
	<script src="<?= asset('swagger-ui-standalone-preset.js')?>"></script>
	<script>
		window.onload = function() {
			// Begin Swagger UI call region
			const ui = SwaggerUIBundle({
				url: "http://localhost:8000/api/swagger",
				dom_id: '#swagger-ui',
				deepLinking: true,
				presets: [
					SwaggerUIBundle.presets.apis,
					SwaggerUIStandalonePreset
				],
				plugins: [
					SwaggerUIBundle.plugins.DownloadUrl
				],
				layout: "StandaloneLayout"
			})
			// End Swagger UI call region

			window.ui = ui
		}
	</script>
</body>

</html>