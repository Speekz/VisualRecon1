<?php
function miniAPIPost($foto){
  $url ="https://gateway-a.watsonplatform.net/visual-recognition/api/v3/detect_faces?api_key=34b950721ae8deb959f0291079d1b1df1c8f7ec0&version=2016-05-17";
  
  $tmpfile = $foto['tmp_name'];
  $filename = basename($foto['name']);
  $data = array(
	'images_file' => '@'.$tmpfile.';filename='.$filename,
  );
            
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data );
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
  $result = curl_exec($ch);
  curl_close($ch); 
  
  return json_decode($result, true);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>PHP Starter Application</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
if( isset($_POST["submit"]) ){
    $asd = miniAPIPost($_FILES["foto"]);
    $resultado = $asd['images'][0]["faces"][0];
?>
<div><b>Edad:</b> <?php echo $resultado['age']["min"]; ?>-<?php echo $resultado['age']["max"]; ?> (score: <?php echo $resultado['age']["score"]; ?>)</div>
<div><b>Genero:</b> <?php echo $resultado['gender']["gender"]; ?> (score: <?php echo $resultado['gender']["score"]; ?>)</div>
<div><b>Identidad:</b> <?php echo $resultado['identity']["name"]; ?> (score: <?php echo $resultado['identity']["score"]; ?>)</div>
<?php }else{ ?>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="foto">
    <button type="submit" name="submit">Enviar</button>
</form>
<?php } ?>
</body></html>
