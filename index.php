<?php
   
    require "vendor/autoload.php";
    require "db.php";
    
    
    

    $router = new AltoRouter();
    


$router->map('GET',"/shortLink/",function()
{
    require 'home.php'; 
});

$router->map('POST',"/shortLink/",function()
{   
    if (isset($_POST["url"])) 
    {   
        if (!filter_var($_POST["url"], FILTER_VALIDATE_URL) === false) 
        {
            
            function generateRandomString($length = 5) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }

                return "/shortLink/".$randomString;
            }
            
            $links = generateRandomString();
            $init = new db();
            $insert = $init->create(1,$_POST["url"],$links);
            require 'home.php';
            echo "<a href='$links' target='_blank'>".$links."</a>";
        } 
        else 
        {   
            require 'home.php';
            echo("URL n'est pas valide");
        }
    }
});

// var_dump($_SESSION["host"]);
 $router->map('GET',"/shortLink/[*:name]",function($name)
{      
    $init = new db();
    $urllink = $init->geturl();
    $urllink = $urllink[0];
    $url = $urllink->url;

    header("location:$url");
});


$match = $router->match();

if( is_array($match) && is_callable( $match['target'] ) ) 
{
    call_user_func_array( $match['target'], $match['params'] ); 
} 
else 
{
// no route was matched
    header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}

// var_dump($_SESSION["host"]);

?>

