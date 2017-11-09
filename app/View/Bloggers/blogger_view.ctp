<div class="main-wrap">
   <div class="container">
       <div class="row">
<table class="table table-striped">
        <tbody>
                
                <tr>
                  <td><?php echo __dbt('YouTube Url'); ?></td>
                  <td><?php echo h($videos['WallContent']['name']); ?></td>
                </tr>
                <tr>
                  <td><?php echo __dbt('Title'); ?></td>
                  <td><?php echo h($videos['WallContent']['title']); ?></td>
                </tr>
                
                <tr>
                  <td><?php echo __dbt('Status'); ?></td>
                  <td><?php echo h($videos['WallContent']['status']); ?></td>
                </tr>
                <tr>
                  <td><?php echo __dbt('Created'); ?></td>
                  <td><?php echo h($videos['WallContent']['created']); ?></td>
                </tr>
                <tr>
                  <td><?php echo __dbt('Modified'); ?></td>
                  <td><?php echo h($videos['WallContent']['modified']); ?></td>
                </tr>
      </tbody>
</table>    
            </div>
       </div>
    </div>