<?php

 namespace App\Models;

 use \App\Token;
 use \Core\Model;
 

 use PDO;
    /*** User Model ***/

    class User extends Model{

        /**
        * Error messages
        *
        * @var array
        */
        public $errors= [];


        /**
        * User object constructor
        * Dynamically create  new properties and values
        *
        * @param array $data Initial property values (optional)
        * 
        * 
        * @return 
        */
        public function __construct($data =[]){
            foreach($data as $key => $value){
                $this->$key = $value;
            };

        }


        /**
        * Save user insert prepare param values into table
        * validate values first
        * 
        *
        * @return boolean True if the user was saved, false otherwise
        */
        public function save(){

            //validate values first
            $this->validate();

            //check if there are any errors
            if(empty($this->errors)){
        
                $sql = "INSERT INTO users ( name, email, password_hash ) VALUES ( :name, :email, :password_hash )";

                $password_hashed = password_hash($this->password_hash, PASSWORD_DEFAULT);
                
                try {
                
                $db= static::getDB();
                    $stmt = $db->prepare($sql);//prepare statement

                    $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
                    $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
                    $stmt->bindValue(':password_hash', $password_hashed, PDO::PARAM_STR);
                    
                   return  $stmt->execute();//returns true or false

                    
                    } catch(PDOException $e){
                        echo $e->getMessage();
                    }

            }//end of errors check
           
           return false;//incase validation fails
    
            
        }



        /**
        * Validate current property values, 
        * adding validation error messages to the errors array property
        *
        * @return void
        */
        public function validate(){
            
            // Name
            if($this->name == ''){
                $this->errors[] = 'Name is required';
            }

            // Email address
            //Filter Email
            if(filter_var($this->email, FILTER_VALIDATE_EMAIL) === false){
                $this->errors[] = 'Invalid email.';
            }

            if(static::mailExists($this->email)){
                $this->errors[] = 'Email already taken';
            }

            // Password 
            //check if passwords match
            if($this->password_hash != $this->password_confirmation){
                $this->errors[] = 'Password must match confirmation';
            }

            // check if password is more than 5 characters
            if(strlen($this->password_hash) < 5){
                $this->errors[] = 'Please enter at least 5 characters for the password';
            }

            // check if password has at least one letter.
            if(preg_match ('/.*[a-z]+.*/i', $this->password_hash) == 0){
                $this->errors[] = 'Password needs at least one letter';
            }

            // Check if password has at least one number
            if(preg_match('/.*\d+.*/i', $this->password_hash) == 0){
                $this->errors[] = 'Password needs at least one number';
            }


        }//end of validation


        /**
        * See if a user record already exists with the specified email
        *
        * @param string $email address to search for
        *
        * @return boolean True if a reacord 
        * already exists with the specified email, false otherwise
        */
        public static function emailExists($email){
            return static::findByEmail() !== false;
        }

        /**
        * Find a user model by email address
        *
        * @param string $email email address to search for
        *
        * @return mixed User object if found, false otherwise
        */
        public static function findByEmail($email){
            $sql = 'SELECT * FROM users WHERE email = :email';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);

            //returns object with this line else array
            //get_called_class() returns 'App\Models\User'
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
            $stmt->execute();

            //if email is not false meaning one exists
            // return the boolean
            // true if it exists or false if it doesn't
            return $stmt->fetch();
        }

        



        /**
        * Authenticate a user by email and password
        *
        * @param string $email email address
        * @param string $password password
        *
        * @return mixed The user object or false if authentication fails
        */

        public static function authenticate($email, $password){
            $user = static::findByEmail($email);

            if($user){
                if(password_verify($password, $user->password_hash)){//native php methods
                    return $user;
                }
            }
            return false;

        }

        /**
        * Find a user model by by ID
        *
        * @param int $id ID  to search for
        *
        * @return mixed User object if found, false otherwise
        */
        public static function findByID($id){
            $sql = 'SELECT * FROM users WHERE id = :id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            //returns object with this line else array
            //get_called_class() returns 'App\Models\User'
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
            $stmt->execute();

            //if email is not false meaning one exists
            // return the boolean
            // true if it exists or false if it doesn't
            return $stmt->fetch();
        }


        /**
        * Remember the login by inserting a new unique token into the login_tokens table
        * for this user record
        *
        * @return boolean True if th elogin was remembered successfully, false otherwise
        */
        public function rememberLogin(){
            $token = new Token();
            $hashed_token =$token->getHash();

            //add remember_token property to user
            $this->remember_token = $token->getValue();


            //add expiry_timestamp property to user
            $this->expiry_timestamp = time() + 60 * 60 *24 * 7; // 7days from now

            $sql = 'INSERT INTO login_tokens (token_hash, user_id, expires_at) 
                    VALUES (:token_hash, :user_id, :expires_at)';

                    $db = static::getDB();
                    $stmt = $db->prepare($sql);

                    $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
                    $stmt->bindValue(':user_id', $this->id, PDO::PARAM_INT);
                    $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $this->expiry_timestamp), PDO::PARAM_STR);
                    
                    return $stmt->execute();


        }



    }
    




?>