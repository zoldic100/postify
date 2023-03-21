<div class="posts  mt-5 pt-5 col-8 col-md-8  ">
    <?php
          $user_post = mysqli_query($conn, "SELECT * FROM post ORDER BY create_at desc  ");
          while ($post = mysqli_fetch_array($user_post)) :
            $post_user_id = $post['user_id'];
            // to create a comment we need   user_id and post id 

            $user_info = mysqli_query($conn, "SELECT * FROM users WHERE  id='$post_user_id'   ");
            while ($user_post_from_db = mysqli_fetch_array($user_info)) :
        ?>

    <div class="album   mb-4">
        <!-- i use that while to showing data from data base -->

        <!-- 1 card posts -->
 

            <div class="card  " style=" background-color: #f2f2f2; border: unset; ">
                <div class="card-head  d-flex justify-content-between align-items-center   "
                    style="height:100px; padding:0 15px 0 15px; ">
                    <div>


                        <img src="../media/profile_img/<?php echo $user_post_from_db['profile'] ?>" alt="" width="64"
                            height="64" class="rounded-circle me-2">
                        <strong><?php echo $user_post_from_db['fname'] . " " . $user_post_from_db['lname'] ?></strong>
                        <small class="text-muted"><i class="fa-solid fa-circle text-secondary "
                                style="width: 6px; margin:0 5px 0 10px;"></i></small>
                        <small class="text-muted"><?php echo getTimeDifference($post['create_at']) . " "  ?></small>
                    </div>
                    <div class="dropdown d-flex align-items-end">

                        <a href="#" class=" link-dark text-decoration-none " id="dropdownUser2"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis fs-3"></i>
                        </a>
                        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                            <li><a class="dropdown-item" href="#">New post</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Edit</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Sign out</a></li>
                        </ul>
                    </div>

                </div>
                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal<?php echo $post['post_id'] ?>">

                    <img src="../media/post_img/<?php echo $post['image'] ?>" class="bd-placeholder-img card-img-top"
                        alt="" width="100%">

                </a>
                <!-- card body -->
                <div class="card-body  p-0 m-0 ps-1 pt-1">
                    <div class="d-flex justify-content-between  align-items-center">
                        <div class="btn-group ps-0 ms-0">
                            <a href="#" class="link-dark fs-4 ">
                                <i class="fa-regular fa-heart"></i>
                            </a>
                            <a href="#" class="link-dark fs-4 ms-2" data-bs-toggle="modal"
                                data-bs-target="#imageModal<?php echo $post['post_id'] ?>">
                                <img src="../media/post_img/<?php echo $post['image'] ?>"
                                    class="bd-placeholder-img d-none card-img-top" alt="" width="100%">

                                <i class="fa-regular fa-comment"></i>
                            </a>
                        </div>
                        <small class="text-muted"><?php echo getTimeDifference($post['create_at']) . " "  ?></small>
                    </div>
                    <!-- description -->
                    <strong
                        class="fs-6"><?php echo $user_post_from_db['fname'] . " " . $user_post_from_db['lname'] ?></strong>
                    <small class="card-text pt-2"><?php echo $post['text'] ?>.</small>
                    <!-- comment form -->

                    <form method="Post" action="">

                        <div class="input-group ms-0 ps-0  mb-3">
                            <?php
                                        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Check if form was submitted
                                            //print_r($_POST);
                                            $post_id = $_POST['get_id'];
                                            $comment = $_POST['comment'];

                                            // Output the comment above the input field for the correct post
                                            if ($post_id == $post['post_id']) {
                                                echo '<div>' . htmlspecialchars($comment) . '</div>';
                                            }
                                        }
                                        ?>
                            <?php echo '<input name="get_id" type="hidden" class="form-control"  value="' . $post["post_id"] . '">'; ?>

                            <input name="comment" type="text" class="form-control" placeholder="Add a comment..."
                                aria-label="Recipient's username" aria-describedby="button-addon2" spellcheck="false"
                                data-ms-editor="true">
                            <input class="btn btn-outline-secondary" value="Post" type="submit" id="button-addon2">
                        </div>
                    </form>

                </div>
                <!-- popup model -->
                <div class="modal popup-model fade" id="imageModal<?php echo $post['post_id'] ?>" tabindex="-1"
                    aria-labelledby="imageModalLabel<?php echo $post['post_id'] ?>" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-8 p-0">
                                        <!-- image  -->
                                        <img src="../media/post_img/<?php echo $post['image'] ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <!-- wihte space -->
                                    <div
                                        class="col-md-4 p-0 modal-body-content  d-flex flex-column justify-content-between">
                                        <!-- profile picture -->
                                        <div class="row ms-2 mt-3">

                                            <div class=" col-6 text-start d-inline ">
                                                <div class="profile-img d-flex align-items-end d-inline">

                                                    <img src="../media/profile_img/<?php echo $data['profile'] ?>"
                                                        alt="" width="64" height="64" class="rounded-circle me-2">
                                                    <strong><?php echo $data['fname'] . " " . $data['lname'] ?></strong>


                                                </div>

                                            </div>
                                            <div class=" col-6 text-end d-inline ">

                                                <div class="btn-group dropend">
                                                    <button type="button" class="border-0 fs-4"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item text-danger"
                                                                href="delete.php?id=<?php echo  $post['post_id'] ?>">Delelte</a>
                                                        </li>

                                                        <li><a class="dropdown-item" href="#">Share</a></li>
                                                        <li><a class="dropdown-item" href="#">Cancel</a>
                                                        </li>
                                                    </ul>
                                                </div>


                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>

                                            </div>

                                        </div>
                                        <hr>
                                        <!-- description  area -->
                                        <div class="row ms-2 mt-3">
                                            <div class=" col-3 align-items-center text-start d-inline ">
                                                <div class="profile-img d-flex align-items-end d-inline">
                                                    <img src="../media/profile_img/<?php echo $data['profile'] ?>"
                                                        alt="" width="72" height="72" class="rounded-circle me-2">
                                                </div>

                                            </div>
                                            <div class="text-start mt-3  col-7 ">
                                                <strong><?php echo $data['fname'] . " " . $data['lname'] ?></strong>
                                                <span class="d-block text-trance text-truncate "
                                                    style="width:100%;"><?php echo $post['text'] ?></span>

                                            </div>
                                        </div>
                                        <!--  comment area-->
                                        <!-- check if there a comment -->
                                        <?php
                                                    $post_id_for_comment = $post['post_id'];
                                                    $check_comment = mysqli_query($conn, "SELECT * FROM `comment` WHERE post_id ='$post_id_for_comment'");
                                                    if (mysqli_num_rows($check_comment) < 1) : //if there a row in comment table
                                                    ?>

                                        <div class="row ms-2 mt-3  ">

                                            <div class="text-start mt-3  col-7 ">no comment
                                            </div>

                                        </div>
                                        <?php else : ?>
                                        <!-- comments -->
                                        <ul class="list-group list-group-flush p-0 m-0   ">
                                            <?php //echo $post['text'] 
                                                            $post_id_for_comment = $post['post_id'];
                                                            $comments_query = mysqli_query($conn, "SELECT * FROM `comment` WHERE post_id ='$post_id_for_comment'");
                                                            while ($comment = mysqli_fetch_array($comments_query)) :
                                                                $user_comment_id = $comment['user_id'];
                                                                //to get each comment
                                                                $user_comment_query = mysqli_query($conn, "SELECT * FROM users WHERE  id='$user_comment_id'   ");
                                                                while ($comment_by_comment = mysqli_fetch_array($user_comment_query)) :
                                                                    $user_id_from_comment = $comment['user_id']; ?>







                                            <li class="list-group-item p-0 m-0">
                                                <div class="row ms-2 mt-3">
                                                    <div class="col-3 align-items-center text-start d-inline ">
                                                        <div class="profile-img d-flex align-items-end d-inline">
                                                            <img src="../media/profile_img/<?php echo $comment_by_comment['profile'] ?>"
                                                                alt="" width="64" height="64"
                                                                class="rounded-circle me-2">
                                                        </div>
                                                    </div>
                                                    <div class="text-start mt-3 col-7">
                                                        <strong><?php echo $comment_by_comment['fname'] . " " . $comment_by_comment['lname'] ?></strong>
                                                        <small
                                                            class="d-flex  justify-content-between text-trance text-truncate"
                                                            style="width:100%;">
                                                            <!-- comment -->
                                                            <?php echo $comment['text'] ?>

                                                            <a
                                                                href="delete_cmt.php?id=<?php echo  $comment['comment_id'] ?>">
                                                                <i class="fa-solid fa-trash text-danger"></i>


                                                            </a>
                                                        </small>
                                                    </div>



                                                </div>
                                            </li>



                                            <?php endwhile ?>
                                            <?php endwhile ?>
                                        </ul>
                                        <?php endif ?>
                                        <!-- create comment -->
                                        <div class="comment text-center mt-auto ">
                                            <form method="Post" action="">

                                                <div class="input-group ms-0 ps-0  mb-3">
                                                    <?php
                                                                echo '<input name="get_id" type="hidden" class="form-control"  value="' . $post["post_id"] . '">'; ?>


                                                    <input name="comment" type="text" class="form-control"
                                                        placeholder="Add a comment..." aria-label="Recipient's username"
                                                        aria-describedby="button-addon2">
                                                    <input class="btn btn-outline-secondary" value="Post" type="submit"
                                                        id="button-addon2">
                                                </div>
                                            </form>
                                            <div class="form-group">



                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>





        


    </div>
    <?php endwhile; ?>

    <?php endwhile; ?>

</div>