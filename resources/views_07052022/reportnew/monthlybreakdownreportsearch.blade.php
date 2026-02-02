
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
#scroll{
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
              <h4>Monthly Report on Breakdowns(Machine Wise)
              <br>
                For the Period From {{$start_date}} To {{$end_date}}

            </h4>
           </div>
           <div class="col-md-2 notPrint">
               <p class="fm10">Date : 07/10/2019</p>
        <p class="f10">Page :1</p>
           </div>
            </div>
</div>
 <div class="sbox-content">
<div class="table" >
  
<div class="row">
<div class="col-lg-12 col-md-12" >
  <div class="overflow" style="overflow-x:auto;">
<table class="table table-bordered" id="table-scroll" style="width: 100%;">
<thead>
                   <tr class="display">
                     <th colspan="5"><img src="{{asset('images/logo.jpg')}}" class="img-responsive"></th>
                     <th colspan="7">Monthly Report on Breakdowns(Machine Wise)
              <br>
                For the Period From {{$start_date}} To {{$end_date}}</th>
                     <th colspan="5">Date : 07/10/2019<br>
                       
                     </th>
                   </tr>

                      <tr>
                          
                          <th rowspan="3">Group Name</th>
                          <th rowspan="3">AVLB. HOURS</th>
                          <?php foreach($data_break as $k=>$v) { ?>
                          <th colspan="3"  ><?php echo $v->breakdown_name; ?><br>   HH:MM  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Freq&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;%</th>
                              <?php }?>
                          <th colspan="3" >OVER ALL TOTAL <br>
                               HH:MM  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Freq&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;%
                          </th>
                          </tr>
                      

                  </thead>

                  <tbody >
                    <?php $i=1; foreach($data_department as $key=>$value) { $kk=0;?>

                        <?php
                        foreach($data as $k=>$v) {
                         
                     if($v->department_id==$value->department_id){ if($kk==0){ $kk=1;?>
                                              <tr>
                                   <td>
Department : <b class="tobold">{{$value->department_name }}<b>
                                   </td>
                     </tr><?php } ?>
               <tr>
                   <td>{{$v->machine}}</td>
                    <td>{{$v->total_hrs}}</td>
                   <?php  foreach($data_break as $k1=>$v1) {  $freq="freq".$v1->breakdowntype_id; $id="typesum".$v1->breakdowntype_id;  $id1="percent".$v1->breakdowntype_id;?>
                     
                      <td>{{$v->$id}}</td>
                      <td>{{$v->$freq}}</td>
                       <td>{{$v->$id1}}</td>
                   <?php } ?>
 <td>{{$v->total}}</td>
 <td>{{$v->total_freq}}</td>
 <td>{{$v->percenttotal}}</td>
               </tr>

                    <?php  } } }?>
                          
            <tr>
                <th colspan='7'>ELECTRICITY CONSUMPTION  ( UNITS )		</th>
                <th colspan='3'>E.B.		</th>
                <th colspan='5'> </th>
                <th colspan='5'>D.G.	</th>
                <th colspan='3'> </th>
            </tr>    
                <?php      ?>
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
