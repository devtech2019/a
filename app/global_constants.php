<?php
/* Global constants for site */
define('FFMPEG_CONVERT_COMMAND', '');
define("ADMIN_FOLDER", "admin/");
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', base_path());
define('APP_PATH', app_path());

/*constant for front website url for account verification*/
define('WEBSITE_MAIN_FOLDER','car_wash');
define('FRONT_SITE_URL',ROOT);
define('WEBSITE_URL', url('/').'/');
define('WEBSITE_ADMIN_NAV_URL', url('/'));
define('ADMIN_URL', WEBSITE_URL.ADMIN_FOLDER);

define('WEBSITE_PUBLIC_FOLDER_URL', WEBSITE_URL . 'public/');
define('WEBSITE_JS_URL', WEBSITE_URL . 'public/js/');
define('WEBSITE_CSS_URL', WEBSITE_URL . 'public/css/');
define('WEBSITE_IMG_URL', WEBSITE_URL . 'public/img/');
define('WEBSITE_IMAGE_URL', WEBSITE_URL . 'public/images/');



define('WEBSITE_IMG_ROOT_PATH', ROOT . DS . 'img' .DS );
define('WEBSITE_UPLOADS_ROOT_PATH', ROOT . DS . 'public/uploads' .DS );
define('logo_UPLOADS_ROOT_PATH', ROOT . DS . 'img/' .DS );
define('WEBSITE_UPLOADS_URL', WEBSITE_URL . 'public/uploads/');
define('WEBSITE_PUBLIC_UPLOADS_URL', WEBSITE_PUBLIC_FOLDER_URL . 'uploads/images/');

define('WEBSITE_ADMIN_URL', WEBSITE_URL.ADMIN_FOLDER );
define('WEBSITE_ADMIN_IMG_URL', WEBSITE_ADMIN_URL . 'img/');
define('WEBSITE_ADMIN_JS_URL', WEBSITE_ADMIN_URL . 'js/');
define('WEBSITE_ADMIN_FONT_URL', WEBSITE_ADMIN_URL . 'fonts/');
define('WEBSITE_ADMIN_CSS_URL', WEBSITE_ADMIN_URL . 'css/');


/* * * image.php *** */
if (!defined('WEBSITE_IMG_FILE_URL')) {
    define("WEBSITE_IMG_FILE_URL", WEBSITE_URL . 'image.php');
}

define('SETTING_FILE_PATH', APP_PATH . DS . 'settings.php');
define('MENU_FILE_PATH', APP_PATH . DS . 'menus.php');

