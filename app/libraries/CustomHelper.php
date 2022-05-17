<?php
namespace App\libraries;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use App\User;
use App\EmailAction;
use App\EmailTemplate;
use App\Washing_price;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use HTML,Str,Config,DB,Session,Mail,mongoDate,Auth;
use BookingHelper;

// Use the REST API Client to make requests to the Twilio REST API
/*use Twilio\Rest\Client;
require_once "./vendor/twilio/sdk/Twilio/autoload.php"; 
*/

/**
 * Custom Helper
 *
 * Add your methods in the class below
 */
class CustomHelper { 
	
###################################### COMMON CUSTOM FUNCTIONS START HERE ###############################################	
	public static function sanitize(){
		$input = $this->all();
		if (preg_match("#https?://#", $input['url']) === 0) {
			$input['url'] = 'http://'.$input['url'];
		}
		$input['name'] = filter_var($input['name'], FILTER_SANITIZE_STRING);
		$input['description'] = filter_var($input['description'], 
		FILTER_SANITIZE_STRING);

		$this->replace($input);     
	}
	
	/**
	 * Function for global xss clean
	 *
	 * @param null
	 *
	 * @return array. 
	 */		
	public static function globalXssClean() {		
		// Recursive cleaning for array [] inputs, not just strings.
		$sanitized = static::arrayStripTags(Input::get());
		Input::merge($sanitized);
	}// end globalXssClean()
	
	/**
	 * Function for strip and trime data
	 *
	 * @param array
	 *
	 * @return array. 
	 */	
	public static function arrayStripTags($array){
		$result = array();
	
		foreach ($array as $key => $value) {
			// Don't allow tags on key either, maybe useful for dynamic forms.
			$key = strip_tags($key,ALLOWED_TAGS_XSS);
	 
			// If the value is an array, we will just recurse back into the
			// function to keep stripping the tags out of the array,
			// otherwise we will set the stripped value.
			if (is_array($value)) {
				$result[$key] = static::arrayStripTags($value);
			} else {
			
				// I am using strip_tags(), you may use htmlentities(),
				// also I am doing trim() here, you may remove it, if you wish.
				$value	=	trim($value);
				$value  = preg_replace( "#(^(&nbsp;|\s)+|(&nbsp;|\s)+$)#", "", $value );
			
				if(Request::segment(1) != 'admin'){
					$result[$key] = trim(strip_tags($value,str_replace('<iframe>','',ALLOWED_TAGS_XSS)));
				}else{
					$result[$key] = trim(strip_tags($value,ALLOWED_TAGS_XSS));
				}
			}
		}	 
		return $result;
	}// end arrayStripTags()



	public static function displayAlert()
{
      if (Session::has('message'))
      {
         list($type, $message) = explode('|', Session::get('message'));

         $type = $type == 'error' ?: 'danger';
         $type = $type == 'message' ?: 'info';

         return sprintf('<div class="alert alert-%s">%s</div>', $type, $message);
      }

      return '';
}
	
	/**
	* Function for strip tags
	*
	* null
	* 
	* @return number . 
	*/
	public static function htmlentities($string){
		$string		=	strip_tags($string);
		return $string;
	}//end htmlentities()

	/**
     * Upload the banner image, create a thumb as well
     *
     * @param        $file
     * @param string $path
     * @param array  $size
     * @return string|void
     */
    public static function uploadImage(
        UploadedFile $file, $path = '', $size = ['o' => [1024, 1024], 'tn' => [255, 255]]
    ) {
        $name = token();

        $extension = $file->getClientOriginalExtension();


        $filename = $name . '.' . $extension;
        $filenameThumb = $name . '-tn.' . $extension;
        $imageTmp = Image::make($file->getRealPath());
        if (!$imageTmp) {
            return notify()->error('Oops', 'Something went wrong', 'warning shake animated');
        }
        if(empty($path)){
        	$path = upload_path_images();
        }

        // original
        $imageTmp->save($path . $name . '-o.' . $extension);

        // save the image
        $image = $imageTmp->fit($size['o'][0], $size['o'][1])->save($path . $filename);

        $image->fit($size['tn'][0], $size['tn'][1])->save($path . $filenameThumb);

        return $filename;
    }
	
   /**
	* Function for number format
	*
	* $number as price to be formatted
	* 
	* @return formated number . 
	*/	
	public static function  numberFormat($number =''){
		$result='';
		if(is_numeric($number)){
		 	$result		=	number_format($number,2);
		}		
		return $result;		
	}//end numberFormat() 
	
	/**
	 * display time ago
	 * 
	 * return time
	 */
	public static function time_elapsed_string($datetime, $full = false) {
		$now = new \DateTime;
		$ago = new \DateTime($datetime);
		$diff = $now->diff($ago);
		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;
		$string = array(
			 'y' => 'year',
			 'm' => 'month',
			 'w' => 'week',
			 'd' => 'day',
			 'h' => 'hour',
			 'i' => 'minute',
			 's' => 'second',
		 );
		 foreach ($string as $k => &$v) {
			 if ($diff->$k) {
				 $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			 } else {
				 unset($string[$k]);
			 }
		 }
		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}	


	/** 
	 * Function to send email form website
	 *
	 * @param string $to             as reciver email address
	 * @param string $toName      	 as full name of receiver
	 * @param array $rep_Array       as array of constant values
	 * @param string $action  		 as action name
	 * @param array $attributes   	 as passed attributes if any like(subject,from,fromName,files,path,attachmentName), default blank
	 * @return void
	 * */
	
