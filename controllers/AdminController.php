<?php 
	//Admin side for Yii2/Stickit  site
	//Create main page 
	//User can register/login via Facebook/Google
	//User can restore password
		//Register form with
			//User name
			//E-mail
			//Phone number
			//City
			//Password
			//Re-entred password
		//Has personal cabinet
		//Can read private messages
		//Can make an adverticement
			//Can set Title
			//Can set adverticement type
			//Can set category
			//Can set sub-category
			//Can set distance/month
			//Can set region 
			//Can set price/month
			//Can set City
			//Can set Description
			//Can add images
			//Can set email visibility
			//
		//Can see favourite advertisements
		//Can see archive of advertisements
		//Can edit profile
	//Users needs to be created
	//User permissions needs to be created
	//OAuth2.0?
	//Facebook registration API
	//Blog with categories
	//Media storage needs to be created
	//Share with Facebook/Instagram/WhatsApp/Telegram/Viber
	//User can make an advertisement
	//
	namespace app\controllers;

	use Yii;
	use yii\web\Controller;

	/**
	 * Admin controller side
	 * 
	 */
	class AdminController extends Controller
	{
		public function actionIndex()
		{
			return $this->render('index.twig');
		}
	}
?>