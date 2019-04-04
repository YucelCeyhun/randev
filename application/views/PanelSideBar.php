 <nav class="sidebar">
     <div class="sidebar-header mt-5">
         <div class="header-wrapper">
             <a class="d-flex" href="<?php echo base_url('panel');?>"><div class="head-brand" style="width:48px;height:48px;"></div><h4>Randev</h4></a>
            </div>
     </div>
     <ul class="list-unstyled slidebar-nav">
         <li>
             <a href="#appointment" data-toggle="collapse" aria-expanded="<?php echo $menuParent == "appointments" ? "true" : "false" ;?>" class="dropdown-toggle"><i class="fas fa-map-marked mr-3"></i>Randevu İşlemleri</a>
             <ul class="collapse list-unstyled <?php echo $menuParent == "appointments" ? " show" : null ;?>" id="appointment">
                    <li><a href="<?php echo base_url("panel/appointments/create");?>" class="<?php echo $menuChild == "create" && $menuParent == "appointments" ? "active" : null ;?>">Randevu Oluştur Manuel</a></li>
                    <li><a href="<?php echo base_url("panel/appointments/createauto");?>" class="<?php echo $menuChild == "createauto" && $menuParent == "appointments" ? "active" : null ;?>">Randevu Oluştur Otomatik</a></li>
                    <li><a href="<?php echo base_url("panel/appointments/");?>" class="<?php echo $menuChild == "" && $menuParent == "appointments" ? "active" : null ;?>">Randevuları Götüntüle</a></li>
                    <li><a href="<?php echo base_url("panel/appointments/routelist");?>" class="<?php echo $menuChild == "routelist" && $menuParent == "appointments" ? "active" : null ;?>">Randevu Rota Görüntle</a></li>
                    <li><a href="<?php echo base_url("panel/appointments/exlist");?>" class="<?php echo $menuChild == "exlist" && $menuParent == "appointments" ? "active" : null ;?>">Randevu Excel Oluştur</a></li>
             </ul>
         </li>
         <li>
             <a href="#engineer" data-toggle="collapse" aria-expanded="<?php echo $menuParent == "engineers" ? "true" : "false" ;?>" class="dropdown-toggle"><i class="icofont-engineer mr-3"></i>Mühendis İşlemleri</a>
             <ul class="collapse list-unstyled <?php echo $menuParent == "engineers" ? " show" : null ;?>" id="engineer">
                 <li><a href="<?php echo base_url("panel/engineers/create");?>" class="<?php echo $menuChild == "create" && $menuParent == "engineers" ? "active" : null ;?>">Yeni Mühendis Oluştur</a></li>
             </ul>
         </li>
         <li>
             <a href="#company" data-toggle="collapse" aria-expanded="<?php echo $menuParent == "companies" ? "true" : "false" ;?>" class="dropdown-toggle"><i class="fas fa-building mr-3"></i>Firma İşlemleri</a>
             <ul class="collapse list-unstyled <?php echo $menuParent == "companies" ? " show" : null ;?>" id="company">
                 <li><a href="<?php echo base_url("panel/companies/create");?>" class="<?php echo $menuChild == "create" && $menuParent == "companies" ? "active" : null ;?>">Yeni Firma Oluştur</a></li>
             </ul>
         </li>
         <li>
             <a href="#user" data-toggle="collapse" aria-expanded="<?php echo $menuParent == "users" ? "true" : "false" ;?>" class="dropdown-toggle"><i class="fas fa-user-tie mr-3"></i>Randevucu İşlemleri</a>
             <ul class="collapse list-unstyled <?php echo $menuParent == "users" ? " show" : null ;?>" id="user">
                 <li><a href="<?php echo base_url("panel/users/create");?>" class="<?php echo $menuChild == "create" && $menuParent == "users" ? "active" : null ;?>">Yeni Randevucu Oluştur</a></li>
             </ul>
         </li>
         <li>
             <a href="#email" data-toggle="collapse" aria-expanded="<?php echo $menuParent == "email" ? "true" : "false" ;?>" class="dropdown-toggle"><i class="fas fa-envelope-open mr-3"></i>E-mail İşlemleri</a>
             <ul class="collapse list-unstyled <?php echo $menuParent == "email" ? " show" : null ;?>" id="email">
                 <li><a href="<?php echo base_url("panel/email/create");?>" class="<?php echo $menuChild == "create" && $menuParent == "email" ? "active" : null ;?>">Firmaya E-mail Gönder</a></li>
             </ul>
         </li>
     </ul>
 </nav>