<!DOCTYPE html>
<html>
<head>
  <title>Home</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      text-align: center;
      padding: 20px;
    }
    h2 {
      color: #333;
    }
    .quiz-container {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 8px;
      margin-top: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 80%;
      max-width: 500px;
      margin: 0 auto;
    }
    button {
      padding: 10px 20px;
      font-size: 16px;
      margin: 10px;
      background-color: #007BFF;
      color: white;
      border: none;
      cursor: pointer;
    }
    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

  <h2>Welcome to the Quiz App</h2>
  <p>Hello, <span id="userName"></span>! Choose a quiz below to test your knowledge.</p>

  <div class="quiz-container">
    <h3>Available Quizzes:</h3>

    <?php
    
    include 'get_quizzes.php';
    ?>

  </div>

  <script>
    const userName = localStorage.getItem("currentUser");
    if (userName) {
      document.getElementById('userName').innerText = userName;
    } else {
      document.getElementById('userName').innerText = "Guest";
    }
  </script>

</body>
</html>
