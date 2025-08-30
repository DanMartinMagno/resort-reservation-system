<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php

if (!isset($_SESSION['username']))  {
  echo "<script>window.location.href='".APPURL."' </script>";
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if($_SESSION['id'] != $id) {
    echo "<script>window.location.href='".APPURL."' </script>";
    }

    // Assuming $conn is your PDO connection object
    $bookings = $conn->prepare("SELECT * FROM bookings WHERE user_id = :id");
    $bookings->bindParam(':id', $id);
    $bookings->execute();

    $allBookings = $bookings->fetchAll(PDO::FETCH_OBJ);
}
?>

<!-- Your HTML table code remains the same -->



<?php if(count($allBookings) > 0) :?>

<table class="table">
  <thead>
    <tr>
      <th scope="col">check_in</th>
      <th scope="col">check_out</th>
      <th scope="col">email</th>
      <th scope="col">phone_number</th>
      <th scope="col">full_name</th>
      <th scope="col">resort_accom_name</th>
      <th scope="col">status</th>
      <th scope="col">created_at</th>

    </tr>
  </thead>
  <tbody>
    <?php foreach($allBookings as $booking) : ?>
    <tr>
      <th scope="row"><?php echo $booking->check_in; ?></th>
      <td><?php echo $booking->check_out; ?></td>
      <td><?php echo $booking->email; ?></td>
      <td><?php echo $booking->phone_number; ?></td>
      <td><?php echo $booking->full_name; ?></td>
      <td><?php echo $booking->resort_accom_name; ?></td>
      <td><?php echo $booking->status; ?></td>
      <td><?php echo $booking->created_at; ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php else : ?>
  <div class="alert alert-primary" role="alert">
  You have not made any bookings just yet
</div>
<?php endif; ?>


<?php require "../includes/footer.php"; ?>