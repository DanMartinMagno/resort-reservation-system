<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php 

if(!isset($_SESSION['adminname'])){
  echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php' </script>";
}

if(isset($_POST['submit'])){
  if(empty($_POST['name']) OR empty($_POST['description'])){
    echo "<script>alert('one or more input are empty')</script>";
  }else{

   $name = $_POST['name'];
   $description = $_POST['name'];
   $image = $_FILES['image']['name'];

   $dir = "resort_image/" . basename($image);


   $insert = $conn->prepare("INSERT INTO resort_accom (name, image, description)
VALUES (:name, :image, :description )");


   $insert->execute([
    ":name" => $name,
    ":image" => $image,
    ":description" => $description,
   ]);

   if(move_uploaded_file($_FILES['image']['tmp_name'], $dir)){
    header("location: show-hotels.php");
}

   


  }
}

// if(!isset($_SESSION['adminname'])){
//   echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php' </script>";
// }

// if(isset($_POST['submit'])){
//   if(empty($_POST['adminname']) OR empty($_POST['email']) OR empty($_POST['password'])){
//     echo "<script>alert('one or more input are empty')</script>";
//   }else{

//    $adminname = $_POST['adminname'];
//    $email = $_POST['email'];
//    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

//    $insert = $conn->prepare("INSERT INTO admins (adminname, email, mypassword)
//    VALUES (:adminname, :email, :mypassword)");

//    $insert->execute([
//     ":adminname" => $adminname,
//     ":email" => $email,
//     ":mypassword" => $password,
//    ]);

//    header("location: admins.php");


//   }
// }







?>




       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Hotels</h5>
          <form method="POST" action="create-hotels.php" enctype="multipart/form-data">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="name" id="form2Example1" class="form-control" placeholder="name" />
                 
                </div>

                <div class="form-outline mb-4 mt-4">
                <input type="file" name="image" id="form2Example2" class="form-control"/>

                 
                </div>

                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Description</label>
                  <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>

      
                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>

          
              </form>

            </div>
          </div>
        </div>
      </div>
 <?php require "../layouts/footer.php"; ?>