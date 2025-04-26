<?php
include 'db.php';  


$sql = "SELECT * FROM quizzes";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='quiz'>";
        echo "<h4>" . $row['title'] . "</h4>";  
        echo "<p>" . $row['description'] . "</p>";  
        echo "<form action='quiz.php' method='GET'>";
        echo "<input type='hidden' name='quiz_id' value='" . $row['id'] . "'>";
        echo "<button type='submit'>Start Quiz</button>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "<p>No quizzes available.</p>";
}
?>
