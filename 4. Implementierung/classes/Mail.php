<?php

/**
 * Class Mail
 * /F450/
 */
class Mail
{

	/**
	 * Mail send
	 * @param $to
	 * @param $subject
	 * @param $msg
	 */
	public function send($to, $subject, $msg)
	{
		mail($to, $subject, $msg);
	}
}