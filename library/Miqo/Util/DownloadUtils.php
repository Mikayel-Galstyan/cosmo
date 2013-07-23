<?php 
/**
 * undocumented class
 *
 * @package library_tf_util
 **/
abstract class Miqo_Util_DownloadUtils
{
	/**
	 * undocumented function
	 *
	 * @return void
	 **/
	public static function download ($content, $name, $contentType = null) {
		header('Content-Description: File Transfer');
		if (headers_sent()) {
			$this->Error('Some data has already been output to browser, can\'t send the file');
		}
		header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
		header('Pragma: public');
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		// force download dialog
		header('Content-Type: application/force-download');
		header('Content-Type: application/octet-stream', false);
		header('Content-Type: application/download', false);
		header('Content-Type: ' + $contentType, false);
		// use the Content-Disposition header to supply a recommended filename
		header('Content-Disposition: attachment; filename="'.basename($name).'";');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.strlen($content));
		echo $content;
	}
} // END abstract class Miqo_Util_DownloadUtils
 ?>