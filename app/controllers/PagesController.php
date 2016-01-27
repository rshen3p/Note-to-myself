<?php
session_start();
ob_start();

class PagesController extends BaseController {

    public function generateRandomString($length = 4) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }



    public function generatePassAndEmail(){
        $newPass = $this->generateRandomString();
        return $newPass;
    }



    public function home(){
        return View::make('home');
    }



    public function returnProfile($userID = 0){
        if($userID == 0) {
            $userID = User::select('userID')->where('email', $_POST["username"])
                ->where('password',md5($_POST["password"]))->first();
            if ($userID == null) {
                $tempUserID = User::select('userID')->where('email',$_POST["username"])->first();
                if($tempUserID != null){
                    $count = User::select('count')->where('email',$_POST["username"])->first();
                    $count = $count->toArray();
                    $count = $count["count"];
                    $count++;
                    User::where('email',$_POST["username"])->update(array('count' =>$count));
                    if($count >= 3){
                        echo "ACCOUNT LOCKED";
                        User::where('email',$_POST["username"])->update(array('password' => md5($_POST["password"])));
                        Mail::send('emails.emailBreak', array('code' => $_POST["password"]), function($message) {
                            $message->to($_POST["username"], 'User')->subject('Account Blocked!');
                        });
                        return 'locked';
                    }
                }
                exit("Login Error. Did you <a href='forgotPass'>forget your password?</a> Please try again to "
                    . "<a href='register'>register</a> or <a href='home'>Log in</a>.");
            }
            $userID = $userID->toArray();
            $userID = $userID["userID"];
        }

        $table = User::
        join('notes','user.userID','=','notes.userID')
            ->join('tbd','user.userID','=','tbd.userID')
            ->where('user.userID',$userID)->get();
        $profile = $table->toArray();

        $websiteArray = array();
        $table = Website::select('website')->where('userID',$userID)->get()->toArray();
        foreach ($table as $info) {
            array_push($websiteArray,$info["website"]);
        }

        $imageArray = array();
        $table = Image::select('image')->where('userID',$userID)->get()->toArray();
        foreach ($table as $info) {
            array_push($imageArray,$info["image"]);
        }
        $profile = $profile + array("websites" => $websiteArray) + array("image" => $imageArray);
        $_SESSION["validLogin"] = true;
        return $profile;
    }



    public function processLogin(){
        $user = User::select('verification')->where('email',$_POST["username"])->first();
        if($user["verification"] != ""){
            exit("NOT VERIFIED");
        }
        $profile = $this->returnProfile();
        if($profile == 'locked') {
            return View::make('forgotPassword');
        }
        User::where('email',$_POST["username"])->update(array('count' => 0));
        $_SESSION["valid"] = true;
        $_SESSION["time"] = time();
        return View::make('profile')->with('userProfile',$profile);
    }



    public function register(){
        return View::make('register')->with('error',"");
    }



    public function processRegister(){
        if(!(filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))){
            return View::make('register')->with('error',"EMAIL NOT VALID");
        }
        $result = User::select('email')->where('email',$_POST["email"])->get();
        $result = $result->toArray();
        if($result != null){
            exit("Account already exists for ". $_POST["email"] . ". Did you "
                . "<a href='forgotPass'>forget your password?</a> Please try again to "
                . "<a href='register'>register</a> or <a href='home'>log in</a>");
        }
        if($_POST["pass"] == "")
            exit("MUST HAVE PASSWORD. " . "<a href='register'>Register</a>" );
        if($_POST["confirmPass"] == "")
            exit("MUST HAVE CONFIRM PASS. " . "<a href='register'>Register</a>" );
        if($_POST["pass"] != $_POST["confirmPass"]) {
            exit("Password Not The Same. " . "<a href='register'>Register</a>");
        }
        // email with link
        $verificationCode = $this->generateRandomString(10);
        User::insert(array('email' => $_POST["email"],'password' => md5($_POST["pass"])
            ,'verification' => $verificationCode));
        $result = User::select('userID')->where('email',$_POST["email"])->first()->toArray();
        $userID = $result["userID"];
        Image::insert(array('userID' =>$userID,'image' => ''));
        Notes::insert(array('userID' =>$userID,'notes' => ''));
        TBD::insert(array('userID' =>$userID,'tbd' => ''));
        Website::insert(array('userID' =>$userID,'website' => ''));

        Mail::send('emails.emailMessage', array('code' => $verificationCode, 'email' => $_POST["email"]), function($message) {
            $message->to($_POST["email"], 'User')->subject('Welcome!');
        });

        return View::make('registerComplete');
    }



    public function forgotPass(){
        return View::make('forgotPassword');
    }



    public function processForgotPassword(){
        $result = User::select('email')->where('email',$_POST["email"])->get();
        $result = $result->toArray();
        if($result == null){
            exit('No record for ' . $_POST["email"] . ". Please <a href='register'>Register</a>");
        }
        $profile = array();
        array_push($profile,$_POST["email"]);
        $newPass = $this->generatePassAndEmail();
        array_push($profile,$newPass);
        User::where('email',$result)->update(array('count'=>0));
        // EMAIL WITH NEW PASSWORD
        User::where('email',$result)->update(array('password' => md5($newPass)));
        Mail::send('emails.emailNewPass', array('code' => $newPass), function($message) {
            $message->to($_POST["email"], 'User')->subject('Temporary Password');
        });


        return View::make('newPasswordSent')->with('profile',$profile);

    }



    public function submitPage(){
        $timeDiff = round(abs(time() - $_SESSION["time"]) / 60,2). " minute";
        if($timeDiff >= 20){
            exit("LOGGED OUT OF INACTIVE. <a href='home'>Log In</a>");
        }
        $userID = $_POST["userID"];

        $result = Image::where('userID',$userID)->count();
        if(file_exists($_FILES['photo']['tmp_name']) || is_uploaded_file($_FILES['photo']['tmp_name'])) {
            $result++;
        }
        if($result >= 4){
            echo $result;
            exit("CAN ONLY HAVE 4 IMAGES GO BACK");
        }

        $id = Image::select('id')->where('userID',$userID)->get()->toArray();

        for($i = 0; $i < $result; $i++){
            if(isset($_POST["delete$i"])){
                Image::where('id',$id[$i]["id"])->delete();
            }
        }

        Notes::where('userID', $_POST["userID"])
            ->update(array('notes' => $_POST["notes"]));

        TBD::where('userID', $_POST["userID"])
            ->update(array('tbd' => $_POST["tbd"]));

        $emailArray = array();
        for($i = 0; $i < 10;$i++){
            if(isset($_POST["website$i"]) && $_POST["website$i"] != ""){
                array_push($emailArray,$_POST["website$i"]);
            }
        }
        for($i = 0; $i < count($emailArray); $i++){
            $result = Website::select('website')->where('website',$emailArray[$i])->get();
            if($result == "[]"){
                Website::insert(array('userID' => $userID, 'website' => $emailArray[$i]));
            }
        }

        if($_FILES['photo']['error'] === UPLOAD_ERR_OK){
            if($_FILES['photo']['type'] == "image/jpeg" || $_FILES['photo']['type'] == "image/jpg"
                || $_FILES['photo']['type'] == "image/gif" ) {
                Image::insert(array('userID' => $userID,'image' => file_get_contents($_FILES['photo']['tmp_name'])));
            }
        }
        $profile = $this->returnProfile($_POST["userID"]);
        return View::make('profile')->with('userProfile',$profile);
    }



    public function logout(){
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        return View::make('logout');
    }



    public function verify($code, $email) {
        if ($code == null || $email == null) {
            exit("Whoops, no code or email");
        }
        User::where('email',$email)->update(array('verification'=>''));
        User::where('email',$email)->update(array('active'=>1));
        echo "ACCOUNT VERIFIED";
        sleep(5);
        return Redirect::to('home');
    }



    public function resetPass($email){
        return View::make('resetPass')->with('email',$email);
    }



    public function processResetPass(){
        User::where('email',$_POST["email"])->update(array('password' => md5($_POST["password"])));
        User::where('email',$_POST["email"])->update(array('count' => 0));
        echo "<a href='home'>Log In</a>";
    }
}
ob_end_flush();