	/*public static function callSendMail($to, $toName, $rep_Array, $action, $attributes = array()) {
		$modelEmailAction	= 'App\Model\EmailAction';
		$modelEmailTemplate	= 'App\Model\EmailTemplate';
	    echo '<pre>';
		$emailActions		= $modelEmailAction::where('action','=',$action)->get()->toArray();
		print_r($emailActions);
		die;
        $emailTemplates		= $modelEmailTemplate::where('action','=',$action)->get(array('name','subject','action','body'))->toArray();
		
		$cons 			= explode(',',$emailActions[0]['options']);
		$constants 		= array();
		
		foreach($cons as $key => $val){
			$constants[] = '{'.$val.'}';
		} 
		
		//replace constant by values
		$messageBody	= str_replace($constants, $rep_Array, $emailTemplates[0]['body']);
		
		//set attributes if any
		$subject 		= (isset($attributes['subject']) && !empty($attributes['subject'])) ? $attributes['subject'] : $emailTemplates[0]['subject'];
		$from			=	(isset($attributes['from']) && !empty($attributes['from'])) ? $attributes['from'] : Config::get('Site.email');
		$fromName		=	(isset($attributes['fromName']) && !empty($attributes['fromName'])) ? $attributes['fromName'] : Config::get('Site.name_display_in_emails');
		
		$files			=	(isset($attributes['files']) && !empty($attributes['files'])) ? $attributes['files'] : false;
		$path			=	(isset($attributes['path']) && !empty($attributes['path'])) ? $attributes['path'] : '';
		$attachmentName	=	(isset($attributes['attachmentName']) && !empty($attributes['attachmentName'])) ? $attributes['attachmentName'] : '';
		
		self::sendMail($to, $toName, $subject, $messageBody, $from, $fromName,   $files, $path, $attachmentName); 
    }*/
	//end callSendMail()
   
	/** 
	 * Function to send email form website
	 *
	 * @param string $to             as reciver email address
	 * @param string $toName      	 as full name of receiver
	 * @param string $subject      	 as subject
	 * @param array $messageBody  	 as message body
	 * @param string $from   		 as sender email address
	 * @param string $fromName  	 as full name of sender
	 * @param boolen $files   		 as true if mail have any file attachment, default false
	 * @param string $path   		 as file path
	 * @param string $attachmentName as attached file Name
	 *
	 * @return void
	 * */
	
	/*public static function sendMail($to, $toName, $subject, $messageBody, $from = '', $fromName = '', $files = false, $path='', $attachmentName='') {
		$data				=	array();
		$data['to']			=	$to;
		$data['fullName']	=	$toName;
		$data['fromName']	=	!empty($fromName) ? $fromName : Config::get('Site.name_display_in_emails');
		$data['from']		=	!empty($from) ? $from : Config::get('Site.email');
		$data['subject']	=	$subject;
		
		$data['filepath']		=	$path;
		$data['attachmentName']	=	$attachmentName;
		
		if($files===false){
			Mail::send('emails.template', array('messageBody' => $messageBody), function($message) use ($data) {
                $message->to($data['to'], $data['fullName'])->from($data['from'], $data['fromName'])->subject($data['subject']);
            });
		}else{
			if($attachmentName!=''){
				Mail::send('emails.template', array('messageBody'=> $messageBody), function($message) use ($data){
					$message->to($data['to'], $data['fullName'])->from($data['from'], $data['fromName'])->subject($data['subject'])->attach($data['filepath'],array('as'=>$data['attachmentName']));
				});
			}else{
				Mail::send('emails.template', array('messageBody'=> $messageBody), function($message) use ($data){
					$message->to($data['to'], $data['fullName'])->from($data['from'], $data['fromName'])->subject($data['subject'])->attach($data['filepath']);
				});
			}
		}
		
		DB::table('email_logs')->insert(
			array(
				'email_to'	 => $data['to'],
				'email_from' => $data['from'],
				'subject'	 => $data['subject'],
				'message'	 =>	$messageBody,
				'created_at' => new \MongoDB\BSON\UTCDateTime()
			)
		); 
	}//end sendMail()
	*/
 
	
	/**
	 * Function for encoding url manually
	 *
	 * @param null
	 *
	 * @return $universityList
	 */
	public static function manual_url_encode($string){
		$string = str_ireplace('+','%2B',$string);
		$string = str_ireplace('=','%3D',$string);
		return $string;
	}//end manual_url_encode();	
	
	
	/**
	 * 	Function for encryption url id
	 *
	 *  @param $id as Id
	 *
	 * 	@return $sResult
	 */	
	public static function encryption($id = null){
		$sKey	 =	Config::get('UrlEncoding.key');
		$sResult =	'';
		for($i = 0; $i < strlen($id); $i ++){
			$sChar    = substr($id, $i, 1);
			$sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
			$sChar    = chr(ord($sChar) + ord($sKeyChar));
			$sResult .= $sChar;
		}
		return  base64_encode($sResult);
	}//end encryption()
		
	/**
	 * 	Function for decription url id
	 *
	 *  @param $id as ID
	 *
	 * 	@return $sResult
	 */	
	public static function decription($id = null){
		$sKey	 =	Config::get('UrlEncoding.key');
		$sResult = '';
		$sData   = base64_decode($id);
		for($i = 0; $i < strlen($sData); $i ++){
			$sChar    = substr($sData, $i, 1);
			$sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
			$sChar    = chr(ord($sChar) - ord($sKeyChar));
			$sResult .= $sChar;
		}
		return $sResult;
	}//end decription()	
	
	/**
	 * Method for finding drop down category name;
	 *
	 * @param dropdown category ids
	 *
	 * @return category names.
	 */
	public static function dropdownCategoryName($dropdownids){
		
		$ids = explode(',', $dropdownids);
		$categoryName = DropDown::whereIn('id', $ids)->lists('name')->toArray();

		return $categoryName;
	}

	/**
	* Function for get user role
	*
	* $userId As User Id
	* 
	* @return number . 
	*/
	public static function getUserRole($userId){
		$userRole			=	User::where('id',$userId)->pluck('user_role_id');
		return $userRole;
	}// end getUserRole()

	
	
	/**
	* Function for get master dropdown
	*
	* @param $drop_down as dropdown type 
	* 
	* @return number. 
	*/
	public static function getMasterDropdown($drop_down,$from){
		$DB = DropDown::where('dropdown_type', $drop_down)->where('status',ACTIVE)->orderby('name','ASC');
		if($from == "api"){
			$master = $DB->select('id as value','name as label')->get()->toArray();
		}else{
			$master = $DB->pluck('name','id')->toArray();
		}
		return $master;
	}//end getMasterDropdown()
	
	/**
	 * Function for get config value
	 * @param $config as constant name
	 * @return array
	 */
	public static function getConfigValue($config){
		return Config::get($config);
	}//end getConfigValue()
	
	/**
	 * CustomHelper::convert_date_to_timestamp()
	 * @Description Function  to get timestamp value of any date
	 * @param $date date
	 * @return timestamp
	 * */
	public static function convert_date_to_timestamp($date = null) {
		return strtotime($date);
	}//end convert_date_to_timestamp()
	
