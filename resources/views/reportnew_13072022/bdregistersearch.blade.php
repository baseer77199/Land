
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

 .m-header,.heads,.form-group.row,.footer,.search{
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
#scroll,.scroll-top.tran3s{
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
           <div class="col-md-8 notPrint text-center">
              <h4>BREAKDOWN REPORT REGISTER
              <br>
                For the Period From {{$start_date}} To {{$end_date}}

            </h4>
           </div>
           <div class="col-md-2 notPrint">
               <p class="fm10">Date : 07/10/2019</p>
        
           </div>
            </div>
     
     
     
     
     
     
          
            </div>

 <div class="sbox-content">
<div class="table">
  
<div class="row">
<div class="col-lg-12 col-md-12" >
  <div class="overflow" style="overflow-x:auto;">
<table class="table table-bordered" id="table-scroll" >


<thead>
<tr class="display">
                     <th colspan="3"><img src="{{asset('images/logo.jpg')}}" class="img-responsive"></th>
                     <th colspan="6"><center>BREAKDOWN REPORT REGISTER
                 <br>
                For the Period From {{$start_date}} To {{$end_date}}</center></th>
                     <th colspan="1">Date : 07/10/2019<br>
                       
                     </th>
                   </tr>


                      <tr>
                          
                          <th >S.no</th>
                          <th >Ticket No - Date - Shift</th>
                          <th >Machine Name</th>
                          <th >Category/BD Type</th>
                          <th >Breakdown Details</th>
                          <th >BD Raised On / Department / Raised By</th>
                          <th >Action Taken</th>
                          <th >Attended By PMD(PS NO) <br>Time Taken(HH/MM)</th>
                          <th >BD Completion Acknowledged On -Action By</th>
                          <th >Completion Status</th>
                          </tr>
                      

                  </thead>

                  <tbody >
                        
                         <?php $i=1; foreach($data as $key=>$value) {  ?>
                      <tr>
                             <td>{{$i}}</td>      
 <td>{{$value->slip_no}}</td>
 <td>{{$value->machine}}</td>
 <td>{{$value->br_type}}</td>
 <td>{{$value->bd_detail}}</td>
 <td>{{$value->bd_raised}}</td>
 <td>{{$value->corrective_action}}</td>
 <td>{{$value->action_by}}</td>
 <td>{{$value->complete}}</td>
 <td>{{$value->com_status}}</td>
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
