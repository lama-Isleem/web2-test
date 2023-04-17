<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password =$_POST["password"];
    $gender=$_POST["gender"];


    

	$host = "localhost";
	$username="root";
	$passwordd="";
	$dbname="web22";
	

	$conn = new mysqli($host,$username,$passwordd,$dbname);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

	if($conn->connect_error){
        die("connection failed: ".$conn->connect_error);
	} 
    
    $stmt = $conn->prepare("INSERT INTO users (name,email,password,gender) VALUES (?, ?, ?, ?)");
     $stmt->bind_param("ssss", $name, $email, $hashed_password, $gender);
      	if($stmt->execute()){ 	
            	echo "New record created successfully"; 	
        }else{ 	
            	echo "Error: " . $conn->error; 
            	} 
                
                $conn->close();
                $stmt->close();
    

    // Validate name
    if (($name)=="") {
        echo "Name is required";
        exit;
    }

    // Validate email
    if (($email)=="") {
        echo "Email is required";
        exit;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    // Validate password
    if (($password)=="") {
        echo "Password is required";
        exit;
    } 

    // Validate gender
    if (isset($_POST['gender'])) {
        if ($_POST['gender'] == 1) {
             echo 'MALE';
        } else {
             echo 'FEMALE';
        }
    }

    // Validate image
    if($_FILES['image']['size'] > 1024*1024  ) {
        echo'Image size must be less than 1 MB';

    } else {
        $ext =  pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        // echo mime_content_type($_FILES['image']['name']);
        $img_name = date('Y-m-dH-i-s') . md5($_FILES['image']['name']) .'.' . $ext;
    }


}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title> signup</title>
</head>

<body>
    <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        Name: <input type="text" name="name">
        <br><br>
        Email: <input type="text" name="email">
        <br><br>
        Password: <input type="password" name="password">
        <br><br>
        Gender:
        <input type="radio" name="gender" value="1"> Male
        <input type="radio" name="gender" value="2"> Female
    
        <br><br>
        Image: <input type="file" name="image"><br><br>
        <input type="checkbox" name="checkbox" required >Remember me
        <br><br>
        <input type="submit" name="submit" value="Submit">
        
        
    </form> 
</body>

</html>