<?php
require_once '../config/config.php';
require_once '../config/db.php';

$sql = 'SELECT id, name FROM departments';

$results = $db->query($sql);
#print_r($results);

$row = $results->fetch_all(MYSQLI_ASSOC);
$ms = '';

#print_r($row);

#print_r($_POST);

if(isset($_POST['submit'])){
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $role = $_POST['role'];
  $dept_ID = $_POST['dept_ID'];
  $address = $_POST['address'];
  $phone = $_POST['phone'];
  $id = time();

  $password = password_hash($password, PASSWORD_DEFAULT);
//check email
  $sql = "Select * from users where email = '$email'";
  $results = $db->query($sql);
  $row = $results->num_rows;
  if($row > 0){
    $ms =  'Email already existed';
  }else{
    $sql = "INSERT INTO users (id, fullname, email, dept_ID, phone,password, role, address) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('ississss', $id, $fullname, $email, $dept_ID, $phone,$password, $role, $address);
    $stmt->execute();
    $ms = 'Add user success';
  }


 /* $sql = "INSERT INTO users (id, fullname, email, dept_ID, phone, password, role, address)
   VALUES ($id, '$fullname', '$email', '$dept_ID', '$phone','$password', '$role', '$address')";

  $db->query($sql);*/
}

?>



<form action="" method="post">
<h3>Form Add user </h3>
  <input type="text" name="fullname" placeholder="Fullname">
  <input type="text"  name="email"  placeholder="Email">
  <input type="text"  name="password"  placeholder="password">
  <input type="text"  name="phone"  placeholder="Phone">
  <select name="role">
    <option value="user">User</option>
    <option value="manager">Manager</option>
    <option value="admin">Super admin</option>
  </select>
  <h5>Department</h5>
  <select name="dept_ID">
    <?php
    foreach ($row as $row) {
      echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
    }
    ?>
  </select>
  <textarea name="address"  name=""  placeholder="Address"></textarea>
  <div class='alert'>
  <?php
  echo $ms;
  ?>
  </div>
  <a href="<?php echo BASE_URL ?>/user">Cancel</a>
  <button type="submit"  name="submit" value="Add user">Submit</button>
</form>

<style>
  form {
    max-width: 500px;
    margin:0 auto;
  }
  form input, form select, form textarea{
    display: block;
    margin-bottom: 10px;
  }
  .alert{
    background: #f00;
    color: #fff;
    padding: 10px;
    border-radius: 5px;
  }
</style>
