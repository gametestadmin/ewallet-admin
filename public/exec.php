<?php
require __DIR__ . '/../app/config/config_apps.php';

//START: create css from less files
$dir_lessc = __DIR__. '/assets/'.$config_apps['template'].'/less/';

//echo $dir_lessc;die;
echo "Exec Lessc :\n";
$files_lessc = scandir($dir_lessc, 0);

for($b = 0; $b < count($files_lessc); $b++)
{
	$files_name_lessc = $files_lessc[$b];

	$str_lessc = $files_name_lessc;
	$name_expl_lessc = (explode(".less",$str_lessc));

	//if not less file, continue
	if(substr($str_lessc, -5) !== ".less") continue;

	//create development folder
	if (!file_exists(__DIR__. '/assets/'.$config_apps['template'].'/css/development/')){
		mkdir(__DIR__. '/assets/'.$config_apps['template'].'/css/development/', 0755, true);
	}

	echo "- ".$name_expl_lessc[0]."\n";
	try
	{
		$lesscss = 'lessc '.__DIR__.'/assets/'.$config_apps['template'].'/less/'.$name_expl_lessc[0].'.less '.__DIR__.'/assets/'.$config_apps['template'].'/css/development/'.$name_expl_lessc[0].'.css';
		$result_lessc = exec($lesscss);
	}
	catch (exception $e)
	{
		echo "Fatal Error: " . $e->getMessage();
	}
}
//END: create css from less files

//echo "<br>";
//echo "<b>Exec minify js :</b>"."<br><br>";
/*$dir_js = __DIR__. '/assets/js/development/sixasix/';
$files_js = scandir($dir_js, 0);

for($i = 0; $i < count($files_js); $i++)
{
    $files_name_js = $files_js[$i];

    $str_js = $files_name_js;
    $name_expl_js = (explode(".js",$str_js));

    if (!file_exists(__DIR__. '/assets/js/production/sixasix/')){mkdir(__DIR__. '/assets/js/production/sixasix/', 0755, true);}

    //secho "hasil:".substr($str_js, -3)."<br>";
    if(substr($str_js, -3) !== ".js") continue;

    echo "exec:".$name_expl_js[0]."<br>";
    try
    {
        $minify_js = "minify --output ".__DIR__."/assets/js/production/sixasix/".$name_expl_js[0].".min.js ".__DIR__."/assets/js/development/sixasix/".$name_expl_js[0].".js";
        $result_js = exec($minify_js);
    }
    catch (exception $e)
    {
      echo "Fatal Error: " . $e->getMessage();
    }
}*/

echo "\nExec minify css :\n";
$dir_css = __DIR__. '/assets/'.$config_apps['template'].'/css/development/';
$files_css = scandir($dir_css, 0);
for($a = 0; $a < count($files_css); $a++)
{
	$files_name_css = $files_css[$a];

	$str_css = $files_name_css;
	$name_expl_css = (explode(".css",$str_css));

	if (!file_exists(__DIR__. '/assets/'.$config_apps['template'].'/css/production/')){mkdir(__DIR__. '/assets/'.$config_apps['template'].'/css/production/', 0755, true);}

	//echo "hasil:".substr($str_css, -4)."<br>";
	if(substr($str_css, -4) !== ".css") continue;

	echo "- ".$name_expl_css[0]."\n";
	try
	{
		$minify_css = 'minify --output '.__DIR__.'/assets/'.$config_apps['template'].'/css/production/'.$name_expl_css[0].'.min.css '.__DIR__.'/assets/'.$config_apps['template'].'/css/development/'.$name_expl_css[0].'.css';
		$result_css = exec($minify_css);
	}
	catch (exception $e)
	{
		echo "Fatal Error: " . $e->getMessage();
	}
}

//$minify_js = "minify --output minifyjs/jsone.min.js js/jsone.js";
//exec($minify_js);

//$minify_css = "minify --output minifycss/style.min.css css/style.css";
//$minify_css = "minify css/style.css";
//$result_exec =exec($minify_css);
?>
