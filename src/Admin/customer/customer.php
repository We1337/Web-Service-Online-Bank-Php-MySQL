<?php
include("../include/header.php");
require_once("../../Modules/config.php");

// Handle search input
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$searchCondition = empty($searchTerm) ? '' : 'WHERE FirstName LIKE :searchTerm OR LastName LIKE :searchTerm OR Email LIKE :searchTerm OR PhoneNumber LIKE :searchTerm OR Address LIKE :searchTerm';

// Fetch data based on the search condition
$stmt = $conn->prepare("SELECT * FROM `Customers` $searchCondition");
if (!empty($searchTerm)) {
    $searchTerm = "$searchTerm";  // Modify the search term before binding
    $stmt->bindValue(':searchTerm', "%". $searchTerm . "%", PDO::PARAM_STR);
}
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<div style="padding-left: 2rem; padding-right: 2rem; padding-top: 1rem;">
    <form method="GET" action="">
        <div class="input-group">
            <input type="search" name="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" value="<?= htmlentities($searchTerm) ?>" />
            <button type="submit" class="btn btn-outline-primary" data-mdb-ripple-init>Search</button>
        </div>
    </form>
</div>

<div style="padding-left: 2rem; padding-right: 2rem; padding-top: 1rem;">
    <table class="table align-middle mb-0 bg-white">
        <thead class="bg-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Number</th>
                <th>Address</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($result as $row): ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="https://mdbootstrap.com/img/new/avatars/6.jpg" class="rounded-circle" alt="" style="width: 45px; height: 45px" />
                            <div class="ms-3">
                                <p class="fw-bold mb-1"><?= htmlentities($row['FirstName']) ?></p>
                                <p class="text-muted mb-0"><?= htmlentities($row['Email']) ?></p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <p class="fw-normal mb-1"><?= htmlentities($row['Email']) ?></p>
                    </td>
                    <td>
                        <p class="fw-normal mb-1"><?= htmlentities($row['PhoneNumber']) ?></p>
                    </td>
                    <td>
                        <p class="fw-normal mb-1"><?= htmlentities($row['Address']) ?></p>
                    </td>
                    <td>
                        <button type="button" class="btn btn-link btn-rounded btn-sm fw-bold" data-mdb-ripple-color="dark">
                            View
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include("../include/footer.php"); ?>
