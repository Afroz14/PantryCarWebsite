<?php namespace App\Http\Controllers;

use Mail;
class MailerController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public static function sendSuccessfullSignupMail($userData)
	{
		$userEmail =  $userData['emailId'];
		$userName  =  $userData['name'];
        Mail::send('emails.welcome-email', array('username'=>$userName), function($message) use($userEmail,$userName){
            $message->to($userEmail, $userName)->subject('Welcome to PantryCar ');
        });
	}




}
