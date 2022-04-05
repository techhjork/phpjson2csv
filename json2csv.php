<?php

if((isset($_FILES["file"]["type"]) && $_FILES["file"]["type"] != NULL)
	|| (isset($_POST['json']) && $_POST['json'] != NULL)
	|| (isset($argv[1]))){

	require_once('json2csv.class.php');
	$JSON2CSV = new JSON2CSVutil;

	if(isset($argv[1])){
		$shortopts = "f::";  // Required value
		$longopts  = array("file::","dest::");
		$arguments = getopt($shortopts, $longopts);

		if(isset($arguments["dest"])){
			$filepath = $arguments["dest"];
		}
		else{
			$filepath = "JSON2.CSV";
		}

		$JSON2CSV->flattenjsonFile2csv($arguments["file"], $filepath);
	}
	elseif($_FILES["file"]["type"] != NULL){
		$JSON2CSV->JSONfromFile($_FILES["file"]["tmp_name"]);
		$JSON2CSV->flattenDL("JSON2.CSV");
	}
	elseif($_POST['json'] != NULL){
		$JSON2CSV->readJSON($_POST['json']);
		$JSON2CSV->flattenDL("JSON2.CSV");
	}
	
}
else{
	?>

<html>
<body>
JSON TO CSV Convert
<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" enctype="multipart/form-data">
<label for="json">JSON data:</label>
<textarea name="json" cols="150" rows="40">

</textarea>
<br />
<label for="file">Filename:</label>
<input type="file" name="file" id="file" />
<br />
<input type="submit" name="submit" value="Convert!" />
</form>

</body>
</html>
<?php
}
?>





<!--
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>

	$(function () {
		const url ="http://amring-test-api.azurewebsites.net";
		const urls = {
			auth:`${url}/token`,
			getProduct:`${url}/api/Articles/GetProducts`,
		}
		const info = {
			token:"",
			products:""
		}

		const http = async (method,success,data=null)=>{
			try{
				let res = await $.ajax({
					headers,
					method,
					data,
					success
				});
				return res;
			}catch(err){
				console.log(err);
			}
		}
		

		const getToken = async ()=>{
			$.ajax({
				type:"POST",
				headers:{
					'Access-Control-Allow-Origin':'*',
					'Access-Control-Allow-Methods':'GET, POST',
					'Access-Control-Allow-Credentials': "true",
					'Access-Control-Allow-Headers': "Origin, Content-Type, Accept, Authorization, X-Request-With",
					"content-type":"application/x-www-form-urlencoded"
				},
				crossDomain: true,
				url:urls.auth,
				data:{
					"grant_type":"password",
					"username":"402641",
					"password":"LveqjekPt1zw"
				},
				success:(res)=>{
					console.log(res)
				}
			})
		}
		getToken()

	});
</script>
-->