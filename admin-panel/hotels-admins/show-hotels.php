<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php
if (!isset($_SESSION['adminname'])) {
    echo "<script>window.location.href='" . ADMINURL . "/admins/login-admins.php' </script>";
}

$resort_accom = $conn->query("SELECT * FROM resort_accom");
$resort_accom->execute();

$allResort_accom = $resort_accom->fetchAll(PDO::FETCH_OBJ);

?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4 d-inline">Accommodation</h5>
                <a href="create-hotels.php" class="btn btn-primary mb-4 text-center float-right">Create</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">name</th>

                            <th scope="col">status value</th>
                            <th scope="col">change status</th>
                            <th scope="col">update</th>
                            <th scope="col">delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allResort_accom as $resort) : ?>
                            <tr>
                                <th scope="row"><?php echo $resort->id; ?></th>
                                <td><?php echo $resort->name; ?></td>

                                <td><?php echo $resort->status; ?></td>

                                <td><a href="status-hotels.php?id=<?php echo $resort->id; ?>" class="btn btn-warning text-white text-center">status</a></td>
                                <td><a href="update-hotels.php?id=<?php echo $resort->id; ?>" class="btn btn-warning text-white text-center">Update</a></td>
                                <td><a href="delete-hotels.php?id=<?php echo $resort->id; ?>" class="btn btn-danger text-center">Delete</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php" ?>
