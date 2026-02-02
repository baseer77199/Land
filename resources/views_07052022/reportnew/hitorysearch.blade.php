
<style>
    h5{
         text-align: center;;
         font-weight: bold;


    }
   #table-scroll {



   margin-top:20px;


}
.table {



  margin-top:20px;
}
.tick{
    color:green;
}
.view_print{
        background-color: #fff;
        text-align: center;
        margin:0px;
        padding:5px;
        border:1px solid #ccc;
        font-size:20px;
        line-height:24px;
        font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color:#555;
    }
.position{
      text-align: center;
    }
.printTable{
  display: none;
}
.display{
  display: none;
}

@media print {

 .m-header,.heads,.form-group.row,.search{
    display: none;
  }
  div.overflow{
    width: 100% !important;
    overflow-x: unset !important;
  }
  #table-scroll{
    width: 100%;
    margin:0mm;
    font-size: 13px !important;
    font-weight: bolder !important;
   border:1px solid !important;
  }
  .sbox{
    width: 100%;
  }
  .overflow{
    overflow-x: hidden !important;
  }
  .notPrint{
    display: none !important;
  }
  .printTable{
    display: unset !important;
  }
  .display{
  display: table-row;
  border:none;
}
.table>caption+thead>tr:first-child>td, .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th{
  border:1px solid #ffff !important;
  border-bottom: 1px solid #ddd !important;
}
.table>thead>tr:nth-child(1)>th{

}
#scroll,.scroll-top{
  display: none !important;
 }

}
.table>thead{
  color: #fff;
  background: #05234e;
}
</style>
<div class="sbox">
 
 <div class="sbox-title">
     
        <div class="row position">
            <div class="col-md-2 notPrint"><img src="{{asset('images/logo.jpg')}}" class="img-responsive"></div>
           <div class="col-md-8 notPrint">
              <h4>History Card
              <br>
                For the Period From {{$start_date}} To {{$end_date}}

            </h4>
           </div>
           <div class="col-md-2 notPrint">
               <p class="fm10">Machine Name : {{$machine_name}}</p>
       
           </div>
            </div>        
            </div>

 <div class="sbox-content">
<div class="table">
  
<div class="row">
<div class="col-lg-12 col-md-12" >
  <div class="overflow" style="overflow-x:auto;">
<table class="table table-bordered" id="table-scroll" style="width:100%;">


<thead>

<tr class="display">
                     <th colspan="4"><img src="{{asset('images/logo.jpg')}}" class="img-responsive"></th>
                     <th colspan="4"><center>History Card
              <br>
                For the Period From {{$start_date}} To {{$end_date}}</center></th>
                     <th colspan="1"><center>Machine Name : {{$machine_name}}</center>
                       
                     </th>
                   </tr>
                      <tr>
                          
                          <th >S.no</th>
                          <th >Slip No</th>
                          <th >Date</th>
                          <th >Shift</th>
                          <th >Action Taken</th>
                          <th >Time Taken(HH:MM)</th>
                          <th >Availability in P/M</th>
                          <th >Frequency in the Month</th>
                          <th >Remarks</th>
                          <th >Causes</th>
                          </tr>
                      

                  </thead>

                  <tbody >
                        
                         <?php $i=1; foreach($data as $key=>$value) {  ?>
                      <tr>
                             <td>{{$i}}</td>      
 <td>{{$value->ticket_number}}</td>
 <td>{{$value->issue_date}}</td>
 <td>{{$value->shift}}</td>
 <td>{{$value->corrective_action}}</td>
 <td>{{$value->time_diff}}</td>
 <td></td>
 <td></td>
 <td>{{$value->remarks}}</td>
 <td>{{$value->causes}}</td>
         </tr>
                    <?php $i++; }?>
                     

                    </tbody>
              </table>
            </div>
</div>
</div>

</div>
</div>
</div>
<script>
 
</script>
