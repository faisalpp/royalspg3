<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>@yield('page-title') {{ settings('app_name') }}</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="description" content="@yield('page-title') - {{ settings('app_name') }}">
	<meta name="viewport" content="width=device-width">
	<link rel="icon" href="/frontend/Default/img/favicon.png">
	<meta property="og:image" content="/frontend/Default/img/vladA.png">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@200&display=swap" rel="stylesheet"> -->
	<style>
		.goog-te-gadget {
			height: 28px;
    		overflow: hidden;
		}

		iframe.goog-te-banner-frame {
			display: none !important;
		}

		select.goog-te-combo {
			min-height: 28px;
			margin: 0px !important;
			padding: 0px 4px;
			background: rgb(19 26 45);
			font-size: 14px;
			color: #fff;
			border-radius: 8px;
		}

		select.goog-te-combo:focus-visible {
			border: unset !important;
		}

		body {
			top: 0px !important;
		}
		
		@-moz-keyframes spinner {
			100% {
				transform: rotate(1turn);
			}
		}

		@-webkit-keyframes spinner {
			100% {
				transform: rotate(1turn);
			}
		}

		@-o-keyframes spinner {
			100% {
				transform: rotate(1turn);
			}
		}

		@keyframes spinner {
			100% {
				transform: rotate(1turn);
			}
		}

		#loader {
			align-items: center;
			background-color: #090f1e;
			display: flex;
			flex-direction: column;
			justify-content: center;
			left: 0;
			right: 0;
			bottom: 0;
			position: fixed;
			text-align: center;
			top: 0;
			height: 100%;
			width: 100vw;
			min-height: 100vh;
			min-width: 100vw;
			z-index: 1000;
		}

		#loader.hidden {
			display: none;
		}

		#loader.transparent {
			opacity: 0;
			visibility: hidden;
		}

		#loader #loader-logo-container {
			margin-bottom: 40px;
			height: 80px;
			width: 160px;
			backface-visibility: hidden;
		}

		#loader .loader-spinner {
			animation: spinner 0.75s infinite linear;
			border: 3px solid #1863d1;
			border-radius: 50%;
			border-right-color: transparent;
			border-top-color: transparent;
			box-sizing: border-box;
			height: 25px;
			pointer-events: none;
			width: 25px;
		}

		body {
			overflow: hidden;
		}
	</style>
</head>

<body class="@yield('add-body-class')" style='top:0px !important'>
	<div id="app"></div>
	<section id="loader">
		<div id="loader-logo-container">
			<img src='{{ Request::root() }}/images/logo.png' alt="logo" style="width: 100%;" />
		</div>
		<div class="loader-spinner"></div>
	</section>
	<script src="{{ mix('js/app.js') }}" async defer></script>
	<!-- <script type="text/javascript">
		function googleTranslateElementInit() {
			setCookie('googtrans', '/en/pt', 1);
			new google.translate.TranslateElement({pageLanguage: 'en' }, 'google_translate_element');
		}
		function setCookie(key, value, expiry) {
			var expires = new Date();
			expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
			document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
		}
	</script>
	<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> -->
</body>

</html>