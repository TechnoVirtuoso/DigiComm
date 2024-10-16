<?php 

echo do_shortcode( '[woocommerce_my_account]' );

?>

<!-- <?php if(!$block["page_select"]){ ?>
    <section class="signin">
        <div class="wrap_signin_section">
            <div class="main_heading">
                <h1><?php echo $block["main_heading"] ?></h1>
            </div>
            <form action="/order-detail/" class="signin_form" method="post">
                <div class="first_name column">
                    <label for="first_name">First Name : </label>
                    <input type="text" name="first_name" Placeholder="First Name">
                </div>
                <div class="last_name column">
                    <label for="last_name">Last Name : </label>
                    <input type="text" name="last_name" Placeholder="Last Name">
                </div>
                <div class="email column">
                    <label for="Email">Email : </label>
                    <input type="text" name="email" Placeholder="Email">
                </div>
                <div class="password column">
                    <label for="Password">Password : </label>
                    <input type="text" name="password" Placeholder="Password">
                </div>
                <div class="confirm_password column">
                    <label for="confirm_password">Confirm Password : </label>
                    <input type="text" name="confirm_password" Placeholder="Confirm Password">
                </div>
                <div class="submit_btn column">
                <a class="btn" href="<?php echo $block["button"]["url"] ?>"><button><?php echo $block["button"]["title"] ?></button></a>
                </div>
            </form>

        </div>
    </section>
<?php } ?>

<?php if($block["page_select"]){ ?>

    <section class="login">
        <div class="wrap_login_section">
            <div class="main_heading">
                <h1><?php echo $block["main_heading"] ?></h1>
            </div>
            <form action="/order-detail/" class="login_form" method="post">
                <div class="email column">
                    <label for="Email">Email : </label>
                    <input type="text" name="login-email" Placeholder="Email">
                </div>
                <div class="password column">
                    <label for="Password">Password : </label>
                    <input type="text" name=" login-password" Placeholder="Password">
                </div>
                <div class="login column">
                    <a class = "btn" href="<?php echo $block["button"]["url"] ?>"><button><?php echo $block["button"]["title"] ?></button></a>
                </div>
            </form>

        </div>
    </section>
<?php } ?> -->




