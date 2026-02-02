<html>
    <style>
     
*, *:before, *:after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

html, body {
  height: 100vh;
}



h1 {
  padding: 10px 0;
  font-weight: 400;
  text-align: center;
}

p {
  margin: 0 0 20px;
  line-height: 1.5;
}
section1 {
  display: none;
  padding: 20px 0 0;
  border-top: 1px solid #ddd;
}
main {
  min-width: 1000px;
  max-width: 1500px;
  padding: 10px;
  margin: 0 auto;
  background: #fff;
}
 #table-scroll {
  
    overflow-x: scroll; 
    overflow-y: visible;
    width: 1200px;
    height: 1000px;
    
    
  margin-top:20px;
  
}


input {
  display: none;
}

label {
  display: inline-block;
  margin: 0 0 -1px;
  padding: 15px 25px;
  font-weight: 600;
  text-align: center;
  color: #170f0f;
  border: 1px solid transparent;
}

label:before {
  font-family: fontawesome;
  font-weight: normal;
  margin-right: 10px;
}
label[for*='1']:before { content: '\f1da'; }
label[for*='2']:before { content: '\f09d'; }
label[for*='3']:before { content: '\f1c0'; }
label[for*='4']:before { content: '\f1ec'; }
label[for*='5']:before { content: '\f080'; }
label[for*='6']:before { content: '\f080'; }

.head:hover {
  color: #888;
  cursor: pointer;
  background-color: #f3187d;
  color:white;
}

input:checked + label {
  color: #555;
  border: 1px solid #ddd;
  border-top: 2px solid orange;
  border-bottom: 1px solid #fff;
  
   background-color: pink;
  color:white;
}

#tab1:checked ~ #content1,
#tab2:checked ~ #content2,
#tab3:checked ~ #content3,
#tab4:checked ~ #content4,
#tab5:checked ~ #content5,
#tab6:checked ~ #content6{
  display: block;
}

@media screen and (max-width: 650px) {
  label {
    font-size: 0;
  }
  label:before {
    margin: 0;
    font-size: 18px;
  }
}

@media screen and (max-width: 400px) {
  label {
    padding: 15px;
  }
}
h1 {
    text-transform: uppercase;
}
        </style>
        <div>
	<div> 
            </div>
    <body>
        <div class="sbox-content form-horizontal"> 
             <input type="text" name="machine_id" class="machine_id" value="{{$department_id}}">
    <input type="text" name="year" class="year" value="{{$year}}">
        <h1> {{ $department_name}} REPORT</h1>

<main>
   
    <input id="tab1" type="radio" name="tabs">
    <label class="head" for="tab1" >Maintenance PPT</label>
    
  <input id="tab2" type="radio" name="tabs">
  <label class="head" for="tab2">Maintenance</label>
    
  <input id="tab3" type="radio" name="tabs">
  <label class="head" for="tab3">Consolidation Sheet</label>
    
  <input id="tab4" type="radio" name="tabs">
  <label class="head" for="tab4">BD Wire</label>
  
  <input id="tab5" type="radio" name="tabs">
  <label class="head" for="tab5">MTTR</label>
  
  <input id="tab6" type="radio" name="tabs">
  <label class="head" for="tab6">MTBF</label>
    
  <section1 id="content1">
   
  </section1>
    
  <section1 id="content2">
    
  </section1>
    
  <section1 id="content3">
    
  </section1>
    
  <section1 id="content4">
    
  </section1>
  
  <section1 id="content5">
    
  </section1>
  
  <section1 id="content6">
    
  </section1>
    
</main>
        </div>
        </body>
        </div>
</html>
<script>
   $(document).ready(function() {
   
 $('#tab1').change(function(){
             var department_id=<?php echo $department_id; ?>;
            var year=<?php echo $year; ?>;
            $.get('consolidationsheetreport/'+department_id+'/'+year+'/maintainanceppt',function(data){
             $("#content1").html(data);
         });
      });
      $('#tab2').change(function(){
             var department_id=<?php echo $department_id; ?>;
            var year=<?php echo $year; ?>;
            
         //$.get('consolidationsheet/maintainance/'+department_id+'/'+year,function(data){
         $.get('consolidationsheetreport/'+department_id+'/'+year+'/maintainance',function(data){
           
             $("#content2").html(data);
         });
      });
      $('#tab3').change(function(){
             var department_id=<?php echo $department_id; ?>;
            var year=<?php echo $year; ?>;
            
         $.get('consolidationsheetreport/'+department_id+'/'+year+'/consolidation',function(data){
           
             $("#content3").html(data);
         });
      });
      $('#tab4').change(function(){
              var department_id=<?php echo $department_id; ?>;
            var year=<?php echo $year; ?>;
         $.get('consolidationsheetreport/'+department_id+'/'+year+'/bdwire',function(data){
           
             $("#content4").html(data);
         });
      });
      $('#tab5').change(function(){
            var department_id=<?php echo $department_id; ?>;
            var year=<?php echo $year; ?>;
         //$.get('consolidationsheet/maintainanceppt/'+department_id+'/'+year+'/mttr',function(data){
            $.get('consolidationsheetreport/'+department_id+'/'+year+'/mttr',function(data){
             $("#content5").html(data);
         });
      });
       $('#tab6').change(function(){
            var department_id=<?php echo $department_id; ?>;
            var year=<?php echo $year; ?>;
        // $.get('consolidationsheet/maintainanceppt/'+department_id+'/'+year+'/mtbf',function(data){
             $.get('consolidationsheetreport/'+department_id+'/'+year+'/mtbf',function(data){
             $("#content6").html(data);
         });
      });
      $("#tab1").trigger('click') ;  
      });
</script>