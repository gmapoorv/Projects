<?php
	//echo "string";
	$fp1 = fopen('simple.csv', 'r');
		//echo "string";
	 	$i=0;
	while (!feof($fp1)) {
	 	if($i == 0)
	 		$keywords = explode(',', fgets($fp1));
	 	else
			$docs[$i] = explode(',', fgets($fp1));
		$i++;
	}
	//Testing Conditions
	var_dump($keywords);
	echo "<br>";
	var_dump( $docs[1]);
	//echo $keywords[0][1];



	echo "<br>";
	//echo $docs[2][3];

	//1. Find Keywords pertaining to the particular Document!!
	for($j = 1; $j <= 2; $j++){
		for($k = 1; $k<4;$k++)
			{
				if($docs[$j][$k] != 0)
				$docKeyWords[$docs[$j][0]][] = $keywords[$k];
			}
	}
		var_dump($docKeyWords);


	//2.a)Finding the md5 for each keyword
	/*
	for($j = 1; $j <= 2; $j++){
		for($k = 1; $k<4;$k++)
			{
				$md = md5($docKeyWords[$docs[$j][0]][]);
			}
	}
	*/



	echo "<br>";
	for($j = 1; $j <= 2; $j++){
		$keywordIndex = array();
		for($k = 0,$indexIterator = 0; $k<count($docKeyWords[$docs[$j][0]]);$k++,$indexIterator++)
		{
		$processingKeyword = $docKeyWords[$docs[$j][0]][$k];	
	//$processingKeyword = $docKeyWords[$docs[1][0]][0];
	// echo "$processingKeyword";
	echo $processingKeyword."<br>";
	echo md5($processingKeyword);	
	echo "<br>";
	$last = substr(md5($processingKeyword), strlen(md5($processingKeyword))-2);
	//echo strlen(md5($docKeyWords[$docs[1][0]][0]));
	//echo md5($docKeyWords[$docs[1][0]][0][30];
	echo $last."<br>";
	$num = hexdec($last)%100;
	echo $num."<br>";
	
//Working Code Above This







	//for()
	// echo "<br>";
	// var_dump($docs);
	//$j =1;

	//2.b) Indexing the table key attached in bucket.csv

	$fp1 = fopen('bucket.csv', 'r');

	while(!feof($fp1)){

	//echo fgets($fp1)."<br>";
	$s = fgets($fp1);
	$pos = strrpos($s, ';');
	//echo $pos."<br>";
	$st = substr($s, 0,$pos);
	//echo $st."<br>";
	if(!strcmp($st, "\"$num\"")){
		echo substr($s, $pos+1)."<br>";
		$secretkey = substr($s, $pos+1);
		break;
	}
	}
	fclose($fp1);

	//2.c) Perform SHA-256, SHA-384, SHA-512 
	echo hash('sha256', $secretkey)."<br>";
	echo hash('sha384', $secretkey)."<br>";
	echo hash('sha512', $secretkey)."<br>";

	$s1 = hash('sha256', $secretkey);
	$s2 = hash('sha384', $secretkey);
	$s3 = hash('sha512', $secretkey);


//Working Till Above





	//2. d) Generate a string of length 2688 bits 
	$fullString = $s2.$s1.$s3.$s2.$s1.$s3.$s2;
	$shaString = "";
	for($i=0; $i<strlen($fullString);$i++){
	  	switch($fullString[$i])
	    {
	      case 0:
	      $shaString .= "0000";
	      break;
	      case 1:
	      $shaString .= "0001";
	      break;
	      case 2:
	      $shaString .= "0010";
	      break;
	      case 3:
	      $shaString .= "0011";
	      break;
	      case 4:
	      $shaString .= "0100";
	      break;
	      case 5:
	      $shaString .= "0101";
	      break;
	      case 6:
	      $shaString .= "0110";
	      break;
	      case 7:
	      $shaString .= "0111";
	      break;
	      case 8:
	      $shaString .= "1000";
	      break;
	      case 9:
	      $shaString .= "1001";
	      break;
	      case 'a':
	      $shaString .= "1010";
	      break;
	      case 'b':
	      $shaString .= "1011";
	      break;
	      case 'c':
	      $shaString .= "1100";
	      break;
	      case 'd':
	      $shaString .= "1101";
	      break;
	      case 'e':
	      $shaString .= "1110";
	      break;
	      case 'f':
	      $shaString .= "1111";
	      break;
	      default:
	      $shaString .="Not Hex";
	      break;
	   }
	}
	  echo strlen($shaString)."<br>";
	  echo $shaString."<br>";
//Working till Above



	//2. e)Split the string into sub-strings of length d(6)
	//Substrings = 2688/6 = 448 strings
	$strLength = strlen($shaString)/6;
	for($p=0;$p<$strLength;$p++){
		//for($q=6*$p;$q<(6*$p)+6;$q++)
			//$substrings[$p][] = $shaString[$q];
		$substrings[$p] = substr($shaString,$p*6,6);
	}
	//echo ($substrings[447])."<br>";
//Working Till Above

	

	
	// for($p=0;$p<$strLength;$p++){
	// 	for($q=0; $q<6;$q++)
	// 		echo $substrings[$p][$q];
	// 		echo "<br>";
	// 	}

	//2. f) If all the bits in the substrings are 0, Replace the substring with a single bit 0 else replace with 1.
                   
	for($m=0;$m<$strLength;$m++){
		$f=0;
		for($n=0; $n<6;$n++){
			if($substrings[$m][$n]!=0)
			{
				$f=1;
				break;
			}
		}
		if($f)
		$substrings[$m] = 1;
		else
		$substrings[$m] = 0; 	
	}
	//echo $substrings[0]."<br>";
	echo count($substrings)."<br>";
	// for($i=0;$i<$strLength;$i++)
	// 	echo $substrings[$i]."<br>";




//Working Fine Till Here!!



	echo "Checking For KEYWORD INDEX <br><br>";
	//2. g) Generate the output String of length 448 bits
		//$keywordIndex= array();
		//echo $keywordIndex."<br>";
	for($z=0;$z<$strLength;$z++)
		$keywordIndex[$indexIterator] .= $substrings[$z];
		echo ($keywordIndex[$indexIterator])."<br>";
}

	// Working Great Till Here!!


	//3. Generate a Bitwise-And for all the keyword indexes
		//echo "Final Index<br>";
		//echo $keywordIndex
		$finalIndex = substr($keywordIndex[0], 0);
		// echo $keywordIndex[0]."<br>";
		//echo $finalIndex."<br>";
		//echo "Final Index<br>";


		//echo $finalIndex."<br>";
		for($s=0;$s<count($keywordIndex);$s++)
			$finalIndex = $finalIndex & $keywordIndex[$s]; 
		$documentName = $docs[$j][0];
		echo $finalIndex."<br>";
		//echo $documentName."<br>";

	//Working Fine Till Here!!





//4. Store the Index of all documents in Database

$conn = mysqli_connect('localhost','root','test','apoorv');
$query = "insert into Documents values ('".$documentName."','".$finalIndex."')";

if ($conn->query($query) === TRUE) {
    echo "<center><b>New record created successfully<b><center>";
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}
}
/*


	//5. Read search term from the user. Generate the query string
	$userSearch = "11011"; //Length = 5
	//Generate the 



	//6. Perform a search over the dataset 
	//Document Relevant or Irrelevant





	//7. Plaintext Search
	$Plaintext = "D1";



	//8. Find total correct and Incorrect matches for each search.
	$correctMatches = 2;
	$IncorrectMatches = 5;




	//9. Compute overall correct and incorrect Match value for all the searches performed by the user
	//User Authentication
	//UserSearches[]

?>