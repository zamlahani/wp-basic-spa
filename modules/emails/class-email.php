<?php
namespace BD\Emails;

defined('ABSPATH') or die('Can\'t access directly');

Use \Mailjet\Resources;

class Email
{
	public static function set_placeholder($content, $placeholder_tags)
	{
		$placeholder = new Placeholder();
		return $placeholder->setContent($content)->convert($placeholder_tags);
	}

}
