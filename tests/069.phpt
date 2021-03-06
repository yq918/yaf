--TEST--
Fixed bug that alter_response is not binary safe
--SKIPIF--
<?php if (!extension_loaded("yaf")) print "skip"; ?>
--INI--
yaf.use_spl_autoload=0
yaf.lowcase_path=0
yaf.use_namespace=0
--FILE--
<?php 
require "build.inc";
startup();

$config = array(
	"application" => array(
		"directory" => APPLICATION_PATH,
	),
);

file_put_contents(APPLICATION_PATH . "/controllers/Index.php", <<<PHP
<?php
   class IndexController extends Yaf_Controller_Abstract {
         public function indexAction() {
         }
   }
PHP
);


file_put_contents(APPLICATION_PATH . "/views/index/index.phtml", "head <?php echo chr(0);?> tail" . PHP_EOL);

$app = new Yaf_Application($config);
$app->run();
?>
--CLEAN--
<?php
require "build.inc"; 
shutdown();
?>
--EXPECTF--
head   tail
