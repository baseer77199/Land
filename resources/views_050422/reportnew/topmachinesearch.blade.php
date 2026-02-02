
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
              <h4>TOP 5 BREAKDOWN
              <br>
                For the Period From {{$start_date}} To {{$end_date}}

            </h4>
           </div>
           <div class="col-md-2 notPrint">
               <p class="fm10">MACHINE WISE</p>
       
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
                     <th><img src="{{asset('images/logo.jpg')}}" class="img-responsive"></th>
                     <th ><center>TOP 5 BREAKDOWN
              <br>
                For the Period From {{$start_date}} To {{$end_date}}</center></th>
                <th>&nbsp;</th>
                     <th >MACHINE WISE<br>
                       
                     </th>
                   </tr>
    <tr><th>MACHINE NAME</th>
<th>DEPARTMENT</th>
<th>No. OF BDS</th>
<th>DOWNTIME(Hrs.)</th>
    </tr>
    </thead>
   
                                        
                                            <?php foreach($data as $k=>$v) { ?>
         <tr>
                                        <td>{{$v->machine}}</td> 
                                        <td>{{$v->dept }} </td>
                                        <td>{{$v->bids }}</td>
                                        <td>{{$v->time_diff }}</td>
   </tr>
                                            <?php } ?>

                                     
  

              </table>
            </div>
</div>
</div>

</div>
</div>
</div>
<script>
 
</script>
