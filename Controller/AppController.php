<?

class AppController
{

  protected $template = '';
  protected $variables = array();

  public $msg = null;
  private $allowedMethodList = array();
  private $protectedMethodList = array();

  public function __construct()
  {
    include_once('Utils/Messages.php');
    $this->msg = new Messages();
  }

  protected function allowedMethods($list)
  {
    $this->allowedMethodList = $list;
  }

  public function getAllowedMethods()
  {
    return $this->allowedMethodList;
  }

  protected function protectedMethods($list)
  {
    $this->protectedMethodList = $list;
  }

  public function getProtectedMethods()
  {
    return $this->protectedMethodList;
  }

  public function hasRole($method)
  {
    // debug($method);
    // debug($this->allowedMethodList);
    // debug($_SESSION['user']);
    // debug($this->protectedMethodList);


    if (!in_array($method, $this->allowedMethodList) && $_SESSION['user'] == null) {
      return false;
    } elseif (!in_array($method, $this->allowedMethodList) && $_SESSION['user'] != null) {
      $accessMethods = $this->protectedMethodList[$_SESSION['role']];

      if (in_array($method, $accessMethods)) {
        return true;
      } else {
        return false;
      }
    } else {
      return true;
    }
  }

  public function getTemplate()
  {
    return $this->template;
  }

  protected function useModels($models)
  {
    foreach ($models as $model) {
      include_once("Model/$model.php");
      $this->{$model} = new $model();
    }
  }

  protected function set($name, $value)
  {
    $this->variables[$name] = $value;
  }


  public function getContent()
  {
    $msg = $this->msg;
    $object = $this;

    if (empty($this->getTemplate()) || !$this->getTemplate()) {
      $this->template = 'error';
    }

    foreach ($this->variables as $name => $value) {
      ${$name} = $value;
    }

    include_once('View/' . $this->getTemplate() . '.php');
  }
}
