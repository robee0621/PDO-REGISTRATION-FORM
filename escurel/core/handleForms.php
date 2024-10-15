<?php
require_once 'dbConfig.php';
require_once 'models.php';

// Function to sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

if (isset($_POST['applyJobBtn'])) {
    // Trim and sanitize all input fields
    $firstName = sanitizeInput($_POST['firstName']);
    $lastName = sanitizeInput($_POST['lastName']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $experience = sanitizeInput($_POST['experience']);
    $skills = sanitizeInput($_POST['skills']);
    $coverLetter = isset($_POST['coverLetter']) ? sanitizeInput($_POST['coverLetter']) : '';

    // Check if all fields are filled
    if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($phone) && !empty($experience) && !empty($skills) && !empty($coverLetter)) {
        // Proceed with inserting data into the database
        $query = insertIntoApplicants($pdo, $firstName, $lastName, $email, $phone, $experience, $skills, $coverLetter);

        if ($query) {
            // Redirect to index.php on success
            header("Location: ../index.php");
            exit(); // Always exit after redirection
        } else {
            echo "Application submission failed";
        }
    } else {
        // Display an error message if any fields are empty
        echo "Make sure that no fields are empty";
    }
}

if (isset($_POST['editApplicantBtn'])) {
    $applicant_id = isset($_GET['applicant_id']) ? sanitizeInput($_GET['applicant_id']) : null;
    $firstName = sanitizeInput($_POST['firstName']);
    $lastName = sanitizeInput($_POST['lastName']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $experience = sanitizeInput($_POST['experience']);
    $skills = sanitizeInput($_POST['skills']);
    $coverLetter = isset($_POST['coverLetter']) ? sanitizeInput($_POST['coverLetter']) : ''; // Ensure coverLetter is retrieved

    // Debugging: Log the values of the variables before validation
    var_dump($applicant_id, $firstName, $lastName, $email, $phone, $experience, $skills, $coverLetter);

    if (!empty($applicant_id) && !empty($firstName) && !empty($lastName) && !empty($email) && !empty($phone) && !empty($experience) && !empty($skills)) {
        // Proceed with updating even if the cover letter is empty
        $query = updateApplicant($pdo, $applicant_id, $firstName, $lastName, $email, $phone, $experience, $skills, $coverLetter);

        if ($query) {
            header("Location: ../index.php");
            exit();
        } else {
            echo "Update failed";
        }
    } else {
        echo "Make sure that no fields are empty";
    }
}

if (isset($_POST['deleteApplicantBtn'])) {
    $applicant_id = isset($_GET['applicant_id']) ? sanitizeInput($_GET['applicant_id']) : null;

    if (!empty($applicant_id)) {
        $query = deleteApplicant($pdo, $applicant_id);

        if ($query) {
            header("Location: ../index.php");
            exit();
        } else {
            echo "Deletion failed";
        }
    } else {
        echo "Invalid applicant ID";
    }
}
?>