	/**
	 * CustomHelper::get_country_name()
	 * @Description Function  to get country name
	 * @param $country_id
	 * @return $country_name
	 * */
	public static function get_country_name($country_id = null) {
		$country = Country::where('_id', $country_id)->pluck('country_name','_id')->toArray();
		return $country[$country_id];
	}//get_country_name()
	
	/**
	 * CustomHelper::get_state_name()
	 * @Description Function  to get state name
	 * @param $state_id
	 * @return $state_name
	 * */
	public static function get_state_name($state_id = null){
		$state = State::where('_id', $state_id)->pluck('state_name','_id')->toArray();
		return $state[$state_id];
	}//get_state_name()
	
	/**
	 * CustomHelper::get_city_name()
	 * @Description Function  to get city name
	 * @param $city_id
	 * @return $city_name
	 * */
	public static function get_city_name($city_id = null){
		$city = City::where('_id', $city_id)->pluck('city_name','_id')->toArray();
		return $city[$city_id];
	}//get_city_name()
	
	/**
	 * CustomHelper::get_category_name()
	 * @Description Function  to get category name
	 * @param $category_id
	 * @return $category_name
	 * */
	public static function get_category_name($category_id = null){
		$category = ProductCategory::where('_id', $category_id)->pluck('category_name','_id')->toArray();
		return $category[$category_id];
	}//end get_category_name()
	
	/* @description to show images on website
	* @param 	   $root_path ,
	* @param 	   $http_path,
	* @param 	   $image_name,
	* @param 	   $attribute all attributes of image like(height,width, class),
	* @return 	   image url
	* */

	public static function showImage($root_path='', $http_path='', $image_name='', $type='', $attribute=array()) {
		// $alt = Configure::read('CONFIG_SITE_TITLE');
		$alt = trans("messages.custom.image");
		$height = '';
		$width = '';
		$class = '';
		$link_url = '';
		$zc = '0';
		$ct = '0';
		$cropratio = '';
		$img_id_val = '';
		if (isset($attribute['alt']) && $attribute['alt'] != '') {
			$alt = $attribute['alt'];
		}
		if (isset($attribute['id']) && $attribute['id'] != '') {
			$img_id_val = $attribute['id'];
		}

		if (isset($attribute['height']) && $attribute['height'] != '') {
			$height = $attribute['height'] . 'px';
		}

		if (isset($attribute['width']) && $attribute['width'] != '') {
			$width = $attribute['width'] . 'px';
		}
		if (isset($attribute['class']) && $attribute['class'] != '') {

			$class = $attribute['class'];
		}

		if (isset($attribute['url']) && $attribute['url'] != '') {

			$link_url = $attribute['url'];
		}

		// override Default zoom/crop setting of img.php file .

		if (isset($attribute['zc']) && $attribute['zc'] != '') {

			$zc = $attribute['zc'];
		}

		if (isset($attribute['ct']) && $attribute['ct'] != '') {

			$ct = $attribute['ct'];
		}

		if (isset($attribute['type']) && $attribute['type'] != '') {

			$type = $attribute['type'];
		}

		if (isset($attribute['cropratio']) && $attribute['cropratio'] != '') {

			$cropratio = $attribute['cropratio'];
		}

		if (file_exists($root_path . $image_name) && !empty($image_name)) {
			$url = WEBSITE_IMG_FILE_URL . '?image=' . $http_path . $image_name . '&amp;height=' . $height . '&amp;width=' . $width . '&amp;zc=' . $zc . '&amp;ct=' . $ct.'&amp;cropratio='.$cropratio;
			$html = HTML::image($url, $alt, array( 'class'=>$class ));
			return  $html;
		}else{
			
			if($type == USER_TYPE_IMAGE){
				$url 	= WEBSITE_IMG_FILE_URL . '?image=' . WEBSITE_IMG_URL.'admin/no-user-image.png' . '&amp;height=' . $height . '&amp;width=' . $width . '&amp;zc=' . $zc . '&amp;ct=' . $ct.'&amp;cropratio='.$cropratio;
				$html 	= HTML::image($url, $alt, array( 'width' => $width, 'height' => $height,'class'=>$class ));
				return  $html;
			}else{
				$url 	= WEBSITE_IMG_FILE_URL . '?image=' . WEBSITE_IMG_URL.'admin/no_image_available.jpeg' . '&amp;height=' . $height . '&amp;width=' . $width . '&amp;zc=' . $zc . '&amp;ct=' . $ct.'&amp;cropratio='.$cropratio;
				$html 	= HTML::image($url, $alt, array( 'width' => $width, 'height' => $height,'class'=>$class ));
				return  $html;
			}
		}
		
	}//end showImage()
	
