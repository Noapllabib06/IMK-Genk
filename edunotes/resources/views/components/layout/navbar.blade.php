<nav class="navbar navbar-expand-lg navbar-dark py-3 sticky-top"> 
  <div class="container-fluid px-4">
    <a class="navbar-brand fw-bold fs-4" href="#home">EduNOTES</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-lg-5 gap-2 mt-3 mt-lg-0">
        <li class="nav-item">
          <a class="nav-link btn border-0 fw-semibold px-3 text-white text-start" href="#home">HOME</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn border-0 fw-semibold px-3 text-white text-start" href="#about">ABOUT</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn border-0 fw-semibold px-3 text-white text-start" href="#information">INFORMATION</a>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle btn border-0 fw-semibold px-4 text-white d-flex align-items-center justify-content-between" 
             href="#" 
             id="navbarDropdownAccount" 
             role="button" 
             data-bs-toggle="dropdown" 
             aria-expanded="false"
             style="background: rgba(255,255,255,0.05); border-radius: 8px;">
            ACCOUNT
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0 dropdown-menu-dark mt-2 p-2" 
              aria-labelledby="navbarDropdownAccount"
              style="background-color: #1e1e1e; border: 1px solid #333 !important; min-width: 180px;">
            <li>
                <a class="dropdown-item rounded-2 py-2 mb-1" href="/login">
                    <i class="fa-solid fa-right-to-bracket me-2 small text-primary"></i> Login
                </a>
            </li>
            <li>
                <a class="dropdown-item rounded-2 py-2 mb-1" href="/register">
                    <i class="fa-solid fa-user-plus me-2 small text-primary"></i> Register
                </a>
            </li>  
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>