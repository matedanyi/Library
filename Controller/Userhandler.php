<?
include_once('AppController.php');

class Userhandler extends AppController
{

    public function __construct()
    {
        parent::__construct();

        $this->allowedMethods(array('login', 'logout'));
    }


    public function login()
    {
        $this->template = 'admin/login';

        if (isset($_POST['loginname']) && isset($_POST['password'])) {

            $loginname = $_POST['loginname'];
            $pass = md5($_POST['password']);


            if (strlen($_POST['loginname']) > 10) {
                $this->messages[] = 'Username is too long!';
                echo 'Username is too long!';
                return false;
            }

            if (!is_string($_POST['loginname'])) {
                $this->messages[] = 'Username can only be text';
                echo 'Username can only be text';
                return false;
            }

            if ((empty($_POST['password']))) {
                $this->messages[] = "Password field can not be empty";
                echo 'Password field can not be empty';
                return false;
            }

            $this->useModels(array('Users'));
            $user = array();
            $user = $this->Users->getUser($loginname, $pass);
            $this->set('user', $user);
            $user = array(
                'loginname' => $user[0]['loginname'],
                'password' => $user[0]['password'],
                'role' => $user[0]['role'],

            );
         //   var_dump($user);
            if (
                strtolower($_POST['loginname']) == strtolower($user['loginname'])
                && md5($_POST['password']) == $user['password']
            ) {
                $userSessionId = session_id();
                $_SESSION['user'] = $user['loginname'];
                $_SESSION['sid'] = $userSessionId;
                $_SESSION['role'] = $user['role'];
             //   var_dump($_SESSION);

                $user = $this->Users->setSessionId();
                header('Location: ?library/backend');
                exit;
            } else {
                $this->msg->setSessionMessage('Incorrect username or password');
            }
        }
    }

    public function logout()
    {
        $this->useModels(array('Users'));

        $_SESSION['sid'] = null;

        $this->Users->setSessionId();
        session_unset();
        session_destroy();
        header('Location: ?library/index');
        exit;
    }
}
