<?php include 'inc/header.php'; ?>

<div class="banner contact-banner">
    <div class="overlay-text">
        <span>
            Contact Us
        </span>
    </div>
</div>

<div class="banner-bottom"></div>
<div class="banner-tabs tab-shadow">
    <div class="cover-line"></div>
    <div class="container tab-container">
    <div class="tab tab-solution"><a href="/solutions/">SOLUTIONS</a></div>
    <div class="tab tab-process"><a href="/process/">PROCESS</a></div>
    </div>
</div>

<div class="container" id="contact">
    <div class="row">

        <div class="col-sm-8 contact-form">
            <span class="caption">Talk to the team at Primal Surfacing today for all your surfacing needs.</span>
            <div class="form-text">
                <h3 id="form-text"></h3>
            </div>
            <form action="/actions/send-enquiry.php" id="contact-form">
                <input type="text" name="name" class="required form-control" placeholder="Name...">
                <input type="text" name="phone" class="required form-control" placeholder="Phone...">
                <input type="text" name="email" class="required email form-control" placeholder="Email Address...">
                <textarea name="message" class="required form-control"placeholder="Enquiry..."></textarea>
                <input type="submit" href="#" class="submit" value="Submit">
            </form>

            <div class="contact-wrapper">
                <div class="address">
                    <span>ADDRESS:</span>
                    <a href="https://www.google.com.au/maps/place/3+Oban+Ct,+Laverton+North+VIC+3026/@-37.825351,144.770207,17z/data=!3m1!4b1!4m2!3m1!1s0x6ad68a13c23291a3:0xd30c76038d5024ed"><span><?php cms('contact-address') ?></span></a>
                </div>
                <div class="contacts">
                    <span><?php cms('contact-phone') ?></span>
                    <span><?php cms('contact-fax') ?></span>
                    <a href="mailto:info@primalsurfacing.com.au"><span><?php cms('contact-email') ?></span></a>
                </div>
            </div>
        </div>

        <div class="col-sm-4 img-block">
            <?php cms('contact-feagure-img-1') ?>
            <?php cms('contact-feagure-img-2') ?>
        </div>
    </div>
</div>


<?php include 'inc/footer.php'; ?>