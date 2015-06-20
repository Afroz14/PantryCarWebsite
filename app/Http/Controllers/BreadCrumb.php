<?php namespace App\Http\Controllers;

use App\Http\Controllers\MailerController as Mailer;
class BreadCrumb extends Controller {


	/**
	 * Create a new controller instance.
	 * Initially all five elements are inactive
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->breadCrumbElements =  array(false,false,false,false,false);
	}

   public function getBreadCrumb($indexSelected){

        $this->breadCrumbElements[$indexSelected] =  true;
        
        $breadCrumbHtml  = '<div class="pc-breadcrumb">';
		$breadCrumbHtml .= '<span class="'.(($this->breadCrumbElements[0])?"active":"").' no-border-left">Journey Details</span>';
		$breadCrumbHtml .= '<span class="'.(($this->breadCrumbElements[1])?"active":"").'" >Choose Station</span>';
		$breadCrumbHtml .= '<span class="'.(($this->breadCrumbElements[2])?"active":"").'" >Choose Restaurant</span>';
		$breadCrumbHtml .= '<span class="'.(($this->breadCrumbElements[3])?"active":"").'" >Choose Food</span>';
		$breadCrumbHtml .= '<span class="'.(($this->breadCrumbElements[4])?"active":"").'" >Choose Checkout</span>';
        $breadCrumbHtml .= '</div>';
        return $breadCrumbHtml;
   }

}
