<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php 
   if(!isset($_SERVER['HTTP_REFERER'])){
    echo "<script>window.location.href='".APPURL."' </script>";
    exit;
   }




?>


<div class="hero-wrap js-fullheight" style="background-image: url('<?php echo APPURL; ?>/images/Capture1.PNG'); background-attachment: fixed; background-position: center; background-size: cover;" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="col-md-7 ftco-animate text-center">
                <h2 class="subheading" style="font-size: 4em;">Pay Page for your Room</h2>
                <div class="container">
                    <!-- Replace "test" with your own sandbox Business account app client ID -->
                    <script src="https://www.paypal.com/sdk/js?client-id=test&currency=PHP"></script>
                    <!-- Set up a container element for the button -->
                    <div id="paypal-button-container"></div>
                    <script>
                        paypal.Buttons({
                            // Sets up the transaction when a payment button is clicked
                            createOrder: (data, actions) => {
                                return actions.order.create({
                                    purchase_units: [{
                                        amount: {
                                            value: '500' // Can also reference a variable or function
                                        }
                                    }]
                                });
                            },
                            // Finalize the transaction after payer approval
                            onApprove: (data, actions) => {
                                return actions.order.capture().then(function (orderData) {

                                    window.location.href = 'index.php';
                                });
                            }
                        }).render('#paypal-button-container');
                    </script>
                </div>

                <p><a href="#" class="btn btn-primary">Learn more</a> <a href="<?php echo APPURL; ?>/contact.php" class="btn btn-white">Contact us</a></p>
            </div>
        </div>
    </div>
</div>


    

<?php require "../includes/footer.php"; ?>


