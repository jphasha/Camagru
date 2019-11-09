<?php
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
        foreach($items as $item => $rules)
        {
            foreach($rules as $rule => $rule_value)
            {
                $value = $source[$item];
                
                if ($rule === 'required' && empty($rule_value))
                {
                    $this->addError("{$item} is required");
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
        return $this->$_errors;
    }

    public function passed()
    {
        return $this->_passed;
    }
}
?>