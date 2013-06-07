CSRFWork
==========

A simple way of protecting forms regarding to CSRF


Installation:
-------------

* Place the csrf.php file into your application folder
* Include it
```include_once 'csrf.php'; ```
* and initate it: ```CSRF::init();```    


HowTo
---------

There are 2 methods available for you to interact with your cache.

*  ```token()```
*  ```check($token)```



TOKEN
-----


	token()

This method will return the token for the current and next request.

**Example usage:**

    <input type="hidden" value="<?php echo CSRF::token(); ?>" name="csrf_token" />
    

This will add a hidden input field to you form with the name ```csrf_token``` and the value is the token itself. How we can use we' ll see in the ```check()``` part.


CHECK
-----

	check($token)

This method will check if a string matches the token generated in the **previous** request.

* ```$token```: string: the string to check

**Example usage:**

    if (CSRF::check($_POST['csrf_token'])) {   
        // Everything' s fine   
    } else {   
        // The post request was not submited by the form on your site.   
        die('DIE STUPID ATTACKER'); //Take 'em down...   
    }   



You can always have a look at the PHP doc for a brief explanation.