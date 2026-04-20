<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<form action="index.php?page=update_user" method="post" id="validator" role="form">
    <table class="table-striped">
        <tr>
            <td width="20%">Username</td>
            <td><input type="text" class="form-control" name="username" value="<?php if(isset($_SESSION['populate']['username'])){ echo $_SESSION['populate']['username']; } ?>" /></td>
        </tr>
        <tr>
            <td width="20%">First name</td>
            <td><input type="text" class="form-control" name="first_name" value="<?php if(isset($_SESSION['populate']['first_name'])){ echo $_SESSION['populate']['first_name']; } ?>" /></td>
        </tr>
        <tr>
            <td width="20%">Last name</td>
            <td><input type="text" class="form-control" name="last_name" value="<?php if(isset($_SESSION['populate']['last_name'])){ echo $_SESSION['populate']['last_name']; } ?>" /></td>
        </tr>
        <tr>
            <td width="20%">Password</td>
            <td><input type="password" class="form-control" name="password" /></td>
        </tr>
        <tr>
            <td width="20%">Email</td>
            <td><input type="text" class="form-control" name="email" value="<?php if(isset($_SESSION['populate']['email'])){ echo $_SESSION['populate']['email']; } ?>" /></td>
        </tr>
        <tr>
            <td width="20%">Gender</td>
            <td>Male : <input type="radio" name="gender" value="1" /> Female : <input type="radio" name="gender" value="0" /></td>
        </tr>
        <tr>
            <td width="20%">City</td>
            <td><input type="text" class="form-control" name="city" value="<?php if(isset($_SESSION['populate']['city'])){ echo $_SESSION['populate']['city']; } ?>" /></td>
        </tr>
        <tr>
            <td width="20%">Age</td>
            <td><input type="text" class="form-control" name="age" value="<?php if(isset($_SESSION['populate']['age'])){ echo $_SESSION['populate']['age']; } ?>" /></td>
        </tr>
        <tr>
            <td width="20%">About</td>
            <td><textarea name="about"><?php if(isset($_SESSION['populate']['about'])){ echo $_SESSION['populate']['about']; } ?></textarea></td>
        </tr>
        <tr>
            <td width="20%">Country</td>
            <td><input type="text" class="form-control" name="country" value="<?php if(isset($_SESSION['populate']['country'])){ echo $_SESSION['populate']['country']; } ?>" /></td>
        </tr>
    </table>
    <input type="submit" class="btn btn-primary" value="Add" />
</form>