	/**
     * Function to send message through twilio API
     *
     * @param string $mobile_no     as mobile number
     * @param string $msg           as message to be send
     *
     * @return void
     */
    public static function _SendSms($receiverNumber = null, $message = null) {
        $response = array();

        //$receiverNumber = "+919352351087";

		$response['message'] 	=	$message;
		$response['status'] 	=	'error';

		// try {
		//     $account_sid 	= getenv("TWILIO_SID");
		//     $auth_token 	= getenv("TWILIO_TOKEN");
		//     $twilio_number 	= getenv("TWILIO_NUMBER");

		//     $client = new \Twilio\Rest\Client($account_sid, $auth_token);
		//     $client->messages->create($receiverNumber, [
		//         'from' => $twilio_number, 
		//         'body' => $message]);

		// 	$response['status'] 	= 'success';
		// } catch (Exception $e) {
		//     //dd("Error: ". $e->getMessage());
		// 	$response['message'] 	= $e->getMessage();
		// }


		$data =array(
			"apikey"=> env('APIKEY_OF_MOBILE_MESSAGE'),
			"senderid" => env('SENDERID_OF_MOBILE_MESSAGE'),
			"number" => $receiverNumber,
			"message"=> $message,
			"format"=> "json"
		);
		// dd($data);
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => "http://msg.mtalkz.com/V2/http-api-post.php",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => json_encode($data),

		));
		$responseVal = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			$response['message'] 	= $err;
		} else {

			$response['status'] 	= 'success';
		}
        $obj 					= new \App\SmsLog();
        $obj->to_mobile_number 	= $receiverNumber;
        $obj->message 			= $response['message'];
        $obj->status 			= $response['status'];
        $obj->save();

        return $response;
    }//end _SendSms()

    /**
     * Function to send otp through twilio API
     *
     * @param string $action     	as sms_action
     * @param string $mobile_no     as mobile number
     * @param string $OTP           as OTP
     *
     * @return void
     */
    public static function _SendOtp($mobile_no, $OTP) {
        $sms_template 	= "Dear Customer, Your OTP is {OTP} for availing Bubblebath services - Bubblebath Mobile Car Spa Pvt Ltd";
        $sms_template 	= str_replace(array('{OTP}'), array($OTP), $sms_template);
        $res = CustomHelper::_SendSms($mobile_no, $sms_template);
        // dd($res);
    }//end _SendOtp()

    /**
     * Function to send message on mobile through twilio API
     *
     * @param string $mobile_no     as mobile number
     * @param string $msg           as message to be send
     *
     * @return void
     */
    public static function _SendMessageOnMobile( $mobile_no, $message) {
        $sms_template = "Dear Customer, Your OTP is {#var#} for availing Bubblebath services - Bubblebath Mobile Car Spa Pvt Ltd";
        $sms_template = str_replace(array('{MESSAGE}'), array($message), $sms_template['sms_text']);
        $res = CustomHelper::_SendSms($mobile_no, $sms_template);
    }//end _SendMessageOnMobile()
    
   
	
	############################################# New Functions ####################################################
	 /**
	 * Function for unique otp varification code
	 * 
	 * @param null
	 * 
	 * return verification_code
	 */
	 public static function generateVerificationCode(){
		$digits = OTP_CHARACTER_LIMIT;
		$verification_code	=	rand(pow(10, $digits-1), pow(10, $digits)-1);
		return $verification_code;
		// return 1234;
	}// end generate_verification_code()
	
	/**
	 * CustomHelper::getUserEmail()
	 * @Description Function  to get success story
	 * @param 
	 * */
	public static function getUsersList($conditions = [],$attr){
		$result 	=	[];
		$DB 		= 	User::where($conditions);
		if(isset($attr['type']) && !empty($attr['type'])){
			if($attr['type'] == "pluck"){
				$result = $DB->pluck('email', 'id')->toArray();
			}else if($attr['type'] == "first"){
				$result = $DB->first();
			}
		}else{
			if(isset($attr['select']) && !empty($attr['select'])){
				$result = $DB->select($attr['select'])->get();
			}else{
				$result = $DB->get();
			}
		}
		return $result;
	}//end getUserEmail()
	
	
	
	/**
	 *  Function to Converts a price value given with Symbol
	 *
	 * @param int $price
	 * @return price
	 */
	
	public static function display_price($price = null) {
		// $currency	   = Currency::where('is_base',ACTIVE)->first();
		//$site_currency = $currency['symbol'];
		$site_currency = "₹";
		return $currency_symbol = $site_currency.' '.number_format($price, 2);
	}
		/**
	 *  Function to Converts a price value given with Symbol
	 *
	 * @param int $price
	 * @return price
	 */
	
	public static function price_symbol() {
		// $currency	   = Currency::where('is_base',ACTIVE)->first();
		//$site_currency = $currency['symbol'];
		$site_currency = "₹";
		return $currency_symbol = $site_currency;
	}
	
	/**
	 *  Function to Converts a price value given with Symbol
	 *
	 * @param int $price
	 * @return price
	 */
	
	public static function get_price($price = null) {
		// return number_format($price, 2);
		return $price;
	}
	// end display_price method



