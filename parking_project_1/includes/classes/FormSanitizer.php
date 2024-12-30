<?php
    class FormSanitizer{
        
        public static function sanitizeFormUsername($inputText){  //static so that no need to make instance to call it
            $sanitizedInput = strip_tags(trim($inputText)); //removes
            // HTML tags and trims whitespace from both sides of the string.
            $sanitizedInput=strtolower($sanitizedInput);
            // $sanitizedInput=ucfirst($sanitizedInput);
            return  $sanitizedInput; 
        }

        public static function sanitizeFormPassword($inputText){  
            $sanitizedInput = strip_tags($inputText); 
            return  $sanitizedInput; 
        }

        public static function sanitizeFormOwnerName($inputText){  
            $sanitizedInput = strip_tags(trim($inputText)); 
            $sanitizedInput=strtolower($sanitizedInput);
            $sanitizedInput=ucwords($sanitizedInput);
            return  $sanitizedInput; 
        }
        public static function sanitizeFormVehicleName($inputText){  
            $sanitizedInput = strip_tags(trim($inputText)); 
            $sanitizedInput=strtolower($sanitizedInput);
            $sanitizedInput=ucfirst($sanitizedInput);
            return  $sanitizedInput; 
        }

        public static function sanitizeFormVehicleNumber($inputText){  
            $sanitizedInput = strip_tags(trim($inputText)); 
            $sanitizedInput=strtoupper($sanitizedInput);
            return  $sanitizedInput; 
        }
        
        public static function sanitizeInt($inputText){  
            $sanitizedInput = strip_tags(trim($inputText)); 
            return  $sanitizedInput; 
        }
    }
?>