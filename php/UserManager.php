<?php

class UserManager
{
    /* Root admin (v případě, že neexistuje žádný admin. Tento Admin nemůže zaniknout)*/
    private static $ADMIN_NAME = "admin";
    private static $ADMIN_PASSWORD = "$2y$10\$tdDql8oljvlCBU.SV95/AOqMUtNid2ZXOiaDmg8supN7hKf6lxZdq"; //root123

    static function isLogged(): bool {
        return isset($_SESSION["username"]);
    }

    static function isRootAdminLogged(): bool
    {
        if (!self::isLogged()) return false;
        return $_SESSION["username"] == self::$ADMIN_NAME;
    }

    static function isAdminLogged(): bool {
        if (!self::isLogged()) return false;
        if (self::isRootAdminLogged()) return true;

        return Db::queryOne("SELECT isadmin FROM users WHERE username=?",$_SESSION["username"])["isadmin"];
    }

    static function getLoggedUsername(): ?string {
        return self::isLogged() ? $_SESSION["username"] : null;
    }
    static function getLoggedId(): ?int {
        return self::isLogged() ? Db::queryOne("SELECT id FROM users WHERE username=?",self::getLoggedUsername())["id"] : null;
    }
    static function getUsernameById($id) {
        return Db::queryOne("SELECT username FROM users WHERE id=?",$id)["username"];
    }

    static function login($username, $password): bool{
        if ($username == self::$ADMIN_NAME && password_verify($password,self::$ADMIN_PASSWORD) ){
            $_SESSION["username"] = self::$ADMIN_NAME;
            return true;
        }

        $request_user = Db::queryAll("SELECT * FROM users WHERE username=? LIMIT 1",$username);
        if (sizeof($request_user) == 1 && password_verify($password,$request_user[0]["password"])) {
            $_SESSION["username"] = $request_user[0]["username"];
            BasketManager::initBasket();
            return true;
        }

        return false;
    }

    static function logout():bool {
        if (!self::isLogged()) return false;
        unset($_SESSION["username"]);
        BasketManager::destroyBasket();
        return true;
    }

    static function existsUser($username): bool {
        if ($username == self::$ADMIN_NAME) return true;
        return sizeof(Db::queryAll("SELECT * FROM users WHERE username=? LIMIT 1",$username)) == 1;
    }

    static function existsEmail($email): bool {
        return sizeof(Db::queryAll("SELECT * FROM users WHERE email=? LIMIT 1",$email)) == 1;
    }

    static function existsPhoneNumber($number): bool {
        return sizeof(Db::queryAll("SELECT * FROM users WHERE phonenumber=? LIMIT 1",$number)) == 1;
    }

    static function register($username,$firstname,$lastname,$password,$email,$phonenumber,$street,$propertynum,$city,$postcode): bool {

        if (self::existsUser($username)) return false;
        if (self::existsPhoneNumber($phonenumber)) return false;
        if (self::existsEmail($email)) return false;

        Db::query("
            INSERT INTO `users` 
                (`username`, `firstname`, `lastname` ,`password`, `email`, `phonenumber`, `street`, `propertynum`, `city`, `postcode`,`isadmin`) 
            VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,False)
            "
            ,$username,$firstname,$lastname,password_hash($password,PASSWORD_BCRYPT),strtolower($email),$phonenumber,$street,$propertynum,$city,$postcode
        );
        return true;
    }

    static function getUsersDatabaseInfo(){
        return Db::queryAll("SELECT * FROM users");
    }

    static function changePassword($oldpassword,$newpassword): bool{
        if(!self::isLogged()) return false;

        if (password_verify($oldpassword,Db::queryOne("SELECT password FROM users WHERE username=?",self::getLoggedUsername())["password"])){
            Db::query("UPDATE users SET password=? WHERE username=?",password_hash($newpassword,PASSWORD_BCRYPT),self::getLoggedUsername());
            return true;
        }
        return false;
    }

    static function promoteToAdmin($userid){
        Db::query("UPDATE users SET isadmin=? WHERE id=?",True,$userid);
    }
    static function demoteToAdmin($userid){
        Db::query("UPDATE users SET isadmin=? WHERE id=?",False,$userid);
    }
    static function unregister($id){
        Db::query("DELETE FROM users WHERE id=?",$id);
    }

}