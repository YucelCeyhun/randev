 <nav class="sidebar">
     <div class="sidebar-header">
         <h5>Jayhoon Admin Panel</h5>
     </div>
     <ul class="list-unstyled slidebar-nav">
         <li>
             <a href="#appointment" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-map-marked"></i>Randevu İşlemleri</a>
             <ul class="collapse list-unstyled" id="appointment">
                 <li><a href="#">Randevu Girişi</a></li>
                 <li><a href="#">Randevu Düzenle</a></li>
             </ul>
         </li>
         <li>
             <a href="#engineer" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle"><i class="fas fa-map-marked"></i>Mühendis İşlemleri</a>
             <ul class="collapse list-unstyled show" id="engineer">
                 <li><a href="<?php echo base_url("panel/engineers/create");?>">Yeni Mühendis Oluştur</a></li>
                 <li><a href="#">hm2</a></li>
                 <li><a href="#">hm3</a></li>
             </ul>
         </li>
     </ul>
 </nav>