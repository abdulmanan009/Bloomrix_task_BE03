
<?php

// ======================================
// 1. STUDENT DATA
// ======================================

$students = [

    [
        "name" => "Ali",
        "roll_no" => 101,
        "marks" => [
            "PHP" => 85,
            "Database" => 90,
            "Programming" => 80
        ]
    ],

    [
        "name" => "Ahmed",
        "roll_no" => 102,
        "marks" => [
            "PHP" => 70,
            "Database" => 75,
            "Programming" => 80
        ]
    ],

    [
        "name" => "Sara",
        "roll_no" => 103,
        "marks" => [
            "PHP" => 95,
            "Database" => 92,
            "Programming" => 98
        ]
    ],

    [
        "name" => "Usman",
        "roll_no" => 104,
        "marks" => [
            "PHP" => 40,
            "Database" => 45,
            "Programming" => 35
        ]
    ],

    [
        "name" => "Ayesha",
        "roll_no" => 105,
        "marks" => [
            "PHP" => 80,
            "Database" => 85,
            "Programming" => 75
        ]
    ],

    [
        "name" => "Hassan",
        "roll_no" => 106,
        "marks" => [
            "PHP" => 55,
            "Database" => 60,
            "Programming" => 50
        ]
    ],

    [
        "name" => "Fatima",
        "roll_no" => 107,
        "marks" => [
            "PHP" => 90,
            "Database" => 88,
            "Programming" => 92
        ]
    ],

    [
        "name" => "Bilal",
        "roll_no" => 108,
        "marks" => [
            "PHP" => 30,
            "Database" => 40,
            "Programming" => 35
        ]
    ],

    [
        "name" => "Zain",
        "roll_no" => 109,
        "marks" => [
            "PHP" => 65,
            "Database" => 70,
            "Programming" => 60
        ]
    ],

    [
        "name" => "Hira",
        "roll_no" => 110,
        "marks" => [
            "PHP" => 75,
            "Database" => 80,
            "Programming" => 85
        ]
    ]

];


// ======================================
// 2. FUNCTIONS
// ======================================

// Calculate total possible marks
function calculateTotalMarks($marks) {

    return count($marks) * 100;

}


// Calculate obtained marks
function calculateObtainedMarks($marks) {

    return array_sum($marks);

}


// Calculate percentage
function calculatePercentage($obtained, $total) {

    if ($total == 0) {
        return 0;
    }

    return ($obtained / $total) * 100;

}


// Determine grade
function determineGrade($percentage) {

    if ($percentage >= 90) {
        return "A";
    } elseif ($percentage >= 80) {
        return "B";
    } elseif ($percentage >= 70) {
        return "C";
    } elseif ($percentage >= 60) {
        return "D";
    } elseif ($percentage >= 50) {
        return "E";
    } else {
        return "F";
    }

}


// Determine pass or fail
function determineStatus($percentage) {

    return ($percentage >= 50) ? "Pass" : "Fail";

}


// ======================================
// 3. CALCULATE RESULTS FOR ALL STUDENTS
// ======================================

$studentResults = [];

foreach ($students as $student) {

    $totalMarks = calculateTotalMarks($student["marks"]);

    $obtainedMarks = calculateObtainedMarks($student["marks"]);

    $percentage = calculatePercentage($obtainedMarks, $totalMarks);

    $grade = determineGrade($percentage);

    $status = determineStatus($percentage);


    // Store student information and calculated results
    $studentResults[] = [

        "name" => $student["name"],
        "roll_no" => $student["roll_no"],
        "marks" => $student["marks"],
        "total_marks" => $totalMarks,
        "obtained_marks" => $obtainedMarks,
        "percentage" => $percentage,
        "grade" => $grade,
        "status" => $status

    ];

}


// ======================================
// 4. FILTER PASSED AND FAILED STUDENTS
// ======================================

$passedStudents = array_filter($studentResults, function($student) {

    return $student["status"] == "Pass";

});


$failedStudents = array_filter($studentResults, function($student) {

    return $student["status"] == "Fail";

});


// ======================================
// 5. FIND HIGHEST SCORING STUDENT
// ======================================

$highestStudent = $studentResults[0];

foreach ($studentResults as $student) {

    if ($student["percentage"] > $highestStudent["percentage"]) {

        $highestStudent = $student;

    }

}


// ======================================
// 6. CALCULATE CLASS AVERAGE
// ======================================

$totalPercentage = 0;

foreach ($studentResults as $student) {

    $totalPercentage += $student["percentage"];

}

$averagePercentage = $totalPercentage / count($studentResults);


// ======================================
// 7. SUMMARY
// ======================================

$totalStudents = count($studentResults);

$totalPassed = count($passedStudents);

$totalFailed = count($failedStudents);

?>


<!DOCTYPE html>
<html>
<head>
    <title>Student Result Management System</title>
</head>

<body>

    <h1>Student Result Management System</h1>


    <!-- Display all student results -->

    <h2>All Student Results</h2>

    <table border="1" cellpadding="8">

        <tr>
            <th>Name</th>
            <th>Roll Number</th>
            <th>Subject Marks</th>
            <th>Total Marks</th>
            <th>Obtained Marks</th>
            <th>Percentage</th>
            <th>Grade</th>
            <th>Status</th>
        </tr>


        <?php foreach ($studentResults as $student) { ?>

            <tr>

                <td><?php echo $student["name"]; ?></td>

                <td><?php echo $student["roll_no"]; ?></td>

                <td>
                    <?php
                    foreach ($student["marks"] as $subject => $mark) {

                        echo $subject . ": " . $mark . "<br>";

                    }
                    ?>
                </td>

                <td><?php echo $student["total_marks"]; ?></td>

                <td><?php echo $student["obtained_marks"]; ?></td>

                <td><?php echo round($student["percentage"], 2); ?>%</td>

                <td><?php echo $student["grade"]; ?></td>

                <td><?php echo $student["status"]; ?></td>

            </tr>

        <?php } ?>

    </table>


    <!-- Highest scoring student -->

    <h2>Highest Scoring Student</h2>

    <p>Name: <?php echo $highestStudent["name"]; ?></p>

    <p>Roll Number: <?php echo $highestStudent["roll_no"]; ?></p>

    <p>Percentage: <?php echo round($highestStudent["percentage"], 2); ?>%</p>


    <!-- Class average -->

    <h2>Class Average</h2>

    <p>
        Average Percentage:
        <?php echo round($averagePercentage, 2); ?>%
    </p>


    <!-- Passed students -->

    <h2>Passed Students</h2>

    <ul>

        <?php foreach ($passedStudents as $student) { ?>

            <li>
                <?php echo $student["name"]; ?>
                - <?php echo $student["percentage"]; ?>%
            </li>

        <?php } ?>

    </ul>


    <!-- Failed students -->

    <h2>Failed Students</h2>

    <ul>

        <?php foreach ($failedStudents as $student) { ?>

            <li>
                <?php echo $student["name"]; ?>
                - <?php echo $student["percentage"]; ?>%
            </li>

        <?php } ?>

    </ul>


    <!-- Final summary -->

    <h2>Class Summary</h2>

    <p>Total Students: <?php echo $totalStudents; ?></p>

    <p>Passed Students: <?php echo $totalPassed; ?></p>

    <p>Failed Students: <?php echo $totalFailed; ?></p>

</body>
</html>
