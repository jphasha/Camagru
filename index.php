<?php
// print_r(PDO::getAvailableDrivers()); //to see the list of drivers that are available for you to use. on my machine, it is mysql: version=sqlite.

// now to connect to the database that is hosted in the above driver.

// $connection = new PDO('mysql:host=localhost;dbname=rush', 'root', ''); //MYSQL=driver; HOST=your server host, for now we are dealing with localhost(127.0.0.1); dbname=whichever database you will be connecting to \
                                                       // and accessing; 'user' then 'password'. should any of the above entries be wrong, a connection will fail to establish and thus you may get, the page does not exist

// now for error mode
// we will use the try-catch block
try
{
    $connection = new PDO('mysql:host=localhost;dbname=rush', 'root', '369089jp');
    // $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //because i have activated the error handling in the php.ini, there is no difference whether this statement is in or not.
}
// TRY will try to run whatever code is in the TRY block, if it fails, the CATCH block will catch that error or exception and instead of crashing the page ito \
// the error/exception, it will instead execute the code that is in the CATCH block.
catch(PDOException $some_exception) //in this case, the EXCEPTION/ERROR that is caught, is stored inside the variable $SOME_EXCEPTION or which ever variable that you have declared here.
{
    echo $some_exception->getMessage()."</br>";
    die('password?');
}
    // catch() catches the error that has occurred and do whatever corrective measure you direct it to do.
    // for instance, if you have inputted the wrong database, user, password.
    // in this case, die() is used as a corrective measure to ensure that the error will not cause the page to stop working without warning. also to make sure that \
    // the program stops on our terms.

    // IF THERE IS NO EXCEPTION CAUGHT.

    echo "OK! we are good! </br>";

    // now to access a table inside a database
    $container = $connection->query('SELECT * FROM users'); //a query or a request to the database to return everything(*) from the table USERS.
    // while($cont = $container->fetch())
    // {
    //     echo $cont['user_email']."<br>"; //this statement will return all the user_emails line by line.
    // }
    $cont = $container->fetch();
    echo '<pre>', var_dump($cont), '</pre>';
?>