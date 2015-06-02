<?php require_once('view/header.php'); ?>
<div class="container">
<script>
    $(document).ready(function() {
        $('.name').editable();
        $('.name').editable();		
    });

    function confirmDelete() {
        if (confirm("Are you sure?")) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }
</script>
<h1><?=SITE_NAME?></h1>
       
    <div class="row">
        <div class="col-md-8">
        <form class="form-horizontal" role="form" method='POST' action='save'>
            <div class="form-group">
                <label for="name">Name:</label>
                <input name="name" type="text" class="form-control" id="name">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input name="price" type="text" class="form-control" id="price">
            </div>
            <div class="form-group">
                <label for="url">image URL:</label>
                <input name="url" type="text" class="form-control" id="url">
            </div>
            <div class="form-group">
            <button type="submit" class="btn btn-default">Submit</button>
            </div>
            
        </form>
        </div>   
    </div>
    <div class="row">
        <?php showPagination(DB_NAME); ?>
    </div>
    <div class="row">
        <div class="col-xs-8 col-xs-body">
        <?php if(isset($goods) && !empty($goods) && is_array($goods)):?> 
        <table class="table table-striped">
          <thead>
              <tr>
              <th><a href="<?=  (!isset($_GET['sort']) || $_GET['sort']=='id_desc') ? addToUrl(['sort' => 'id_asc']) : addToUrl(['sort' => 'id_desc'])?>">#</a></th>
              <th><a href="<?=  (!isset($_GET['sort']) || $_GET['sort']=='name_desc') ? addToUrl(['sort' => 'name_asc']) : addToUrl(['sort' => 'name_desc'])?>">Name</a></th>
              <th>Description</th>
              <th>Price</th>
              <th>Image URL</th>
              <th>Actions</th>
              </tr>
          </thead> 
          <tbody>
          <?php foreach($goods as $row): ?>
              <tr><td><?=$row['id']?></td>
              <td><a href="#" class='name' id="name" data-type="text" data-pk="<?=$row['id']?>" data-url="update" data-title="Enter username"><?=$row['name']?></a></td>
              <td><a href="#" class='name' id="description" data-type="text" data-pk="<?=$row['id']?>" data-url="update" data-title="Enter username"><?=$row['description']?></a></td>
              <td><a href="#" class='name' id="price" data-type="text" data-pk="<?=$row['id']?>" data-url="update" data-title="Enter username"><?=$row['price']?></a></td>
              <td><a href="#" class='name' id="url" data-type="text" data-pk="<?=$row['id']?>" data-url="update" data-title="Enter username"><?=$row['url']?></a></td>
              <td><a href="delete?id=<?=$row['id']?>" onclick="return confirmDelete();">Delete</a></td>
              </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        <?php else:?>
            <h2>Empty result</h2>
        <?php endif;?>    
        </div>
    </div>
    <div class="row">
        <?php showPagination(DB_NAME); ?>
    </div>
    <div class="row">
        <p>
        Time: <?=round($time,4)?> sec.
        </p>
    </div>  
</div>
<?php require_once('view/footer.php'); ?>