<?php
include 'db.php'; 


$quiz_id = isset($_GET['quiz_id']) ? $_GET['quiz_id'] : 0;


$quiz_query = "SELECT * FROM quizzes WHERE id = $quiz_id";
$quiz_result = mysqli_query($conn, $quiz_query);
$quiz = mysqli_fetch_assoc($quiz_result);


$question_query = "SELECT * FROM questions WHERE quiz_id = $quiz_id";
$questions_result = mysqli_query($conn, $question_query);


$answers_query = "SELECT * FROM answers WHERE question_id IN (SELECT id FROM questions WHERE quiz_id = $quiz_id)";
$answers_result = mysqli_query($conn, $answers_query);


$answers = [];
while ($answer_row = mysqli_fetch_assoc($answers_result)) {
    $answers[$answer_row['question_id']][] = $answer_row;
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
      padding: 20px;
    }
    .quiz-box {
      background: white;
      padding: 20px;
      margin: auto;
      width: 80%;
      max-width: 600px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      color: #333;
    }
    .question {
      margin-bottom: 20px;
      text-align: left;
    }
    .question p {
      font-weight: bold;
    }
    .question label {
      display: block;
      margin: 5px 0;
      cursor: pointer;
    }
    button {
      margin-top: 20px;
      padding: 10px 20px;
      font-size: 16px;
      background-color: #007BFF;
      color: white;
      border: none;
      cursor: pointer;
    }
    button:hover {
      background-color: #0056b3;
    }
    .score {
      margin-top: 20px;
      font-size: 18px;
      color: green;
    }
  </style>
</head>
<body>

  <div class="quiz-box">
    <h2 id="quizTitle"><?php echo $quiz['title']; ?></h2>
    <p id="quizDescription"><?php echo $quiz['description']; ?></p>
    <form id="quizForm" method="POST" action="submit_quiz.php">
      
      <?php
      $questionIndex = 1;
      while ($question = mysqli_fetch_assoc($questions_result)) {
          $questionId = $question['id'];
          $questionText = $question['question'];
          echo "<div class='question'>";
          echo "<p>Q$questionIndex: $questionText</p>";

          if (isset($answers[$questionId])) {
              foreach ($answers[$questionId] as $answer) {
                  $answerId = $answer['id'];
                  $answerText = $answer['answertext'];
                  echo "<label><input type='radio' name='q$questionId' value='$answerId'> $answerText</label>";
              }
          }
          echo "</div>";
          $questionIndex++;
      }
      ?>

      <button type="submit">Submit</button>
    </form>
  </div>

</body>
</html>
