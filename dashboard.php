<?php
include 'db.php';

if (isset($_POST['create_quiz'])) {
    $quiz_title = $_POST['quiz_title'];
    $quiz_description = $_POST['quiz_description'];

    $question1 = $_POST['question1'];
    $opt1_1 = $_POST['opt1_1'];
    $opt1_2 = $_POST['opt1_2'];
    $opt1_3 = $_POST['opt1_3'];
    $correct1 = $_POST['correct1'];

    $question2 = $_POST['question2'];
    $opt2_1 = $_POST['opt2_1'];
    $opt2_2 = $_POST['opt2_2'];
    $opt2_3 = $_POST['opt2_3'];
    $correct2 = $_POST['correct2'];

    $question3 = $_POST['question3'];
    $opt3_1 = $_POST['opt3_1'];
    $opt3_2 = $_POST['opt3_2'];
    $opt3_3 = $_POST['opt3_3'];
    $correct3 = $_POST['correct3'];


    mysqli_query($conn, "INSERT INTO quizzes (title, description) VALUES ('$quiz_title', '$quiz_description')");
    $quiz_id = mysqli_insert_id($conn);

    mysqli_query($conn, "INSERT INTO questions (quiz_id, question) VALUES ('$quiz_id', '$question1')");
    $q1_id = mysqli_insert_id($conn);
    mysqli_query($conn, "INSERT INTO answers (question_id, answertext, is_correct) VALUES ('$q1_id', '$opt1_1', '".($correct1=='0' ? 1 : 0)."')");
    mysqli_query($conn, "INSERT INTO answers (question_id, answertext, is_correct) VALUES ('$q1_id', '$opt1_2', '".($correct1=='1' ? 1 : 0)."')");
    mysqli_query($conn, "INSERT INTO answers (question_id, answertext, is_correct) VALUES ('$q1_id', '$opt1_3', '".($correct1=='2' ? 1 : 0)."')");

    mysqli_query($conn, "INSERT INTO questions (quiz_id, question) VALUES ('$quiz_id', '$question2')");
    $q2_id = mysqli_insert_id($conn);
    mysqli_query($conn, "INSERT INTO answers (question_id, answertext, is_correct) VALUES ('$q2_id', '$opt2_1', '".($correct2=='0' ? 1 : 0)."')");
    mysqli_query($conn, "INSERT INTO answers (question_id, answertext, is_correct) VALUES ('$q2_id', '$opt2_2', '".($correct2=='1' ? 1 : 0)."')");
    mysqli_query($conn, "INSERT INTO answers (question_id, answertext, is_correct) VALUES ('$q2_id', '$opt2_3', '".($correct2=='2' ? 1 : 0)."')");

    mysqli_query($conn, "INSERT INTO questions (quiz_id, question) VALUES ('$quiz_id', '$question3')");
    $q3_id = mysqli_insert_id($conn);
    mysqli_query($conn, "INSERT INTO answers (question_id, answertext, is_correct) VALUES ('$q3_id', '$opt3_1', '".($correct3=='0' ? 1 : 0)."')");
    mysqli_query($conn, "INSERT INTO answers (question_id, answertext, is_correct) VALUES ('$q3_id', '$opt3_2', '".($correct3=='1' ? 1 : 0)."')");
    mysqli_query($conn, "INSERT INTO answers (question_id, answertext, is_correct) VALUES ('$q3_id', '$opt3_3', '".($correct3=='2' ? 1 : 0)."')");

    echo "<p style='color:green;'>Quiz Created Successfully!</p>";
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<style>
body {
font-family: Arial, sans-serif; 
background-color: #f4f4f4; 
text-align: center; 
padding: 20px;}
.dashboard-container {
background-color: white; 
padding: 20px; margin: auto; 
width: 90%; max-width: 700px; 
border-radius: 10px; 
box-shadow: 0 0 10px rgba(0,0,0,0.1);}
h2 {
color: #333;}
table {
width: 100%; 
border-collapse: collapse; 
margin-top: 20px;}
th, td {
padding: 10px; 
border: 1px solid #ddd;}
th {
background-color: #007BFF; 
color: white;}
td {
text-align: center;}
.quiz-form {
background-color: white;
padding: 20px; margin-top: 20px; 
border-radius: 10px; 
box-shadow: 0 0 10px rgba(0,0,0,0.1);}
input, textarea {
width: 100%; 
padding: 8px; 
margin: 5px 0; 
border-radius: 5px; 
border: 1px solid #ccc;}
select {
width: 100%; 
padding: 8px; 
margin: 5px 0; 
border-radius: 5px; 
border: 1px solid #ccc;}
button {
background-color: #007BFF; 
color: white; 
padding: 10px 20px; 
border: none; 
border-radius: 5px; 
cursor: pointer;}
button:hover {
background-color: #0056b3;}
</style>
</head>
<body>

<div class="dashboard-container">
<h2>Admin Dashboard</h2>
<p>Users and Their Scores</p>

<table>
<thead>
<tr><th>User</th><th>Quiz</th><th>Score</th></tr>
</thead>
<tbody>
<?php
$sql = "SELECT users.email, quizzes.title, scores.score FROM scores JOIN users ON scores.user_id = users.id JOIN quizzes ON scores.quiz_id = quizzes.id ORDER BY scores.completed_at DESC";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
        echo "<td>" . htmlspecialchars($row['score']) . "%</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No scores available</td></tr>";
}
?>
</tbody>
</table>

<div class="quiz-form">
<h2>Create New Quiz</h2>
<form method="POST">
<input type="text" name="quiz_title" placeholder="Quiz Title" required>
<textarea name="quiz_description" placeholder="Quiz Description" required></textarea>

<h3>Question 1</h3>
<input type="text" name="question1" placeholder="Question text" required>
<input type="text" name="opt1_1" placeholder="Option 1" required>
<input type="text" name="opt1_2" placeholder="Option 2" required>
<input type="text" name="opt1_3" placeholder="Option 3" required>
<select name="correct1" required>
<option value="0">Option 1 Correct</option>
<option value="1">Option 2 Correct</option>
<option value="2">Option 3 Correct</option>
</select>

<h3>Question 2</h3>
<input type="text" name="question2" placeholder="Question text" required>
<input type="text" name="opt2_1" placeholder="Option 1" required>
<input type="text" name="opt2_2" placeholder="Option 2" required>
<input type="text" name="opt2_3" placeholder="Option 3" required>
<select name="correct2" required>
<option value="0">Option 1 Correct</option>
<option value="1">Option 2 Correct</option>
<option value="2">Option 3 Correct</option>
</select>

<h3>Question 3</h3>
<input type="text" name="question3" placeholder="Question text" required>
<input type="text" name="opt3_1" placeholder="Option 1" required>
<input type="text" name="opt3_2" placeholder="Option 2" required>
<input type="text" name="opt3_3" placeholder="Option 3" required>
<select name="correct3" required>
<option value="0">Option 1 Correct</option>
<option value="1">Option 2 Correct</option>
<option value="2">Option 3 Correct</option>
</select>

<button type="submit" name="create_quiz">Create Quiz</button>
</form>
</div>

</div>

</body>
</html>
