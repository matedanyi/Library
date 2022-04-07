<?

class ErrorHandler {

  private $debug = true;

  public function __construct() {}

    public function errorAndDie($msg, $sql = null) {
      //logolja a hibát, application.php másol

      $time = @date('[d/M/Y:H:i:s]');
      $logStr = PHP_EOL . $time . $msg;



      if($sql !== null) {
        $logStr .=" -- SQL QUERRY: ".$sql;
      }

      $log = fopen("log/errorlog.txt", "a");
      fwrite($log, $logStr);
      fclose($log);


      if(!$this->debug) {
        $msg = 'Szerver oldali hiba!!!';
      }

      die($msg);

    }

}












?>
