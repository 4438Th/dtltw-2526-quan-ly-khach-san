 <header class="pt-2 pb-2">
     <div class="container d-flex justify-content-between align-items-center">
         <div class="logo">
             <a href="/home" class="nav-link">
                 <h1>Khách sạn</h1>
             </a>
         </div>
         <div class="profile">
             <ul
                 class="navbar-nav d-flex flex-row align-items-center justify-content-between">
                 <li class="nav-item me-2"><?php echo $username ?? 'Người dùng'; ?></li>
                 <li class="nav-item me-2">
                     <a href="#"><i class="fa-solid fa-user"></i></a>
                 </li>
             </ul>
         </div>
     </div>
 </header>