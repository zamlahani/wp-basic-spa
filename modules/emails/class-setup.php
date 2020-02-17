<?php
/**
 * Example of component
 *
 * @package BornDigital
 */

namespace BD\Emails;

class Setup
{
	 
	public function __construct()
	{
		remove_filter( 'wp_mail_content_type', [$this, 'email_content_type'] );
		add_filter( 'wp_mail_content_type',  [$this, 'email_content_type'] );
	}

	public function email_content_type()
	{
		return 'text/html';
	}
}

new Setup();