define('CK_EDITOR_URL', WEBSITE_UPLOADS_URL . 'ckeditor_pic/');
define('CK_EDITOR_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH . 'ckeditor_pic' . DS);


define('SLIDER_URL', WEBSITE_UPLOADS_URL . 'slider/');
define('SLIDER_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'slider' . DS);

define('MSG_ATTACHMENT_FOLDER', WEBSITE_UPLOADS_URL .  'msg_attachment/');
define('MSG_ATTACHMENT_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'msg_attachment' . DS);

define('USER_PROFILE_IMAGE_URL', WEBSITE_UPLOADS_URL . 'user/');
define('USER_PROFILE_IMAGE_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'user' . DS);

define('USER_DOCUMENT_URL', WEBSITE_UPLOADS_URL . 'user_doc/');
define('USER_DOCUMENT_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'user_doc' . DS);

define('USER_IMAGES_URL', WEBSITE_UPLOADS_URL . 'user/');
define('USER_IMAGES_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'user' . DS);

define('SETTING_IMG_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH . 'setting_image' . DS);
define('SETTING_IMG_URL', WEBSITE_UPLOADS_URL . 'setting_image/');

define('MEDIA_IMAGE_URL', WEBSITE_UPLOADS_URL . 'media_partner/');
define('MEDIA_IMAGE_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'media_partner' . DS);


//advertisement Image path
define('ADVERTISEMENT_URL', WEBSITE_UPLOADS_URL . 'advertisement/');
define('ADVERTISEMENT_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'advertisement' . DS);


define('MASTERS_IMAGE_URL', WEBSITE_UPLOADS_URL . 'masters/');
define('MASTERS_IMAGE_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'masters' . DS);

define('ALBUMS_IMAGE_URL', WEBSITE_UPLOADS_URL . 'albums/');
define('ALBUMS_IMAGE_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'albums' . DS);

define('USER_IMAGE_URL', WEBSITE_UPLOADS_URL . 'users/');
define('USER_IMAGE_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'users' . DS);



define('EVENTS_IMAGE_URL', WEBSITE_UPLOADS_URL . 'events/');
define('EVENTS_IMAGE_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'events' . DS);

define('SONGS_TRACK_URL', WEBSITE_UPLOADS_URL . 'songtrack/');
define('SONGS_TRACK_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'songtrack' . DS);

define('SONGS_TRACK_IMAGE_URL', WEBSITE_UPLOADS_URL . 'songtrack_image/');
define('SONGS_TRACK_IMAGE_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'songtrack_image' . DS);

define('CMS_IMAGE_URL', WEBSITE_UPLOADS_URL . 'cms_images/');
define('CMS_IMAGE_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'cms_images' . DS);
$config =   array();
define('POST_FILE_NAME_MAX_LENGTH',50);
define('ALLOWED_TAGS_XSS','<a><strong><b><p><br><i><font><img><h1><h2><h3><h4><h5><h6><span><em><table><ul><li></li></ul><section><thead><tbody><tr><td><iframe><div><figure>');

define('DATE_FORMAT_WITH_SECOND','Y-m-d H:i:s');
define('DATE_TIME_FORMAT_WITH_AM_PM','d-m-Y H:i a');
define('SHOW_DATE_FORMAT','d/m/Y');
define('SHOW_PROFILE_DATE_FORMAT','d M, Y');
define('YEAR_FORMAT','Y');
define('MESSAGE_DATE_FORMAT','d M Y H:i:s');
define('SIGNUP_DATE_FORMAT','H:i:s');
define('DATE_FORMAT','Y-m-d');



/**  Active Inactive global constant **/
define('ACTIVE',1);
define('INACTIVE',0);
define('YES',1);
define('NO',0);
define('DELETE',1);
define('NOT_DELETE',0);
define('IS_VERIFIED',1);
define('NOT_IS_VERIFIED',0);
define('NOT_PROFILE_COMPLETE',0);
define('IS_SEEN',1);
define('NOT_SEEN',0);
define('NOT_SENT',0);
define('SENT',1);
define('REJECT',2);
define('BLOCK',1);
define('UNBLOCK',0);
define('ADMIN_ID',2);
define('GENRE_Id', 1);
define('ARTIST_USER', 1);
define('GENRES', 1);
define('RATER', 2);
define('RECENT',1);




Config::set('user_roles',array(
    ARTIST_USER =>  "Artist",
    RATER  		=>  "Rater",
));
// Config::set('type',array(
//    GENRES =>  "genres",
//     LANGUAGE	=>  "language",
// ));


define("PASSWORD_REGX", "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/");

define('OTP_CHARACTER_LIMIT',4);

if (!defined('FORGOT_OTP_TIME')) {
    define('FORGOT_OTP_TIME', '+5 minute');
}
if (!defined('RESEND_OTP_TIME')) {
    define('RESEND_OTP_TIME', '+1 minute');
}


Config::set('user_common_condition',array(
    ['id','<>',ADMIN_ID],
	['is_verified','=',IS_VERIFIED],
	['block','=',UNBLOCK]
));
define('PENDING',   0);
define('INPROGRESS',1);
define('RESOLVED',  2);

Config::set('reportStatus',array(
    PENDING         =>  "Pending",
    INPROGRESS      =>  "In Progress",
    RESOLVED        =>  "Resolved",
));

define('REPORT_TO_USER',  0);
define('REPORT_TO_ALBUM', 1);
define('REPORT_TO_TRACK', 2);
define('REPORT_TO_EVENT', 3);

Config::set('reporting',array(
    REPORT_TO_USER 		=>  "Report to User",
    REPORT_TO_ALBUM  	=>  "Report to Album",
    REPORT_TO_TRACK  	=>  "Report to Track",
    REPORT_TO_EVENT  	=>  "Report to Event",
));


define('UNFOLLOW', 0);
define('FOLLOW',1);

define('CURRENCY', '₹');

Config::set('followStatus',array(
    UNFOLLOW         =>  "unfollow",
    FOLLOW           =>  "follow",
)); 

define('DISLIKE', 0);
define('LIKE',1);


/** For data table data types **/
//define('SORT_ASC',  'asc');
//define('SORT_DESC',  'desc');

define('NUMERIC_FIELD',  'numeric');
define('EXACT_FIELD',  'exact');

/** Not allowed characters in regular expresssion **/
Config::set('NOT_ALLOWED_CHARACTERS_FOR_REGEX',['(',')','+','*','?','[',']']);
define('HOME_EVENT_LIMIT',10);
define('HOME_ALBUM_LIMIT',3);

define('NOTGOING', 0);
define('GOING',1);

Config::set('goingEvent',array(
    GOING       =>  "going",
    NOTGOING    =>  "notgoing",
));