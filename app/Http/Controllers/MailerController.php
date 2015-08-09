<?php namespace App\Http\Controllers;

use Mail;
use URL;

class MailerController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		
	}


	public static function sendSuccessfullSignupMail($userData)
	{
		$userEmail =  $userData['emailId'];
		$userName  =  $userData['name'];
		if(getenv("SEND_EMAIL") == true ) {
			        Mail::send('emails.welcome-email', array('username'=>$userName), function($message) use($userEmail,$userName){
                             $message->to($userEmail, $userName)->subject('Welcome to PantryCar ');
                 });
		}

	}

	public static function sendEmailVerificationMail($userData)
	{
		$userEmail		  =  $userData['emailId'];
		$userName  		  =  $userData['name'];
		$verificationToken = $userData['verificationToken'];
		$link 			  =  URL::route('activate-account',$verificationToken);
		if(getenv("SEND_EMAIL") == true ) {
		        Mail::send('emails.confirm-email', array('username'=>$userName,'link' => $link), function($message) use($userEmail,$userName){
		            $message->to($userEmail, $userName)->subject('Activate your account ');
		        });
      }
	}

	public static function sendPasswordResetEmail($emailId,$resetToken){
        $link 			  =  URL::route('password-reset',$resetToken);
        if(getenv("SEND_EMAIL") == true ) {
		        Mail::send('emails.password', array('username'=>$emailId,'link' => $link), function($message) use($emailId){
		            $message->to($emailId, $emailId)->subject('Password Reset');
		        });
      }

	}


}
