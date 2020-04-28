# queryAshivaModuleComponents
`queryAshivaModuleComponents()` is a PHP function which queries an ashivaModule Manifest and returns the Da3SH Component types employed by that ashivaModule.

The function requires **two parameters**:

 - `$Module`
 - `$Publisher`

## queryAshivaModuleComponents Function:

```
function queryAshivaModuleComponents($Module, $Publisher) {

  // What about... CUSTOM COMPONENTS ?? Probably need to preserve these?

  $ashivaModuleManifest = getAshivaModuleManifest($Module, $Publisher);
  
  // DELETE COMMENTS
  $ashivaModuleManifest = preg_replace('/\/\/(?!\s{1}[A-Z]).*/', '', $ashivaModuleManifest);
  $ashivaModuleManifest = preg_replace('/\/\*.*?\*\//s', '', $ashivaModuleManifest);
  
  // EXTRACT BUILD COMPONENTS
  $ashivaModuleManifest = preg_replace('/.*(\/\/\s{1}BUILD\s{1}COMPONENTS)/s', '  // BUILD COMPONENTS', $ashivaModuleManifest);
  $ashivaModuleManifest = preg_replace('/.*(\/\/\s{1}BUILD\s{1}COMPONENTS[^\/]*).*/s', '$1', $ashivaModuleManifest);

  // REMOVE SPECIAL COMPONENTS
  $ashivaModuleManifest = preg_replace('/\$Module\[\'(?:Register|Requires).*/', '', $ashivaModuleManifest);

  // DELETE LINE INDENTS
  $ashivaModuleManifest = str_replace('  ', '', $ashivaModuleManifest);
  $ashivaModuleManifest = str_replace('// BUILD COMPONENTS', '', $ashivaModuleManifest);

  // PREPARE ASHIVA MODULE COMPONENTS ARRAY
  $ashivaModuleManifest = str_replace('$Module[\'', '', $ashivaModuleManifest);
  $ashivaModuleManifest = preg_replace('/\'\].*/', '', $ashivaModuleManifest);
  $ashivaModuleManifest = preg_replace('/([A-Za-z0-9])\n/', '$1,', $ashivaModuleManifest);
  $ashivaModuleManifest = trim($ashivaModuleManifest);

  // BUILD ASHIVA MODULE COMPONENTS ARRAY  
  $ashivaModuleComponents = explode(',', $ashivaModuleManifest);
  array_pop($ashivaModuleComponents);

  return $ashivaModuleComponents;
}
```
