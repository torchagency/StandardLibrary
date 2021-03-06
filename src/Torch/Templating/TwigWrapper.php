<?php
namespace Torch\Templating;

use \Twig_Loader_Filesystem;
use \Twig_Environment;
use \Torch\Wordpress\Tools as WordpressTools;
use \Torch\Wordpress\AdminNotice;

if ( !class_exists( "TwigWrapper" ) ):
class TwigWrapper implements Renderer
{
	private $environment 	= null;
	private $context 		= null;
	
	public function __construct( $context )
	{
		if ( class_exists( "Twig_Environment" ) )
		{
			$this->context = $context;

			$loader = new Twig_Loader_Filesystem( $context );
			$this->environment = new Twig_Environment( $loader );
		}
		else
		{
			$message = __( "\"Twig\" is required to use this project." );

			if ( WordpressTools::isWordpress( ) )
				new AdminNotice( $message, "error", true );
			else
				throw new Exception( $message );
		}
	}

	public function updateContext( $new_context )
	{
		if ( class_exists( "Twig_Environment" ) )
		{
			$thie->context = $new_context;
			$this->environment->getLoader( )->setPaths( $new_context );
		}
	}

	public function render( $template, $variables, $return = false )
	{
		$func = "display";
		if ( $return )
			$func = "render";

		$return = "";
		if ( !is_null( $this->environment ) )
			$return = $this->environment->{$func}( $template.".twig", $variables );

		return $return;
	}
}
endif;