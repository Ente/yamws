<?php
namespace yamws{
    /**
     * Class used by the maintenance website, which is called "Yet another Maintenance Website"
     * 
     * @author Bryan B. <bryan.boehnke-avan@macmon.eu>
     * @link https://github.com/Ente/yamws
     */
    use yamws\yamws;
    use yamws\token;
    class auth extends yamws{

        public function __construct(){
            #$conn = conn();
            $twt = new token();
            return $twt;
        }


        function register(string $user, string $password){
            $user = mysqli_real_escape_string($GLOBALS["conn"], $user);
            $password = password_hash($password, PASSWORD_DEFAULT);

            $creation_date = time();
            $id = rand(11111, PHP_INT_MAX);
            $token = bin2hex(random_bytes(16));

            $sql = "INSERT INTO users (id, username, password, group, status, creation_date, last_login_date, token) VALUES ({$id}, {$user}, {$password}, 'user', '1', '{$creation_date}', NULL, '{$token}');";
            $res = mysqli_query($GLOBALS["conn"], $sql);
            if(mysqli_error($GLOBALS["conn"])){
                die("Error: " . mysqli_error($GLOBALS["conn"]));
            } else {
                header("Location: ../../../login?info=success_register");
            }
            
       }

        /**
         * A function to login the user, who registered before with the register() function
         * 
         * @param String $user - The username
         * @param String $password - The password from the user
         * @return bool - Returns TRUE on success login and FALSE otherwise
         * 
         */
        function login(string $user, string $password){
           $yamws = new yamws;
           $mysql = $yamws->conn();
           $user = mysqli_real_escape_string($mysql, $user);
           $sql = "SELECT * FROM users WHERE user_name = '{$user}';";
           $res = mysqli_query($mysql, $sql);
           $count = mysqli_num_rows($res) or die(mysqli_error($mysql));
           if($count == 1){
                $data = mysqli_fetch_assoc($res);
                if(session_status() !== PHP_SESSION_ACTIVE){
                        session_start();
                        $_SESSION["user_id"] = $data["user_id"];
                }
                while($data = mysqli_fetch_array($res)){
                    if(password_verify($password, $data["password"])){
                        return true;
                    } else {
                        return false;
                    }
                }

            } else {
                return false;
            }
        }

       /**
        * user_session - Start a user session
        *
        * @param String $id - the user ID
        * @return bool - Returns 1 on success, returns 0 when session wasn't started yet - security issue - ends function
        * 
        */
       public function user_session(int $id){
           if(session_status() == PHP_SESSION_ACTIVE){
               $_SESSION["logged_in"] = true;
               $_SESSION["id"] = session_id();

               return 1;

           } else {
                return 0;
           }
       }
       
       /**
        * get_data() - Gets all the user data from the Database
        *
        * @param string $user The username
        * @param string $token encrypted token
        * @return array|false Returns an array with user data on success or false on error
        */
       public function get_data(string $user, string $token){
           if($this->check_token_user($token, $user) != true){
                return false;
           }
           $user = mysqli_real_escape_string($GLOBALS["conn"], $user);
           $sql = "SELECT * FROM users WHERE username = '{$user}';";
           $res = mysqli_query($GLOBALS["conn"], $sql);
           $count = mysqli_num_rows($res);
           if($count == 1){
               $data = mysqli_fetch_assoc($res);
               return $data;
           } else {
               return false;
           }
       }
       # TODO: Test this function
       /**
        *  get_auth_header() - Gets relevant authorization headers from the HTTP request
        *
        *  @return string|void Returns "Authorization" value or void
        *  @link <https://gist.github.com/wildiney/b0be69ff9960642b4f7d3ec2ff3ffb0b>
        *  @author Wildiney Di Masi
        *  @copyright Wildiney Di Masi
        */
       public function get_auth_header(){
            $headers = null;
            if(isset($_SERVER["Authorization"])){
                $headers = trim($_SERVER["Authorization"]);
                # NGINX & fCGI check
            } elseif(isset($_SERVER["HTTP_AUTHORIZATION"])){
                $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
            } elseif(function_exists("apache_request_headers")){
                $requestHeaders = apache_request_headers();
                $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
                if(isset($requestHeaders["Authorization"])){
                    $headers = trim($requestHeaders["Authorization"]);
                }
            }

            return $headers;
        }
        # TODO: Test this function
        /**
         * get_bearer_token() - Gets the bearer token from the Authorization headers
         * 
         * @return string|bool Returns the Token on success - On failure "false"
         * @link <https://gist.github.com/wildiney/b0be69ff9960642b4f7d3ec2ff3ffb0b>
         * @author Wildiney Di Masi 
         */
        public function get_bearer_token(){
            $headers = $this->get_auth_header();
            if(!empty($headers)){
                if(preg_match("/Bearer\s(\S+)/", $headers, $matches)){
                    return $matches[1];
                }
            }
            return null;
        }

        /*  TODO: check_token($token)
            - Check token in DataBase
            - Return true, when token is alright for the user

        */
        public function check_token_web(string $token, string $user){
            global $twt;
            $jwt = $twt;
            $token = $this->get_bearer_token();
            $token = $jwt->decode_token();

            
        }

        public function check_token_internal(string $token, string $user){
            global $twt;
            $token = $twt->decode_token();
        }

        /* TODO: check_action()
            - Create list with functions
            - Create list with permissions for groups (e.g. Employee, Admins, Technicians)
            - FLEXIBLE!
        */
        private function check_action_user(string $token, string $action, string $user){

        }

    }
}



?>