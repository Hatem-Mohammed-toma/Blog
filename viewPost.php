<?php require_once 'inc/header.php' ?>
<?php session_start() ?>
    <!-- Page Content -->
    <div class="page-heading products-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>new Post</h4>
              <h2>add new personal post</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    require_once 'inc/succes.php';
    ?>
<?php 
 require_once 'inc/connect.php' ;
if(isset($_GET['id'])){
$id =(int) $_GET['id'];
}else{
  header("Location:index.php");
}

$query = "select * from posts where id = $id";
$run = mysqli_query($conn, $query);
if(mysqli_num_rows($run)==1){
  $post= mysqli_fetch_assoc($run);
}else{
 $msg="no post founded ";
}

?>
    
    <div class="best-features about-features">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <!-- <h2>Our Background</h2> -->
            </div>
          </div>
          <div class="col-md-6">
            <div class="right-image">
            <a href=""><img src="assets/images/postImage/<?php echo $post['image'] ?>" alt=""></a>
            </div>
          </div>
          <div class="col-md-6">
            <div class="left-content">
              <h4><?= $post['title']?></h4>
              <p><?= $post['body']?></p>
              
            <?php if(isset($_SESSION['user_id'])): ?>
              <div class="d-flex justify-content-center">
                 <a href="editPost.php?id=<?= $post['id'] ?>" class="btn btn-success mr-3 "> edit post</a>

                  <form action="handle/removepost.php?id=<?=$post['id']?>" method="POST">            
                         <button type="submit" name="delete" class="btn btn-danger">delete post</button>
                        </form>  
              </div>
              <?php endif ;?>
            </div>
          </div>
        </div>
      </div>
</div>

    <?php require_once 'inc/footer.php' ?>
