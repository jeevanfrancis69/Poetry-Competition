<?php
    include "../connect.php";
    $sel =  "SELECT * FROM peserta ORDER BY namaPeserta ASC";
    if(isset($_POST['search']) && !empty($_POST['search'])){
        $search = $_POST['search'];
        $sel =  "SELECT * FROM peserta ORDER BY namaPeserta ASC";
    }
    $result = mysqli_query($con, $sel);
    $count = 1;
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/senaraipeserta.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript">  

function myFunction1() {
    // Get the checkbox
    var checkBox = document.getElementById("myCheck");

    // If the checkbox is checked, display the output text
    if (checkBox.checked == true){
        var ele=document.getElementsByName('List[]');  
    for(var i=0; i<ele.length; i++){  
        if(ele[i].type=='checkbox')  
            ele[i].checked=true;  
    }  
    } else {
        var ele=document.getElementsByName('List[]');  
    for(var i=0; i<ele.length; i++){  
        if(ele[i].type=='checkbox')  
            ele[i].checked=false;  
    }
    }   
}

var searchbar = document.getElementById("searchbar");
// Execute a function when the user releases a key on the keyboard
searchbar.addEventListener("keyup", e => {
// Number 13 is the "Enter" key on the keyboard
    if (e.key === 13) {
        // Cancel the default action, if needed
        e.preventDefault();
        // Trigger the button element with a click
        document.getElementById("searchbtn").click();
    }
});


function changeInput(index){
    document.getElementById('id02').style.display='block';

    var ic = document.getElementById('username');
    var nama = document.getElementById('nama');
    var pass = document.getElementById('pass');
    var OriNoIC = document.getElementById('OriNoUser');
    var mark = document.getElementById('mark');

    
    var table = document.getElementById("myTable");
    var tr = table.getElementsByTagName("tr");

    ictd = tr[index].getElementsByTagName("td")[1];
    namatd = tr[index].getElementsByTagName("td")[2];
    passtd = tr[index].getElementsByTagName("td")[3];
    OriNoICtd = tr[index].getElementsByTagName("td")[1];
    marktd = tr[index].getElementsByTagName("td")[4];
    
    ic.value = ictd.textContent || ictd.innerText;
    nama.value = namatd.textContent || namatd.innerText;
    pass.value = passtd.textContent || passtd.innerText;
    OriNoIC.value = OriNoICtd.textContent || OriNoICtd.innerText;
    mark.value = marktd.textContent || marktd.innerText;
}

</script> 
<script>
function myFunction() {
  
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
</head>

<body>
<div class="topnav">
        <a href="../html/senaraipeserta.php">Home</a>
        <a href="../html/RegPesertaCSV.php">CSV</a>    
        <a href="../html/setting.php">Settings</a>        
</div>

<h1>List of Students</h1>
    <form action="" method="post">
        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names..">
    </form>

    <div class="container">
    <form action="../php/delete.php" method = "POST">
        <?php if($row = mysqli_num_rows($result) >= 0){ ?>
        
        <table id="myTable">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Username Peserta</th>
                    <th scope="col"><strong>Nama</strong></th>
                    <th scope="col"><strong>Kata Laluan Peserta</strong></th>
                    <th scope="col"><strong>Markah</strong></th>
                    <th scope="col"><strong>Edit Information</strong></th>
                    <th scope="col"><strong>Select<input type = "checkbox" onclick="myFunction1()" id = "myCheck"></strong></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $row['usernamePeserta']; ?></td>
                            <td><?php echo $row['namaPeserta']; ?></td>
                            <td><?php echo $row['kataLaluanPeserta']; ?></td>
                            <td><?php echo $row['markah']; ?></td>
                            <td><button type="reset" onclick="changeInput(<?php echo $count; ?>)" style="width:auto;">Edit</button>
                            <td><input type="checkbox" value="<?php echo $row["usernamePeserta"]?>" name = "List[]"></td>
                        </tr>
                <?php
                $count++; 
                } 
                ?>
            </tbody>
        </table>
        <button type="reset" onclick="document.getElementById('id01').style.display='block'" style="width:auto;">+ Add Student</button>
        <button style.display='block' type="submit" name="button1" class="button" >- Delete Selected Student(s)</button>
        </form>
            </div>

<div id="id01" class="modal">
  
  <form class="modal-content animate" action="../php/processAdminDaftarPeserta.php" method="post">

    <div class="container">
            <input type="text" placeholder="Name" name = "namaPeserta" required>
            <input type="text" placeholder="Username" name = "usernamePeserta" minlength = 12 maxlength = 12 required>
            <input type="text" placeholder="Password" name = "kataLaluanPeserta" required>
            <button type = "submit" id = "abc">Add Student</button>
                    

    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </form>
</div>

<div id="id02" class="modal">
  
  <form class="modal-content animate" action="../php/processEditPeserta.php" method="post">

    <div class="container">
          <input type="text" placeholder="usernamePeserta" id="ic" name = "usernamePeserta" minlength = 4 maxlength = 12 required>
            <input type="text" placeholder="Name" id="nama" name = "namaPeserta" required>
            <input type="text" placeholder="Kata Laluan" id="pass" name = "kataLaluanPeserta" minlength = 6 maxlength = 12 required>
            <input type="text" placeholder="Markah" id="mark" name = "MarkahPeserta" required>
            <input type="hidden" id = "OriNoUser" name="OriNoUser" minlength = 4 maxlength = 12 required>
            <button type = "submit" id = "abc">Edit Information</button>
                
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </form>
</div>

<script>
// Get the modal
var modal1 = document.getElementById('id01');
var modal2 = document.getElementById('id02');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal1 || event.target == modal2) {
        modal1.style.display = "none";
        modal2.style.display = "none";
    }
}
</script>
        <?php 
        }else{ 
        ?>
            <p>No matches!</p>
        <?php 
        }
        ?>
    </div>
</body>
</html>