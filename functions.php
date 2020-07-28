<?php
// Add this to functions.php //
// Create XML by scraping email using before_send_mail action //
add_action( 'wpcf7_before_send_mail', 'cf7_xml_creation' );
function cf7_xml_creation($cf7) {
  // Allow to target the ID of specific form  //
  $form_id = $cf7->id();
  // Check certain form by ID - remove this IF statement if not specific //
  if ($form_id == 'your_form_ID'){
    // Make sure the file is saved into wp-content to retieve it within WPCF7 settings as an attachement //
    $user_register_xml = 'wp-content/uploads/xml/your_xml_file.xml';
    // Create file contents - if you have more fields add them to the output below - change the XML to suit your rows //
    $output = '<?xml version="1.0" encoding="UTF-8"?>';
    $output .= '<contacts>'."\n";
      $output .= '<contact>'."\n";
        $output .= '<first_name>'.$_POST['your-name'].'</first_name>'."\n";
        $output .= '<last_name>'.$_POST['your-last-name'].'</last_name>'."\n";
      $output .= '</contact>'."\n";
    $output .= '</contacts>';
    // Format XML //
    $xml = new SimpleXMLElement($output);
    // Save contents //
    file_put_contents($user_register_xml, $xml->asXML());
  }
}
// Clear file/user data after submission //
add_action('wpcf7_mail_sent', function ($cf7) {
  $user_register_xml = 'wp-content/uploads/xml/your_xml_file.xml';
  file_put_contents($user_register_xml, '');
  // File cleared and ready to be rewritten on next submission //
});
// Remember - add the above path to the WPCF7 File attachment setting within the relevant form //
?>
