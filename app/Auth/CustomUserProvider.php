<?php namespace App\Auth;

use Illuminate\Contracts\Auth\User as UserContract;
use Illuminate\Contracts\Auth\UserProvider as UserProviderInterface;
use Illuminate\Auth\GenericUser;
use App\Libraries\Curl;
use App\Config\Constants;

class CustomUserProvider implements UserProviderInterface {


    private $curl;

    /**
    * The user object.
    */
    private $user;


    /**
    * Constructor
    *
    * @return void
    */
    public function __construct()
    {
        $this->curl = new Curl;
        if (!empty(\Session::get('user'))) {
           $this->user = unserialize(\Session::get('user'));
         } else {
             $this->user = null;
         }
    }

    /**
    * Retrieves a user by id
    *
    * @param int $identifier
    * @return mixed null|array
    */
    public function retrieveByID($identifier)
    {
        if(!is_null($this->user))
            return $this->user;

        $url       = API_HOST.USER_DETAIL_ROUTE.$identifier."/";
        $this->curl->setOption(CURLOPT_HEADER, true);
        $this->curl->setOption(CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = $this->curl->get($url); 
        $response = (array)json_decode($response);
        if(isset($response['status']) && $response['status'] === false){
            return null;
        }  
        $userArray = array("id" => $response['emailId'],"name" => $response['name'],"contactNo" =>  $response['contactNo']);
        $userObject      = new GenericUser($userArray);
        if (is_null($this->user)) {
             \Session::set('user', serialize($userObject));
          }  
        return $userObject;
    }
    

    /**
    * Tries to find a user based on the credentials passed.
    *
    * @param array $crendtials username|password
    * @return mixed bool|UserInterface
    */
    public function retrieveByCredentials(array $credentials)
    {
        $postParam = array("emailId" =>$credentials['email'],"loginPass" => $credentials['password']);
        $url       = API_HOST.LOGIN_API_ROUTE;
        $this->curl->setOption(CURLOPT_HEADER, true);
        $this->curl->setOption(CURLOPT_HTTPHEADER, array('Content-Type: application/json',"Accept: application/json"));
        $response = $this->curl->post($url, json_encode($postParam));
        $response = (array)json_decode($response);
        if(isset($response['status']) && $response['status'] === false){
            return null;
        } 
        $userArray = array("id" => $response['emailId'],"name" => $response['name']);
        return new GenericUser($userArray);
    }


    /**
    * Validates the credentials passed to the ones in webservice.
    *
    * @param UserInterface $user
    * @param array $credentials
    * @return bool
    */
    public function validateCredentials(\Illuminate\Contracts\Auth\Authenticatable $user, array $credentials)
    {
        $postParam = array("emailId" =>$credentials['email'],"loginPass" => $credentials['password']);
        $url       = API_HOST.LOGIN_API_ROUTE;
        $this->curl->setOption(CURLOPT_HEADER, true);
        $this->curl->setOption(CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = $this->curl->post($url, json_encode($postParam));
        $response = (array)json_decode($response);
        if(isset($response['status']) && $response['status'] === true)
            return true;

        return false;
    }


   /* Needed by Laravel 4.1.26 and above
   */
  public function retrieveByToken($identifier,$token)
  {
        $url       = API_HOST.TOKEN_ROUTE;
        $this->curl->setOption(CURLOPT_HEADER, true);
        $this->curl->setOption(CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = $this->curl->get($url,array("token" => $token));  
        $response = (array)json_decode($response); 
        if(isset($response['status']) && $response['status'] === false)
            return null;
        $userArray = array("id" => $response['emailId'],"name" => $response['name']);
        return new GenericUser($userArray);
  }

  /**
   * Needed by Laravel 4.1.26 and above
   */
  public function updateRememberToken(\Illuminate\Contracts\Auth\Authenticatable $user, $token)
  {
        $url       = API_HOST."/customers/".$user->id."/update_remember_token/";
        $this->curl->setOption(CURLOPT_HEADER, true);
        $this->curl->setOption(CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = $this->curl->put($url,json_encode(array("rememberToken" => $token))); 
  }

    /**
    * Verifiy user account based on the code passed.
    *
    * @param verfication_token
    * @return bool
    */

   public function verifyUserAccount($code){
        $url       = API_HOST.VERIFIY_ACCOUNT_ROUTE;
        $this->curl->setOption(CURLOPT_HEADER, true);
        $this->curl->setOption(CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = $this->curl->put($url,json_encode(array("verificationToken" => $code))); 
        $response = (array)json_decode($response);
        if(isset($response['status']) && $response['status'] === true && isset($response['verified']) && $response['verified'] === true)
          return true;
        return false;
  }

}