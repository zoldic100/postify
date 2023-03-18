<?php
$pageTitle = "Sing Up";
include './layout.php'; ?>

<?php
include_once('../db/conn.php');
$falseEmail = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']); /*to prevent to be hacked*/
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn,  $_POST['email']);
    $password = mysqli_real_escape_string($conn,  $_POST['password']);

    $error = [];


    if (!$fname) {
        $errors[] = 'first name is requared';
    }
    if (!$lname) {
        $errors[] = 'last name is requared';
    }
    if (!$email) {
        $errors[] = 'email  is requared';
    }
    if (!$password) {
        $errors[] = 'password is requared';
    }

    if (empty($_FILES['profile']['name'])) {
        $errors[] = 'photo is requared';
    }

    $checkIfEmailAlreadyUsed =mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($checkIfEmailAlreadyUsed)!=0){
        $errors[]= 'the email is already used';
    }



    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $falseEmail = 'enter a valid email';
    }


    if (!isset($errors)) {

        $file_name = $_FILES['profile']['name'];
        $file_tmp_name = $_FILES['profile']['tmp_name'];
        $file_size = $_FILES['profile']['size'];
        $file_error = $_FILES['profile']['error'];
        $file = explode('.', $file_name); //bach tfr9
        $file_accepte = strtolower(end($file));
        $allowed = array('png', 'jpg', 'svg', 'jpge');
        if (in_array($file_accepte, $allowed)) {
            if ($file_error === 0) {
                if ($file_size < 4000000) {
                    $image_new_name = uniqid("", true) . "-" . $file_name;
                    $target = '../media/profile_img/' . $image_new_name;
                    $sql = " INSERT INTO users (fname,lname,email,password,profile) VALUES('$fname','$lname','$email','$password','$image_new_name')";
                    if (!empty($file_name)) {
                        mysqli_query($conn, $sql);
                        if (move_uploaded_file($file_tmp_name, $target)); // to save file in target location
                        header('location:./login.php');
                    }
                }
                else {
                    $errors[]= ' image size is too big';
                }

            }
        }
    }
};
?>

<div class="login">
    <div class="container">
        <div>
            <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error) : ?>
                        <div><?php echo '- ' . $error; ?></div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="form-outline">
                        <label class="form-label" for="fname">First name</label>
                        <input type="text" name="fname" id="fname" class="form-control" />

                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-outline">
                        <label class="form-label" for="lname">Last name</label>
                        <input type="text" name="lname" id="lname" class="form-control" />

                    </div>
                </div>
            </div>
            <!-- Email input -->
            <div class="form-outline mb-4">

                <label class="form-label" for="email">Email address</label>
                <input type="email" name="email" id="email" class="form-control" />

                <?php if (!$falseEmail) : ?>
                    <div>
                    </div>

                <?php endif ?>
                <?php if ($falseEmail) : ?>
                    <div class="mt-2 alert alert-danger">
                        <div><?= $falseEmail; ?></div>
                    </div>

                <?php endif ?>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" />
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="profile">Profile Pictue</label>
                <input type="file" name="profile" class="form-control" id="profile">

            </div>


            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-4 text-center">


                <div class="col">
                    <!-- Simple link -->
                    <a href="#!">Forgot password?</a>
                </div>
            </div>

            <!-- Submit button -->
            <div class="text-center">
                <input type="submit" class="btn btn-primary btn-block mb-4" value="Sign Up">

            </div>
            <!-- Register buttons -->
            <div class="text-center">
                <p>You Have An Account? <a href="./login.php">Sign in</a></p>
                <p>or sign in with:</p>
                <button type="button" class="btn btn-link btn-floating mx-1">
                    <i class="fab fa-facebook-f"></i>
                </button>

                <button type="button" class="btn btn-link btn-floating mx-1">
                    <i class="fab fa-google"></i>
                </button>

                <button type="button" class="btn btn-link btn-floating mx-1">
                    <i class="fab fa-twitter"></i>
                </button>

                <button type="button" class="btn btn-link btn-floating mx-1">
                    <i class="fab fa-github"></i>
                </button>
            </div>
        </form>
    </div>
</div>