<?php require "../../config/config.php"; ?>
<?php 

if(isset($_GET['id'])){
   
    $id = $_GET['id'];
  
    $getImage = $conn->query("SELECT * FROM resort_accom WHERE id='$id'");
    $getImage->execute();
  
    $fetch =  $getImage->fetch(PDO::FETCH_OBJ);

    unlink("resort_image/" . $fetch->image);

    $delete = $conn->query("DELETE FROM resort_accom WHERE id='$id'");
    $delete->execute();

    header("location: show-hotels.php");

}
?>