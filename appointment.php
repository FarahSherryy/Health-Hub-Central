<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


	include("connection.php");
	

	if (!isset($_SESSION['username'])) {
		header("location:login.php");
	}
	

	if(isset($_POST['submit']))
  {
 $name=$_POST['name'];
 $mobnum=$_POST['phone'];
 $email=$_POST['email'];
 $appdate=$_POST['date'];
 $aaptime=$_POST['time'];
 $specialization=$_POST['specialization'];
 $doctorlist=$_POST['doctorlist'];
 $message=$_POST['message'];
 $aptnumber=mt_rand(100000000, 999999999);
 $cdate=date('Y-m-d');

if($appdate<=$cdate){
       echo '<script>alert("Appointment date must be greater than todays date")</script>';
} else {
$sql="insert into tblappointment(AppointmentNumber,Name,MobileNumber,Email,AppointmentDate,AppointmentTime,Specialization,Doctor,Message)values(:aptnumber,:name,:mobnum,:email,:appdate,:aaptime,:specialization,:doctorlist,:message)";
$query=$dbh->prepare($sql);
$query->bindParam(':aptnumber',$aptnumber,PDO::PARAM_STR);
$query->bindParam(':name',$name,PDO::PARAM_STR);
$query->bindParam(':mobnum',$mobnum,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':appdate',$appdate,PDO::PARAM_STR);
$query->bindParam(':aaptime',$aaptime,PDO::PARAM_STR);
$query->bindParam(':specialization',$specialization,PDO::PARAM_STR);
$query->bindParam(':doctorlist',$doctorlist,PDO::PARAM_STR);
$query->bindParam(':message',$message,PDO::PARAM_STR);

 $query->execute();
   $LastInsertId=$dbh->lastInsertId();
   if ($LastInsertId>0) {
    echo '<script>alert("Your Appointment Request Has Been Send. We Will Contact You Soon")</script>';
echo "<script>window.location.href ='appointment.php'</script>";
  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}
}
?>





<!DOCTYPE html>
<html>
<head>
	<title>Book an Appointment</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
        
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/bootstrap-icons.css" rel="stylesheet">

    <link href="css/owl.carousel.min.css" rel="stylesheet">

    <link href="css/owl.theme.default.min.css" rel="stylesheet">

    <link href="css/templatemo-medic-care.css" rel="stylesheet">
	<script>
	function getdoctors(val) {
 	 //  alert(val);
	$.ajax({

	type: "POST",
	url: "get_doctors.php",
	data:'sp_id='+val,
	success: function(data){
	$("#doctorlist").html(data);
	}
	});
	}
  </script>
</head>
<body id="top">
<?php include_once('header.php');?>
<div class="name">
        <center><span style="font-size: 40px; font-weight: bold;">Welcome  </span>
            <?php
            // echo $_SESSION['valid'];
            
            echo '<span style="font-size: 40px; font-weight: bold;">' . $_SESSION['username'] . '</span>';

            ?>
            
        </center>
    </div>

	<section class="gallery">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-6 ps-0">
                            <img src="images/medium-shot-man-getting-vaccine.jpg" class="img-fluid galleryImage" alt="get a vaccine" title="get a vaccine for yourself">
                        </div>

                        <div class="col-lg-6 col-6 pe-0">
                            <img src="images/female-doctor-with-presenting-hand-gesture.jpg" class="img-fluid galleryImage" alt="wear a mask" title="wear a mask to protect yourself">
                        </div>

                    </div>
                </div>
    </section>

	<section class="section-padding" id="booking">
                <div class="container">
                    <div class="row">
                    
                        <div class="col-lg-8 col-12 mx-auto">
                            <div class="booking-form">
                                
                                <h2 class="text-center mb-lg-3 mb-2">Book an appointment</h2>
                            
                                <form role="form" method="post">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Full name" required='true'>
                                        </div>

                                        <div class="col-lg-6 col-12">
                                            <input type="email" name="email" id="email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Email address" required='true'>
                                        </div>
                                   
                                        <div class="col-lg-6 col-12">
                                            <input type="telephone" name="phone" id="phone" class="form-control" placeholder="Enter Phone Number" maxlength="10">
                                        </div>

                                        <div class="col-lg-6 col-12">
                                            <input type="date" name="date" id="date" value="" class="form-control">
                                            
                                        </div>

                                            <div class="col-lg-6 col-12">
                                            <input type="time" name="time" id="time" value="" class="form-control">
                                            
                                        </div>

    <div class="col-lg-6 col-12">
<select onChange="getdoctors(this.value);"  name="specialization" id="specialization" class="form-control" required>
<option value="">Select specialization</option>
<!--- Fetching States--->
<?php
$sql="SELECT * FROM tblspecialization";
$stmt=$dbh->query($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
while($row =$stmt->fetch()) { 
  ?>
<option value="<?php echo $row['ID'];?>"><?php echo $row['Specialization'];?></option>
<?php }?>
</select>
</div>


<div class="col-lg-6 col-12">
<select name="doctorlist" id="doctorlist" class="form-control">
<option value="">Select Doctor</option>
</select>
</div>



                                        <div class="col-12">
                                            <textarea class="form-control" rows="5" id="message" name="message" placeholder="Additional Message"></textarea>
                                        </div>

                                        <div class="col-lg-3 col-md-4 col-6 mx-auto">
                                            <button type="submit" class="form-control" name="submit" id="submit-button">Book Now</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </section>


	

	<!-- JAVASCRIPT FILES -->
	<script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/scrollspy.min.js"></script>
        <script src="js/custom.js"></script>
</body>
</html>