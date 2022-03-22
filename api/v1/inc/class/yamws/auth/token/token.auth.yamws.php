<?php
namespace yamws{
    require "/var/www/maintenance/api/v1/inc/loader.php";
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    class token extends auth{
        public function __construct(){
            
        }
        /**
         * generate_token_user() - Generates a JWT token for API use
         * 
         * @param int $user_id - User ID
         * @param string $user_email - THe Email address of the user
         * @param string $aud - "Audience" - FOr what is the key for? 
         */
        public function generate_token_user($user_id, $user_email, $aud = "user"){
            #if($aud != "user" || $aud != "service"){
            #    return false;
            #}
            $iat = time();
            $iss = "yamws";
            $key = $user_id;
            $payload = [
                "iss" => $iss,
                "iat" => $iat,
                "aud" => $aud,
                "user_id" => $user_id,
                "user_email" => $user_email
            ];
            $jwt = JWT::encode($payload, $key, 'HS256');
            #$decode = JWT::decode($jwt, new Key($key, 'HS256'));

            return [
                "jwt" => $jwt,
                "key" => $key,
                "algorithm" => 'HS256'
            ];
        }
        /**
         * decode_token_user() - Decodes a JWT-Token containing user information, etc.
         * 
         * @param object $jwt_object - A jwt object from the encode_token_user() function
         * @param string $key - Public key from the token
         * @param int $user_id - The ID from the user. "Issued for"
         * @return array|bool Returns the decoded JWT or a boolean
         */
        public function decode_token_user($jwt_object, $key, $user_id){
            if(!is_object($jwt_object)){
                return false;
            }
            $decode = (array) JWT::decode($jwt_object, new Key($key, 'HS256'));
            if($decode["user_id"] != $user_id){
                return false;
            } 

            return $decode;
        }
    }
}



?>