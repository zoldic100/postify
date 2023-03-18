<?php
session_start();
$pageTitle = "Login";



include './layout.php'; ?>

<?php
include_once('../db/conn.php');



$falseEmailOrPass = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = mysqli_real_escape_string($conn,  $_POST['email']);
    $password = mysqli_real_escape_string($conn,  $_POST['password']);

    $error = [];

    if (!$email) {
        $errors[] = 'email  is requared';
    }
    if (!$password) {
        $errors[] = 'password is requared';
    }



    if (!isset($errors)) {
        $query = "SELECT * FROM users WHERE  email='$email'  AND password ='$password' limit 1";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows != 0) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['lname'] = $row['lname'];
            $_SESSION['email'] = $row['email'];

            header('location:./welcom.php');
        } else {
            $falseEmailOrPass = 'Incorrect email or password. Please try again.';
        }
    }
}
?>
<div class="container">
    <div class="row">
        

        <div class="col-md-6 d-flex justify-content-center align-items-center">
        <div class="row">
        <div class="col-md-6 w-100 ">
            <h2 class="display-1 fw-bold text-lg-start text-md-center" >Postify</h2>
            <p class="display-6">Postify, share and stay connected with your community.</p>
        </div>
        </div>
        </div>
        
        

        <div class="col-md-6">
            <div class="login">
                <div class="container ">
                    <div>
                        <?php if (!empty($errors)) : ?>
                            <div class="alert alert-danger">
                                <?php foreach ($errors as $error) : ?>
                                    <div><?php echo '- ' . $error; ?></div>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                    </div>
                    <form action="" method="POST">
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="email">Email address</label>
                            <input type="email" name="email" id="email" class="form-control" />

                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" />

                        </div>
                        <div class="form-outline mb-4">

                            <?php if (!$falseEmailOrPass) : ?>
                                <div></div>
                            <?php endif ?>
                            <?php if ($falseEmailOrPass) : ?>
                                <div class="mt-2 alert alert-danger">
                                    <div><?= $falseEmailOrPass; ?></div>
                                </div>

                            <?php endif ?>
                        </div>





                        <!-- 2 column grid layout for inline styling -->
                        <div class="row mb-4">
                            <div class="col d-flex justify-content-center">
                                <!-- Checkbox -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                                    <label class="form-check-label" for="form2Example31"> Remember me </label>
                                </div>
                            </div>

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
                            <p>Not a member? <a href="./signup.php">Register</a></p>
                            <p>or sign up with:</p>
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
        </div>
    </div>
</div>