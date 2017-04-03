<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="#"><i class="fa fa-wrench fa-fw"></i> Manejo de Usuarios<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="#">Usuarios</a>
                    </li>
                </ul>
            </li>
            @foreach($pages as $page)
                <li>
                    <a href="#" ><i class="fa fa-file-code-o fa-fw"></i>{{$page->name}}<span class="fa arrow"></span></a>
                    <!--<ul class="nav nav-second-level">
                        <li>
                            <a href="#"><i></i>Pagina de test</a>
                        </li>
                    </ul>
                    -->
                </li>
            @endforeach
        </ul>
    </div>
</div>