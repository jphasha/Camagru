<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Validate
{
    private $_passed = false,
            $_errors = array(),
            $_db = null;

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    public function check($source, $items = array())
    {
        foreach($items as $item => $rules) // $items are the input fields ('username, password, etc');
        {
            foreach($rules as $rule => $rule_value) // $rules is the array that contains the rule table (required => true, etc).
            { // $rule is the key value(s) == required, min, max.
              // $$rule_value are the assoc values == true, 2, 50.
                $value = trim($source[$item]); // just in case there are spaces before or after an entry, the entry must still be valid.
                $item = escape($item); // the entered entry will be freed of backslashes and other funny characters.
                // echo "{$item} {$rule} must be {$rule_value}";
                // when referring to password minimum requirement.
                // the above statement must read: password min must be 2.
                if ($rule === 'required' && empty($value))
                {
                    $this->addError("{$item} is required");
                }

                else if (!empty($value))
                {
                    switch ($rule)
                    {
                        case 'min':
                            if (strlen($value) < $rule_value)
                            {
                                $this->addError("{$item} requires a minimum of {$rule_value} characters");
                            }
                        break;

                        case 'max':
                        if (strlen($value) > $rule_value)
                        {
                            $this->addError("{$item} requires a maximum of {$rule_value} characters");
                        }
                        break;

                        case 'matches':
                            if ($value != $source[$rule_value])
                            {
                                $this->addError("{$item} must match {$rule_value}");
                            }
                        break;

                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if ($check->count())
                            {
                                $this->addError("{$item} already exist, try a different {$item}");
                            }
                        break;

                        case 'strong_pattern':
                            if (!preg_match('/([a-z])([A-Z])/', $value))
                            {
                                $this->addError("{$item} must have {$rule_value} characters in it");
                            }
                        break;

                        case 'valid_name':
                            if (!preg_match('/([a-zA-Z])/', $value))
                            {
                                $this->addError("{$item} must contain {$rule_value} characters");
                            }
                        break;
                    }
                }
            }
        }

        if (empty($this->_errors))
        {
            $this->_passed = true;
        }

        return $this;
    }

    public function addError($error)
    {
        $this->_errors[] = $error;
    }

    public function errors()
    {
        return $this->_errors;
    }

    public function passed()
    {
        return $this->_passed;
    }
}
?>