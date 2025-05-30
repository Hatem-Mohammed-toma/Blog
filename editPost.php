<?php require_once 'inc/header.php' ?>
<?php
session_start();
if(!isset($_SESSION['user_id'])){
  header('location:login.php');
}
 ?>
 <!-- Page Content -->
 <div class="page-heading products-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>Edit Post</h4>
              <h2>edit your personal post</h2>
            </div>
          </div>
        </div>
      </div>
    </div>

<div class="container w-50 ">
<div class="d-flex justify-content-center">
    <h3 class="my-5">edit Post</h3>
  </div>
  
  <?php
      require_once 'inc/errors.php';
 ?>
 
<?php 
require_once 'inc/connect.php';

if(isset($_GET['id'])){
  $id = $_GET['id'];

  $query = "select * from posts where id=$id";
  $runQuery = mysqli_query($conn,$query);
  if(mysqli_num_rows($runQuery) == 1){
    $post = mysqli_fetch_assoc($runQuery);
  }else{
    //header("location:handle/handleeditpost.php");
    header("location:index.php");
  }
}
// if(isset($_GET['id'])){
//   $id=$_GET['id'] ;

// $query = "select * from posts where id = $id";
// $run = mysqli_query($conn, $query);

// if(mysqli_num_rows($run)==1){
//   $post= mysqli_fetch_assoc($run);
// }else{
//   $_SESSION['errors']=["not select post"];
//   header("Location:index.php");
// }
// }else{
//   $_SESSION['errors']=["not select id"];
//   header("Location:index.php");
// }

?>

    <form method="POST" action="handle/handleeditpost.php?id=<?= $post['id']?>" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo $post['title']?>">
        </div>
        <div class="mb-3">
        <label for="body" class="form-label">Body</label>
        <textarea class="form-control" id="body" name="body" rows="5"><?php echo $post['body']; ?></textarea>
    </div>
        <div class="mb-3">
            <label for="body" class="form-label">image</label>
            <input type="file" class="form-control-file" id="image" name="file" >
        </div>
        <img src="assets/images/postImage/<?php echo $post['image'] ?>" alt="" width="100px" srcset="">
        
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>
</div>


<?php require_once 'inc/footer.php' ?>