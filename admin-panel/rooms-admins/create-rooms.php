
<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php 

if(!isset($_SESSION['adminname'])){
  echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php' </script>";
}


$resort_accom = $conn->query("SELECT * FROM resort_accom");
$resort_accom->execute();

$allResort_accom = $resort_accom->fetchAll(PDO::FETCH_OBJ);

if(isset($_POST['submit'])){
  if(empty($_POST['name']) OR empty($_POST['price']) OR empty($_POST['num_persons']) 
  OR empty($_POST['num_beds']) OR empty($_POST['size'])){
    
    echo "<script>alert('one or more input are empty')</script>";

  }else{

   $name = $_POST['name'];
   $price = $_POST['price'];
   $num_persons = $_POST['num_persons'];
   $num_beds = $_POST['num_beds'];
   $size = $_POST['size'];
   $resort_accom_name = $_POST['hotel_name'];

   $resort_id = $_POST['resort_id'];
   $image = $_FILES['image']['name'];

   $dir = "room_images/" . basename($image);


   $insert = $conn->prepare("INSERT INTO rooms (name, price, num_persons, num_beds, size, resort_accom_name, resort_id, image)
   VALUES (:name, :price, :num_persons, :num_beds, :size, :resort_accom_name, :resort_id, :image)");

   
$insert->execute([
  ":name" => $name,
  ":price" => $price,
  ":num_persons" => $num_persons,
  ":num_beds" => $num_beds,
  ":size" => $size,
  ":resort_accom_name" => $resort_accom_name,
  ":resort_id" => $resort_id,
  ":image" => $image
]);

if (move_uploaded_file($_FILES['image']['tmp_name'], $dir)) {
    header("location: show-rooms.php");
}


   


  }
}

?>


       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Rooms</h5>
          <form method="POST" action="create-rooms.php" enctype="multipart/form-data">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="name" id="form2Example1" class="form-control" placeholder="name" />
                 
                </div>
                <div class="form-outline mb-4 mt-4">
                  <input type="file" name="image" id="form2Example1" class="form-control" />
                 
                </div>  
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="price" id="form2Example1" class="form-control" placeholder="price" />
                 
                </div> 
                 <div class="form-outline mb-4 mt-4">
                  <input type="text" name="num_persons" id="form2Example1" class="form-control" placeholder="num_persons" />
                 
                </div> 
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="num_beds" id="form2Example1" class="form-control" placeholder="num_beds" />
                 
                </div> 
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="size" id="form2Example1" class="form-control" placeholder="size" />
                 
                
               
               </div> 
               <select name="hotel_name" class="form-control">
                <option>Choose Room type</option>
                <?php foreach($allResort_accom as $hotel) :?>
                <option value="<?php echo $hotel->name; ?>"><?php echo $hotel->name; ?></option>
                <?php endforeach; ?>
               </select>
               <br>
   
               <select name="resort_id" class="form-control">
                <option>Choose Same Hotel ID</option>
                <?php foreach($allResort_accom as $hotel) :?>
                <option value="<?php echo $hotel->id; ?>"><?php echo $hotel->name; ?></option>
                <?php endforeach; ?>
               </select>
               <br>

                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>

          
              </form>

            </div>
          </div>
        </div>
      </div>
<?php require "../layouts/footer.php"; ?>