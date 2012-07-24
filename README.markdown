
HtmlForms Object
================
 
  A singleton PHP object which provides convenience and fast methods for creating HTML forms with validations. 
  It uses jquery validation plugins to validate forms.
 
  When you build as many dynamic CMS-like websites as me, you end up having to manipulate single HTML forms attributes with a bunch of logic and  validation issues and the code can start looking ugly.
It's small, easy to use, and produces beautiful code and forms

The class is pretty simple. When you instantiate the class, you feed it the form attributes. Once the form is created, you use start() to open the form tag and use the createInput(), createTextarea(), createSelectvalues() methods to create your form elements and finally use the end() to close the form tag.
You can choose my default jquery validation or use your own validation by setting the $useValidation variable to false.



Basic Example
-------------

You can get the object's instance as this:   
 

    <?php
	
    include "htmlforms.php";

    //assign form attributes with $useValidation set to true

    $form = new HtmlForms(array('name'=>'contact','method'=>'post','id'=>'contact','action'=>'contact.php'),true);

    //open form tag

    $form->start();

    //creates a hidden input.

    $form->createInput(null,array(
    'name'=>'Send_contact',
    'id'=>'Send_contact',
    'type'=>'hidden',
    'value'=>'yes'
    
    ));


    //create an input with validation.

    $form->createInput('Enter your Email',array(
         //attributes as array
    'name'=>'email',
    'id'=>'email',
    'type'=>'text',
    'title'=>'Enter your Email'
    
    ),array(
        //validation as array

        'required'=>'true',
        'email'=>'true'
    ) );
   
   //creates a textarea without validation.

    $form->createTextarea('Enter your message',array(
    'name'=>'message',
    'id'=>'message',
    'title'=>'Enter your message',
    
    ));
    
  // create a select option.
  $form->createSelect('Select type',array(
    'name'=>'type',
    'id'=>'type',
    'title'=>'Select type'
    
    ),array(
        'required'=>'true'
    ),
    array( 
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
	 


Check for detail documentation  @ http://philipcodings.com

License
-------

Copyright (C) 2012 by philipcodings.com

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.