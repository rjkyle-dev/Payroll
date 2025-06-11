<?php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "payroll_db";

   try {
       // Establish PDO connection
       $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
       // Set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       // Prepare and execute the query
       $sql = "SELECT * FROM employees";
       $stmt = $conn->prepare($sql);
       $stmt->execute();

   } catch (PDOException $e) {
       echo "Connection failed: " . $e->getMessage();
   }
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Bootstrap Example</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
   </head>
   <style>
   .col-sm-6{text-align:Center}
   .col-sm-12{text-align:Center}
   </style>
   
   <body>
   <h3 class="text-center">Display Data in Bootstrap Modal</h3>
      <div class="container">
         <table class="table table-striped">
            <thead>
               <tr>
                  <th>Name</th>
                  <th>Age</th>
               </tr>
            </thead>
            <tbody>
               <?php 
                  // Fetching data from PDO result
                  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
                  {
                  ?>
               <tr>
                <td>
                     <img src="http://localhost/mvcPayroll/public/<?php echo $row['photo_path']; ?>" style="width: 50px; height: 50px;" alt="Employee Photo">
                  </td>


                  <td> <?php echo $row["employee_no"] ?></td>
                  <td> <?php echo $row["first_name"] ?></td>
                  <td> <?php echo $row["middle_name"] ?></td>
                  <td> <?php echo $row["last_name"] ?></td>
                  <td> <?php echo $row["rfid_number"] ?></td>
                  <td><a href='javascript:void(0)' class="btn btn-success get_id" data-id='<?php echo $row["id"] ?>' data-toggle="modal" data-target="#myModal"><?php echo $row["position"] ?></a></td>
               </tr>
               <?php	
                  }
                  ?>
            </tbody>
         </table>
      </div>
      <div id="myModal" class="modal fade" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               
               <div class="modal-body" id="load_data">
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
      <script>
	  
      $(document).ready(function(){
          $(".get_id").click(function(){
              var ids = $(this).data('id');
               $.ajax({
                   url:"upload.php",
                   method:'POST',
                   data:{id:ids},
                   success:function(data){
                       
                       $('#load_data').html(data);
                   
                   }
                   
               })
          })
      })
      
      </script>
   </body>
</html>
<!--  -->
