<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php 

  //resort accommudation
   $resort_accom = $conn->query("SELECT * FROM resort_accom WHERE status = 1");
   $resort_accom->execute();

   $allresort_accom = $resort_accom ->fetchAll(PDO::FETCH_OBJ);
   
   //rooms
   $rooms = $conn->query("SELECT * FROM rooms WHERE status = 1");
   $rooms->execute();

   $allrooms = $rooms ->fetchAll(PDO::FETCH_OBJ);


?>


    <div class="hero-wrap js-fullheight" style="background-image: url('images/Capture1.PNG');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-7 ftco-animate">
          	<h2 class="subheading">Welcome to Hi-Way 411 Resort</h2>
          	<h1 class="mb-4">Reserve your room escape effortlessly today</h1>
            <p><a href="#" class="btn btn-primary">Learn more</a> <a href="<?php echo APPURL; ?>/contact.php" class="btn btn-white">Contact us</a></p>
          </div>
        </div>
      </div>
    </div>

  
    <section class="ftco-section ftco-services">
    	<div class="container">
    	<div class="row">
			<?php foreach($allresort_accom as $resort) : ?>
          <div class="col-md-4 d-flex services align-self-stretch px-4 ftco-animate">
            <div class="d-block services-wrap text-center">
              <div class="img" style="background-image: url(images/<?php echo $resort->image; ?>);"></div>
              <div class="media-body py-4 px-3">
                <h3 class="heading"><?php echo $resort->name; ?></h3>
                <p><?php echo $resort->description; ?></p>
                <p></p>
                <p><a href="rooms.php?id=<?php echo $resort->id; ?>" class="btn btn-primary">View rooms</a></p>
              </div>
            </div>      
          </div>
      <?php endforeach; ?>
          
        </div>
    	</div>
    </section>

    <section class="ftco-section bg-light">
			<div class="container-fluid px-md-0">
				<div class="row no-gutters justify-content-center pb-5 mb-3">
          <div class="col-md-7 heading-section text-center ftco-animate">
            <h2>Apartment Room</h2>
          </div>
        </div>
				<div class="row no-gutters">
				<?php foreach($allrooms as $rooms) : ?>
    			<div class="col-lg-6">
    				<div class="room-wrap d-md-flex">
    					<a href="#" class="img" style="background-image: url(images/<?php echo $rooms->image; ?>);"></a>
    					<div class="half left-arrow d-flex align-items-center">
    						<div class="text p-4 p-xl-5 text-center">
    							<p class="star mb-0"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></p>
    							<!-- <p class="mb-0"><span class="price mr-1">$120.00</span> <span class="per">per night</span></p> -->
	    						<h3 class="mb-3"><a href="<?php echo APPURL; ?>/rooms/rooms-single.php?id=<?php echo $rooms->id; ?>"><?php echo $rooms->name; ?></a></h3>
	    						<ul class="list-accomodation">
	    							<li><span>Max:</span> <?php echo $rooms->num_persons; ?> Persons</li>
	    							<li><span>Size:</span> <?php echo $rooms->size; ?> m2</li>
	    							<!-- <li><span>View:</span> </li> -->
	    							<li><span>Bed:</span> <?php echo $rooms->num_beds; ?></li>
									<li><span>Price Per Night: </span><?php echo $rooms->price; ?></li>
	    						</ul>
	    						<p class="pt-1"><a href="<?php echo APPURL; ?>/rooms/room-single.php? id=<?php echo $rooms->id; ?>" class="btn-custom px-3 py-2">View Room Details <span class="icon-long-arrow-right"></span></a></p>
    						</div>
    					</div>
    				</div>
    			</div>
    			<?php endforeach; ?>
    		</div>
			</div>
		</section>



    <section class="ftco-section bg-light">
			<div class="container">
				<div class="row no-gutters">
					<div class="col-md-6 wrap-about">
						<div class="img img-2 mb-4" style="background-image: url(images/image_2.JPG);">
						</div>
						<h2>The most recommended vacation rental</h2>
						<p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
					</div>
					<div class="col-md-6 wrap-about ftco-animate">
	          <div class="heading-section">
	          	<div class="pl-md-5">
		            <h2 class="mb-2">What we offer</h2>
	            </div>
	          </div>
	          <div class="pl-md-5">
							<p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
							<div class="row">
		            <div class="services-2 col-lg-6 d-flex w-100">
		              <div class="icon d-flex justify-content-center align-items-center">
		            		<span class="flaticon-diet"></span>
		              </div>
		              <div class="media-body pl-3">
		                <h3 class="heading">Tea Coffee</h3>
		                <p>Enjoy a cozy tea or coffee moment, enhancing your stay with comforting beverages.</p>
		              </div>
		            </div> 
		            <div class="services-2 col-lg-6 d-flex w-100">
		              <div class="icon d-flex justify-content-center align-items-center">
		            		<span class="flaticon-workout"></span>
		              </div>
		              <div class="media-body pl-3">
		                <h3 class="heading">Playground</h3>
		                <p>Exciting, kid-friendly playground ensuring delightful moments for our young guests.</p>
		              </div>
		            </div>
		            <div class="services-2 col-lg-6 d-flex w-100">
		              <div class="icon d-flex justify-content-center align-items-center">
		            		<span class="flaticon-diet-1"></span>
		              </div>
		              <div class="media-body pl-3">
		                <h3 class="heading">Basketball Court</h3>
		                <p>Hoop dreams come alive on our well-maintained court for sports enthusiasts</p>
		              </div>
		            </div>      
		            <div class="services-2 col-lg-6 d-flex w-100">
		              <div class="icon d-flex justify-content-center align-items-center">
		            		<span class="flaticon-first"></span>
		              </div>
		              <div class="media-body pl-3">
		                <h3 class="heading">Videoke Machines</h3>
		                <p>Sing your heart out with friends and family using our entertaining videoke machines.</p>
		              </div>
		            </div>
		            <div class="services-2 col-lg-6 d-flex w-100">
		              <div class="icon d-flex justify-content-center align-items-center">
		            		<span class="flaticon-first"></span>
		              </div>
		              <div class="media-body pl-3">
		                <h3 class="heading">Free Wifi</h3>
		                <p>Stay connected throughout the resort with seamless Wi-Fi, ensuring convenience for work and leisure.</p>
		              </div>
		            </div> 
		            <div class="services-2 col-lg-6 d-flex w-100">
		              <div class="icon d-flex justify-content-center align-items-center">
		            		<span class="flaticon-first"></span>
		              </div>
		              <div class="media-body pl-3">
		                <h3 class="heading">Restaurants and Bars</h3>
		                <p>Savor delicious cuisine and refreshing beverages in our onsite dining establishments.</p>
		              </div>
		            </div> 
		            <div class="services-2 col-lg-6 d-flex w-100">
		              <div class="icon d-flex justify-content-center align-items-center">
		            		<span class="flaticon-first"></span>
		              </div>
		              <div class="media-body pl-3">
		                <h3 class="heading">Parking Lot</h3>
		                <p>Convenient and secure parking facilities for hassle-free access to the resort amenities and accommodations.</p>
		              </div>
		            </div> 
		            <div class="services-2 col-lg-6 d-flex w-100">
		              <div class="icon d-flex justify-content-center align-items-center">
		            		<span class="flaticon-first"></span>
		              </div>
		              <div class="media-body pl-3">
		                <h3 class="heading">Clean Restrooms/Showers</h3>
		                <p>Pristine facilities for a refreshing and hygienic experience during your stay.</p>
		              </div>
		            </div>
		          </div>  
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<section class="ftco-intro" style="background-image: url(images/image_2.JPG);" data-stellar-background-ratio="0.5">
			<div class="overlay"></div>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-9 text-center">
						<h2>Ready to get started</h2>
						<p class="mb-4">It’s safe to book online with us! Get your dream stay in clicks or drop us a line with your questions.</p>
						<p class="mb-0"><a href="<?php echo APPURL; ?>/about.php" class="btn btn-primary px-4 py-3">Learn More</a> <a href="#" class="btn btn-white px-4 py-3">Contact us</a></p>
					</div>
				</div>
			</div>
		</section>


    <?php require "includes/footer.php"; ?>