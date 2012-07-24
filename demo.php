<?php

include "htmlforms.php";

//assign form attributes with $useValidation set to true.

$form = new HtmlForms(array('name'=>'contact','method'=>'post','id'=>'contact','action'=>'contact.php'),true);

//open form tag.
$form->start();

//creates a hidden input. label set to null.
$form->createInput(null,array(
	//attributes as array
    'name'=>'Send_contact',
    'id'=>'Send_contact',
    'type'=>'hidden',
    'value'=>'yes'
    
    ));

	 //create a text input with validation.
$form->createInput('Enter your Email',array(
    'name'=>'email',
    'id'=>'email',
    'type'=>'text',
    'title'=>'Enter your Email'
    
    ),array(
		//validation as array

        'required'=>'true',
        'email'=>'true'
    ) );

	 //create a password input with validation.
$form->createInput('Enter your password',array(
    'name'=>'password',
    'id'=>'password',
    'type'=>'password',
    'title'=>'Enter your password'
    
    ),array(
        'required'=>'true',
        'minlength'=>'6'
    ) );

	//create a checkbox input without validation.
$form->createInput('Select Gender',array(
    'name'=>'Gender',
    'id'=>'Gender',
    'type'=>'checkbox',
    'title'=>'Enter your Gender'
    
    ) );
	
	
	//creates a textarea with validation.

$form->createTextarea('Enter your message',array(
    'name'=>'message',
    'id'=>'message',
    'title'=>'Enter your message',
    
    
    ),array(
        'required'=>'false',
        'maxlength'=>'200'
    ) );

	// create a select option.
$form->createSelect('Select type',array(
    'name'=>'type',
    'id'=>'type',
    'title'=>'Select type'
    
    ),array(
        'required'=>'true'
    ),array(
	//options as array
        'Select Type...'=>array('value'=>""),
        'Free'=>array('value'=>'free'),
        'Premium'=>array('value'=>'premium')
        
    ) );

// customize form buttons:
  $form->renameButtons('send','clear');

 //close form tag.
$form->end();




?>
