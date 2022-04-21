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

            //TODO: Loginname validálása, users tábla és model létrehozása, a user adatok lekérése

            /* if (strlen($_POST['loginname']) > 10) {
                $this->messages[] = 'A felhasználónév túl hosszú!';
                echo 'A felhasználónév túl hosszú!';
                return false;
            }

            if (!is_string($_POST['loginname'])) {
                $this->messages[] = 'A felhasználónév csak szöveg lehet';
                echo 'A felhasználónév csak szöveg lehet!';
                return false;
            }

            if ((empty($_POST['password']))) {
                $this->messages[] = 'A jelszó kitöltése kötelező';
                echo 'A jelszó kitöltése kötelező!';
                return false;
            }*/
            $this->useModels(array('Users'));
            $user = array();
            $user = $this->Users->getUser($loginname, $pass);
            $this->set('user', $user);
            $user = array(
                'loginname' => $user[0]['loginname'],
                'password' => $user[0]['password'],
            );
            if (
                strtolower($_POST['loginname']) == strtolower($user['loginname'])
                && md5($_POST['password']) == $user['password']
            ) {
                $userSessionId = session_id();
                $_SESSION['user'] = $user['loginname'];
                $_SESSION['sid'] = $userSessionId;

                $user = $this->Users->setSessionId();
                header('Location: ?library/backend');
                exit;
            } else {
                $this->msg->setSessionMessage('Helytelen felhasználó név vagy jelszó!');
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
