<?php
class Hash
{
    // salt improves the security of a password hash because it adds a randomly generated string.
    // this string is added to the end of the user's password. this makes hacking difficult.
    public static function make($string) //a function that makes/creates the hash.
    {
        return hash('sha256', $string . $salt);
    }

    public static function salt($length) // to generate salt. $length = how long do you want your randomly generated string to be?.
    {
        return mcrypt_create_iv($length); // our random nonsense generator.
    }

    public static function unique() //making a unique hash.
    {
        return self::make(uniqid());
    }
}
?>