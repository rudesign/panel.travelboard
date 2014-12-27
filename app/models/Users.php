<?php

class Users extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $visible;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $sid;

    /**
     *
     * @var string
     */
    protected $login;

    /**
     *
     * @var string
     */
    protected $password;


    /**
     * Method to set the value of field visible
     *
     * @param integer $visible
     * @return $this
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Method to set the value of field name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setCity($name)
    {
        $this->city = $name;

        return $this;
    }


    /**
     * Method to set the value of field sid
     *
     * @param string $sid
     * @return $this
     */
    public function setSid($sid)
    {
        $this->sid = $sid;

        return $this;
    }

    /**
     * Method to set the value of field login
     *
     * @param string $login
     * @return $this
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Method to set the value of field password
     *
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Generate session id key
     * @return string
     */
    public function makeSid(){
        return $this->getDI()->get('security')->hash(time());
    }

    /**
     * Returns the value of field visible
     *
     * @return integer
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Returns the value of field sid
     *
     * @return string
     */
    public function getSid()
    {
        return $this->sid;
    }

    /**
     * Returns the value of field login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Returns the value of field password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'visible' => 'visible', 
            'name' => 'name', 
            'city' => 'city',
            'login' => 'login', 
            'password' => 'password',
            'sid' => 'sid'
        );
    }

    public function signup()
    {

        // Get user by auth data
        if($user = $this->checkIfLoginExists($this->getLogin())) throw new \Exception('Login exists');

        // Update user
        if(!$this->save()) throw new \Exception('User creation failed');

        $this->login($this->getLogin(), $this->getPassword(), true);

        return true;
    }


    /**
     * Perform login
     * @param string $login
     * @param string $password
     * @return bool
     * @throws Exception
     */
    public function login($login = '', $password = '', $passwordSecured = false)
    {
        $this->getSession()->remove('sid');

        // Get user by auth data
        $user = $this->getByAuthData($login, $password, $passwordSecured);

        // Generate new session id
        if(!$sid = $this->makeSid()) throw new \Exception('Empty session id');

        // Change user model data set
        $user->setSid($sid);

        // Store sid in the session
        $this->getSession()->set('sid', $sid);

        // Update user
        if(!$user->update()) throw new \Exception('Session id update failed');

        return true;
    }

    /**
     * @param string $login
     * @return Users
     * @throws Exception
     */
    public function checkIfLoginExists($login = ''){
        if(empty($login)) throw new \Exception('Не указан login');

        $result = $this->query()->where("login='{$login}'")->limit(1)->execute();

        return ($user = $result->getFirst()) ? $user : null;
    }

    /**
     * Get user by auth data: login & password
     * @param string $login
     * @param string $password
     * @return Users
     * @throws Exception
     */
    public function getByAuthData($login = '', $password = '', $passwordSecured = false)
    {
        if(empty($login)) $login = $this->getLogin();
        if(empty($password)) $password = $this->getPassword();

        if(empty($login)) throw new \Exception('Не указан login');
        if(empty($password)) throw new \Exception('Не указан пароль');

        if(!$user = $this->checkIfLoginExists($login)) throw new Exception('Пользователь не зарегистрирован');

        if($passwordSecured){
            if($password != $user->password) throw new \Exception('Неверный пароль');
        }else{
            if(!$this->getDI()->get('security')->checkHash($password, $user->password)) throw new \Exception('Неверный пароль');
        }

        return $user;
    }

    /**
     * Get user by session id
     * @return null|Users
     */
    public function getBySid()
    {
        try{
            if(!$this->getSession()->has('sid')) throw new \Exception;

            $sid = $this->getSession()->get('sid');

            $result = $this->query()->where("sid='{$sid}'")->limit(1)->execute();

            if(!$user = $result->getFirst()) throw new \Exception;

            return $user;
        }catch (\Exception $e){
            return null;
        }
    }

    public function logout(){
        $this->getSession()->destroy();
    }

    /**
     * @return Phalcon\Session\Bag()
     */
    protected function getSession(){
        return $this->getDI()->get('session');
    }

    /**
     * Returns people grid item uri
     * @return string
     */
    public function getPeopleItemUri()
    {
        $uri = $this->getDI()->get('url')->get(array(
            'for'=>'peopleItem',
            'id'=>$this->getId(),
        ));

        return $uri;
    }
}
