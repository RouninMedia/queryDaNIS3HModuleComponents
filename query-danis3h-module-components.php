<?php

  //******************//
 //* DISPLAY ERRORS *//
//******************//

error_reporting(E_ALL);
ini_set('display_errors', 1);


  //*********************************//
 //* QUERY danis3hModule COMPONENTS *//
//*********************************//

function queryDaNIS3HModuleComponents($Module, $Publisher) {

  // What about... CUSTOM COMPONENTS ?? Probably need to preserve these?
  $danis3hModuleManifest = getDaNIS3HModuleManifest($Module, $Publisher);
  
  // DELETE COMMENTS
  $danis3hModuleManifest = preg_replace('/\/\/(?!\s{1}[A-Z]).*/', '', $danis3hModuleManifest);
  $danis3hModuleManifest = preg_replace('/\/\*.*?\*\//s', '', $danis3hModuleManifest);
  
  // EXTRACT BUILD COMPONENTS
  $danis3hModuleManifest = preg_replace('/.*(\/\/\s{1}BUILD\s{1}COMPONENTS)/s', '  // BUILD COMPONENTS', $danis3hModuleManifest);
  $danis3hModuleManifest = preg_replace('/.*(\/\/\s{1}BUILD\s{1}COMPONENTS[^\/]*).*/s', '$1', $danis3hModuleManifest);

  // REMOVE SPECIAL COMPONENTS
  $danis3hModuleManifest = preg_replace('/\$Module\[\'(?:Register|Requires).*/', '', $danis3hModuleManifest);

  // DELETE LINE INDENTS
  $danis3hModuleManifest = str_replace('  ', '', $danis3hModuleManifest);
  $danis3hModuleManifest = str_replace('// BUILD COMPONENTS', '', $danis3hModuleManifest);

  // PREPARE ASHIVA MODULE COMPONENTS ARRAY
  $danis3hModuleManifest = str_replace('$Module[\'', '', $danis3hModuleManifest);
  $danis3hModuleManifest = preg_replace('/\'\].*/', '', $danis3hModuleManifest);
  $danis3hModuleManifest = preg_replace('/([A-Za-z0-9])\n/', '$1,', $danis3hModuleManifest);
  $danis3hModuleManifest = trim($danis3hModuleManifest);

  // BUILD ASHIVA MODULE COMPONENTS ARRAY  
  $danis3hModuleComponents = explode(',', $danis3hModuleManifest);
  array_pop($danis3hModuleComponents);

  return $danis3hModuleComponents;
}

?>
