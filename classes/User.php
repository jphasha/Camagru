<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class User
{
    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn;

    public function __construct($user = null)
    {
        $this->_db = DB::getInstance();

        $this->_sessionName = Config::get('sessions/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

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

    public function update($fields = array(), $id = null)
    {
        if (!$id && $this->isLoggedIn())
        {
            $id = $this->data()->user_id;
        }

        if (!$this->_db->update('users', $id, $fields))
        {
            throw new Exception('there was a problem<br>');
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
    public function login($username = null, $password = null, $remember = false)
    {
        if (!$username && !$password && $this->exists())
        {
            Session::put($this->_sessionName, $this->_data->user_id); // user/session id???
        }
        else
        {
            $user = $this->find($username);
            if ($user)
            {
                if ($this->data()->user_pass === Hash::make($password, $this->data()->salt))
                {
                    Session::put($this->_sessionName, $this->data()->user_id);

                    if ($remember)
                    {
                        $hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->user_id));

                        if (!$hashCheck->count())
                        {
                            $hash = Hash::unique();
                            $this->_db->insert('users_session', array(
                                'user_id' => $this->data()->user_id,
                                'hash' => $hash
                            )
                        );
                        }
                        else
                        {
                            $hash = $hashCheck->first()->hash;
                        }
                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }

                    return true;
                }
            }
        }
        return false;
    }

    public function hasPermission($key)
    {
        $group = $this->_db->get('groups', array('user_id', '=', $this->data()->group)); //WHAT??

        if ($group->count())
        {
            $permission = json($group->first()->permissions, true);

            if ($permission[$key] == true)
            {
                return true;
            }
        }
        return false;
    }

    public function exists()
    {
        if (empty($this->_data))
        {
            return false;
        }
        return true;
    }

    public function logout()
    {
        $this->_db->delete('users_session', array('user_id', '=', $this->data()->user_id));

        Session::delete($this->_sessionName); // simple, just delete the current session.
        Cookie::delete($this->_cookieName);
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