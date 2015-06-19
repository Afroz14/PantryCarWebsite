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
        Mail::send('emails.welcome-email', array('username'=>$userName), function($message) use($userEmail,$userName){
            $message->to($userEmail, $userName)->subject('Welcome to PantryCar ');
        });
	}

	public static function sendEmailVerificationMail($userData)
	{
		$userEmail		  =  $userData['emailId'];
		$userName  		  =  $userData['name'];
		$verificationToken = $userData['verificationToken'];
		$link 			  =  URL::route('activate-account',$verificationToken);
        Mail::send('emails.confirm-email', array('username'=>$userName,'link' => $link), function($message) use($userEmail,$userName){
            $message->to($userEmail, $userName)->subject('Activate your account ');
        });
	}


}
