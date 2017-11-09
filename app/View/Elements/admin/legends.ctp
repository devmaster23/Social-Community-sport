<ul>
    <?php if ($this->request->params['controller'] == 'news' || $this->request->params['action'] == 'admin_index ') { ?>
        <li>
            <i class="fa fa-eye"></i> View News
        </li>
        <li>
            <i class="fa fa-edit"></i> Edit News
        </li>
        <li>
            <i class="fa fa-remove"></i> Delete News
        </li>
        <li>
            <i class="fa fa-arrow-up"></i> Set Top News<i class="fa fa-star"></i> Set Normal News
        </li>
        <li>
            <i class="fa fa-th"></i> Publish News<i class="fa fa-power-off"></i> Un publish News
        </li>
    <?php } ?>
</ul>
