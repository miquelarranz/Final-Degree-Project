<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => '',
            'client_secret' => '',
            'scope'         => array(),
        ),
        'Google' => array(
            'client_id'     => '781414786878-cl3bd8ctkn2ocbpiikph7bo8mhgl8jjb.apps.googleusercontent.com',
            'client_secret' => 'BfOUsUkBDfguxCMPBLXlcv7y',
            'scope'         => array('userinfo_email', 'userinfo_profile', 'https://www.googleapis.com/auth/calendar'),
        ),

    )

);