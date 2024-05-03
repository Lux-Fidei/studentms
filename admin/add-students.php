<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Check if the user is logged in
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $subjectname = $_POST['subjectname'];
        $subjecttype = $_POST['subjecttype'];
        $sql = "INSERT INTO tblsubjects (SubjectName, subject_type) VALUES (:subjectname, :subjecttype)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':subjectname', $subjectname, PDO::PARAM_STR);
        $query->bindParam(':subjecttype', $subjecttype, PDO::PARAM_STR);
        if ($query->execute()) {
            echo '<script>alert("Subject has been added.")</script>';
            echo "<script>window.location.href ='add-subject.php'</script>";
        } else {
            echo '<script>alert("Something went wrong. Please try again.")</script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Management System || Add Subject</title>
    <!-- Include CSS and other necessary files here -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <div class="container-scroller">
        <!-- Include header -->
        <?php include_once('includes/header.php');?>
        <div class="container-fluid page-body-wrapper">
            <!-- Include sidebar -->
            <?php include_once('includes/sidebar.php');?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Add Subject</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Add Subject</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title" style="text-align: center;">Add Subject</h4>
                                    <form class="forms-sample" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="exampleInputName1">Subject Name</label>
                                            <input type="text" name="subjectname" value="" class="form-control" required='true'>
                                        </div>
                                        <!-- Add Subject Type dropdown -->
                                        <div class="form-group">
                                            <label for="exampleInputName2">Subject Type</label>
                                            <select class="form-control" name="subjecttype" required>
                                                <option value="">Select Subject Type</option>
                                                <option value="Core">Core</option>
                                                <option value="Specialized">Specialized</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary mr-2" name="submit">Add</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Table to display added subjects -->
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">List of Added Subjects</h4>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Subject ID</th>
                                                    <th>Subject Name</th>
                                                    <th>Subject Type</th> <!-- New column for subject type -->
                                                    <th>Action</th> <!-- New column for actions -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql3 = "SELECT * FROM tblsubjects";
                                                $query3 = $dbh->prepare($sql3);
                                                $query3->execute();
                                                $results = $query3->fetchAll(PDO::FETCH_OBJ);
                                                if ($query3->rowCount() > 0) {
                                                    foreach ($results as $row) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo htmlentities($row->SubjectID); ?></td>
                                                            <td><?php echo htmlentities($row->SubjectName); ?></td>
                                                            <td><?php echo htmlentities($row->subject_type); ?></td> <!-- Display subject type -->
                                                            <td>
                                                                <a href="edit-subject.php?id=<?php echo $row->SubjectID; ?>" class="btn btn-primary btn-sm">Edit</a>
                                                                <a href="delete-subject.php?id=<?php echo $row->SubjectID; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this subject?')">Delete</a>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
                                                } else {
                                                ?>
                                                    <tr>
                                                        <td colspan="4">No subjects found</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Include footer -->
                <?php include_once('includes/footer.php');?>
            </div>
        </div>
    </div>
    <!-- Include JS files -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="vendors/select2/select2.min.js"></script>
    <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <script src="js/typeahead.js"></script>
    <script src="js/select2.js"></script>
</body>
</html>
