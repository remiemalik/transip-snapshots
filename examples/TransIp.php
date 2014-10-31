<?php


require_once ('insert location of the folder TransIp (transip-snapshots\TransIp)');

/**
 * 
 * @author Remie
 *
 */
class TransIp {
	function __construct() {
		
	}
	
	/**
	 * 
	 * @param unknown $vpses
	 * @return multitype:
	 */
	function getSnapShots($vpses) {
		$snapshotList = array ();
		
		try {
			foreach ( $vpses as $vps ) {
				// Get a list of all snapshots for a vps
				$snapshot = Transip_VpsService::getSnapshotsByVps ( $vps->name );
				
				array_push ( $snapshotList, $snapshot );
			}
			return $snapshotList;
		} catch ( SoapFault $f ) {
			// It is possible that an error occurs when connecting to the TransIP Soap API,
			// those errors will be thrown as a SoapFault exception.
			echo 'An error occurred: ' . $f->getMessage (), PHP_EOL;
		}
	}
	
	/**
	 * 
	 * @param unknown $vpsName
	 * @param unknown $snapshotName
	 */
	function setRemoveSnapShot($vpsName, $snapshotName) {
		try {
			// Remove snapshot for vps
			Transip_VpsService::removeSnapshot ( $vpsName, $snapshotName );
			echo "<--------------------------------------------->\n";
			echo 'Removing snapshot' . $snapshotName . " on " . $vpsName . "\n";
			echo "<--------------------------------------------/>\n\n";
		} catch ( SoapFault $f ) {
			// It is possible that an error occurs when connecting to the TransIP Soap API,
			// those errors will be thrown as a SoapFault exception.
			echo 'An error occurred: ' . $f->getMessage (), PHP_EOL;
		}
	}
	/**
	 * 
	 * @param unknown $vpsName
	 * @param unknown $snapshotName
	 */
	function setCreateSnapshot($vpsName, $snapshotName) {
		try {
			// Create snapshot for vps
			Transip_VpsService::createSnapshot ( $vpsName, $snapshotName );
			echo "<--------------------------------------------->\n";
			echo 'Starting snapshot ' . $snapshotName . " on " . $vpsName . "\n";
			echo "<--------------------------------------------/>\n\n";
		} catch ( SoapFault $f ) {
			// It is possible that an error occurs when connecting to the TransIP Soap API,
			// those errors will be thrown as a SoapFault exception.
			echo 'An error occurred: ' . $f->getMessage (), PHP_EOL;
		}
	}
	/**
	 * 
	 * @return multitype:Transip_Vps
	 */
	function getVpses() {
		try {
			// Get a list of all Vps objects
			$vpsList = Transip_VpsService::getVpses ();
			
			return $vpsList;
		} catch ( SoapFault $f ) {
			// It is possible that an error occurs when connecting to the TransIP Soap API,
			// those errors will be thrown as a SoapFault exception.
			echo 'An error occurred: ' . $f->getMessage (), PHP_EOL;
		}
	}
}

?>
