<?PHP

/* tweetPHP, PHP twitter Class By Tim Davies
	Requires cURL and SimpleXML (both standard) */

class twitter {

	//set login variables in __construct
	function __construct($user, $pass) {
		$this->login = $user.':'.$pass;	
		$this->user = $user;
	}
	
	
	//fetch tweets via cURL
	public function fetch_tweets($tweetlimit = 5, $charlimit = False, $limit= 42) {		

		$ch = curl_init();
		$login = $this->login;
		$target = 'http://twitter.com/statuses/user_timeline.xml';
		curl_setopt($ch, CURLOPT_URL, $target);
		curl_setopt($ch, CURLOPT_USERPWD, $login);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		//Parsing the data
		$getweet = curl_exec($ch);
		
		$twitters = new SimpleXMLElement($getweet);

		//error reporting
		if(array_key_exists('@attributes', $twitters)){
			//die("<b>Fatal Error</b> Twitter is currently unavaliable");
		}
		
		
		//echo each tweet that was fetched.
		$counter = 0; 
		foreach ($twitters->status as $twit) { 
		
			$twiturl = 'http://twitter.com/'. $this->user .'/statuses/'. $twit->id;
   			$created = substr($twit->created_at,0,16);

  			if(++$counter > $tweetlimit) { 
      			break; 	
   			}else{	
   			
   				if($charlimit){
   					
			   		if(strlen($twit->text) > $charlimit) {
 						$tweet = substr($twit->text, 0 , $limit)."...";
			   		}else{
 						$tweet = substr($twit->text, 0 , $limit);
 					}

				}else{
					$tweet = $twit->text;
				}
				
				echo '<li class="tweet">'. $tweet .'</li>';
				
   			}
		} 

	}
	
	
	//posting tweets, send data via curl
	
	public function post_tweet($message) {
	
		$ch = curl_init();
		$login = $this->login;
		$target = 'http://twitter.com/statuses/update.xml';
		curl_setopt($ch, CURLOPT_URL, $target);
		curl_setopt($ch, CURLOPT_USERPWD, $login);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "status=$message&source=tweetPHP");
	
		$buffer = curl_exec($ch);
		curl_close($ch);
	
	}
	
	public function fetch_followers() {
	
		$ch = curl_init();
		$login = $this->login;
		$target = 'http://twitter.com/statuses/followers.xml';
		curl_setopt($ch, CURLOPT_URL, $target);
		curl_setopt($ch, CURLOPT_USERPWD, $login);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		$getfollowers = curl_exec($ch);
		
		$followers = new SimpleXMLElement($getfollowers);
		
		foreach ($followers->user as $follower) { 

  			echo '<li class="tweet">'. $follower->screen_name .' - '. $follower->name .'</li>';
				
		}
	}


}

?>