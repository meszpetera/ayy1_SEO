<?php
class Template
{
  private $file;
  private $variables = array();
  public $loaded = false;

  public function assign_var_array($names)
  {
    foreach($names as $name => $value){
      if(!isset($this->variables[$name]))
        $this->variables[$name] = $value;
    }
  }
  
  public function assign_var($name, $value)
  {
    if(!isset($this->variables[$name]))
      $this->variables[$name] = $value;
  }
  
  public function get_compiled()
  {
    return $this->file;
  }
  
  public function compile($filename)
  {
    if(!($this->file = file_get_contents($filename)))
      return false;
      
    foreach($this->variables as $name => $value){
        if(!is_array($value) && !is_bool($value)){
          $this->file = str_replace("{\$$name}",$value,$this->file);
        }
        else if(is_bool($value))
        {
          if(!$value)
          {
            // exit('/\\{\\$'.$name.' IF\\}[\\w\\s]*\\{\\$'.$name.' ENDIF\\}/');
            $result = "";
      //     echo $this->variables['BASKETLINKS'];
     //    echo preg_match_all('%\\{\\$SHOW_BASKET IF\\}[-\\]<>&@{}!"=/$#;:()[,.\\w\\s]*\\{\\$SHOW_BASKET ENDIF\\}%', $this->file, $result, PREG_SET_ORDER);
      //      exit();
    // echo preg_match('%\\A\\{\\$SHOW_BASKET IF\\}[-\\]<>&@{}!"=/$#;:()[,.\\w\\s]*\\{\\$SHOW_BASKET ENDIF\\}\\z%', $this->file);
  //   exit();
            $this->file = mb_eregi_replace  ( '\\{\\$SHOW_BASKET IF\\}[-\\]<>&@{}!"=/$#;:()[,_*\\w\\s]*\\{\\$SHOW_BASKET ENDIF\\}' , ""  , $this->file  );
          }
        }
      }
    $this->file = preg_replace('/\\{\\$[\\w\\s]*\\}/', "", $this->file);
    return $this->file;
  }
  
  public function display()
  {
    $this->compile();
    print $this->file;
  }
}
?>