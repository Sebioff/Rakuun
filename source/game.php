<?php

/**
 * Globally needed functions
 */
abstract class Rakuun_Game {
	public static function sendErrorMail($backtrace, $customMessage, $errorType, $subject, $additionalInformation = '') {
		$developers = array();
		try {
			$developers = Rakuun_TeamSecurity::get()->getGroupUsers(Rakuun_TeamSecurity::GROUP_DEVELOPER);
		}
		catch (Core_Exception $ce) {
			// couldn't connect to database?
			echo 'Error while trying to send error mail - connection to database probably failed.
			<br/>
			Trying to send error mail to standard error mail recipient.';
		}
		$mail = new Net_Mail();
		$mail->setSubject('[Rakuun] '.$subject);
		$nr = 0;
		$message = '';
		$traceCount = count($backtrace);
		if ($additionalInformation)
			$message = $additionalInformation."\n\n";
		if ($currentUser = Rakuun_User_Manager::getCurrentUser())
			$message = 'User: '.$currentUser->nameUncolored."\n\n";
		$currentModule = Router::get()->getCurrentModule();
		if (!($params = $currentModule->getParams()))
			$params = array();
		$message .= 'URL: '.$currentModule->getUrl($params)."\n\n";
		$message .= $errorType.'! '.$customMessage."\n\n";
		foreach ($backtrace as $backtraceMessage) {
			$message .= '#'.($traceCount - $nr).':'."\t";
			$message .= (isset($backtraceMessage['class']) ? $backtraceMessage['class'].$backtraceMessage['type'].$backtraceMessage['function'] : $backtraceMessage['function']).'('.(isset($backtraceMessage['args']) ? implode(', ', $backtraceMessage['args']) : '').')';
			if (isset($backtraceMessage['file'])) {
				$message .= ' in '.$backtraceMessage['file'].'('.$backtraceMessage['line'].')';
			}
			$message .= "\n";
			$nr++;
		}
		$message .= "\n\n";
		$message .= 'POST Content: '.print_r($_POST, true);
		$mail->setMessage($message);
		$recipients = explode(',', RAKUUN_ERRORMAIL_RECIPIENTS);
		$mail->addRecipients($recipients);
		foreach ($developers as $developer) {
			if (!in_array($developer->mail, $recipients))
				$mail->addRecipient($developer->mail, $developer->nameUncolored);
		}
		$mail->send();
	}
}

?>