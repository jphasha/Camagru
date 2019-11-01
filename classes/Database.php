<?php
class DataBase //a singleton class?
{
    // the underscores before the variable names are just there to denote that the variable is private.
    private static $_instance = null;//a variable that will store our instance whenever it is available.
    private $_pdo,// when a pdo object is instantiated, it will be stored in this variable for later use.
            $_query,// here we store the last query that is executed.
            $_error = false,// here there will be no change unless there is an error encountered.
            $_results,// if we were to search for 10 users from the database, they will be stored here.
            $_count = 0;// and of course, the count of the said results.

    // a constructor function that will connect to the database.
    private function __construct()// private functions can only be used by variables and methods within the class?
    {
        try
        {
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
            // the above line is saying: inside the private variable '$_pdo', store the PDO query to connect:
            // "new PDO('mysql:host=localhost;dbname=db_jphasha,root,password')
            // this info is accessed from the $GLOBALS variable inside the core/initialise.php file through the Config class inside the classes/config.php file.

            // now just to set the PDO error mode to Exception. (i.e.)we are trying to catch some exception.
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        catch (PDOException $some_exception)
        {
            die ("connection failed because :" . $some_exception->getMessage());
        }
    }

    // a function to instantiate (to create / establish)
    public static function getInstance()
    {
        if (!isset(self::$_instance))// where we have not instantiated our class:
        {
            self::$_instance = new DataBase();// we instantiate our 'DataBase' class.
            // echo "instance<br>"; // wanted to see how many times it will instantiate.
        }
        return self::$_instance; //the 'getInstance()' function will instantiate our class when called upon. but only if there was no instantiation that has already occured. (i.e.) no connection has been established already.
    }

    // a function to QUERY
    public function query($sql, $parameters = array())//$sql = an sql query statatement, $parameters,
    {
        $this->_query = $this->_pdo->prepare($sql);
        $this->_error = false; // to make sure that the error that is returned is not the error of the previous query as this function may end up performing multiple queries.
        if ($this->_query = $this->_pdo->prepare($sql))//to prepare and check if the preparation has been successful. | prepared statements protect against sql injections.
        {
            // echo "success<br>"; // if the preparation of the if statement was successful.

            // now to bind the entered values to the prepared statement.
            $value_counter = 1;//for a case where by there is more than one value that needs to be binded to the prepared statement(s).
            if (count($parameters))
            {
                foreach ($parameters as $parameter)//iterate through the parameters and bind them one by one to their prepared statements.
                {
                    $this->_query->bindValue($value_counter, $parameter);
                    $value_counter++;
                }
            }
            // echo "binded " . $value_counter . " times<br>";
            // now that preparation has been carried out, let's execute the prepared statement(s).
            if ($this->_query->execute())
            {
                // echo "prepared and executed<br>";
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ); // fetches all the results of the query and put them in an object form.
                $this->_count = $this->_query->rowCount();
            }
            else
            {
                $this->_error = true;
            }
            // echo $this->_count . "<br>"; //getting the count of rows for the data in the query.
        }
        return $this; // return the current object. i.e. return the end-product of the above code block.
    }

    // the ACTION function, now that we have prepared our statements, it's time to do stuff with them (the statements).
    public function action($action, $table, $where = array())
    {
        if (count($where) === 3) //(i.e.) the 'field' (e.g. user_name), 'operator' (e.g. =) and 'value' (e.g. porter) must all be provided in order for the query to be valid (all three).
        {
            $operators = array('=', '>', '<', '>=', '<=');// defining all the valid / allowed operators.

            $field =    $where[0];
            $operator = $where[1];
            $value =    $where[2];

            if (in_array($operator, $operators))// checking if the entered operator matches one of the pre-defined '$operators'.
            {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

                if (!$this->query($sql, array($value))->error()) // to check if the binding of the value is successful.
                {
                    return $this;
                }
            }
        }
        return false;
    }

    // the GET function which is used to retrieve data from the database.
    public function get($table, $where)
    {
        return $this->action('SELECT *', $table, $where);
    }
    // the DELETE function to delete stuff from the database.
    public function delete($table, $where)
    {
        return $this->action('DELETE', $table, $where);
    }
    // a function to INSERT data into a table.
    public function insert($table, $fields = array())
    {
        if (count($fields))
        {
            $keys = array_keys($fields);
            $values = '';
            $stp_con = 1;

            foreach ($fields as $field)
            {
                $values .= '?';
                if (count($fields) > $stp_con)
                {
                    $values .= ', ';
                }
                $stp_con++;
            }

            $sql = "INSERT INTO users (`" . implode("`, `", $keys) . "`) VALUES ({$values})";
            // echo $sql;
            if (!$this->query($sql, $fields)->error())
            {
                return true;
            }
        }
        return false;
    }
    // the RESULTS function which is used to return all the results of a query and not only the first part of the results.
    public function results()
    {
        return $this->_results;
    }
    // a function to display the FIRST item. the first item that appears in the query results.
    public function first()
    {
        return $this->results()[0];
    }
    // the ALL_NAMES function which is a derivative of the RESULTS function to get all the user_names of the users in the 'table'.
    // public function all_names()
    // {
    //     $all_names = $this->_results->results();
    //     return $all_names; //i'm missing something. brb
    // }
    // the ERROR function.
    public function error() // that's what it does, it checks for errors.
    {
        return $this->_error;
    }

    // the COUNT function. checks for existence of content.
    public function count()
    {
        return $this->_count;
    }
}
?>