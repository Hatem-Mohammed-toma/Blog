<?php session_start(); ?>
<?php require_once 'inc/header.php' ?>

    <!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="banner header-text">
      <div class="owl-banner owl-carousel">
        <div class="banner-item-01">
          <div class="text-content">
            <!-- <h4>Best Offer</h4> -->
            <!-- <h2>New Arrivals On Sale</h2> -->
          </div>
        </div>
        <div class="banner-item-02">
          <div class="text-content">
            <!-- <h4>Flash Deals</h4> -->
            <!-- <h2>Get your best products</h2> -->
          </div>
        </div>
        <div class="banner-item-03">
          <div class="text-content">
            <!-- <h4>Last Minute</h4> -->
            <!-- <h2>Grab last minute deals</h2> -->
          </div>
        </div>
      </div>
    </div>
    <?php
    require_once 'inc/errors.php'
    ?>
    <?php require_once 'inc/succes.php'?>

    <?php require_once 'inc/connect.php';

// pagination انا هنا لازم اديلو عدد الصفح اللي عايز.ها في كل صفحه ولازم كملن امسك الصفحه بي ال get 

  if(isset($_GET['page'])){
    $page=$_GET['page'];
  }else{
    $page= 1;
  }

  $limit=3;
  $offset = ($page-1)*$limit ;
  // number of pages = total /3       انا هنا لازم احدد عدد الصفحات عشان مينفعش اكتب عدد سالب او عدد زياده// ف انا
// ف انا لازم اعمل query يجبلي عدد البوستات اللي عندي عشان ابدا اقسمهم انا هنا برجع قيمه ف انا اكني بعمل select one 
// انا برجع قيمه عدد ف بترجع عن طريف fetch assoc []

$query="select count(id) as total from posts" ;
$result= mysqli_query($conn,$query);
if(mysqli_num_rows($result)==1){
  $total= mysqli_fetch_assoc($result)['total'];
}

 $Numberofpages=  ceil($total/$limit) ;

 if( $page<1 ){ // لو كتبت رقم 0 او رقم سالب بترجعني على الصفحه الاولى
  header("location:".$_SERVER['PHP_SELF']."?page=1"); // 
 }elseif($page > $Numberofpages ){ // لو كتبت رقم اكبر من عدد الصفحات  بيرجعني على اخر صفحه موجوده عندي 
  header("location:".$_SERVER['PHP_SELF']."?page=$Numberofpages"); 

 }

    $query="select * from  posts order by id limit $limit offset $offset";
   
    // $query="select * from  posts ";
    $run = mysqli_query($conn,$query);
    if(mysqli_num_rows($run) >0 ){
      $posts=mysqli_fetch_all($run,MYSQLI_ASSOC);
    }else{
      $msg = "no posts founded";
    }
    ?>

    <div class="latest-products">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Latest Posts</h2>
              <!-- <a href="products.html">view all products <i class="fa fa-angle-right"></i></a> -->
            </div>
          </div>


          <div class="col-md-4">
    <?php if (!empty($posts)): ?>
        <?php 
        $index = 1;
        foreach ($posts as $post): ?>
            <div class="product-item">
                <a href="<?php echo $index; ?>"><img src="assets/images/postImage/<?php echo $post['image'] ?>" alt=""></a>
                <div class="down-content">
                    <a href="#"><h4><?= $post['title'] ."<br>" ?></h4></a>
                    <div class = "m-3"></div>
                    <h6><?= $post['created_at'] ?></h6>
                   
                    <p class="body-content"><?= $post['body']?></p>
                    
                    <!-- <ul class="stars">
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                    </ul>
                    <span>Reviews (24)</span> -->
                    <div class="d-flex justify-content-end">
                        <!-- Adjust the link accordingly -->
                        <a href="viewPost.php?id=<?= $post['id'] ?>"  class="btn btn-info">View</a>
                    </div>
                </div>
            </div>
        <?php 
        $index++;
      endforeach; ?>
    <?php else: ?>
        <?php echo $msg; ?>
    <?php endif; ?>
</div>
   

<?php 
/*


*/
?>         
        </div>
      </div>
    </div>

   <div class="container d-flex justify-content-center"> 
<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item <?php if ($page==1) echo "disabled"?>">
      <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']."?page=".$page-1 ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>

    <li class="page-item"><a class="page-link" ><?php echo $page ?> of <?php echo $Numberofpages?> </a></li>

    <li class="page-item <?php if ($page==$Numberofpages) echo "disabled"?>">
      <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']."?page=".$page+1 ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>
</div>
    
<?php require_once 'inc/footer.php' ?>
