<?php
class User
{
    private $_db,
            $_data,
            $_sessionName,
            $_isLoggedIn;

    public function __construct($user = null)
    {
        $this->_db = DB::getInstance();

        $this->_sessionName = Config::get('sessions/session_name');

        if (!$user)
        {
            if (Session::exists($this->_sessionName))
            {
                $user = Session::get($this->_sessionName);

                if ($this->find($user))
                {
                    $this->_isLoggedIn = true;
                }
                else
                {
                    // process logout
                }
            }
        }
        else
        {
            $this->find($user);
        }
    }

    public function create($fields = array())
    {
        if (!$this->_db->insert('users', $fields))
        {
            throw new Exception('Failed to create an account.');
        }
    }

    public function find($variable = null) // $variable can represent anything. but in this case it represents $user.
    {
        if ($variable)
        {
            if (is_numeric($variable)) // this will obviously be problematic if the user's username is all numbers.
            {
                $table_field = 'user_id';
            }
            else
            {
                $table_field = 'user_name';
            }
            $data = $this->_db->get('users', array($table_field, '=', $variable));

            if ($data->count())
            {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }
    public function login($username = null, $password = null, $remember)
    {
        $user = $this->find($username);

        if ($user)
        {
            if ($this->data()->password === Hash::make($password, $this->data()->salt))
            {
                Session::put($this->_sessionName, $this->data()->id);

                if ($remember)
                {
                    $hash = Hash::unique();
                }

                return true;
            }
        }
        return false;
    }

    public function logout()
    {
        Session::delete($this->_sessionName); // simple, just delete the current session.
    }

    public function data()
    {
        return $this->_data;
    }

    public function isLoggedIn() //this function is there for the purpose of returning the details of a logged in user.
    {
        return $this->_isLoggedIn;
    }
}
?>