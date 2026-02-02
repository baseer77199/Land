@extends('layouts.header')

@section('content')

<style type="text/css">
  body {

    font-family: 'Open Sans','Helvetica Neue',Helvetica,Arial,sans-serif;
    font-size: 12px;
    font-weight: normal;
    color: #595e62;
    -moz-osx-font-smoothing: grayscale;
  }
  .card{
    background:#fff;
    margin-bottom: 5px !important;
  }

  select {
    -webkit-appearance: none;
    -moz-appearance: none;
    -ms-appearance: none;
    appearance: none;
    outline: 0;
    box-shadow: none;
    border: 0 !important;
    background: #2c3e50;
    background-image: none;
  }
  /* Remove IE arrow */
  select::-ms-expand {
    display: none;
  }
  /* Custom Select */
  .select {
    position: relative;
    left: 4px;
    display: flex;
    width: 20em;
    /* height: 3em;*/
    line-height:2.4;
    background: #2c3e50;
    overflow: hidden;
    border-radius: .25em;
  }
  select {
    flex: 1;
    padding: 0 .5em;
    color: #fff;
    cursor: pointer;
  }
  /* Arrow */
  .select::after {
    content: '\25BC';
    position: absolute;
    top: 0;
    right: 0;
    padding: 0 1em;
    background: #34495e;
    cursor: pointer;
    pointer-events: none;
    -webkit-transition: .25s all ease;
    -o-transition: .25s all ease;
    transition: .25s all ease;
  }
  /* Transition */
  .select:hover::after {
    color: #f39c12;
  }
  #production ,#purchase{
    display: none;
  }
  .table-responsive {
    min-height: .01%;
    overflow-x: auto;
  }
  .dashboard {
   margin: 5px;
   background-color: #fff;
   border: solid 1px #ddd;
   width: 100%;
   
 }
 .dashboard1{
  margin: unset;
  background-color: #fff;
  border: solid 1px #ddd;

  min-height: 500px;
  max-height: 500px;
}
h2 {
  font-size: 19px;
  font-weight: 200;
  color: #000000;
  text-align: center;

}
hr{
  margin-bottom: 0;
  margin-top: 0;
}
.fa {
  display: inline-block;
  font: normal normal normal 14px/1 FontAwesome;
  font-size: inherit;
  text-rendering: auto;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  transform: translate(0,0);
}



</style>

<link rel="stylesheet" type="text/css" href="{{asset('css/datatable.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('js/fullcalendar.css')}}">

<!--<link rel="stylesheet" type="text/css" href="http://ifiveapps.com/modine/public/css/fullcalendar.css">-->




@endsection
