  <?php
  require('top.inc.php');
  $categories_id='';
  $name='';
  $mrp='';
  $price='';
  $qty='';
  $image='';
  $shortDesc='';
  $description='';
  $meta_title='';
  $meta_desc='';
  $meta_keyword='';
  $msg='';
  $image_required='required';
  if(isset($_GET['id']) && $_GET['id']!=''){
    $image_required='';
   $id=get_safe_vale($con,$_GET['id']);
   $res=mysqli_query($con,"select * from product where id='$id'");
   $check=mysqli_num_rows($res);
   if($check>0){
               $row=mysqli_fetch_assoc($res);
               $categories_id=$row['categories_id'];
               $name=$row['name'];
               $mrp=$row['mrp'];
               $price=$row['price'];
               $qty=$row['qty'];
               $shortDesc=$row['shortDesc'];
               $description=$row['description'];
               $meta_title=$row['meta_title'];
               $meta_desc=$row['meta_desc'];
               $meta_keyword=$row['meta_keyword'];

 } else{
  header('location:product.php');
    die();
  }

}
  if(isset($_POST['submit']))
  {
    $categories_id=get_safe_vale($con,$_POST['categories_id']);
    $name=get_safe_vale($con,$_POST['name']);
    $mrp=get_safe_vale($con,$_POST['mrp']);
    $price=get_safe_vale($con,$_POST['price']);
    $qty=get_safe_vale($con,$_POST['qty']);
    $shortDesc=get_safe_vale($con,$_POST['shortDesc']);
    $description=get_safe_vale($con,$_POST['description']);
    $meta_title=get_safe_vale($con,$_POST['meta_title']);
    $meta_desc=get_safe_vale($con,$_POST['meta_desc']);
    $meta_keyword=get_safe_vale($con,$_POST['meta_keyword']);
    $res=mysqli_query($con,"select * from product where name='$name'");
   $check=mysqli_num_rows($res);
   if($check>0){
               if(isset($_GET['id']) && $_GET['id']!=''){
                $getData=mysqli_fetch_assoc($res);
                if($id==$getData['id']){

                }
                else{
                  $msg="Product Aleready Exist";
                }

               }
               else{
              $msg="Product Aleready Exist";
            }
   }
  if($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg')
  {
    $msg="Please Select Only png,jpg and jpeg image format";

  }

  if($msg==''){

    if(isset($_GET['id']) && $_GET['id']!=''){
      if($_FILES['image']['name']!=''){
         $image=rand(111111111,999999999).'_'.$_FILES['image']['name'];
      move_uploaded_file($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);
      $update_sql="update product set categories_id='$categories_id',name='$name',mrp='$mrp',price='$price',qty='$qty',shortDesc='$shortDesc',description='$description',meta_title='$meta_title',meta_desc='$meta_desc',meta_keyword='$meta_keyword',image='$image' where id='$id'";
      }
      else{
        $update_sql="update product set categories_id='$categories_id',name='$name',mrp='$mrp',price='$price',qty='$qty',shortDesc='$shortDesc',description='$description',meta_title='$meta_title',meta_desc='$meta_desc',meta_keyword='$meta_keyword' where id='$id'";

      }
      mysqli_query($con,$update_sql);

    }
    else{
      $image=rand(111111111,999999999).'_'.$_FILES['image']['name'];
      move_uploaded_file($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);
    mysqli_query($con,"insert into product(categories_id,name,mrp,price,qty,shortDesc,description,meta_title,meta_desc,meta_keyword,status,image) values('$categories_id','$name','$mrp','$price','$qty','$shortDesc','$description','$meta_title','$meta_desc','$meta_keyword',1,'$image')");
  }
    header('location:product.php');
    die();
  }



  }






  ?>
 <div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Product</strong><small> Form</small></div>
                        <form method="post" enctype="multipart/form-data">
                          <div class="card-body card-block">
                          <div class="form-group">
                            <label for="categories" class=" form-control-label">Categories</label>
                            <select  class=" form-control" name="categories_id">
                              <option>Select Categories</option>
                              <?php
                              $res=mysqli_query($con,"select id,categories from categories order by categories asc");
                              while($row=mysqli_fetch_assoc($res)){
                                if($row['id']==$categories_id){
                                  echo "<option selected value=".$row['id'].">".$row['categories']."</option>";


                                }
                                else{
                                  echo "<option value=".$row['id'].">".$row['categories']."</option>";

                                }

                                

                              }


                              ?>

                            </select>
                          </div>
                           <div class="form-group">
                            <label for="Product" class=" form-control-label">Product</label>
                            <input type="text" name="name" placeholder="Enter Product Name" class="form-control" required value="<?php echo $name ?>">
                          </div>
                          <div class="form-group">
                            <label for="Product" class=" form-control-label">MRP</label>
                            <input type="text" name="mrp" placeholder="Enter Product MRP" class="form-control" required value="<?php 
                            echo $mrp ?>">
                          </div>
                          <div class="form-group">
                            <label for="Product" class=" form-control-label">Price</label>
                            <input type="text" name="price" placeholder="Enter Product Price" class="form-control" required value="<?php echo $price ?>">
                          </div>
                          <div class="form-group">
                            <label for="Product" class=" form-control-label">Quantity</label>
                            <input type="text" name="qty" placeholder="Enter Quantity" class="form-control" required value="<?php echo $qty  ?>">
                          </div>
                          <div class="form-group">
                            <label for="Product" class=" form-control-label">Image</label>
                            <input type="file" name="image" class="form-control" <?php echo $image_required?>>
                          </div>
                          <div class="form-group">
                            <label for="Product" class=" form-control-label">Short Description</label>
                            <textarea name="shortDesc" placeholder="Enter Product Short Description" class="form-control" required>
                              <?php echo $shortDesc ?></textarea>
                          </div>
                          <div class="form-group">
                            <label for="Product" class=" form-control-label">Description</label>
                            <textarea name="description" placeholder="Enter Product  Description" class="form-control" required>
                              <?php echo $description ?></textarea>
                          </div>
                           <div class="form-group">
                            <label for="Product" class=" form-control-label">Meta Title</label>
                            <textarea name="meta_title" placeholder="Enter Product  Meta Title" class="form-control">
                              <?php echo $meta_title ?></textarea>
                          </div>
                           <div class="form-group">
                            <label for="Product" class=" form-control-label">Meta Description</label>
                            <textarea name="meta_desc" placeholder="Enter Product Meta Description" class="form-control">
                              <?php echo $meta_desc ?></textarea>
                          </div>
                           <div class="form-group">
                            <label for="Product" class=" form-control-label">Meta Keyword</label>
                            <textarea name="meta_keyword" placeholder="Enter Product Meta Keyword" class="form-control">
                              <?php echo $meta_keyword ?></textarea>
                          </div>



                           <button name="submit" type="submit" class="btn btn-lg btn-info btn-block">
                           <span id="payment-button-amount">Submit</span>
                           </button>
                            <div class="field_error"><?php echo $msg ?></div>
                        </div>
                      </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
        <?php
  require('footer.inc.php');
  ?>