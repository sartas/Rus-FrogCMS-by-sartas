function db_driver_change(driver)
{
	jQuery('#row_db_host, #row_db_port, #row_db_user, #row_db_pass, #row_table_prefix').toggle();

	if( driver == 'sqlite' )
	{
		jQuery('#help-db-name').innerHTML = 'Required. Enter the <strong>absolute</strong> path to the database file.';
	}
	elseif( driver == 'mysql' )
	{
		jQuery('#help-db-name').innerHTML = 'Required. You have to create a database manually and enter its name here.';
	}
}