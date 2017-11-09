<a href="javascript:history.back();">Back</a>
<section class="grey_container">
    <h1 class="new_padd">View Section Listing</h1>
	<section class="grey_container_info">
            <section class="table_data">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabulardata"> 
		   <tr>
        <th>
            Name:
        </th>
        <td>
            <?php echo ucfirst($SectionList['SectionList']['name']); ?>
        </td>
    </tr>
    <tr>
        <th>
            Controller:
        </th>
        <td>
            <?php echo $SectionList['SectionList']['controller']; ?>
        </td>
    </tr>  
    <tr>
        <th>
            Action:
        </th>
        <td>
            <?php echo $SectionList['SectionList']['action']; ?>
        </td>
    </tr>      
		</table>
            </section>
	</section>
</section>