<?
include_once('Application.php');

class Users extends Application
{

    public function __construct()
    {
        parent::__construct();
    }

    public $sql = array(
        'users' => "SELECT u.loginname, u.password FROM users u
                    WHERE u.loginname = '{loginname}' and u.password = '{password}'"
    );

    public function getUser($loginname, $pass)
    {
        $params = array(
            '{loginname}' => $loginname,
            '{password}' => $pass
        );
        $user = $this->getResultList(strtr($this->sql['users'], $params));
        return $user;
    }

    public function setSessionId()
    {
        $sql = 'UPDATE users u SET u.sid = ' . "'" . $_SESSION['sid'] . "'" . ' WHERE loginname = ' . "'" . $_SESSION['user'] . "'";
        $this->execute($sql);
    }
}
