<?php

if(!function_exists('dt'))
{
  function dt($date)
  {
    $d = new DateTime($date);
    return $d->format('d/m/Y');
  }
}

//18/11/2020
//2020-11-18

if(!function_exists('dbd'))
{
  function dbd($date)
  {
    if(strlen($date) == 10 && strpos($date, "/")){
      
      $d = new DateTime(str_replace("/","-","$date"));
      return $d->format('Y-m-d');
    }
    else{
      return $date;
    }
  }
}