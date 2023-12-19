<?php

include('header.php');

?>

<body>
    <?php
    include('navbar.php');
    ?>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <section id="book-a-table" class="book-a-table">
        <div class="container">
            <div class="section-header">
                <p>Login</p>
            </div>
            <div>
                <?php
                    include('message.php');
                ?>
            </div>
            <div class="row g-0">
                <div class="col-lg-4 reservation-img" style="background-image: url(assets/img/reservation.jpg);"></div>
                <div class="col-lg-8 d-flex align-items-center reservation-form-bg">
                    <form action="login_data.php" method="post" role="form" class="php-email-form">
                        <div class="row gy-4 text-center">
                            <div class="col-lg-12 mx-auto">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" required>
                                <div class="validate"></div>
                            </div>
                            <div class="col-lg-12 mx-auto">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Your Password" data-rule="minlen:4" data-msg="Please enter at least 4 chars" required>
                                <div class="validate"></div>
                            </div>
                            <div class="mb-3">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your booking request was sent. We will call back or send an Email to confirm your reservation. Thank you!</div>
                            </div>
                            <div>
                                <button class="btn btn-danger mt-2" type="submit">Login</button>&nbsp;&nbsp;&nbsp;
                                <button class="btn btn-danger mt-2" type="button"><a href="signup.php" style="color:aliceblue;">Signup
                                    </a></button>
                            </div>
                            <!-- <button class="btn btn-danger" type="submit"><a href="signup.php" style="color:aliceblue;font-weight: bold;">signup</a></button> -->
                    </form>
                </div>
            </div>
        </div>
    </section>

</body>