<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<title><?php wp_title(''); ?></title>

		<!-- Google Chrome Frame for IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<!-- Mobile Meta -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<!-- icons & favicons -->
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->

  	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    
		<!-- wordpress head functions -->
		<?php wp_head(); ?>
		<!-- end of wordpress head -->

		<!-- Google Analytics-->
		<!-- end analytics -->

	</head>

	<body <?php body_class(); ?>>
  	
  	<nav class="navbar navbar-default">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
        </div>
    
        <?php primer_main_nav(); ?>
      </div><!-- /.container -->
    </nav>
    