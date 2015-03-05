<?php

	
	require_once($_SERVER['DOCUMENT_ROOT'].'cloud/models/main/index.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'cloud/models/main/html.php');

	ini_set('display_errors',1);  error_reporting(E_ALL); 
	session_start();
	$_SESSION['count'] =1;

	$_SESSION['userId']= "mike";



	$userId = $_SESSION['userId'];

	if(!isset($_SESSION['action'])){

		$_SESSION['action']=0;
	}



	if(!isset($_SESSION['whichActionProcess'])){

		$_SESSION['whichActionProcess']=0;
	}


	//check for ping to contunue ongoing command

	if(isset($_REQUEST['ping'])){



		if($_SESSION['action']>0){

			//check for a recent command

			$isOnCommand = dbMassData("SELECT * FROM conversations WHERE userId = '$userId' ORDER BY timestamp DESC LIMIT 1");

			//echo("SELECT * FROM conversations WHERE userId = '$userId' ORDER BY timestamp DESC LIMIT 1");

			if($isOnCommand==null){
				echo(json_encode(array("status"=>"fail", "msg"=>"no command in progress 4")));
				return;
			}
			else{
				//echo('made it');
				if($isOnCommand[0]['type'] =="command"){

					$_REQUEST['sentence'] = $isOnCommand[0]['statement'];
				}
				else{

			echo(json_encode(array("status"=>"fail", "msg"=>"no command in progress 2")));
			return;
			}
			}
			
		}
		else{

			echo(json_encode(array("status"=>"fail", "msg"=>"no command in progress 1")));
			return;
		}

		

	}



/*

	//only occurs if we're in the middle of an action
	if(isset($_SESSION['action'])){


		if($_SESSION['action']> 0){

			$theAction = $_SESSION['action'];
			$userId= $_SESSION['userId'];
			
			$whereWeAt = sendStep($theAction, $userId);

			if($whereWeAt==false){

				$responseToClient = array("status"=> "kinda", "msg"=>"you started an action, but it looks like it ended or something. Your action has ended now.", "answer"=>"command brain fart! You shouldnt have gotten this message");
				echo(json_encode($responseToClient));
				return;

			}

			else{

				$overrideAction = $whereWeAt;
			}

		}

	}
*/

	//resp is type of inquery

	if(!isset($overrideAction)){


		$resp = parseSentence($_REQUEST);

		if($resp!="command"){

			$_SESSION['action']=0;
		}

	$statement =$_REQUEST['sentence'];

	dbQuery("INSERT INTO conversations (statement, which, userId, type) VALUES ('$statement', 'human', 'mike', '$resp')");


	$result = determineResponse($_REQUEST, $resp);

	}
	

	else{
	
		//echo('did this one');

		$_REQUEST['sentence']= $overrideAction;
			$resp = parseSentence($_REQUEST);
			if($resp!="command"){

				$_SESSION['action']=0;
			}
		$result = determineResponse($_REQUEST, "command");

	}


	$answer = $result['answer'];
	$answerType= $result['answerType'];
	dbQuery("INSERT INTO conversations (statement, which, userId, type) VALUES ('$answer', 'humanoid', 'allini', '$answerType')");


//add callback for jsonp
if(isset($REQUEST['callback'])){
	echo($_GET['callback'] . '(' .json_encode($result).')');

}

else{
	echo(json_encode($result));
}

	


	function determineResponse($inp, $type){



		switch($type){


			case "question":
				$res = renderAnswer($inp['sentence']);
				return $res;
			break;

			case "command":
				$res = renderTask($inp['sentence']);
				return $res;

			break;

			case "exclamation":
				$res = renderExcl($inp['sentence']);
				return $res;

			break;


			case "declaration":
				$res = renderConvo($inp['sentence']);
				return $res;
			break;


			default:
				$res = renderConvo($inp['sentence']);
				return $res;
			break;
		}






	}


	function parseSentence($req){

		//get responses from the last 5 minutes...

		//these cconversations contain context


		//gives an output... but has to determine if there is a context

		//if contains and it


		if(!isset($req['sentence'])){

			return(array("status"=>"fail", "msg"=>"please send sentence"));


		}
		$sent = $req['sentence'];
		$n_words = preg_match_all('/([a-zA-Z]|\xC3[\x80-\x96\x98-\xB6\xB8-\xBF]|\xC5[\x92\x93\xA0\xA1\xB8\xBD\xBE]){4,}/', $sent, $match_arr);
		$word_arr = $match_arr[0];

		foreach($word_arr as $i => $val){

			$word_arr[$i]= strtolower($word_arr[$i]);
		}

		//get parts of sentence

		$sentParts =explode(",", $sent);

		if(!isset($sentParts[1])){
		
			$sentParts[1]=null;
		}
		else{

		
			$sentParts[0]= $sent;
		}

		$resp = checkForQuestion($sent);


		if($resp==true){

			$resp = answerQuestion($sentParts[0], $sentParts[1], $sent);

			//echo("is a question");
			return "question";

		}

		else{

			//echo("is not a question");
			//return false;
		}

		if(checkCommand($sent)==true){

			//echo('is a command');
			return "command";
		}

		else{
			//echo("is not command");
			//return false;
		}


		if(checkExclamation($sent)==true){

			//echo('is a exclamation');
			return "exclamation";
		}

		else{
			//echo("is not exclamation");
			//return false;
		}

		return "declaration";










		//question

			//bot should determine kind of question

			//what

		//determine if first word is one of these, or if one of these comes after a comma
		//send sentence to question
	

		//exclamation
			//bot should determine if this is excited conversational speak or command

		//go to end of sentence and check for an emoticon or an exclamation mark

		//command
			//bot should determine what the command it

		//determine if first word can be used as a verb... and if there are no other words being used as a verb, then this is command. Also, it should be a present tense.... or if this comes after a comma, like first, do this... 

		//declaration

			//response should be conversational




	}


	function checkForQuestion($sent){

			$questionWords= ['how', 'what', 'why', 'who', 'are', 'is', 'can', 'should', 'where', 'could', 'does', 'do', 'am', "when"];

			$sent = strtolower($sent);
			$conditions = explode(",", $sent);
			foreach($conditions as $i => $value){

				$allWords = explode(" ", $conditions[$i]);

				foreach($questionWords as $j => $value1){

					if($allWords[0] == $questionWords[$j]){

						if($allWords[0]=="when"){
							//echo("contains when");
							if(strpos($sent, "?")!==false){
								//echo('when shit...: '.$sent);
								return true;
							}
							else{
								return false;
							}
						}
						return true;
					}
				}
			}

			return false;

	}

	function checkCommand($sent){

		$commandWords = ['use', 'find', 'go', 'search', 'type', 'e-mail', 'email', 'send', 'ring', 'tell', 'query', 'ask', 'determine', 'program', 'code', 'learn', 'select', 'click', 'paste', 'copy', 'download', 'create', 'make', 'schedule', 'fix', 'repair', 'highlight', 'manipulate', 'run', 'sort', 'reconfigure', 'reimagine', 'delete', 'edit', 'come', 'figure', 'see', 'multiply', 'divide', 'add', 'subtract', 'visit', 'swing', 'read', 'write', 'examine', 'compare', 'google'];

		

		$commandPhrases = ['I want you to', 'let\'s see if you can'];

		$sent = strtolower($sent);

		//$n_words = preg_match_all('/([a-zA-Z]|\xC3[\x80-\x96\x98-\xB6\xB8-\xBF]|\xC5[\x92\x93\xA0\xA1\xB8\xBD\xBE]){4,}/', $sent, $match_arr);
		$word_arr = explode(" ", $sent);
		


			foreach($commandWords as $j=>$value1){
				//echo($word_arr[0]. "is and != ". $commandWords[$j]);
				if($word_arr[0]== $commandWords[$j]){

					return true;
				}


			


		}

			foreach($commandPhrases as $j=>$value1){
				if(strpos($word_arr[0],$commandPhrases[$j]) !==false){

					return true;
				}
				else{
					return false;
				}
				

				
			}

			return false;


	}


	function checkExclamation($sent){

		if(strpos($sent, "!")!==false){

			return true;
		}
		else{
			return false;
		}
	}

	function answerQuestion($quesPart1, $questPart2, $wholeQues){


	}


	function renderAnswer($sent, $offset=0){

		if(strpos($sent, "how are you")!==false || strpos($sent, "how are u")!==false || strpos($sent, "what up")!==false || strpos($sent, "what's up")!==false || strpos($sent, "are you human")!==false || strpos($sent, "how's it going")!==false || strpos($sent, "how is it goin")!==false || $sent == "why" || $sent =="why" || $sent == "what?" || strpos($sent, "what?")!==false || strpos($sent, "you ")!==false || strpos($sent, "you?")!==false || strpos($sent, "why is that")!==false){

			return renderConvo($sent);

		}

		
/*
		$html = file_get_html('https://answers.yahoo.com/search/search_result;?fr=uh3_answers_vert_gs&type=2button&p='.urlencode($sent));

		*/

		$jso = file_get_contents('http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q='.urlencode($sent));

		$response = json_decode($jso, true);
		$answer = $response['responseData']['results'][$offset]['content'] . " " .$response['responseData']['results'][$offset]['unescapedUrl'];


		return(array("status"=>"success", "answer"=>strip_tags($answer), "secondaryAnswers"=> $response['responseData']['results'], "original" => "question", "answerType"=>"link"));
		//$answer = 
		//echo($html);
//return false;
// Find all images 

		/*
		foreach($html->find('.question-title a') as $element) {

			echo("got first, please!!!");
			echo $element->href . '<br>';
		}

		*/


       			
$answerLinks = array();
// Find all links 
			foreach($html->find('a') as $element) {


       				//echo $element->href . '<br>';
       				if(strpos($element->href, 'question/') !==false){
       					//echo('link is'. $element->href);
       					$newLink = explode('question/',$element->href);
       					$linkStr = $newLink[1];
       					$linkStr = 'https://answers.yahoo.com/question/'. $linkStr;
       					array_push($answerLinks, $linkStr);


       				}

			}


			//print_r($answersLinks);
			$which = rand(0,4);

			$linkPres = array("I found this link: ", "This link might help: ", "I found this: ", "Try this link: ", "Ok. I searched and found this: ");

			return(array("status"=>"success", "answer"=>$linkPres[$which] . $answerLinks[0], "secondaryAnswers"=>$answerLinks, "original" => "question", "answerType"=>"link"));


			





		

}



	function sendStep($wStep, $userId){


		$res = dbMassData("SELECT * FROM actionQ where userId = '$userId' ORDER BY timestamp DESC LIMIT 1");

		if($res == null){


			$_SESSION['action']=0;
			return false;

		}

		if($res[0]['completed']!="false"){
			$_SESSION['action']=0;
			return false;
		}


		$currentCommand="";

		$currentCommand = $res[0]['phaseName'];
		return $currentCommand;



	}


	function renderTask($sent){


		if(!isset($_SESSION['action']) || $_SESSION['action']==0){
				$_SESSION['action']=1;
		}

		else{
			$_SESSION['action']= $_SESSION['action']+1;
		}



		$words = explode(" " , $sent);
		$action = $words[0];


		if(strpos($action, "google") !==false){
			return renderAnswer(str_replace("google ", "", $sent));
		}

		$howTo = dbMassData("SELECT * FROM actions WHERE command LIKE '%$action%'");



		if($howTo == null){


			$theResp= "I don't know how to ". $action. " yet. Can you teach me?";


			$_SESSION['isLearning']= true;
			$_SESSION['action']=0;
			$_SESSION['action']=0;

			//session_start();


			//numbers will be used to indicate whether action is in program.


			$_SESSION['action_progress_desc']="seeking clarification";

			return array("status"=>"kinda", "answer"=>
				$theResp, "answerType"=>"clarification", "original"=>"command");
		}


		$onStep = $_SESSION['action']-1;

			$allSteps = explode("\r\n", $howTo[0]['how']);



			if($onStep>= (count($allSteps)-2)){

				$_SESSION['action']=0;
				return array("status"=>"success", "answer"=>
				"I finished the task at hand!", "ended"=>"yay", "original"=>"command", "answerType"=>"ended action");

			}
		$thisStep = $allSteps[$onStep];


		$script = generateScript($thisStep);


		return array("status"=>"success", "answer"=>
				"I'm about to follow this procedure to fufill your request: ".$thisStep, "actionType"=>$howTo[0]['howType'], "answerType"=>"steps", "original"=>"command", "note"=>"going to ". $thisStep. "on your next ping.", "script"=>$script);




	}


	function generateScript($command){

			//$command = str_replace("\\n", "", $command);
			//$command = str_replace("\\r", "", $command);

		//echo("command is " .$command);
			if(strpos($command, "go to gmail.") !==false){
					$script= "window.location='http://gmail.com';";

				}
			else if(strpos($command, "click compose message") !==false){
					$script= "window.location='https://mail.google.com/mail/u/2/#inbox?compose=new';";

			}
		

			else if(strpos($command, "get message to send") !==false){
					$script="alert('what do you want to say?');";

			}

			else if(strpos($command, "click send button") !==false){
					$script= "$('.Up .L3').click();";

			}
			else{
				$script ="alert('command didn\'t catch');";

			}

/*
				case "go to gmail.":
					$script= "window.location='http://gmail.com';";
				break;

				case "click compose message.":
					$script= "window.location='https://mail.google.com/mail/u/2/#inbox?compose=new';";

				break;

				case "get message to send":

					$script="alert('what do you want to say?');";
				break;

				case "click send button":

					$script= "$('.Up .L3').click();";

				default:

					$script ="alert('command didn\'t catch');";

					//this would be the non-trainy wills one
				break;

				




			}
*/
			return $script;

	}

	function renderExcl($sent){

		renderConvo($sent);

	}
	function renderConvo($sent){

		$userId = $_SESSION['userId'];
		$correctTerms= array("wrong", "incorrect", "no,", "not correct", "next", "->", "-->", "another");

		$lastConversation = dbMassData("SELECT * FROM conversations WHERE userId = '$userId' ORDER BY timestamp DESC LIMIT 2");


		if($lastConversation == null){


		} 

		//echo("Last is ".$lastConversation[1]['type'] );

		if($lastConversation[1]['type'] == "question"){

			$words= explode(" ", $sent);

			$firstWord = $words[0];

			for($i = 0; $i < count( $correctTerms); $i++){

				if(strpos($sent, $correctTerms[$i]) !== false){


						// containts the terms we're looking for in order to know that we need to render as question but get next result; 
						$resp= renderAnswer($lastConversation[1]['statement'], 1);
						return $resp;


				}

			}
		

		}
		$resu = json_decode(file_get_contents('http://chat-maybe588.rhcloud.com/chatbot/?msg='.urlencode($sent).'&user=1&room=1'),true);

		if(isset($resu['status'])){

				return array("status"=>"fail");
		}


		else{

			
				if((strpos($resu['content'], "what")!==false && strpos($resu['content'], "called")!==false) || (strpos($resu['content'], "what")!==false && strpos($resu['content'], "name")!==false)){

					return renderConvo("mike");
				}

				

				return array("status"=>"success", "answer"=>$resu['content'], "bot"=>$resu['which'], "answerType"=>"convo", "original"=>"convo");

			}

	}


?>