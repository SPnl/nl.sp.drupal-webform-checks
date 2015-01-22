<?php

ini_set('display_errors','on');
error_reporting(E_ALL);

define('DRUPAL_ROOT', realpath(__DIR__ . '/../../../../../'));
$base_url = 'http://'.$_SERVER['HTTP_HOST'];
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';

drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
civicrm_initialize();
require_once('/var/aegir/platforms/spnettest/sites/spnettest.sp.nl/civicrm.settings.php');
require_once('api/class.api.php');

db_update('queue')
	->fields(array('expire' => 0))
	->execute();

$queue = DrupalQueue::get('spwebform_queue');

while($item = $queue->claimItem(1)) { // Lease time = 1, daarna weer losgelaten

	var_dump(spwebformchk_cron_callback($item));
}
