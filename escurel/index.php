<?php 
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (isset($_POST['applyJobBtn'])) {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $experience = trim($_POST['experience']);
    $skills = trim($_POST['skills']);
    $coverLetter = trim($_POST['coverLetter']);

    if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($phone) && !empty($experience) && !empty($skills) && !empty($coverLetter)) {
        insertIntoApplicants($pdo, $firstName, $lastName, $email, $phone, $experience, $skills, $coverLetter);
    }
}

$applicants = seeAllApplicants($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Application Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1000px;
            margin-top: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            color: #555;
        }
        input, textarea, button {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            width: 97%;
        }
        button {
            background-color: #28a745;
            color: #fff;
            cursor: pointer;
            border: none;
            width: auto;
            padding: 10px 20px;
        }
        button:hover {
            background-color: #218838;
        }
        .table-container {
            margin-top: 40px;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f8f8f8;
        }
        .center-text {
            text-align: center;
        }
        .actions {
            color: #007bff;
            text-decoration: none;
            margin-right: 10px;
        }
        .actions:hover {
            text-decoration: underline;
        }
        .delete {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Form for job application -->
        <h1>Job Application Form</h1>
        <p>Input your details to apply for a job.</p>
        <form action="index.php" method="POST">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" name="firstName" required>

            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" name="lastName" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="experience">Years of Experience</label>
            <input type="number" id="experience" name="experience" required>

            <label for="skills">Skills</label>
            <input type="text" id="skills" name="skills" required>

            <label for="coverLetter">Cover Letter</label>
            <textarea id="coverLetter" name="coverLetter" rows="4" required></textarea>

            <button type="submit" name="applyJobBtn">Apply</button>
        </form>

        <!-- Applicants Table -->
        <div class="table-container">
            <h2>Applicants</h2>
            <table>
                <tr>
                    <th>Applicant ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Experience</th>
                    <th>Skills</th>
                    <th>Cover Letter</th>
                    <th>Action</th>
                </tr>
                <?php if (!empty($applicants)): ?>
                    <?php foreach ($applicants as $applicant): ?>
                        <tr>
                            <td><?= htmlspecialchars($applicant['applicant_id']) ?></td>
                            <td><?= htmlspecialchars($applicant['first_name']) ?></td>
                            <td><?= htmlspecialchars($applicant['last_name']) ?></td>
                            <td><?= htmlspecialchars($applicant['email']) ?></td>
                            <td><?= htmlspecialchars($applicant['phone']) ?></td>
                            <td><?= htmlspecialchars($applicant['experience']) ?></td>
                            <td><?= htmlspecialchars($applicant['skills']) ?></td>
                            <td><?= htmlspecialchars($applicant['cover_letter']) ?></td>
                            <td>
                                <a href="editApplicant.php?applicant_id=<?= $applicant['applicant_id'] ?>" class="actions">Edit</a>
                                <a href="deleteApplicant.php?applicant_id=<?= $applicant['applicant_id'] ?>" class="actions delete">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="center-text">No applicants found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>