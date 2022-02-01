<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CT_Custom
 */

?>

<!-- Footer -->
<footer class="main-footer centre-content flex-horizontal">
            <!-- Contact Form -->
            <div class="form-container">
                <div class="heading">
                    <h6>Contact Us</h6>
                    <hr>
                </div>
                <form action="#" method="post" class="contact-form" id="contact-form" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
                    <div class="name-field-container">
                        <input type="text" name="name" class="name-field" id="name" placeholder="Name*">
                        <p class="feedback-message error inactive"></p>
                    </div>
                    <div class="phone-field-container">
                        <input type="tel" name="phone" class="phone-field" id="phone" placeholder="Phone*">
                        <p class="feedback-message error inactive"></p>
                    </div>
                    <div class="email-field-container">
                        <input type="email" name="email" class="email-field" id="email" placeholder="Email*">
                        <p class="feedback-message error inactive"></p>
                    </div>
                    <div class="message-field-container">
                        <textarea name="message" cols="30" rows="10" class="message-field" id="message" placeholder="Message*"></textarea>
                        <p class="feedback-message error inactive"></p>
                    </div>
                    <div class="submit-button-container">
                        <button type="submit" class="submit-button">Submit</button>
                        <p class="feedback-message success inactive">Message sent successfully!</p>
                        <p class="feedback-message failure inactive">Message failed to send.</p>
                    </div>
                </form>
            </div>
            <!-- Contact Information -->
            <div class="contact-info">
                <div class="heading">
                    <h6>Reach Us</h6>
                    <hr>
                </div>
                <h5 class="company">Coalition Skills Test</h5>
                <div class="address">
                    <p><?php echo get_option('office_address_street'); ?></p>
                    <p><?php echo get_option('office_address_country'); ?></p>
                </div>
                <p class="phone">Phone: <a href="tel:<?php echo get_option('phone_number'); ?>"><?php echo get_option('phone_number'); ?></a></p>
                <p class="fax">Fax: <?php echo get_option('phone_number'); ?></p>
                <div class="social-networks white-links">
                <?php
                
                    $facebook_url = get_option('facebook_url');
                    $twitter_url = get_option('twitter_url');
                    $linkedin_url = get_option('linkedin_url');
                    $pinterest_url = get_option('pinterest_url');
                
                ?>
                    <?php if ($facebook_url != '') { ?><a href="<?php echo $facebook_url; ?>" target="_blank"><i class="fa fa-facebook"></i></a><?php }?>
                    <?php if ($twitter_url != '') { ?><a href="<?php echo $twitter_url; ?>" target="_blank"><i class="fa fa-twitter"></i></a><?php }?>
                    <?php if ($linkedin_url != '') { ?><a href="<?php echo $linkedin_url; ?>" target="_blank"><i class="fa fa-linkedin"></i></a><?php }?>
                    <?php if ($pinterest_url != '') { ?><a href="<?php echo $pinterest_url; ?>" target="_blank"><i class="fa fa-pinterest-p"></i></a><?php }?>
                </div>
            </div>
        </footer>
        <?php wp_footer(); ?>