<?php
    include "../Safety.php";
    session_start();

    require '../connect.php';

    if(isset($_POST['finish'])){
        $fileName = $_FILES["upload"]["tmp_name"];
        
        if ($_FILES["upload"]["size"] > 0) {
            //Open upload file
            $file = fopen($fileName, "r");
            $location = "Location: ../html/senaraipeserta.php";
            $errMsg = "Upload CSV file with correct format as shown in the diagram";
            
            while (($column = fgetcsv($file, ",")) !== FALSE) {
                //Loop through every record
                if(!isset($column[0]) || empty($column[0])) {
                    //Question doesn't exist
                    header($location);
                    exit();
                }


                if(!isset($column[1]) || empty($column[1])){
                    //Answer doesn't exist
                    header($location);
                    exit();
                }


                if(!isset($column[2]) || empty($column[2])){
                    header($location);
                    exit();
                }

                if(!isset($column[3]) || empty($column[3])){
                    $markah = 0;
                }else{
                    $markah = $column[3];
                }

                
                $usernamePeserta = '0'.$column[0];
                //Insert data into database
                $reg = "INSERT into peserta(usernamePeserta, namaPeserta, kataLaluanPeserta, markah)
                values ('". mysqli_real_escape_string($con, $column[0]) ."', 
                '". mysqli_real_escape_string($con, $column[1]) ."', 
                '". mysqli_real_escape_string($con, $column[2]) ."', 
                '". mysqli_real_escape_string($con, $Markah) ."'
                ) ";
                mysqli_query($con, $reg) or die(mysqli_error());
                $idques = mysqli_insert_id($con);
                echo '<script>alert("Upload Successfully")</script>';
                echo "<script>window.location.href = '../html/RegPesertaCSV.php'</script>";
                
        }
    }
    }else{
        header($location);
        exit();
    }

?>