<?php
include 'db.php';
session_start();
$quiz_id = isset($_GET['quiz_id']) ? (int)$_GET['quiz_id'] : 0;
$user_id = 1;
$score = null;
$totalQuestions = null;
$percentage = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    $totalQuestions = 0;
    foreach ($_POST as $question_id => $answer_id) {
        if ($question_id != 'quiz_id') {
            $totalQuestions++;
            $sql = "SELECT * FROM answers WHERE id = $answer_id AND is_correct = 1";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $score++;
            }
        }
    }
    if ($totalQuestions > 0) {
        $percentage = round(($score / $totalQuestions) * 100);
        $insertScore = "INSERT INTO scores (user_id, quiz_id, score, completed_at) VALUES ($user_id, $quiz_id, $percentage, NOW())";
        mysqli_query($conn, $insertScore);
    }
}
$questions = [];
if ($quiz_id > 0) {
    $sql = "SELECT * FROM questions WHERE quiz_id = $quiz_id";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $questions[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Quiz</title>
<style>
body {
font-family: Arial, sans-serif;
background-color: #f0f0f0;
text-align: center;
padding: 20px;}
.quiz-box {
background: white;
padding: 20px;
margin: auto;
width: 80%;
max-width: 600px;
border-radius: 10px;
box-shadow: 0 0 10px rgba(0,0,0,0.1);}
h2 {
color: #333;}
.question {
margin-bottom: 20px;
text-align: left;}
.question p {
font-weight: bold;}
.question label {
display: block;
margin: 5px 0;
cursor: pointer;}
button {
margin-top: 20px;
padding: 10px 20px;
font-size: 16px;
background-color: #007BFF;
color: white;
border: none;
cursor: pointer;}
button:hover {
background-color: #0056b3;}
.score {
margin-top: 20px;
font-size: 18px;
color: green;}
</style>
</head>
<body>

<div class="quiz-box">
<h2>Quiz</h2>

<?php if ($score !== null): ?>
<div class="score">
You scored <?php echo $score; ?> out of <?php echo $totalQuestions; ?> (<?php echo $percentage; ?>%)
</div>
<?php endif; ?>

<?php if (!empty($questions)): ?>
<form method="POST">
<input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">

<?php foreach ($questions as $q): ?>
<div class="question">
<p><?php echo $q['question']; ?></p>
<?php
$q_id = $q['id'];
$sql = "SELECT * FROM answers WHERE question_id = $q_id";
$ansResult = mysqli_query($conn, $sql);
while ($ans = mysqli_fetch_assoc($ansResult)) {
echo '<label><input type="radio" name="' . $q_id . '" value="' . $ans['id'] . '"> ' . $ans['answertext'] . '</label>';
}
?>
</div>
<?php endforeach; ?>

<button type="submit">Submit Quiz</button>
</form>
<?php else: ?>
<p>No questions available for this quiz.</p>
<?php endif; ?>

</div>

</body>
</html>
