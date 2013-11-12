<?php

// Default recipients.
define("MAIL_TO", 't.milev@venatrack.com,l.carlos@venatrack.com,r.costa@venatrack.com');

/**
 * Util class used to send email.
 *
 * @author Ricardo
 *
 */
class MailUtil {

	/**
	 * Function used to send email to default recipients.
	 *
	 * @param $subject
	 * @param $message
	 */
	public static function send_email($subject, $message)
	{
		mail(MAIL_TO, $subject, $message);
	}

	/**
	 * Function used to send email to a specific recipients.
	 *
	 * @param $to
	 * @param $subject
	 * @param $message
	 */
	public static function send_email_to($to, $subject, $message)
	{
		mail($to, $subject, $message);
	}

}
