<?php
    session_start();
    include "../Safety.php";
    $Status = $_SESSION['Status'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="../css/AddPesertaCSV.css">
        <link rel="stylesheet" href="../css/BackgroundCSV.css">
        
        <script type="text/javascript" src="js/CreateQuesCSV.js" defer></script>
    <script type="text/javascript "src="../js/DefaultBackground.js" defer></script>
        <title>CSV</title>
    </head>
    <body>
    <div class="topnav">
        <a href="../html/senaraipeserta.php">Home</a>
        <a href = "../html/RegPesertaCSV.php">CSV</a>
        <a href = "../html/setting.php">Setting</a>
        <a href="../php/logout.php" class = "active">Logout</a>
</div>
        <header>
            <div id="ques" class="form-box">
                <h1>Register Participant</h1>
                <form id="question" class="input_group" name="input_group" id="input_group" action="../php/addPesertaCSV.php" method="POST" enctype="multipart/form-data">
                    <table border="1px" style="border-collapse:collapse;">
                    <caption>Format:</caption>
                        <thead>
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Name<br></th>
                                <th scope="col">Password<br></th>
                                <th scope="col">Marks<br></th>
                            </tr>
                        </thead>
                    </table>
                    <p>Example:</p>
                    <img src="../css/ExpCSV.png" alt="Instruction">
                    <p class="note">#Please create the CSV file like the above image. Leave the fourth column blank if you wish to set the mark value to default value.</p>
                    <div class="input_file">
                        <label style="font-size: 15px; color:#999;" for="upload">CSV File:</label>
                        <input type="file" name="upload" id="upload" accept=".csv">
                        <button type="submit" class="submit-btn" name="finish" id="finishbtn">Submit</button>
                    </div>
                </form>
            </div>
        </header>
    </body>
</html>