<?
class Messages
{
  private $message = array();
  private $type = '';

  private $validationMessages = array();

  public function __construct()
  {
    if (!isset($_SESSION['messages'])) {
      $_SESSION['messages'] = array();
      $_SESSION['messages_flag'] = false;
    }

    if (isset($_SESSION['validation'])) {
      $_SESSION['validation'] = array();
      $_SESSION['validationMessageFlag'] = false;
    }
  }

  public function setValidationMsg($field, $message)
  {
    $this->validationMessages[$field] = $message;
    $_SESSION['validation'] = $this->validationMessages;
    $_SESSION['validationMessageFlag'] = false;
  }

  public function getValidationMessage($field)
  {
    if (!$_SESSION['validationMessageFlag']) {
      $js = ""; //"<script> $('input[name=\"$field\"]').css('border-color', 'red') </script> ";
      echo $_SESSION['validation'][$field] . $js;
      $_SESSION['validationMessageFlag'] = true;
      $_SESSION['validation'] = array();
    }
  }

  public function setErrorMsg($str)
  {
    $this->message[] = $str;
    $this->type = 'error_msg';
  }

  public function messages()
  {
    if (!empty($this->message)) {
      echo "<div class='{$this->type} msg'>" . implode("<br>", $this->message) . "</div>";
    }
  }


  public function setSessionMessage($str)
  {
    $_SESSION['messages'][] = $str;
    $_SESSION['messages_flag'] = false;
  }

  public function getSessionMessage()
  {
    if (!$_SESSION['messages_flag']) {
      echo implode(', <br>', $_SESSION['messages']);
      $_SESSION['messages_flag'] = true;
      $_SESSION['messages'] = array();
    }
  }
}
