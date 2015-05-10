<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Auth\CustomUserProvider;
use App\Http\Controllers\RegisterController;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Auth;
use Illuminate\Auth\GenericUser;
use App\Config\Constants;


class AuthController extends Controller {


  public function login() {

    // Getting all post data
    $data = \Input::all();
    // Applying validation rules.
    $rules = array(
		              'email'    => 'required|email',
		              'password' => 'required|min:6',
	         );
    $validator = \Validator::make($data, $rules);
    if ($validator->fails()){
      
      return \Response::json(array(
        'success' => false,
        'errors' => $validator->getMessageBag()->toArray()
        ), 200);
    }
    else {
         $userData = array(
		                        'email'    => \Input::get('email'),
		                        'password' => \Input::get('password')
		     );
      $rememberMe = empty(\Input::get('remember'))?false:true;
      if (Auth::attempt($userData,$rememberMe)) {
        return \Response::json(['success' => true], 200);
       }

      else
         return \Response::json(['fail' => true], 200);
      }
  }



  public function signup() {
    // Getting all post data
    $data = \Input::all();
    // Applying validation rules.
    $rules = array(
            'email'         => 'required|email',
            'phone-number'  => 'required|min:10',
            'password'      => 'required|min:6|same:cpassword',
            'cpassword'     => 'required|min:6'
       );

    $validator = \Validator::make($data, $rules);
    if ($validator->fails()){
      
      return \Response::json(array(
        'success' => false,
        'errors' => $validator->getMessageBag()->toArray()
        ), 200);
    }
    else {
      $userData = array(
                          'emailId'   => \Input::get('email'),
                          'loginPass' => \Input::get('password'),
                          'contactNo' => \Input::get('phone-number'),
                          'name'      => \Input::get('name'),
      );
      
       $registerController = new RegisterController;
       if ($registerController->store($userData)){
        //Mailer::sendSuccessfullSignupMail($userData);
        return \Response::json(['success' => true], 200);
       }
      else
         return \Response::json(['fail' => true], 200);

    }
  }



  public function facebook_redirect() {
    return \Socialize::with('facebook')->redirect();
  }



  public function google_redirect() {
    return \Socialize::with('google')->redirect();
  }

  
 
  public function facebook() {

    $error = \Input::get("error");
    if(empty($error)){
         $user   = \Socialize::with('facebook')->user();
         list($responseStatus,$errorIfAny) = $this->createOrloginUser($user,"facebook");

         if($responseStatus == true )
            return redirect('/');
         else
            return redirect('/')->with("error_message",$errorIfAny);
             
    }
    else if($error == ACCESS_DENIED){
      return redirect('/')->with("error_message","You denied permission !");
    }
    else{
      return redirect('/')->with("error_message","Error while logging through facebook");
    }
    
  }


  
  public function google() {

    $error = \Input::get("error");
    if(empty($error)){
         $user   = \Socialize::with('google')->user();
         list($responseStatus,$errorIfAny) = $this->createOrloginUser($user,"google");
         if($responseStatus == true )
            return redirect('/');
         else
            return redirect('/')->with("error_message",$errorIfAny);   
    }
    else if($error == ACCESS_DENIED){
      return redirect('/')->with("error_message","You denied permission !");
    }
    else{
      return redirect('/')->with("error_message","Error while logging through facebook");
    }
  }

  public function createOrloginUser($user,$provider){
        
        $email = $user->getEmail();
        $name  = $user->getName();

        if(empty($email))
        {
             return array(false ,"No email id found with your $provider account .");
        }
        else{
            $userProvider = new CustomUserProvider();
            $user = $userProvider->retrieveByID($email);
            if(empty($user)){
               $userdata = array("emailId" => $email,"name" => $name);
               $registerController = new RegisterController;
               if ($registerController->store($userdata)){
                  return array(true,"");
               }
               else{
                   return array(false ,"error_message","Error while signup with you $provider account  .Please try again .");
               }
            }
            else{
                  Auth::login($user);
                  return array(true,"");
            }
            
        }
  }
}