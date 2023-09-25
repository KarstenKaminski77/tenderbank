<?php
// own pdf structure 

class  MYPDF  extends  FPDF 
{ 
   // Margins 
   var  $ left  =  10 ; 
   var  $ right  =  10 ; 
   var  $ top  =  10 ; 
   var  $ bottom  =  10 , 
         
   // Create Table 
   function  OverwriteTable ( $ tcolums ) 
   { 
      // go through all colums 
      for ( $ i  =  0 ,  $ i  <  sizeof ( $ tcolums )  $ i + +) 
      { 
         $ current_col  =  $ tcolums [ $ i ], 
         $ height  =  0 , 
         
         // get max height of current col 
         $ nb = 0 , 
         for ( $ b  =  0 ,  $ b  <  sizeof ( $ current_col )  $ b + +) 
         { 
            // set 
         
         Issue a page break first if needed 
         $ this -> Check Page Break ( $ h ) 
         
         // Draw the cells of the 
            
            Save the current position 
            $ x = $ this -> GetX (); 
            $ y = $ this -> GetY (), 
            
            // set 

if ( substr_count ( $ current_col [ $ b ] [ 'line area' ],  'T' )>  0 ) 
            { 
               $ this -> Line ( $ x ,  $ y ,  $ x + $ w ,  $ y ); 
            }                         if ( 
            
substr_count ( $ current_col [ $ b ] [ 'line area' ],  "B" )>  0 ) 
            { 
               $ this -> Line ( $ x ,  $ y + $ h ,  $ x + $ w ,  $ y + $ h ); 
            }                         if ( 
            
substr_count ( $ current_col [ $ b ] [ 'line area' ],  'L' )>  0 ) 
            { 
               $ this -> Line ( $ x ,  $ y ,  $ x ,  $ y + $ h ); 
            }             if ( 
                        
substr_count ( $ current_col [ $ b ] [ 'line area' ],  "R" )>  0 ) 
            { 
               $ this -> Line ( $ x + $ w ,  $ y ,  $ x + $ w ,  $ y + $ h ); 
            } 
            
            
            // Print the text 
            $ this -> Multi-Cell ( $ w ,  $ current_col [ $ b ] [ 'height' ],  $ current_col [ $ b ] [ 'text' ],  0 ,  $ a ,  0 ) 
            
            // Put the position to the right of the cell 
            $ this -> SetXY ( $ x + $ w ,  $ y );          
         } 
         
         // Go to the next line 
         $ this -> Ln ( $ h );           
      }                   
   } 
   
   // If the height h would cause to overflow, add a new page 
   
   ?>
