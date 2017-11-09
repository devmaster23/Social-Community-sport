<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/*?>
<h2><?php echo $message; ?></h2>
<p class="error">
	<strong><?php echo __d('cake', 'Error'); ?>: </strong>
	<?php printf(
		__d('cake', 'The requested address %s was not found on this server.'),
		"<strong>'{$url}'</strong>"
	); ?>
</p>
<?php
if (Configure::read('debug') > 0):
	echo $this->element('exception_stack_trace');
endif;*/
?>
<section class="content">
<div class="error-page">
  <h2 class="headline text-yellow"><?php echo __dbt('404'); ?></h2>
  <div class="error-content">
    <h3><i class="fa fa-warning text-yellow"></i><?php echo __dbt('Oops! Page not found.'); ?></h3>
    <p>
     <?php echo __dbt('We could not find the page you were looking for.
      Meanwhile, you may <a href="../dashboard/index">return to dashboard</a>.'); ?>
    </p>

  </div><!-- /.error-content -->
</div><!-- /.error-page -->
</section><!-- /.content -->
