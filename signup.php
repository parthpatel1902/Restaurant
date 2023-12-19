<?php
include('header.php');
?>
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<body>
    <?php
    include('navbar.php');
    ?>
    <section id="book-a-table" class="book-a-table">
        <div class="container">
            <div class="section-header">
                <p>Sign Up</p>
            </div>
            <div class="row g-0">
                <div class="col-lg-4 reservation-img" style="background-image: url(assets/img/reservation.jpg);"></div>
                <div class="col-lg-8 d-flex align-items-center reservation-form-bg">
                    <form action="signup_data.php" method="post" role="form" class="php-email-form">
                        <div class="row gy-4">
                            <div class="col-lg-8 mx-auto">
                                <input type="text" name="fname" class="form-control" id="fname" placeholder="Your First Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" required>
                            </div>
                            <div class="col-lg-8 mx-auto">
                                <input type="text" name="lname" class="form-control" id="lname" placeholder="Your Last Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" required>
                            </div>
                            <div class="col-lg-8 mx-auto">
                                <input type="number" name="phoneNumber" class="form-control" id="phoneNumber" placeholder="Your Phone Number" data-rule="minlen:4" data-msg="Please enter at least 4 chars" required>
                            </div>
                            <div class="col-lg-8 mx-auto">
                                <input type="number" class="form-control" name="pincode" id="pincode" placeholder="Your Pincode" data-rule="minlen:4" data-msg="Please enter at least 4 chars" required>
                            </div>
                            <div class="col-lg-8 mx-auto">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" required>
                            </div>
                            <div class="col-lg-8 mx-auto">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" data-rule="minlen:4" data-msg="Please enter at least 4 chars" required>
                            </div>
                        </div>
                        <div class="text-center mt-3"><button type="submit">Sign Up</button></div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>