###################################### FRONT CUSTOM FUNCTIONS START HERE ###############################################
	

	
	/**
	 * CustomHelper::get_block()
	 * 
	 * @Description Function  to get block
	 * 
	 * @param null
	 * */
	public static function get_block($slug	= NULL){
		$blocks = Block::where('block', $slug)->pluck('description')->first();
		return $blocks;
	}//end get_block()
	
	/**
	 * CustomHelper::getLoginUserData()
	 * 
	 * @Description Function  to get login user data
	 * 
	 * @param null
	 * */
	public static function getLoginUserData($userId = '') {
		$userData = User::where('_id',$userId)->first()->toArray();
		return $userData;
	}//end getLoginUserData
	

	/**
	 * CustomHelper::getCityList()
	 * @Description Function  to get city name and id
	 * @param $countryId , $stateId
	 * @return $city_list
	 **/
	public static function getCityList($countryId = null, $stateId = null,$type=null){
		$cityList	=	array();
		if($type == 'api'){
			$cityList 	= 	City::where('country_id',$countryId)
							->where('state_id',$stateId)
							->where('status',ACTIVE)
							->orderBy('city_name','ASC')
							->select('id as value','city_name as label')->get()->toArray();
		}else{
			$cityList 	= 	City::where('country_id',$countryId)
							->where('state_id',$stateId)
							->where('status',ACTIVE)
							->orderBy('city_name','ASC')
							->pluck('city_name','id')->toArray();
		}
		
		return $cityList;
	}//end getCityList()
	
	/**
	 * CustomHelper::getStateList()
	 * @Description Function  to get State name and id
	 * @param $countryId
	 * @return $stateList
	 **/
	public static function getStateList($countryId = null,$type=null){
		$stateList	=	array();
		if($type	==	'api'){
			$stateList 		= 	State::where('status',ACTIVE)
								->where('country_id','=',$countryId)
								->orderBy('state_name','ASC')
								->select('id as value','state_name as label')->get()->toArray();
		}else{
			$stateList 		= 	State::where('status',ACTIVE)
								->where('country_id','=',$countryId)
								->orderBy('state_name','ASC')
								->pluck('state_name','id')->toArray();
		}
		return $stateList;
	}//end getStateList()
	
	/**
	 * CustomHelper::getCountryList()
	 * @Description Function  to get Country name and id
	 * @param null
	 * @return $countryList
	 **/
	public static function getCountryList($type=null){
		$countryList	=	array();
		if($type	==	'api'){
			$countryList 	= 	Country::where('status',ACTIVE)
								->orderBy('country_name','ASC')
								->select('id as value','country_name as label')->get()->toArray();
		}else{
			$countryList 	= 	Country::where('status',ACTIVE)
								->orderBy('country_name','ASC')
								->pluck('country_name','id')->toArray();
		}
		return $countryList;
	}//end getCountryList()

	
	/**
	 * CustomHelper::getFieldValueByFieldName()
	 * @Description Function  to get field name by field value
	 * @param $value
	 * @param $fieldName as field name by which value is to be find
	 * @param $model
	 * @param $field as field name of which value is to be find
	 * @return id
	* */
	public static function getFieldValueByFieldName($value=null,$fieldName=null,$model=null,$field=null){
		$result		=	'';
		if(!empty($value) && !empty($model) && !empty($fieldName) && !empty($field)){
			$Model		=	"\App\Model\\$model";
			$result 	= 	$Model::where($fieldName,$value)->pluck($field)->first();
		}
		return $result;
	}//end getFieldValueByFieldName
	

	
	/**
	 * CustomHelper::getSlug()
	 * @Description Function  to get slug
	 * @param $title as slug value
	 * @param $fieldName as database field to get slug
	 * @param $modelName as database model
	 * @param $limit as slug character limit
	 * @return slug
	 **/
	public static function getSlug($title, $fieldName,$modelName,$limit = 30){
		$slug 		= 	 substr(Str::slug($title),0 ,$limit);
		$Model		=	"\App\Models\\$modelName";

		if($modelName == "User"){
			$Model		=	"\App\\$modelName";
		}
		$slugCount 	=  count($Model::where($fieldName, 'regexp', "/^{$slug}(-[0-9]*)?$/i")->get());
		return ($slugCount > 0) ? $slug."-".$slugCount : $slug;
	}//end getSlug()
	
	
	/**
	 * CustomHelper::randomPassword()
	 * 
	 * @Description Function  user to genrate password
	 * 
	 * @param $length
	 * 
	 * */
	public static function randomPassword($length) {
		$len = $length;

		//define character libraries - remove ambiguous characters like iIl|1 0oO
		$sets = array();
		$sets[] = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
		$sets[] = '123456789';
		$sets[] = '~!@#$%^&*';

		$password = '';
		
		//append a character from each set - gets first 4 characters
		foreach ($sets as $set) {
			$password .= $set[array_rand(str_split($set))];
		}

		//use all characters to fill up to $len
		while(strlen($password) < $len) {
			//get a random set
			$randomSet = $sets[array_rand($sets)];
			
			//add a random char from the random set
			$password .= $randomSet[array_rand(str_split($randomSet))]; 
		}
		
		//shuffle the password string before returning!
		$res		= str_shuffle($password); 
     
		return $res; // return the generated password
	}//end randomPassword()
	
 	/*
     * Function to save notification and activity logs
     *
     * @param $tyep as
     *
     * @return null
    * */
    public static function saveNotificationActivity($rep_Array, $action, $user_id = 0,$otherPrams=null){

        $notification_template = \App\NotificationTemplate::where('action', $action)->first();

        if (!empty($notification_template)) {
            $notification_template  = $notification_template->toArray();

            $template_action        = $notification_template['action'];

            $notification_action    = \App\Notifications_Action::where('action', $template_action)->first();

            $cons       = explode(',',$notification_action->option);

            $constants  = array();

            foreach ($cons as $key => $val) {
                $constants[] = '{' . $val . '}';
            }
            $message = str_replace($constants, $rep_Array, $notification_template['body']);
            $notificationData                       = new \App\Notifications;
            $notificationData->user_id              = $user_id;
            $notificationData->notification         = $message;
            $notificationData->title         		= $notification_template['subject'];
            $notificationData->action         		= $template_action;
            $notificationData->is_read              = Config::get('app.NOT_READ');
            $notificationData->other_params         = $otherPrams;

            $userDetails 	=	\App\User::where('id',$user_id)->first();
            if(isset($userDetails) && !empty($userDetails)){
            	if($userDetails->is_pn_allow == 1){
            		$notificationData->save();
            		self::sendPushNotification($notification_template['subject'],$message,$notificationData->id,$user_id);
            	}
            }
            
        }   
    }//end saveNotificationActivity()


    /*
     * Function to send Push Notification
     *
     * @param $itemDetails as item detail
     *
     * @return Count
     * */
	public static function sendPushNotification($title="",$message="",$notificationId="",$user_id=""){

		$firebaseTokens     =   \App\NotificationTokens::where('user_id',$user_id)
                                ->pluck('notification_token')
                                ->toArray();

        $SERVER_API_KEY 	= 	Config::get('app.SERVER_KEY');
        // $data = [
        //     "registration_ids" => $firebaseTokens,
        //     "notification" => [
        //         "title" => $title,
        //         "body" 	=> strip_tags($message),  
        //     ]
        // ];


        $notification = [
            "title" => $title,
            "body" 	=> strip_tags($message), 
            'icon' =>'myIcon', 
            'sound' => 'mySound'
        ];

        $extraNotificationData = ["message" => $notification,"notification_id" =>$notificationId];

        $data = [
            //"to" => $firebaseTokens,//single token 
            'registration_ids' 	=> $firebaseTokens, //multple token array
            'notification' 		=> $notification,
            'data' 				=> $extraNotificationData
        ];


        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
  
        return $response;
	}
	
	/*
     * Function to get notification count
     *
     * @param $user_id as user_id
     *
     * @return number
     * */
	public static function getNotificationCount($user_id){
		$notification_count=	0;
		if(!empty($user_id)){
			$notification_count	=	\App\Notification::where('user_id',$user_id)->where('is_read',Config::get('app.NOT_READ'))->count();
		}
		return $notification_count;
	}//end getNotificationCount()
	
	/*
     * Function to get letest notifications
     *
     * @param $user_id as user_id
     *
     * @return array
     * */
	public static function getLetestNotifications($user_id){
		$notifications=	0;
		if(!empty($user_id)){
			$sortBy	=	'created_at';
			$order 	=	'DESC';
			$limit	=	5;	
			$notifications	=	Notification::where('user_id',$user_id)->orderBy($sortBy, $order)->limit((int)$limit)->get()->toArray();;
		}
		return $notifications;
	}//end getLetestNotifications()
	
	/*
     * Function to get notification of user
     *
     * @param $attribute as array
     *
     * @return array
     * */
	public static function getMyNotifications($attribute){
		$notifications=	array();
		if(!empty($attribute)){
			$sortBy	=	isset($attribute['sortBy'])?$attribute['sortBy']:'created_at';
			$order	=	isset($attribute['order'])?$attribute['order']:'DESC';
			$user	=	isset($attribute['user'])?$attribute['user']:array();
			$recordPerPage	=	isset($attribute['recordPerPage'])?$attribute['recordPerPage']:Config::get("Reading.records_per_page");
			$page_number	=	isset($attribute['page_number'])?$attribute['page_number']:ACTIVE;
			$thisData		=	Input::all();
			if(isset($thisData['page'])){
				$page_number	=	$thisData['page'];
			}
			
			$notifications	=	array();
			if(!empty($user)){
				$notifications		= Notification::where('user_id',$attribute['user']['_id'])->orderBy($sortBy, $order)->paginate((int)$recordPerPage,['*'],'page',$page_number);
			}
		}
		return $notifications;
	}//end getMyNotifications()
	
	/*
     * Function to mark notification as read
     *
     * @param $attribute as array
     *
     * @return array
     * */
	public static function markNotificationAsRead($attribute){
		$response	=	array();
		$status		=	'error';
		$msg		=	trans('front_messages.INVALID_ACCESS');
		if(!empty($attribute)){
			$formData	=	isset($attribute['formData'])?$attribute['formData']:array();
			$user		=	isset($attribute['user'])?$attribute['user']:array();
			if(!empty($formData) && !empty($user)){
				$notification	=	Notification::where('_id',$formData['notification_id'])->where('user_id',$user['_id'])->first();
				if(!empty($notification)){
					$notification->is_read	=	ACTIVE;
					$notification->save();
					$status	=	'success';
					$msg	=	trans('front_messages.notification_mark_as_read_success');
				}
			}
		}
		$response['status']		=	$status;
		$response['message']	=	$msg;
		return $response;
	}//end markNotificationAsRead()
	

	/*
     * Function to get review Count
     *
     * @param $itemDetails as item detail
     *
     * @return Count
     * */
	public static function reviewCount($productId){
		$TotalReviewCount	=	'';
		if(!empty($productId)){
			$TotalReviewCount	= ProductRating::where('product_id',$productId)->where('active',ACTIVE)->where('is_deleted',INACTIVE)->count();
		}
		return $TotalReviewCount;
	}//end reviewCount()

	/*
     * Function to get current time
     *
     * @param null
     *
     * @return timestamp
     * */
	public static function getCurrentTime(){
		return time();
	}//end getCurrentTime()
	
	/*
     * Function to get rating image
     * @param $rating	=	rating
     * @return image
     * */
	public static function getRatingStars($rating){
		switch ($rating) {
			case '0':
				$result =  HTML::image(WEBSITE_IMG_URL.'unfield-star.png', 'rating_zero');
			break;
			case '0.5':
				$result =  HTML::image(WEBSITE_IMG_URL.'rating_half.png', 'rating_half');
			break;
			case '1':
				$result =  HTML::image(WEBSITE_IMG_URL.'rating_one.png', 'rating_one');
			break;
			case '1.5':
				$result = HTML::image(WEBSITE_IMG_URL.'rating_one_half.png', 'rating_one_half');
			break;
			case '2':
				$result = HTML::image(WEBSITE_IMG_URL.'rating_two.png', 'rating_two');
			break;
			case '2.5':
				$result = HTML::image(WEBSITE_IMG_URL.'rating_two_half.png', 'rating_two_half');
			break;
			case '3':
				$result = HTML::image(WEBSITE_IMG_URL.'rating_three.png', 'rating_three');
			break;
			case '3.5':
				$result =  HTML::image(WEBSITE_IMG_URL.'rating_three_half.png', 'rating_three_half'); 
			break;
			case '4':
				$result = HTML::image(WEBSITE_IMG_URL.'rating_four.png', 'rating_four'); 
			break;
			case '4.5':
				$result = HTML::image(WEBSITE_IMG_URL.'rating_four_half.png', 'rating_four_half');  
			break;
			case '5':
				$result =  HTML::image(WEBSITE_IMG_URL.'rating_five.png', 'rating_five'); 
			break;
			case  'default':
				$result =  HTML::image(WEBSITE_IMG_URL.'rating.png', 'rating'); 
			break;
		}
		return $result;
	}//end getRatingStars()
	
	/*
     * Function to get avg Review Rating
     *
     * @param $productId as product id
     *
     * @return avg
     * */
	public static function getAvgReviewRating($productId){
		$avgrating				 	= 	array();
		$productRating				=	ProductRating::where('product_id',$productId)->where('is_deleted',INACTIVE)->get();
		$avgRating					=	ceil($productRating->avg('rating'));	
		$totalReview				=	$productRating->count();	
		$avgrating['avg_rating']	=	$avgRating;
		$avgrating['total_review']	=	$totalReview.' Review';
		return $avgrating;
	}//end getAvgReviewRating()
	
	/*
     * Function to get get Day Start End Time
     *
     * @param null
     *
     * @return array
     * */
	public static function getDayStartEndTime(){
		$time						=	self::getCurrentTime();
		$startEndTime['startTime']	=	date('Y-m-d 00:00:00',$time);
		$startEndTime['endTime']	=	date('Y-m-d 23:59:59',$time);
		return $startEndTime;
	}//end getDayStartEndTime()
	

	public static function callSendMail($to, $toName, $rep_Array, $action, $attributes = array()) {
		
		$emailActions	= EmailAction::where('action','=',$action)->get()->toArray();
        $emailTemplates	= EmailTemplate::where('action','=',$action)->get(array('name','subject','action','body'))->toArray();
      
		$cons 			= explode(',',$emailActions[0]['option']);
		
		$constants 		= array();
		
		foreach($cons as $key => $val){
			$constants[] = '{'.$val.'}';
		} 

		//replace constant by values
		$messageBody	= str_replace($constants, $rep_Array, $emailTemplates[0]['body']);
		//set attributes if any
		$subject 		= (isset($attributes['subject']) && !empty($attributes['subject'])) ? $attributes['subject'] : $emailTemplates[0]['subject'];
		//Send Email Of Outside User
		$from			=	(isset($attributes['from']) && !empty($attributes['from'])) ? $attributes['from'] : Session::get('titan.settings.email');
	
		
		$fromName		=	(isset($attributes['fromName']) && !empty($attributes['fromName'])) ? $attributes['fromName'] : Session::get('titan.settings.name');
		
		$files			=	(isset($attributes['files']) && !empty($attributes['files'])) ? $attributes['files'] : false;
		$path			=	(isset($attributes['path']) && !empty($attributes['path'])) ? $attributes['path'] : '';
		$attachmentName	=	(isset($attributes['attachmentName']) && !empty($attributes['attachmentName'])) ? $attributes['attachmentName'] : '';
		
		$userId			=	(isset($attributes['user_id']) && !empty($attributes['user_id'])) ? $attributes['user_id'] : '';

		if(isset($userId) && !empty($userId)){
			$userDetails 	=	\App\User::where('id',$userId)->first();
	        if(isset($userDetails) && !empty($userDetails)){
	        	if($userDetails->is_pn_allow == 1){
					self::sendMail($to, $toName, $subject, $messageBody, $from, $fromName,$files, $path, $attachmentName); 
	        	}
	        }
		}else{
			self::sendMail($to, $toName, $subject, $messageBody, $from, $fromName,$files, $path, $attachmentName); 
		}

    }//end callSendMail()
    
	/** 
	 * Function to send email form website
	 *
	 * @param string $to             as reciver email address
	 * @param string $toName      	 as full name of receiver
	 * @param string $subject      	 as subject
	 * @param array $messageBody  	 as message body
	 * @param string $from   		 as sender email address
	 * @param string $fromName  	 as full name of sender
	 * @param boolen $files   		 as true if mail have any file attachment, default false
	 * @param string $path   		 as file path
	 * @param string $attachmentName as attached file Name
	 *
	 * @return void
	*/
	public static function sendMail($to, $toName, $subject, $messageBody, $from = '', $fromName = '', $files = false, $path='', $attachmentName='') {



		$data				=	array();
		$data['to']			=	$to;
		$data['fullName']	=	$toName;
		$data['fromName']	=	!empty($fromName) ? $fromName : self::getAdminData()->name;
		
		$data['from']		=	!empty($from) ? $from : self::getAdminData()->email;
		$data['subject']	=	$subject;

		$data['filepath']		=	$path;
		$data['attachmentName']	=	$attachmentName;


		if($files===false){
			$mail = Mail::send('emails.email_template', array('messageBody' => $messageBody), function($message) use ($data) {
                $message->to($data['to'], $data['fullName'])->from($data['from'], $data['fromName'])->subject($data['subject']);
            });
		}else{
			if($attachmentName!=''){
				Mail::send('emails.email_template', array('messageBody'=> $messageBody), function($message) use ($data){
					$message->to($data['to'], $data['fullName'])->from($data['from'], $data['fromName'])->subject($data['subject'])->attach($data['filepath'],array('as'=>$data['attachmentName']));
				});
			}else{
				Mail::send('emails.email_template', array('messageBody'=> $messageBody), function($message) use ($data){
					$message->to($data['to'], $data['fullName'])->from($data['from'], $data['fromName'])->subject($data['subject'])->attach($data['filepath']);
				});
			}
		}


		$insertData = array(
			'email_to'	 => $data['to'],
			'email_from' => $data['from'],
			'subject'	 => $data['subject'],
			'message'	 =>	$messageBody,
		);
		if( count(Mail::failures()) > 0 ) {
			$insertData['mail_sent']	=	'fail';
		}else{
			$insertData['mail_sent']	=	'pass';
		}
		DB::table('email_logs')->insert($insertData); 
	}//end sendMail()

	
	
	/**
     * @description To download a file from system
     * @param 	   $filename name of file for download 
     * @param 	   $downloadPath path of file
     * @return 	   void
     * */
    public static function downloadFile($filename, $downloadPath) {

        $file = $downloadPath . $filename;
        if (!is_file($file)) {
            die("<b>404 File not found!</b>");
        }
        //Gather relevent info about file
        $len = filesize($file);
        $filename = basename($file);
        $file_extension = strtolower(substr(strrchr($filename, "."), 1));

        //This will set the Content-Type to the appropriate setting for the file
        switch ($file_extension) {

            case "pdf": $ctype = "application/pdf";
                break;
            case "exe": $ctype = "application/octet-stream";
                break;
            case "zip": $ctype = "application/zip";
                break;
            case "docx": $ctype = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
                break;
            case "doc": $ctype = "application/msword";
                break;
            case "xlsx": $ctype = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
                break;
            case "xls": $ctype = "application/vnd.ms-excel";
                break;
            case "ppt": $ctype = "application/vnd.ms-powerpoint";
                break;
            case "gif": $ctype = "image/gif";
                break;
            case "png": $ctype = "image/png";
                break;
            case "jpeg":
            case "jpg": $ctype = "image/jpg";
                break;
            case "mp3": $ctype = "audio/mpeg";
                break;
            case "wav": $ctype = "audio/x-wav";
                break;
            case "mpeg":
            case "mpg":
            case "mpe": $ctype = "video/mpeg";
                break;
            case "mov": $ctype = "video/quicktime";
                break;
            case "avi": $ctype = "video/x-msvideo";
                break;
            case "sql": $ctype = "application/sql";
                break;
            case "html": $ctype = "text/html";
                break;

            //The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
            case "php":
            case "htm":

            case "php3":
            case "php4":
            case "pl":
                die("<b>Cannot be used for " . $file_extension . " files!</b>");
                break;

            default: $ctype = "application/force-download";
        }

        //Begin writing headers
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");

        //Use the switch-generated Content-Type
        header("Content-Type: $ctype");

        //Force the download
        $header = "Content-Disposition: attachment; filename=" . $filename . ";";
        header($header);
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $len);
        @readfile($file);
        exit();
    }//end downloadFile()
    
    

	/**
     * @description public static function getGender List
     * @param null
     * @return array
     * */
    public static function getGenderList() {
		$genderList	=	Config::get('GENDER');
		return $genderList;
    }//end getGenderList()
	
    
    /*
     * Function to get getUserImageUrl
     *
     * @param $root_path as root path
     * @param $http_path as http path
     * @param $image as image
     *
     * @return image url
     * */
	public static function getUserImageUrl($ROOT_PATH,$HTTP_PATH,$image){
		$image_url	=	WEBSITE_IMG_FILE_URL . '?&cropratio=1:1&zc=2&height=250px&width=250px&image=' . WEBSITE_IMG_URL . 'admin/no-user-image.png';
		if(!empty($image) && file_exists($ROOT_PATH . $image)){
			$image_url		=	WEBSITE_IMG_FILE_URL . '?&cropratio=1:1&zc=2&height=250px&width=250px&image=' . $HTTP_PATH.$image;
		}
		return $image_url;
	}//end getUserImageUrl()

	/*
     * Function to get getAdminLocaton
     *
     * @return image url
     * */
	public static function getAdminLocaton(){
		$adminDetails		=	User::where('_id',ADMIN_ID)->first()->toArray();
		return $adminDetails;
	}//end getUserImageUrl()


	/*
    * Function to Get admin data
    *
    * @return data 
	* */
	public static function getAdminData(){		
		$data = \App\Settings::where('id',1)->first();	
		if(!empty($data)){
			return $data;
		}
	}
	
	/**
     * function to get banner()
     * @param $formData as formData
     * @return array
     **/
    public static function getBanner($formData=null){
		$items = Banner::isActiveDates()->where('is_website', 1)
			->orderBy('list_order')->get()->toArray();
		$result 	=	[];
		if(count($items)>0){
			$result 	=	$items;
		}
		return $result;
	}//end getBanner()

	
	 /**
     * function to getWashingPlanData()
     * @param $formData as formData
     * @return array
     **/
    public static function getWashingPlanData($formData=null){
    	
		$items = Washing_price::with('vehicle_type','washing_plan:id,name')->get()->toArray();
		
      
		return $items;
		
	}//end getBanner()

	

	/**
	 * Datatable configuration
	 *
	 * @param req		As	Request Data
	 * @param res		As 	Response Data
	 * @param options	As Object of data have multiple values
	 *
	 * @return json
	 */
	public static function configDatatable($request,$formData=null){
			$resultDraw		= 	($request->draw)	? $request->draw : 1;
			$sortIndex	 	= 	($request->order && $request->order[0]['column'] != '') 	? 	$request->order[0]['column']		: '' ;
			$sortOrder	 	= 	($request->order && $request->order[0]['dir'] && ($request->order[0]['dir'] == 'asc')) ? 'ASC' :'DESC';
			
			/* Searching  */
			$conditions 		=	[];
			$searchData 		=	($request->columns) ? $request->columns :[];
			if(count($searchData) > 0){
				foreach ($searchData as $index => $record) {
					$fieldName 		= (isset($record['name']) ? $record['name'] : (isset($record['data']) ? $record['data'] : ''));
					$searchValue	= (isset($record['search']) && !empty($record['search']['value'])) ? trim($record['search']['value']) : '';
					$fieldType		= (isset($record['field_type'])) ? $record['field_type'] : '';
					if($searchValue && $fieldName){
						
						if(is_numeric($searchValue)){
							array_push($conditions, [$fieldName , '=',$searchValue]);
						}else{
							$valData    =   '%'.$searchValue.'%';
	                    	array_push($conditions, [$fieldName , 'like',$valData]);
						}
					}
				}
			}

			/* Sorting */
			$sortConditions = [];
			if($sortIndex !=''){
				if($searchData[$sortIndex]){
					$dataVal				=	(isset($searchData[$sortIndex]['data']) ? $searchData[$sortIndex]['data'] : '');
					$orderFieldName 		=   (isset($searchData[$sortIndex]['name']) ? $searchData[$sortIndex]['name'] : $dataVal);
					$proptyType				=	'data';
					if(isset($searchData[$sortIndex]['name']) && $searchData[$sortIndex]['name']){
						$proptyType				=	'name';
					}
					if(isset($searchData[$sortIndex][$proptyType]) && !empty($searchData[$sortIndex][$proptyType])){
						$sortConditions[$searchData[$sortIndex][$proptyType]] = $sortOrder;
					}
				}
			}else{
				$sortConditions['id'] = $sortOrder;
			}
			
			return [
				'sort_conditions' 	=> $sortConditions,
				'conditions' 		=> $conditions,
				'result_draw' 		=> $resultDraw
			];
		
	}//End configDatatable()

	/**
	 * function to get prepareTimeSlots()
	 *
	 * @param starttime		As	start time
	 * @param endtime		As 	end time
	 * @param duration		As 	duration
	 *
	 * @return json
	*/
	public static function getTimeSlots($duration,$start,$end){
        // $time = array();
        // $start = new \DateTime($start);
        // $end = new \DateTime($end);
        // $start_time = $start->format('H:i');
        // $end_time = $end->format('H:i');
        // $currentTime = strtotime(Date('Y-m-d H:i'));
        // $i=0;

        // while(strtotime($start_time) <= strtotime($end_time)){
  
	       //      $start = $start_time;
	       //      $end = date('H:i',strtotime('+'.$duration.' minutes',strtotime($start_time)));
	       //      $start_time = date('H:i',strtotime('+'.$duration.' minutes',strtotime($start_time)));
	            
	       //      $today = Date('Y-m-d');
	       //      $slotTime = strtotime($today.' '.$start);
	 
	       //      if($slotTime > $currentTime){
	       //          if(strtotime($start_time) <= strtotime($end_time)){
	       //              $time[$i]['start'] = $start;
	       //              $time[$i]['end'] = $end;
	       //          }
	       //          $i++;
	       //      }
 
        // }
        // return $time;
		$time = array();
        $start = new \DateTime($start);
        $end = new \DateTime($end);
        $start_time = $start->format('H:i');
        $end_time = $end->format('H:i');
        $i=0;
        while(strtotime($start_time) <= strtotime($end_time)){
            $start = $start_time;
            $end = date('H:i',strtotime('+'.$duration.' minutes',strtotime($start_time)));
            $start_time = date('H:i',strtotime('+'.$duration.' minutes',strtotime($start_time)));
            $i++;
            if(strtotime($start_time) <= strtotime($end_time)){
                $time[$i]['start'] = $start;
                $time[$i]['end'] = $end;
            }
        }
        return $time;
	}//End getTimeSlots()




	/**
	 * function to get checkValidSlots()
	 *
	 * @param starttime		As	start time
	 * @param lunchStart 	As	lunch Start time
	 * @param lunchEnd		As	lunch End time
	 *
	 * @return json
	*/
	public static function checkValidSlots($slotTime,$lunchStart,$lunchEnd){
       	if(!empty($slotTime) && !empty($lunchStart) && !empty($lunchEnd)){
       		if($lunchStart > $slotTime ||  $lunchEnd <= $slotTime ){
       			return 	true;
       		}else{
       			return 	false;
       		}
    	}else{
    		return 	false;
    	}
	}//End checkValidSlots()


	/**
	 * function to get siteContactData()
	 *
	 * @param starttime		As	start time
	 * @param lunchStart 	As	lunch Start time
	 * @param lunchEnd		As	lunch End time
	 *
	 * @return json
	*/
	public static function siteContactData(){
        return \App\Contact::first();
	}//End siteContactData()



} // end CustomHelper
