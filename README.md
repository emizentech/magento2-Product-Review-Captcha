<b>Magento2 Product Review Captcha</b>

<p>By using this module you can display magento native captcha on product review form.</p>

1.  <b>Installation:</b>
	  Unzip Module files inside app/code folder.
	  Run Below Commands:
	    php bin/magento setup:upgrade
	    

2. <b>Configuration:</b>
	 Go threw Admin > Store > Configuration > Customer > Customer Configuration > Captcha tab.
	 Select review to show captcha in review form and Save config.
	 
   	<img src="https://www.emizentech.com/Uploads/Configuration.png" />
   


3. <b>Clean magento cache:</b>
	Run Below Commands from magento root folder:-
	php bin/magento cache:clean
	php bin/magento cache:flush
	
4. <b>Frontend View:</b>
 	The Captcha will be appear in product review form as shown in below screenshot.
	
	<img src="https://www.emizentech.com/Uploads/PDP.png" />

	 
