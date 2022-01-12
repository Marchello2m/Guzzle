<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MY Reader</title>
</head>
<body>
<form>
    Enter URL here: <input type="text" name="feed_url"/>
<!--   Enter API key here: <input type="text" name="feed_key"/> -->
    <input type="submit" value="READ"/>
</form>
<?php
if(isset($_REQUEST['feed_url'])){
    require './vendor/autoload.php';
    $myClient = new GuzzleHttp\Client([
        'headers'=>['User-Agent'=>'MyReader']
    ]);
    $feed_response = $myClient->request('GET',$_REQUEST['feed_url']);   // .'feed_key'
    if ($feed_response->getStatusCode()===200){
        if ($feed_response->hasHeader('content-length')){
            $contentLength = $feed_response->getHeader('content-length')[0];
            echo "<p> Downloaded $contentLength by of data.</p>";
        }
        $body=$feed_response->getBody();
       $xml = new SimpleXMLElement($body);

        foreach ($xml->channel->item as $item) {
            echo "<h3>".$item->title ."</h3>";          // can change these params for other url
            echo "<p>".$item->description ."</p>";
            echo "<p>".$item->quantity."</p>";

        }
    }
}

?>

</body>
</html>
