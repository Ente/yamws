<?php
namespace yamws{
    class error extends auth{
        public function __construct(){

        }

        public function error_rep(string $message, int $user, string $method = NULL){
            global $glob_conf;
            if($method == NULL){
                $method = $_SERVER["REQUEST_METHOD"];
            }
            if(!isset($user)){
                $user = "NONE";
            }

            $error_file = $glob_conf["error_file"];
            $time = date("[d.m.Y | H:i:s]");
            error_log("{$time} \"{$message}\" \nUserID: {$user}\nURL: {$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]} \nBBA © {$glob_conf["st_year"]}\nSoftware Info: Version: {$glob_conf["version"]}Server IP:{$_SERVER["SERVER_ADDR"]} - Server Name: {$_SERVER["SERVER_NAME"]} - Request Method: '{$method}'\nRemote Addresse: {$_SERVER["REMOTE_ADDR"]} - Remote Name: '{$_SERVER["REMOTE_HOST"]}' - Remote Port: {$_SERVER["REMOTE_PORT"]}\nScript Name: '{$_SERVER["SCRIPT_FILENAME"]}'\n=======================\n", 3, $error_file);
        }


        /**
         * auth_error_token_data() - Returns information about a specific error
         * 
         * @param string $token - The 16-alphanumeric token from the auth_error_token function
         * @return array Returns a array containing error name, description, code and time (and other information). Returns false on error.
         * 
         */
        public function auth_error_token_data(string $token){
            global $conn;
            $sql = "SELECT * FROM errors WHERE token = '{$token}'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            if($count == 1){
                $data = mysqli_fetch_assoc($res);
                return $data;
            } else {
                return false;
            }
        }
        # TODO: More detailed for the check_uri_error() function
        /**
        * auth_error() - Outputs informations about errors, quite an error handler.
        *
        * @param string $type Error Type (is it a "login" error? "permissions" error?)
        * You can choose between "login", "permission", "server" or "X"
        * @param bool $report Allows you to report this error to the "technicians"
        * @return string Returns an error token. On failure "false"
        * @Notice This function returns a token. With this token you can get a few informations (e.g. group of the employee (technician or employee, admin)).
        * @Notice Try using the `auth_error_token_data()` function to get information about the token.
        */
        public function auth_error(string $type, bool $report = false){
            $yamws = new yamws();
            if($type != "login" || $type != "permission" || $type != "server" || $type != "X"){
                return false;
            } else {
                $error = $this->get_error_message($pseudo, $pseudo);
                $user = $this->get_data($_SESSION["user_id"], "1");
                $error_array = [
                    "timestamp" => time(),
                    "date_time" => date("d.m.Y | H:i:s"),
                    "user" => $_SESSION["user_id"],
                    "employee_group" => $user["role"],
                    "user_status" => $user["status"],
                    "user_name" => $user["user_name"],
                    "user_fullname" => $user["user_fullname"],
                    "user_email" => $user["user_email"]

                ];
            }
        }
        # TODO: Add multiple error messages with array and naming Error1, 2, ... -> then foreach

        /**
         * check_uri_error($error) - Checks the Request URI for any error parameters
         * 
         * @param array $error An error array containing message and id
         * @return array|string Returns a string containing HTML content
         */
        public function check_uri_error(array $error){
            $url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            if(strpos($url, "&error") || strpos($url, "?error")){
                switch($url){
                    case strpos($url, "type=login") == true:
                        $data = <<<EOD

                        <div class="container">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <b>Error: An error occured while logging in!</b>
                            <b>Error Message: {$error["message"]}</b>
                            <p>Error ID: {$error["id"]}</p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        </div>
                        EOD;
                        break;
                    case strpos($url, "type=permission") == true:
                        $data = <<<EOD

                        <div class="container">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <b>Error: An error occured while checking for permissions!</b>
                            <b>Error Message: {$error["message"]}</b>
                            <p>Error ID: {$error["id"]}</p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria hidden="true">&times;</span></button>
                        </div>
                        </div>
                        EOD;
                        break;
                    case strpos($url, "type=server") == true:
                        $data = <<<EOD

                        <div class="container">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <b>Error: An error occured while communicating with the server!</b>
                            <b>Error Message: {$error["message"]}</b>
                            <p>Error ID: {$error["id"]}</p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        </div>

                        EOD;
                        break;
                    default:
                        $data = <<<EOD

                        <div class="container">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <b>Error: An unknown error occured!</b>
                            <b>Error Message: {$error["message"]}</b>
                            <p>Error ID: {$error["id"]}</p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        </div>
                        EOD;
                }

                $error["message_now"] = $data;
                return $error;
            }
        }
        # TODO: security feature
        public function set_gui_error(array $error_array){

            $output = $error_array["message_now"];
            echo $output;
            
        }

        function get_error_message($type, $code){

            $error_messages = [
                "login_error" => [
                    "message" => "Error while logging in",
                    "description" => "An error occured while checking your credentials. Please check for the correct spelling.",
                    "code" => "1"
                ],
                "register" => [
                    "message" => "Error while register user",
                    "description" => "An error occured while completing your registration.",
                    "code" => "2"
                ],
                "..."
                
            ];
        }
    }
}





?>