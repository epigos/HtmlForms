<?php

/**
 *HtmlForms Object
 
 *  A singleton PHP object which provides convenience and fast methods for creating HTMl forms with validations. 
 *  It uses jquery validation plugins to validate forms.
 * 
 * <b>Getting Started</b>
 *  <code>
 *  include "filesystem.php";
 *  $file = FileSystem::getInstance();
 *  $fileExt=$file ->getExtension("foobar.txt");
 *  echo $fileExt; // txt
 * 
 *  </code>
 *
 *  @package    HtmlForms
 *  @author     Philip Adzanoukpe <info@philipcodings.com * @url http://philipcodings.com>
 *  @copyright  (c) 2012 - Philip Adzanoukpe
 *  @version    1.0
 *  @license 	Free to use and modify as you choose. Please give credits.
 */


Class HtmlForms{
    
  /* vars */
  private $inputAttr;
  private $formStart;
  private $formAttr;
  private $elementStart;
  private $useValidation;
  private $valAttr;
  private $formID;
  private $submit;
  private $reset;
  
     /**
     *  Constructor
     *  Private constructor as part of the singleton pattern implementation.
     *  Gets the singleton instance for this object. This method should be called statically in order to use the HtmlForms object.
     *<code>
      * include "htmlforms.php";
      *
      * $form = new HtmlForms(array(
      * 'name'=>'contact',
      * 'method'=>'post',
      * 'id'=>'contact',
      * 'action'=>'contact.php'
      * ));
      * 
      * </code>
      * @access Public
      * @param Array $attributes as form attributes
      * @param bool $useValidation if true it uses the default validation.
      * 
      *
     */
    public function __construct($attributes=array(),$useValidation=true) {
        $this->useValidation = $useValidation;
        $this->formAttr = $attributes;
        
        $this->formStart ='<form';
        
        if(count($this->formAttr))
        {
            foreach($this->formAttr as $key=>$value)
            {
             $this->formStart.= ' '.$key.'="'.$value.'"';
             if ($key =='id' || $key =='ID'){
                 $this->formID = $value;
             }
            }
        }
        
        $this->formStart.='>';
        
    }

 
     
    /** 
     * Adds jquery validation plugins to the form if $useValidation is true.
     * 
     * @access Private
     * @return string
     */
    
    private function addJS(){
        $js ="<script type='text/javascript' src='libs/js/jquery.min.js' ></script>";
        $js .="<script type='text/javascript' src='libs/js/jquery.metadata.js' ></script>";
        $js .="<script type='text/javascript' src='libs/js/jquery.validate.js' ></script>";
        
        return $js;
    }
    
    /**
     * Adds css to the forms.
     * 
     * @access Private
     * @return string
     * 
     */
   private function addCSS(){
        $css ="<link href='libs/css/validate.css' rel='stylesheet' type='text/css'>";
        
        return $css;
    }
    
    
    
    /**
     * Adds jquery validation script and error container to the form if $useValidation is true.
     * 
     * @access private
     * @return string
     * 
     */
    
    private function validate(){
        $validation = <<<_EOT
           <script type='text/javascript' >
            $().ready(function() {
		var container = $('div.error_container');
                // validate the form when it is submitted
                var validator = $("#$this->formID").validate({
		errorContainer: container,
		errorLabelContainer: $("ol", container),
		wrapper: 'li',
		meta: "validate"
                });
            $("#reset").click(function() {
		validator.resetForm();
            });
	
            });
             </script>
            <div class="error_container">				
            <h5>There are errors in your form submission, check below for details</h5>
            <ol>
		
            </ol>
            </div>
_EOT;
        
        return $validation;
    }
    
    
    /**
     * Adds submit and reset buttons to forms.
     * 
     * <code>
     * 
     * $form->renameButtons("Send", "Clear");
     * 
     * </code>
     * 
     * @access Public
     * @param string $submit name or value of submit button.
     * @param string $reset name or value of reset button.
     * @return string
     * 
     */
    
    public function renameButtons($submit='Submit',$reset='Clear'){
        if ($submit !=''){$this->submit= $submit;} 
        if($reset !=''){$this->reset = $reset;} 
        else{$this->submit = "Submit"; $this->reset = "Clear";}
        
        
        return " <p><input type='submit' name='$this->submit' value='$this->submit' id='$this->submit' class='button'>
   <input type='reset' name='$this->reset' value='$this->reset' id='reset' class='button' >
   
</p>";
        
    }


    /**
     * Adds input form element (like text,password,hidden,radio,checkbox) to the form.
     * <code>
     * Input with validation:
     * 
     * $form->createInput('Enter your Email',array(
     *      'name'=>'email',
     *      'id'=>'email',
     *      'type'=>'text',
     *      'title'=>'Enter your Email'
     *   ),array(
     *      'required'=>'true',
     *      'email'=>'true'
     *  ) 
     * );
     * Input without validation:
     * 
     * $form->createInput('Enter your Email',array(
     *      'name'=>'email',
     *      'id'=>'email',
     *      'type'=>'text',
     *      'title'=>'Enter your Email'
     *   )
     * );
     * </code>
     * 
     * @access Public
     * @param string $label label for the input element.
     * @param Array $attributes attributes of the input such as id,name,type,title.
     * @param Array $validate jquery validation such as required,email,number,minlength.
     * @return string
     * 
     */
   
    public function createInput($label="",$attributes=array(),$validate=array())
    {
        
        $type='input';
        $this->inputAttr = $attributes;
        $this->elementStart ='<p>';
        if ($label !=''){
            $this->elementStart .= "<label>$label </label>";
        }
        
        $this->elementStart .='<'.$type;
        
        if(count($this->inputAttr))
        {
            foreach($this->inputAttr as $key=>$value)
            {
             $this->elementStart.= ' '.$key.'="'.$value.'"';
            }
        }
        
        if ($this->useValidation==true){
            $this->valAttr = $validate;
            
            if(count($this->valAttr))
            {
             $val ='';
            foreach($this->valAttr as $key=>$value)
            {
               
               $sep=',';
                       
             $val .= $key.':'.$value.$sep;
            }
            $this->elementStart.="class={validate:{".$val."}}";
            }
            
        }
        
        
        $this->elementStart.='>'."</p>";
        
        echo $this->elementStart;
    } 
    
    /**
     * Adds a textarea to the form.
     * <code>
     * 
     * $form->createTextarea('Enter your message',array(
     *      'name'=>'message',
     *      'id'=>'message',
     *      'title'=>'Enter your message',
     *      'value'=>'Type your message here...'
     * 
     *     ),array(
     *      'required'=>'false',
     *      'maxlength'=>'200'
     *    )
     *  );
     * </code>
     * 
     * @access Public
     * @param string $label label for the textarea element.
     * @param Array $attributes attributes of the input such as id,name,type,value,title.
     * @param Array $validate jquery validation such as required,email,number,minlength.
     * @return string
     * 
     */
   
   
    public function createTextarea($label="",$attributes=array(),$validate=array())
    {
        
        $type='textarea';
        $defaultValue='';
        $this->inputAttr = $attributes;
        $this->elementStart ='<p>';
        if ($label !=''){
            $this->elementStart .= "<label>$label </label>";
        }
        $this->elementStart .='<'.$type;
        
        if(count($this->inputAttr))
        {
            foreach($this->inputAttr as $key=>$value)
            {
                if (strtolower($key)=='value'){
                 $val='';
                 $defaultValue=$value;
             }
             else{   
             $this->elementStart.= ' '.$key.'="'.$value.'"';
            }}
        }
        
        if ($this->useValidation==true){
            $this->valAttr = $validate;
            
            if(count($this->valAttr))
            {
             $val ='';
            foreach($this->valAttr as $key=>$value)
            {
               
               $sep=',';
                    
             $val .= $key.':'.$value.$sep;
             
            }
            $this->elementStart.="class={validate:{".$val."}}";
            }
            
        }
        
        
        $this->elementStart.='>'.$defaultValue."</textarea></p>";
        
        echo $this->elementStart;
    } 
    
    
    /**
     * Adds a select input to the form.
     * <code>
     * 
     * $form->createSelect('Select message type',array(
     *      'name'=>'type',
     *      'id'=>'type',
     *      'title'=>'Select message type',
     *      
     *     ),array(
     *      'required'=>'true',
     *      
     *    ),array(
     *          'Select Message Type...'=>array('value'=>""),
     *          'Free'=>array('value'=>'free'),
     *          'Premium'=>array('value'=>'premium')
     *    )
     *  );
     * </code>
     * 
     * @access Public
     * @param string $label label for the textarea element.
     * @param Array $attributes attributes of the input such as id,name,type,value,title.
     * @param Array $validate jquery validation such as required,email,number,minlength.
     * @param Array $options select options
     * @return string
     * 
     */
   
    public function createSelect($label="",$attributes=array(),$validate=array(),$options=array())
    {
        
        $type='select';
        $this->inputAttr = $attributes;
        $this->elementStart ='<p>';
        if ($label !=''){
            $this->elementStart .= "<label>$label </label>";
        }
        $this->elementStart .='<'.$type;
        
        if(count($this->inputAttr))
        {
            foreach($this->inputAttr as $key=>$value)
            {
             $this->elementStart.= ' '.$key.'="'.$value.'"';
            }
        }
        
        if ($this->useValidation==true){
            $this->valAttr = $validate;
            
            if(count($this->valAttr))
            {
             $val ='';
            foreach($this->valAttr as $key=>$value)
            {
               
               $sep=',';
                       
             $val .= $key.':'.$value.$sep;
            }
            $this->elementStart.="class={validate:{".$val."}}";
            }
            
        }
        $this->elementStart .='>';
        if (is_array($options)){
           
            while (list($key1) = each($options)){
                $this->elementStart .="<option ";
                while (list ($key2,$val2) = each ($options["$key1"])){
                    $va =" $key2='$val2'";
                   
                }
                $this->elementStart .=" $va >$key1</option>";
            }
        }
        
        
        $this->elementStart.="</select></p>";
        
        echo $this->elementStart;
    } 
    
    /**
     * Start processing of form
     * 
     * 
     * @access Private
     * @return string
     *  
     *
     */
    
  private function startForm()
  {
      
    //start
    $build = "<div id='form' class=' $this->formID '>";
    $build .=$this->addCSS();
     if ($this->useValidation==true){
    
    $build .=$this->addJS();
    $build .=$this->validate();
     }
    $build .= $this->formStart;
    
   
    //return it
    return $build;
  }
  
  /**
     * End processing of form
     * 
     * 
     * @access Private
     * @return string
     *  
     *
     */
  private function endForm()
  {
     
    $build =$this->renameButtons($this->submit,$this->reset);
    $build .= "</div>";
   
    //return it
    return $build;
  }
  
  
 /**
     * Starts the Outputs of the processed form 
     * It should be called immediately after instantiating the HtmlForms object to open the form tag. 
     * All your form elements must then come after this.
     *<code> 
     * $form = new HtmlForms(array('name'=>'contact','method'=>'post','id'=>'contact','action'=>'contact.php'),true);
     * 
     * $form->start();
     * 
     * </code>
     * @access Public
     * @return string
     *  
     *
     */
  public function start()
  {
      
    echo $this->startForm();
  }
  
  /**
     * Ends the Outputs of the processed form 
     * It should be called immediately after all your form elements to close the form tag.
     *<code> 
     * 
     * $form->end();
     * 
     * </code>
     * @access Public
     * @return string
     *  
     *
     */
  
    public function end()
  {
      
    echo $this->endForm();
  }
    
    
    
    
    
    
    
}


?>
