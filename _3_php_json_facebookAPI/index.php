<?php require_once __DIR__ . '/php-graph-sdk-5.0.0/src/Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '262860694166336',
  'app_secret' => 'c5cfcbb501175f3bdb0526c10c513b29',
  'default_graph_version' => 'v2.8',
]);
$fb->setDefaultAccessToken('EAADvEgZANG0ABAIUTWcsLyvW1wIulplo9Og1CZC4ZCSEeakzoTZB5cIhZCiHFtlFUoAZC4GlCiBk7CaxCS9oElhkQ76ot5sUDdmKzG1r6zHTEeJulh7WzI03iZBWYo9c4Xod9SNeH4nl3tZAwMZBVmTtTVstHbUOC44ZAYVcjcJfTQYQZDZD');
$accessToken='EAADvEgZANG0ABAIUTWcsLyvW1wIulplo9Og1CZC4ZCSEeakzoTZB5cIhZCiHFtlFUoAZC4GlCiBk7CaxCS9oElhkQ76ot5sUDdmKzG1r6zHTEeJulh7WzI03iZBWYo9c4Xod9SNeH4nl3tZAwMZBVmTtTVstHbUOC44ZAYVcjcJfTQYQZDZD';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>hw6 facebook search</title>
        <style>
            body{
                font-family: "Times New Roman", Times, serif;
            }
            #searchPanel{
                width: 45%;
                margin: 0 auto 0 auto;
                height: 160px;
                background-color: #F3F3F3;
                border: solid 2px #D4D4D4;
            }
            .noRecord{
                width: 55%;
                margin: 0 auto 0 auto;
                background-color: #F3F3F3;
                border: solid 1px #D4D4D4;
                text-align: center;
            }
            #searchPanel p{
                margin: 2px 0 2px 2px;
            }            
            #searchPanel label{
                margin: 0 0 0 2px;
                width: 40px;
            }
            #searchPanel .input1{
                margin: 0 0 0 2px;
                width: 100px;
            }
            #searchPanel .input2{
                margin: 0 0 0 5px;
                width: 100px;
            }
            #searchPanel .input3{
                margin: 0 0 0 68px;
            }            
            #searchPanel select{
                margin: 0 0 0 30px;
            }
            table,th, td{
                font-family: Arial;
                margin: auto;
                border: 2px solid #D4D4D4;
                background-color: #F3F3F3;
                border-collapse: collapse;
                text-align: left;
                width: 55%;
            }
            tr td img{
                width: 40px;
                height: 30px;
            }
            img{
                width:35px;
                height:35px;
            }
            .a1{
                width: 55%;
                height: 25px; 
                background-color: #D4D4D4;
                margin: 0 auto 0 auto;
                display: block;
                text-align: center;
            }
            .profile{
                width: 15%;
            }
            .details{
                width: 7.5%;
            }
        </style>
        <script>
            function showPlaceInputs() {
                if(document.getElementById("type").value=="place"){
                    document.getElementById("placeInputs").style.visibility = 'visible';
                    document.getElementById('location').required='required';
                    document.getElementById('distance').required='required';
                    document.getElementById('distance').pattern='[0-9]+';
                    document.getElementById('distance').title='Distance must be a number';
                }
                else{
                    document.getElementById('location').required='';
                    document.getElementById('distance').required='';
                    document.getElementById("placeInputs").style.visibility = 'hidden';
                    if(document.getElementById('distance').pattern)
                    document.getElementById('distance').removeAttribute('pattern');
                    document.getElementById('distance').title='';
                }
                
            }
            function hide() {
                document.getElementById("placeInputs").style.visibility = 'hidden';               
            }
            function enlarge(image) {
                var newWindow = window.open('_blank');
                newWindow.document.write('<img src="'+image+'">');
                document.close();
            }            
            function showAP(ap) {
                if(ap=='a'){
                    if(document.getElementById('albums').style.display=='none')
                        document.getElementById('albums').style.display='table';
                    else
                        document.getElementById('albums').style.display='none';
                    if(document.getElementById('posts')){
                        document.getElementById('posts').style.display='none';
                    }
                }
                else if(ap=='p'){
                    if(document.getElementById('posts').style.display=='none')
                        document.getElementById('posts').style.display='table';
                    else
                        document.getElementById('posts').style.display='none';
                    if(document.getElementById('albums')){
                        document.getElementById('albums').style.display='none';
                    }
                }
            }
            function showPhoto(id){
                if(document.getElementById(id).style.display=='none')
                        document.getElementById(id).style.display='table-cell';
                    else
                        document.getElementById(id).style.display='none';
            }
            function showOriginal(id,token) {
                var newWindow = window.open('_blank');
                originalImg = "https://graph.facebook.com/v2.8/"+id+"/picture?access_token="+token;
                newWindow.document.write('<img src="'+originalImg+'">');
                document.close();
            }
            function reset(){
                document.getElementById('keyword').value="";
            }
        </script>
    </head>
    <body>
        <div id="searchPanel">
            <p style="text-align:center;margin:0 0 0 0;font-size:22pt"><i>Facebook Search</i></p>
            <hr style="width:95%">
            <form method="GET" action="">
                <p>
                    <label>Keyword</label>
                    <input class="input1" type="text" name="keyword" required="required" id="keyword"
                           value="<?php echo (isset($_GET["keyword"]) or isset($_GET["showDetails"]))?$_GET["keyword"]:"";?>">
                </p>
                <p>
                    <label>Type</label>    
                    <select class="input" id="type" name="type" onchange="showPlaceInputs()">
                        <option <?php
                                if(!isset($_GET["type"])){
                                    echo "selected=\"selected\"";
                                }
                                if(isset($_GET["type"]) or isset($_GET["showDetails"])){
                                    if($_GET["type"]=="user")
                                        echo "selected=\"selected\"";
                                }?> value="user">Users</option>
                        <option <?php
                                if(isset($_GET["type"]) or isset($_GET["showDetails"])){
                                    if($_GET["type"]=="page")
                                        echo "selected=\"selected\"";
                                }?> value="page">Pages</option>
                        <option <?php
                                if(isset($_GET["type"]) or isset($_GET["showDetails"])){
                                    if($_GET["type"]=="event")
                                        echo "selected=\"selected\"";
                                }?> value="event">Events</option>
                        <option <?php
                                if(isset($_GET["type"]) or isset($_GET["showDetails"])){
                                    if($_GET["type"]=="group")
                                        echo "selected=\"selected\"";
                                }?> value="group">Groups</option>
                        <option <?php
                                if(isset($_GET["type"]) or isset($_GET["showDetails"])){
                                    if($_GET["type"]=="place")
                                        echo "selected=\"selected\"";
                                }?> value="place">Places</option>
                    </select>
                </p>
                <p id="placeInputs" <?php
                                    if(!isset($_GET["type"])){
                                        echo "style=\"visibility:hidden\"";
                                    }
                                    if(isset($_GET["type"]) or isset($_GET["showDetails"])){
                                        if($_GET["type"]=="place")
                                            echo "style=\"visibility:visible\"";
                                        else
                                            echo "style=\"visibility:hidden\"";
                                    }?>>
                    <label>Location</label> 
                    <input id="location" class="input2" type="text" name="location" <?php echo isset($_GET["location"])? "value='{$_GET["location"]}'":""?>>
                    Distance(meters)
                    <input type="text" name="distance" id="distance" <?php echo isset($_GET["distance"])? " value='{$_GET["distance"]}'":""?>>
                </p>
                <p>
                    <input class="input3" type="submit" name="search" value="Search">
                    <a href="?reset=1" style='text-decoration:none'><input type="button" value="Clear" name="Clear"></a>
                </p>
            </form>
        </div>
        
    <?php if(isset($_GET["search"])):?>
        <?php 
        try {
            $q = $_GET["keyword"];
            $type = $_GET["type"];
            $fields = "id,name,picture.width(700).height(700)";
            if($_GET["type"]=="event"){
                $fields = "id,name,picture.width(700).height(700),place";
            }
            $getRequest = "/search?q={$q}&type={$type}&fields={$fields}";
            if($_GET["type"]=="place"){
                $distance = $_GET["distance"];
                $locationRaw = $_GET["location"];
                $location = urlencode($locationRaw);
                $key = "AIzaSyC79VmY83XX4PG-CoAP601k-75WAWRMe4w";
                $apiURL = "https://maps.googleapis.com/maps/api/geocode/json?address={$location}&key={$key}";
                $response_json = file_get_contents($apiURL);
                $response = json_decode($response_json, true);
                //var_dump($response);
                if($response['status']=='OK'){
                    $latitude = $response['results'][0]['geometry']['location']['lat'];
                    $longitude = $response['results'][0]['geometry']['location']['lng'];
                }
                $getRequest = "/search?q={$q}&type={$type}&center={$latitude},{$longitude}&distance={$distance}&fields={$fields}";
            }
            //echo $getRequest;
            $response = $fb->get($getRequest);
            $body = $response->getBody();
            $bodyArray = $response->getDecodedBody();
            $data = $bodyArray["data"];
            if (count($data)>0){
                if($_GET["type"]=="user" or $_GET["type"]=="group" or $_GET["type"]=="page" or $_GET["type"]=="place"){
                    echo "<br/><table>"
                        ."<tr><th class=\"profile\">Profile Photo</th>"
                        ."<th>Name</th>"
                        ."<th class=\"details\">Details</th></tr>";
                    foreach ($data as $entry) {
                        $photo=$entry["picture"]["data"]["url"];
                        $name=$entry["name"];
                        $id=$entry["id"];
                        echo "<tr><td class=\"profile\"><img src={$photo} onClick=\"enlarge('{$photo}')\"></td>"
                            ."<td>{$name}</td>";
                        if($type=="user" or $type=="group" or $type=="page"){
                        echo "<td class=\"details\"><a href=\"?showDetails={$id}&keyword={$q}&type={$type}\">Details</a></td></tr>";
                        }
                        elseif($type=="place"){
                        echo "<td class=\"details\"><a href=\"?showDetails={$id}&keyword={$q}&type={$type}&location={$locationRaw}&distance={$distance}\">Details</a></td></tr>";
                        }
                    }
                    echo "</table>";
                }
                elseif($_GET["type"]=="event"){
                    echo "<br/><table>"
                        ."<tr><th class=\"profile\">Profile Photo</th>"
                        ."<th>Name</th>"
                        ."<th>Place</th></tr>";
                    foreach ($data as $entry) {
                        echo "<tr>";
                        if(isset($entry["picture"]["data"]["url"]))
                            echo "<td class=\"profile\"><img src={$entry["picture"]["data"]["url"]} onClick=\"enlarge('{$entry["picture"]["data"]["url"]}')\"></td>";
                        else
                            echo "<td></td>";
                        if(isset($entry["name"]))
                            echo "<td>{$entry["name"]}</td>";
                        else
                            echo "<td></td>";
                        if(isset($entry["place"]["name"]))
                            echo "<td>{$entry["place"]["name"]}</td>";
                        else
                            echo "<td></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            }
            else{
                echo "<br/><div class=\"noRecord\">No Records have been found</div>";
            }
            //$entry = $data[0];
            //var_dump($data);
            //echo count($data);
        } 
        catch(Facebook\Exceptions\FacebookResponseException $e) {
          // When Graph returns an error
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } 
        catch(Facebook\Exceptions\FacebookSDKException $e) {
          // When validation fails or other local issues
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        }
        
        ?>
    <?php endif; ?>
        
    <?php
    if (isset($_GET['showDetails'])){
        try{
            $response = $fb->get("/".$_GET['showDetails']."?fields=id,name,picture.width(700).height(700),albums.limit(5){name,photos.limit(2){name, picture}},posts.limit(5)");
            $bodyArray = $response->getDecodedBody();
            if(isset($bodyArray["albums"])){
                echo "<br/><a class='a1' href=\"javascript:showAP('a')\">Albums</a><br/><table id='albums' style='display:none'>";
                foreach ($bodyArray["albums"]["data"] as $album){
                    if(isset($album["photos"]["data"][0])){
                        echo "<tr><td><a href=\"javascript:showPhoto('{$album["name"]}')\">{$album["name"]}</a></td></tr>";
                        echo "<tr><td id='{$album["name"]}' style='display:none'>";
                        foreach ($album["photos"]["data"] as $photo){
                            echo "<img src={$photo["picture"]} onclick=\"showOriginal('{$photo["id"]}','{$accessToken}')\" style=\"width:80px;height:80px;margin:0 5px 0 0\" >";
                        }
                        echo "</td></tr>";
                    }
                    else{
                        echo "<tr><td>".$album["name"]."</td></tr>";
                    }
                }
                echo "</table>";
            }
            else{
                echo "<br/><div class=\"noRecord\">No Album has been found</div>";
            }
            if(isset($bodyArray["posts"])){
                echo "<br/><a class='a1' href=\"javascript:showAP('p')\">Posts</a><br/><table id='posts' style='display:none'>"
                    ."<tr><th>Message</th></tr>";
                foreach($bodyArray["posts"]["data"] as $post){
                    if(isset($post["message"]))
                        echo "<tr><td>{$post["message"]}</td></tr>";
                    else
                        echo "<tr><td></td></tr>";
                }
                echo "</table>";
            }
            else{
                echo "<br/><div class=\"noRecord\">No Post has been found</div>";
            }
        }
        catch(Facebook\Exceptions\FacebookResponseException $e) {
          // When Graph returns an error
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } 
        catch(Facebook\Exceptions\FacebookSDKException $e) {
          // When validation fails or other local issues
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        }
    }
    ?>
        <NOSCRIPT/>
    </body>
</html>