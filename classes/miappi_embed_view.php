<?php

class Miappi_Embed_View {

	private $fontsize = '14';
	private $bgcolor = '#000000';
	private $width = '300px';
	private $height = '400px';
	private $user = '';

	public function default_attributes() {
		return array(
			'fontsize' => $this->fontsize,
			'bgcolor' => $this->bgcolor,
			'width' => $this->width,
			'height' => $this->height,
			'user' => $this->user,
		);
	}

	public function generate( $attributes, $echo = false ) {
		// Merge the attributes with the defaults
		extract( shortcode_atts( $this->default_attributes(), $attributes ) );

		if ( ! isset( $user ) ) {
			$error = 'Must have user';
			if ( $echo ) {
				wp_die( $error );
			} else {
				return $error;
			}
		}

		// Return the embed code HTML/JS
		$html = "
			<div id='miappi-frame' style='width: " . esc_attr( $width ) . "; height: " . esc_attr( $height ) . ";'></div>
			<script type='text/javascript'>
				var _mpi_user = '" . esc_js( $user ) . "',
					_mpi_fontsize = '" . esc_js( $fontsize ) . "',
					_mpi_bgcolor = '" . esc_js( $bgcolor ) . "';

				(function() {
					var miappi = document.createElement('script');
					miappi.type = 'text/javascript';
					miappi.async = true;
					miappi.src = '//miappi.com/embed.js';
					var script = document.getElementsByTagName('script')[0];
					script.parentNode.insertBefore(miappi,script);
				})();
			</script>";

		if ( $echo ) {
			echo $html;
		} else {
			return $html;
		}
    }

}
