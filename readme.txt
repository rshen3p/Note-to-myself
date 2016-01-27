Assignment 1: Note-to-myslef

Group member: Ricky Zheng Rui, Chen   ID: A00074589
Group member: Andrew, Walsh            ID: A00837208

Link to our website:

http://allyouneedmarket.x10host.com/note-to-myself/public/index.php/home

Step:     Score:    Implementation:
1.        5         Click on register link will take you to the register account page. Enter the 
                    account information. Make sure password match. System will go to database and 
                    compare to see if there is any duplicates. If everything checks out, user will
                    be sent an email for account actication. Password is hashed using MD5 when stored
                    into database. Username has to follow email format inorder to be consdered valid.

2.        5         When a new user wants to register, they have to pass the reCaptcha implemented from
                    Google.

3.        5         User can click on forgot password link from the home screen. Then they can enter their
					email/username to receive an email with their new passowrd in it. The new password will
					also be sotred into database and hashed with MD5.

4.        5         User cannot login right after they create the account. They must go into their email and 
                    click on the activation link to activate their account. I have a active status implemented
                    in the account database that checks for the status.

5.        4         I have a counter in the account databse that keeps track of the number of invalid logins. 
                    Once it reaches 3 the account is locked. A new password is generated and sent to the user 
                    via email. The email will notify the user his or her account was under attack and they must login with their new password from now on. 

6.        5         Notes have their own databse table. User's notes will be added to the database via query. 

7.        5         Similiar to Notes, tbd have their own databse table. User's tbd will be added to the
                    database via query. 

8.        5         Similiar to Notes, links have their own databse table. User's links will be added to the
                    database via query.

9.        5         Similiar to Notes, images have their own databse table. User's images will be added to the
                    database via query. Images will be displayed to the screen in smaller size to fit the screen. 

10.       5         Users can make changes to the note and click on submit. The submit button will trigger 
                    the update query for the database thus the system will store new data. 

11.       5         See 10)

12.       5         See 10)

13.       5         Insde the image table in my database, there is a userID associated to each image, I would 
                    run a count() function that counts the number of images inside the databse for the current
                    userID, if it is equal to 4 then no new image can be uploaded.  
 
14.       5         In my controller I specificed only 2 types of image can be uploaded via 
                    ($_FILE['photo']['type']) see below:

                    if($_FILES['photo']['error'] === UPLOAD_ERR_OK){
            			if($_FILES['photo']['type'] == "image/jpeg" || $_FILES['photo']['type'] == "image/jpg"
               				 || $_FILES['photo']['type'] == "image/gif" ) {
               			 Image::insert(array('userID' => $userID,'image' => file_get_contents($_FILES['photo']['tmp_name'])));
           				}
      				}

15.       5         I have a $_POST['delete'] function that if it is triggered, the databse will be notified 
                    and delete the image accordingly.

16.       5         I don't use a temp folder to hold images, I store them directly to the databse.

17.       5         A stand alone View for logout that is called if the user clicks on logout 

18.       3         The content page where all user data will be displayed can only be triggered through login.                    If user try to access the page directly an error will be thrown. Didn't implament cookie. 

19.       5         Changed the value of 'secure' to true in session.config. 

20.       5         Changed the value of lifetime is session.config to 20.          

Total score: 97/100