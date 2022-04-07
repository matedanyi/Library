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
        /*  echo '$params<br>';
        var_dump($params);
        echo '<br>';
        echo '$sql<br>';
        echo '<br>';
        echo '$this->sql<br>';
        var_dump($this->sql);
        echo '<br>';
        echo 'strtr$this->sql<br>';
        var_dump(strtr($this->sql['users'], $params));*/
        $user = $this->getResultList(strtr($this->sql['users'], $params));

        /*echo '<br>';
        echo '$user<br>';
        debug($user);
        var_dump($user);
        echo '<br>';
        echo '<br>';*/

        return $user;
    }

    public function setSessionId()
    {

        /*  echo '$params <br>';
        var_dump($params);
        echo '<br>';*/
        $sql = 'UPDATE users u SET u.sid = ' . "'" . $_SESSION['sid'] . "'" . ' WHERE loginname = ' . "'" . $_SESSION['user'] . "'";

        echo $sql;
        echo '<br>';
        debug($sql);
        $this->execute($sql);
        //return $sql;
        //return  $sId;


    }

    
}
