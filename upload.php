<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "payroll_db";
$output = '';
$rec_id = $_POST['id'];  // Get the ID from the POST request

try {
    // Establish connection using PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL query
    $sql = "SELECT * FROM employees WHERE id = :rec_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':rec_id', $rec_id, PDO::PARAM_INT);
    
    // Execute the query
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Build the HTML content
            echo $row["photo_path"]; // Check if the image path is correct
            // $console.log('Photo Path:', $row["photo_path"]);

            $output .= "<div class='d-flex flex-column flex-md-row gap-3'>
                <div class='me-3'>
                    <div class='rounded-circle border mt-3' style='width: 96px; height: 96px; overflow: hidden;'>
                        <img src='http://localhost/mvcPayroll/public/" . $row["photo_path"] . "' alt='Employee' class='aspect-square w-[50px] h-[50px] object-fit-cover'>
                    </div>
                </div>

                <div class='flex-grow-1'>
                    <h4 class='fw-bold mb-3 text-lg'>" . $row["first_name"] . " " . $row["middle_name"] . " " . $row["last_name"] . "</h4>
                    <div class='row'>
                        <div class='col-md-6 mb-2'>
                            <p class='mb-2'><span class='fw-semibold text-sm text-success'>Employee ID: </span><span class='text-sm'>" . $row["employee_no"] . "</span></p>
                            <p class='mb-2'><span class='fw-semibold text-sm text-success'>Position: </span><span class='text-sm'>" . $row["position"] . "</span></p>
                        </div>
                        <div class='col-md-6 mb-2'>
                            <p class='mb-2'><span class='fw-semibold text-sm text-success'>Email: </span><span class='text-sm'>" . $row["email"] . "</span></p>
                            <p class='mb-2'><span class='fw-semibold text-sm text-success'>Phone: </span><span class='text-sm'>" . $row["contact_number"] . "</span></p>
                            <p class='mb-2'><span class='fw-semibold text-sm text-success'>RFID Number: </span><span class='text-sm'>" . $row["rfid_number"] . "</span></p>
                        </div>
                    </div>
                </div>
            </div>";


            $output .= "<div class='row mt-2 ml-2'>
                            <div class='col-12'>
                                <h6 class='fw-semibold text-sm text-success mb-2'>Address</h6>
                                <p class='text-sm'>".$row["address"]."</p>
                            </div>
                        </div>";

            $output .= "<div class='row ml-2'>
                            <div class='col-12'>
                                <h6 class='fw-semibold text-sm text-success mb-2'>Salary Information</h6>
                                <p class='mb-0'>
                                    <span class='fw-semibold text-sm text-success'>Base Salary: </span>
                                    <span class='text-sm'>".$row["base_salary"]."</span>
                                </p>
                            </div>
                        </div>";

            $output .= "<div class='row ml-2 mt-3'>
                            <div class='col-12'>
                                <h6 class='fw-semibold text-success mb-2'>Benefits Information</h6>
                                <p class='mb-1' style='line-height: 1.3;'>
                                    <span class='fw-semibold text-sm text-success'>SSS Number: </span>
                                    <span class='text-sm'>".$row["sss_number"]."</span>
                                </p>
                                <p class='mb-1' style='line-height: 1.3;'>
                                    <span class='fw-semibold text-sm text-success'>Pag-IBIG Number: </span>
                                    <span class='text-sm'>".$row["pagibig_number"]."</span>
                                </p>
                                <p class='mb-0' style='line-height: 1.3;'>
                                    <span class='fw-semibold text-sm text-success'>PhilHealth Number: </span>
                                    <span class='text-sm'>".$row["philhealth_number"]."</span>
                                </p>
                            </div>
                        </div>";

            $output .= "<div class='d-flex justify-content-end mt-3'>
                            <button type='button' class='btn btn-outline-success w-[100px] me-2' data-bs-toggle='modal' data-bs-target='#editEmployeeModal'>
                                <i class='bi bi-pencil me-1'></i>Edit
                            </button>
                            <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteEmployeeModal'>
                                <i class='bi bi-trash me-1'></i>Delete
                            </button>
                        </div>";
        }
        // Return the output
        echo $output;
    } else {
        echo "No records found.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
