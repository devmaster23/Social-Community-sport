<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li><?php echo $this->Html->link(__dbt( isset($title) ? $title : 'Users'), array('controller' => isset($controller) ? $controller : 'users', 'action' => 'index')); ?></li>
  </ol>
